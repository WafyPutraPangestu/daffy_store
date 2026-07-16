<?php

namespace App\Livewire\Admin\Order;

use App\Models\Order;
use App\Traits\Notifies;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Manifest extends Component
{
    use Notifies;

    #[Computed]
    public function readyOrders()
    {
        // FIX: Load items (bukan orderDetails) dan load user.customerProfile untuk nomor telepon
        return Order::with(['user.customerProfile', 'items.product'])
            ->where('status', 'diproses')
            ->orderBy('created_at', 'asc')
            ->get();
    }

    public function markAllAsShipped(): void
    {
        $orders = $this->readyOrders();

        if ($orders->isEmpty()) {
            $this->notifyError('Tidak ada pesanan yang siap dikirim saat ini.', 'MANIFEST KOSONG');
            return;
        }

        Order::whereIn('id', $orders->pluck('id'))->update(['status' => 'dikirim']);

        $this->notifySuccess(
            $orders->count() . ' pesanan telah ditandai sebagai DIKIRIM.',
            'LOGISTIK DIPERBARUI'
        );
    }

    public function render()
    {
        return view('livewire.admin.order.manifest');
    }
}
