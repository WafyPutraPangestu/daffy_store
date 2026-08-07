<?php

namespace App\Livewire\Pelanggan\Transaction;

use App\Models\Order;
use App\Models\Payment;
use App\Traits\Notifies;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction; // Impor class Transaction dari Midtrans

class Show extends Component
{
    use Notifies;

    public Order $order;

    public function mount(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        $this->order = $order->load(['items.product', 'payment']);

        // OTO-POLLING: Setiap kali halaman dibuka, otomatis cek status terbaru ke Midtrans
        if ($this->order->status === 'menunggu_pembayaran' && $this->order->snap_token) {
            $this->checkPaymentStatus(silent: true);
        }
    }

    // Fungsi memunculkan Pop-up Midtrans (Tetap Sama)
    public function pay()
    {
        if ($this->order->status !== 'menunggu_pembayaran') {
            $this->notifyError('Pesanan ini sudah diproses atau tidak valid.', 'AKSES DITOLAK');
            return;
        }

        // --- MOCK MIDTRANS UNTUK DEMO ---
        Payment::updateOrCreate(
            ['order_id' => $this->order->id],
            [
                'gateway_transaction_id' => 'DUMMY-' . uniqid(),
                'payment_method'         => 'demo_payment',
                'amount'                 => $this->order->total_amount,
                'status'                 => 'paid',
                'gateway_response'       => json_encode(['status' => 'mocked']),
                'paid_at'                => now(),
            ]
        );

        $this->order->update([
            'status' => 'diproses',
            'snap_token' => 'DUMMY_TOKEN'
        ]);

        $this->order->refresh();
        $this->notifySuccess('Pembayaran berhasil disimulasikan (Mode Demo).', 'SUKSES');
    }

    // --- KONSEPNYA POLLING / MANUAL CHECK STATUS ---
    public function checkPaymentStatus($silent = true)
    {
        // --- MOCK MIDTRANS UNTUK DEMO ---
        if ($this->order->status === 'menunggu_pembayaran') {
             if (!$silent) {
                 $this->notifyWarning('Pembayaran belum dilakukan. Silakan klik LANJUTKAN PEMBAYARAN.', 'BELUM DIBAYAR');
             }
        } else {
             if (!$silent) {
                 $this->notifySuccess('Pembayaran sudah lunas (Mode Demo).', 'SUKSES');
             }
        }
    }

    public function render()
    {
        return view('livewire.pelanggan.transaction.show');
    }
}
