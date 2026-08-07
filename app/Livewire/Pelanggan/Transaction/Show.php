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

        if (!$this->order->snap_token) {
            Config::$serverKey = config('services.midtrans.server_key');
            Config::$isProduction = config('services.midtrans.is_production');
            Config::$isSanitized = true;
            Config::$is3ds = true;

            $params = [
                'transaction_details' => [
                    'order_id'     => $this->order->order_number,
                    'gross_amount' => (int) $this->order->total_amount,
                ],
                'customer_details' => [
                    'first_name' => $this->order->recipient_name,
                    'email'      => Auth::user()->email,
                ],
            ];

            try {
                $snapToken = Snap::getSnapToken($params);
                $this->order->update(['snap_token' => $snapToken]);
            } catch (\Exception $e) {
                $this->notifyError('Gagal terhubung ke Midtrans: ' . $e->getMessage(), 'PAYMENT ERROR');
                return;
            }
        }

        $this->dispatch('open-snap', token: $this->order->snap_token);
    }

    // --- KONSEPNYA POLLING / MANUAL CHECK STATUS ---
    public function checkPaymentStatus($silent = true)
    {
        // Konfigurasi Kunci Midtrans
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');

        try {
            // FIX INTELEPHENSE: Tambahkan (object) agar VS Code tahu ini bukan Array
            $status = (object) Transaction::status($this->order->order_number);

            $transactionStatus = $status->transaction_status ?? null;

            $paymentStatus = 'pending';
            $orderStatus = 'menunggu_pembayaran';

            // Pemetaan status Midtrans ke Database lokal kita
            if ($transactionStatus == 'settlement' || $transactionStatus == 'capture') {
                $paymentStatus = 'paid';
                $orderStatus = 'diproses';
            } elseif ($transactionStatus == 'cancel' || $transactionStatus == 'deny' || $transactionStatus == 'expire') {
                $paymentStatus = $transactionStatus == 'expire' ? 'expired' : 'failed';
                $orderStatus = 'dibatalkan';
            }

            // 1. Simpan/Update data ke tabel PAYMENTS
            Payment::updateOrCreate(
                ['order_id' => $this->order->id],
                [
                    'gateway_transaction_id' => $status->transaction_id ?? null,
                    'payment_method'         => $status->payment_type ?? null,
                    'amount'                 => $status->gross_amount ?? $this->order->total_amount,
                    'status'                 => $paymentStatus,
                    'gateway_response'       => json_encode($status),
                    'paid_at'                => $paymentStatus === 'paid' ? now() : null,
                ]
            );

            // 2. Update status utama di tabel ORDERS
            $this->order->update(['status' => $orderStatus]);

            // Refresh data order agar tampilan di blade langsung berubah secara reaktif
            $this->order->refresh();

            if (!$silent) {
                if ($paymentStatus === 'paid') {
                    $this->notifySuccess('Pembayaran terverifikasi! Pesanan Anda segera diproses.', 'SUKSES');
                } else {
                    $this->notifyInfo('Status pembayaran saat ini: ' . strtoupper($transactionStatus), 'SINKRONISASI');
                }
            }
        } catch (\Exception $e) {
            if (!$silent) {
                $this->notifyWarning('Belum ada rekaman pembayaran untuk invoice ini di Midtrans.', 'BELUM DIBAYAR');
            }
        }
    }

    public function render()
    {
        return view('livewire.pelanggan.transaction.show');
    }
}
