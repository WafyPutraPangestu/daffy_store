<?php

namespace App\Livewire\Pelanggan;

use App\Models\Cart;
use App\Models\CustomerProfile;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Setting;
use App\Models\User;
use App\Notifications\NewOrderNotification;
use App\Services\RajaOngkirService;
use App\Traits\Notifies;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Checkout extends Component
{
    use Notifies;

    // Properti Form Pengiriman
    public string $recipient_name = '';
    public string $shipping_address = '';
    public string $postal_code = '';

    // Properti Wilayah Komerce API
    public array $provinces = [];
    public array $cities = [];
    public array $districts = []; // Tambahan Kecamatan
    public array $courierServices = [];

    public string $province_id = '';
    public string $city_id = '';
    public string $district_id = ''; // Tambahan Kecamatan
    public string $courier = '';
    public string $selected_service = '';

    // Properti Hasil Kalkulasi Finansial
    public float $shipping_cost = 0;
    public string $courier_service_name = '';

    // Flag untuk menampilkan notifikasi "alamat diambil dari profil"
    public bool $addressPrefilled = false;

    public function mount(RajaOngkirService $rajaOngkir): void
    {
        if (!$this->cartData || $this->cartData->items->count() === 0) {
            $this->redirect(route('pelanggan.cart'), navigate: true);
            return;
        }
        $this->recipient_name = Auth::user()->name;
        $this->fetchProvinces($rajaOngkir);
        $this->prefillFromProfile($rajaOngkir);
    }

    #[Computed]
    public function cartData()
    {
        return Cart::with('items.product')->where('user_id', Auth::id())->first();
    }

    #[Computed]
    public function subtotal(): float
    {
        $total = 0;
        if ($this->cartData) {
            foreach ($this->cartData->items as $item) {
                if ($item->product) {
                    $total += $item->quantity * $item->product->price;
                }
            }
        }
        return $total;
    }

    #[Computed]
    public function totalWeight(): int
    {
        $weight = 0;
        if ($this->cartData) {
            foreach ($this->cartData->items as $item) {
                if ($item->product) {
                    $weight += $item->quantity * ($item->product->weight ?? 500);
                }
            }
        }
        return $weight;
    }

    #[Computed]
    public function totalAmount(): float
    {
        return $this->subtotal + $this->shipping_cost;
    }

    // --- PREFILL DARI PROFIL PELANGGAN ---

    /**
     * Ambil data alamat tersimpan dari customer_profiles dan isi otomatis
     * ke form checkout. Semua tetap bisa diedit oleh pelanggan.
     *
     * Catatan: province & city di-match berdasarkan NAMA (bukan ID),
     * karena customer_profiles hanya menyimpan teks bebas, bukan ID Komerce.
     * Kecamatan tidak bisa di-prefill karena tidak ada field terpisah di profil,
     * jadi pelanggan tetap perlu memilih kecamatan secara manual.
     */
    private function prefillFromProfile(RajaOngkirService $rajaOngkir): void
    {
        $profile = CustomerProfile::where('user_id', Auth::id())->first();

        if (!$profile) {
            return;
        }

        // Alamat & kode pos bisa langsung diisi apa adanya (teks bebas)
        if (!empty($profile->default_address)) {
            $this->shipping_address = $profile->default_address;
            $this->addressPrefilled = true;
        }

        if (!empty($profile->postal_code)) {
            $this->postal_code = $profile->postal_code;
        }

        // Coba cocokkan provinsi berdasarkan nama
        if (!empty($profile->province)) {
            $matchedProvince = collect($this->provinces)->first(function ($prov) use ($profile) {
                return strtoupper(trim($prov['province'])) === strtoupper(trim($profile->province));
            });

            if ($matchedProvince) {
                $this->province_id = (string) $matchedProvince['province_id'];
                $this->loadCities($rajaOngkir, $this->province_id);

                // Coba cocokkan kota berdasarkan nama
                if (!empty($profile->city)) {
                    $matchedCity = collect($this->cities)->first(function ($city) use ($profile) {
                        return strtoupper(trim($city['city_name'])) === strtoupper(trim($profile->city));
                    });

                    if ($matchedCity) {
                        $this->city_id = (string) $matchedCity['city_id'];
                        $this->loadDistricts($rajaOngkir, $this->city_id);
                        // Kecamatan sengaja dibiarkan kosong -> pelanggan pilih manual
                    }
                }
            }
        }
    }

    // --- LOGIKA KOMERCE API V2 (via RajaOngkirService, sudah di-cache) ---

    private function fetchProvinces(RajaOngkirService $rajaOngkir): void
    {
        try {
            $data = $rajaOngkir->getProvinces();
            $this->provinces = collect($data)->map(function ($item) {
                return [
                    'province_id' => $item['id'],
                    'province'    => $item['name'],
                ];
            })->toArray();
        } catch (\Exception $e) {
            $this->notifyError($e->getMessage(), 'API ERROR');
        }
    }

    private function loadCities(RajaOngkirService $rajaOngkir, string $provinceId): void
    {
        try {
            $data = $rajaOngkir->getCities($provinceId);
            $this->cities = collect($data)->map(function ($item) {
                return [
                    'city_id'   => $item['id'],
                    'city_name' => $item['name'],
                ];
            })->toArray();
        } catch (\Exception $e) {
            $this->notifyError($e->getMessage(), 'API ERROR');
        }
    }

    private function loadDistricts(RajaOngkirService $rajaOngkir, string $cityId): void
    {
        try {
            $data = $rajaOngkir->getDistricts($cityId);
            $this->districts = collect($data)->map(function ($item) {
                return [
                    'district_id'   => $item['id'],
                    'district_name' => $item['name'],
                ];
            })->toArray();
        } catch (\Exception $e) {
            $this->notifyError($e->getMessage(), 'API ERROR');
        }
    }

    public function updatedProvinceId($value, RajaOngkirService $rajaOngkir): void
    {
        $this->cities = [];
        $this->city_id = '';
        $this->districts = [];
        $this->district_id = '';
        $this->resetCost();

        if (empty($value)) return;

        $this->loadCities($rajaOngkir, $value);
    }

    public function updatedCityId($value, RajaOngkirService $rajaOngkir): void
    {
        $this->districts = [];
        $this->district_id = '';
        $this->resetCost();

        if (empty($value)) return;

        $this->loadDistricts($rajaOngkir, $value);
    }

    public function updatedDistrictId(RajaOngkirService $rajaOngkir): void
    {
        $this->resetCost();
        $this->checkCost($rajaOngkir);
    }

    public function updatedCourier(RajaOngkirService $rajaOngkir): void
    {
        $this->resetCost();
        $this->checkCost($rajaOngkir);
    }

    public function checkCost(RajaOngkirService $rajaOngkir): void
    {
        if (empty($this->district_id) || empty($this->courier)) return;

        try {
            $costs = $rajaOngkir->calculateCost(
                (string) Setting::get('store_origin_id'),
                $this->district_id,
                $this->totalWeight,
                $this->courier
            );

            $this->courierServices = collect($costs)->map(function ($service) {
                return [
                    'service'     => $service['service'],
                    'description' => $service['description'] ?? '',
                    'cost'        => $service['cost'][0]['value'] ?? 0,
                    'etd'         => $service['cost'][0]['etd'] ?? '',
                ];
            })->toArray();

            if (count($this->courierServices) === 0) {
                $this->notifyWarning('Layanan kurir tidak tersedia untuk rute tujuan ini.', 'LOGISTIK KOSONG');
            }
        } catch (\Exception $e) {
            $this->notifyError($e->getMessage(), 'API ERROR');
        }
    }

    public function updatedSelectedService($value): void
    {
        if (empty($value)) {
            $this->shipping_cost = 0;
            $this->courier_service_name = '';
            return;
        }

        [$service, $cost] = explode('|', $value, 2);
        $this->shipping_cost = (float) $cost;
        $this->courier_service_name = $service;
    }

    private function resetCost(): void
    {
        $this->courierServices = [];
        $this->selected_service = '';
        $this->shipping_cost = 0;
        $this->courier_service_name = '';
    }

    // --- PROSES SIMPAN TRANSAKSI ---

    public function placeOrder()
    {
        $this->validate([
            'recipient_name'   => 'required|string|max:255',
            'shipping_address' => 'required|string|max:1000',
            'province_id'      => 'required',
            'city_id'          => 'required',
            'district_id'      => 'required',
            'postal_code'      => 'required|string|max:10',
            'courier'          => 'required',
            'selected_service' => 'required',
        ], [
            'district_id.required' => 'Silakan pilih kecamatan.',
            'selected_service.required' => 'Silakan pilih layanan ekspedisi.',
        ]);

        $provData = collect($this->provinces)->firstWhere('province_id', $this->province_id);
        $cityData = collect($this->cities)->firstWhere('city_id', $this->city_id);
        $districtData = collect($this->districts)->firstWhere('district_id', $this->district_id);

        $provinceName = $provData['province'] ?? '';

        // TRIK: Gabungkan Nama Kota & Kecamatan agar masuk sempurna ke 1 kolom 'city' di DB kamu
        $cityName = ($cityData['city_name'] ?? '') . ', Kec. ' . ($districtData['district_name'] ?? '');

        $orderNumber = 'INV-' . date('Ymd') . '-' . strtoupper(str_shuffle(substr(uniqid(), -5)));

        $order = Order::create([
            'user_id'          => Auth::id(),
            'order_number'     => $orderNumber,
            'status'           => 'menunggu_pembayaran',
            'recipient_name'   => $this->recipient_name,
            'shipping_address' => $this->shipping_address,
            'city'             => $cityName,
            'province'         => $provinceName,
            'postal_code'      => $this->postal_code,
            'courier'          => strtoupper($this->courier),
            'courier_service'  => $this->courier_service_name,
            'total_weight'     => $this->totalWeight,
            'shipping_cost'    => $this->shipping_cost,
            'subtotal'         => $this->subtotal,
            'total_amount'     => $this->totalAmount,
        ]);

        foreach ($this->cartData->items as $item) {
            if ($item->product) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $item->product_id,
                    'quantity'   => $item->quantity,
                    'unit_price' => $item->product->price,
                    'subtotal'   => $item->quantity * $item->product->price,
                ]);
                $item->product->decrement('stock', $item->quantity);
            }
        }

        $this->cartData->delete();
        $this->dispatch('cartUpdated');

        // Kirim notifikasi in-app ke semua admin
        $admins = User::where('role', 'admin')->get();
        Notification::send($admins, new NewOrderNotification($order));

        $this->notifySuccess('Manifes transaksi berhasil diterbitkan. Menunggu pelunasan.', 'ORDER CREATED');

        return $this->redirect(route('pelanggan.transaction.show', $order->id));
    }

    public function render()
    {
        return view('livewire.pelanggan.checkout');
    }
}
