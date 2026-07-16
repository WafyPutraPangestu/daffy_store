<?php

namespace App\Livewire\Pelanggan\Transaction;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Url;
use Livewire\Component;

class Tracking extends Component
{
    // Mengambil query string ?resi=xxx dari URL
    #[Url(history: true)]
    public string $resi = '';

    public ?Order $trackedOrder = null;

    public function mount()
    {
        // Jika dari awal URL sudah ada resi, langsung lacak
        if (!empty($this->resi)) {
            $this->track();
        }
    }

    public function track()
    {
        $this->validate([
            'resi' => 'required|string|min:5'
        ], [
            'resi.required' => 'Nomor resi wajib diisi.'
        ]);

        // Cari pesanan berdasarkan nomor resi yang juga milik user ini
        $this->trackedOrder = Order::where('tracking_number', $this->resi)
            ->where('user_id', Auth::id())
            ->first();
    }

    public function render()
    {
        return view('livewire.pelanggan.transaction.tracking');
    }
}
