<?php

namespace App\Livewire\Admin\Order;

use App\Models\Order;
use App\Traits\Notifies;
use Livewire\Component;

class Show extends Component
{
    use Notifies;

    public Order $order;
    public string $trackingNumber = '';

    public function mount(Order $order)
    {
        // Load relasi user dan items bawaan dari model Order milikmu
        $this->order = $order->load(['user', 'items.product']);
        $this->trackingNumber = $order->tracking_number ?? '';
    }

    public function updateStatus(string $newStatus): void
    {
        if ($newStatus === 'dikirim' && empty($this->trackingNumber)) {
            $this->notifyWarning('Nomor resi wajib diisi sebelum mengubah status ke DIKIRIM.', 'VALIDASI GAGAL');
            return;
        }

        $this->order->update([
            'status' => $newStatus,
            'tracking_number' => $this->trackingNumber
        ]);

        $this->notifySuccess(
            'Status pesanan ' . $this->order->order_number . ' berhasil diubah menjadi ' . strtoupper($newStatus),
            'UPDATE BERHASIL'
        );
    }

    public function saveTrackingNumber(): void
    {
        $this->validate([
            'trackingNumber' => 'required|string|min:5'
        ]);

        $this->order->update([
            'tracking_number' => $this->trackingNumber
        ]);

        $this->notifySuccess(
            'Nomor resi untuk ' . $this->order->order_number . ' berhasil disimpan.',
            'RESI TERSIMPAN'
        );
    }

    public function render()
    {
        return view('livewire.admin.order.show');
    }
}
