<?php

namespace App\Livewire\Pelanggan\Profile;

use App\Models\CustomerProfile;
use App\Services\RajaOngkirService;
use App\Traits\Notifies;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Address extends Component
{
    use Notifies;

    public string $default_address = '';
    public string $postal_code = '';

    public array $provinces = [];
    public array $cities = [];

    public string $province_id = '';
    public string $city_id = '';

    public function mount(RajaOngkirService $rajaOngkir): void
    {
        // 1. Load data provinsi (sudah di-cache di service, tidak akan kena rate limit lagi)
        $this->fetchProvinces($rajaOngkir);

        // 2. Ambil data profil yang sudah tersimpan di DB jika ada
        $profile = CustomerProfile::where('user_id', Auth::id())->first();

        if ($profile) {
            $this->default_address = $profile->default_address ?? '';
            $this->postal_code = $profile->postal_code ?? '';

            // 3. Cocokkan nama provinsi & kota tersimpan (teks) ke ID Komerce,
            //    supaya dropdown ikut ter-preselect saat pelanggan edit alamat.
            $this->preselectRegion($rajaOngkir, $profile);
        }
    }

    private function fetchProvinces(RajaOngkirService $rajaOngkir): void
    {
        try {
            $this->provinces = $rajaOngkir->getProvinces();
        } catch (\Exception $e) {
            $this->notifyError($e->getMessage(), 'API ERROR');
        }
    }

    private function preselectRegion(RajaOngkirService $rajaOngkir, CustomerProfile $profile): void
    {
        if (empty($profile->province)) {
            return;
        }

        $matchedProvince = collect($this->provinces)->first(function ($prov) use ($profile) {
            return strtoupper(trim($prov['name'])) === strtoupper(trim($profile->province));
        });

        if (!$matchedProvince) {
            return;
        }

        $this->province_id = (string) $matchedProvince['id'];

        try {
            $this->cities = $rajaOngkir->getCities($this->province_id);
        } catch (\Exception $e) {
            $this->notifyError($e->getMessage(), 'API ERROR');
            return;
        }

        if (empty($profile->city)) {
            return;
        }

        $matchedCity = collect($this->cities)->first(function ($city) use ($profile) {
            return strtoupper(trim($city['name'])) === strtoupper(trim($profile->city));
        });

        if ($matchedCity) {
            $this->city_id = (string) $matchedCity['id'];
        }
    }

    public function updatedProvinceId($value, RajaOngkirService $rajaOngkir): void
    {
        $this->cities = [];
        $this->city_id = '';

        if (empty($value)) return;

        try {
            $this->cities = $rajaOngkir->getCities($value);
        } catch (\Exception $e) {
            $this->notifyError($e->getMessage(), 'API ERROR');
        }
    }

    public function saveAddress()
    {
        $this->validate([
            'default_address' => 'required|string|max:1000',
            'postal_code'     => 'required|string|max:10',
            'province_id'     => 'required',
            'city_id'         => 'required',
        ], [
            'province_id.required' => 'Provinsi wajib dipilih.',
            'city_id.required'     => 'Kota/Kabupaten wajib dipilih.',
        ]);

        $provData = collect($this->provinces)->firstWhere('id', $this->province_id);
        $cityData = collect($this->cities)->firstWhere('id', $this->city_id);

        CustomerProfile::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'default_address' => $this->default_address,
                'postal_code'     => $this->postal_code,
                'province'        => $provData['name'] ?? '',
                'city'            => $cityData['name'] ?? '',
            ]
        );

        $this->notifySuccess('Buku alamat pengiriman utama berhasil diperbarui.', 'ALAMAT TERSIMPAN');
    }

    public function render()
    {
        return view('livewire.pelanggan.profile.address');
    }
}
