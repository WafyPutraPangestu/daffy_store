<?php

namespace App\Livewire\Kepala\Analytics;

use App\Models\Payment;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Component;

class PaymentStats extends Component
{
    public string $filterMonth;

    public function mount()
    {
        $this->filterMonth = now()->format('Y-m');
    }

    #[Computed]
    public function stats()
    {
        $year = Carbon::parse($this->filterMonth)->year;
        $month = Carbon::parse($this->filterMonth)->month;

        // Hitung total transaksi & nominal per metode pembayaran
        return Payment::select(
            'payment_method',
            DB::raw('COUNT(*) as total_trx'),
            DB::raw('SUM(amount) as total_amount')
        )
            ->whereYear('paid_at', $year)
            ->whereMonth('paid_at', $month)
            ->where('status', 'paid')
            ->groupBy('payment_method')
            ->orderByDesc('total_trx')
            ->get();
    }

    public function render()
    {
        return view('livewire.kepala.analytics.payment-stats');
    }
}
