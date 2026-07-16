<?php

namespace App\Livewire\Kepala\Report;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Carbon;
use Livewire\Component;

class ExportCenter extends Component
{
    public string $reportType = 'penjualan'; // penjualan atau pembayaran
    public string $startDate = '';
    public string $endDate = '';

    public function mount()
    {
        // Default rentang tanggal: Awal bulan sampai hari ini
        $this->startDate = now()->startOfMonth()->format('Y-m-d');
        $this->endDate = now()->format('Y-m-d');
    }

    public function exportCSV()
    {
        $this->validate([
            'startDate' => 'required|date',
            'endDate' => 'required|date|after_or_equal:startDate',
        ]);

        $start = Carbon::parse($this->startDate)->startOfDay();
        $end = Carbon::parse($this->endDate)->endOfDay();

        $fileName = 'Laporan_' . strtoupper($this->reportType) . '_' . $start->format('dMy') . '-' . $end->format('dMy') . '.csv';

        // Stream data langsung ke browser user
        return response()->streamDownload(function () use ($start, $end) {
            $file = fopen('php://output', 'w');

            if ($this->reportType === 'penjualan') {
                // Header CSV Penjualan
                fputcsv($file, ['Tanggal', 'Nomor Pesanan', 'Pelanggan', 'Status', 'Total Belanja']);

                $orders = Order::with('user')
                    ->whereBetween('created_at', [$start, $end])
                    ->whereIn('status', ['dikirim', 'selesai'])
                    ->get();

                foreach ($orders as $order) {
                    fputcsv($file, [
                        $order->created_at->format('Y-m-d H:i'),
                        $order->order_number,
                        $order->user->name ?? 'Guest',
                        strtoupper($order->status),
                        $order->total_amount
                    ]);
                }
            } else {
                // Header CSV Pembayaran
                fputcsv($file, ['Tanggal Lunas', 'Nomor Pesanan', 'Metode', 'Status', 'Nominal Dana Masuk']);

                $payments = Payment::with('order')
                    ->whereBetween('paid_at', [$start, $end])
                    ->where('status', 'paid')
                    ->get();

                foreach ($payments as $payment) {
                    fputcsv($file, [
                        Carbon::parse($payment->paid_at)->format('Y-m-d H:i'),
                        $payment->order->order_number ?? '-',
                        strtoupper($payment->payment_method ?? 'TRANSFER'),
                        strtoupper($payment->status),
                        $payment->amount
                    ]);
                }
            }

            fclose($file);
        }, $fileName, [
            'Content-Type' => 'text/csv',
            'Cache-Control' => 'no-store, no-cache',
        ]);
    }

    public function render()
    {
        return view('livewire.kepala.report.export-center');
    }
}
