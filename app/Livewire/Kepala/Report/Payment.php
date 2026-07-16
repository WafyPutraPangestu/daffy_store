<?php

namespace App\Livewire\Kepala\Report;

use App\Models\Payment as PaymentModel;
use Illuminate\Support\Carbon;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class Payment extends Component
{
    use WithPagination;

    public string $filterMonth;

    public function mount()
    {
        $this->filterMonth = now()->format('Y-m');
    }

    public function updatingFilterMonth(): void
    {
        $this->resetPage();
    }

    #[Computed]
    public function paymentData()
    {
        $year = Carbon::parse($this->filterMonth)->year;
        $month = Carbon::parse($this->filterMonth)->month;

        return PaymentModel::with(['order.user'])
            ->whereYear('paid_at', $year)
            ->whereMonth('paid_at', $month)
            ->where('status', 'paid')
            ->latest('paid_at')
            ->paginate(15);
    }

    #[Computed]
    public function summary()
    {
        $year = Carbon::parse($this->filterMonth)->year;
        $month = Carbon::parse($this->filterMonth)->month;

        $validPayments = PaymentModel::whereYear('paid_at', $year)
            ->whereMonth('paid_at', $month)
            ->where('status', 'paid');

        return [
            'total_income' => $validPayments->sum('amount'),
            'transaction_count' => $validPayments->count(),
        ];
    }

    public function render()
    {
        return view('livewire.kepala.report.payment');
    }
}
