<?php

namespace App\Livewire\Admin\Finance;

use App\Models\Payment;
use App\Traits\Notifies;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination, Notifies;

    public string $search = '';

    // Status di database: 'pending', 'paid', 'failed', 'expired'
    public string $paymentStatus = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }
    public function updatingPaymentStatus(): void
    {
        $this->resetPage();
    }

    public function verifyPayment(int $paymentId): void
    {
        $payment = Payment::with('order')->find($paymentId);

        if ($payment) {
            // 1. Ubah status di tabel payments menjadi lunas
            $payment->update([
                'status' => 'paid',
                'paid_at' => now(),
            ]);

            // 2. Ubah status di tabel orders menjadi diproses
            if ($payment->order) {
                $payment->order->update([
                    'status' => 'diproses'
                ]);
            }

            $this->notifySuccess(
                'Pembayaran untuk invoice ' . $payment->order->order_number . ' telah diverifikasi.',
                'REKONSILIASI BERHASIL'
            );
        }
    }

    #[Computed]
    public function payments()
    {
        return Payment::query()
            ->with(['order.user']) // Memuat relasi pesanan dan pembeli
            ->when($this->paymentStatus, function ($query) {
                $query->where('status', $this->paymentStatus);
            })
            ->when($this->search, function ($query) {
                // Cari berdasarkan nomor pesanan (order_number) di tabel relasi orders
                $query->whereHas('order', function ($q) {
                    $q->where('order_number', 'like', '%' . $this->search . '%');
                });
            })
            ->latest()
            ->paginate(15);
    }

    public function render()
    {
        return view('livewire.admin.finance.index');
    }
}
