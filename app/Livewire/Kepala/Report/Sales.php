<?php

namespace App\Livewire\Kepala\Report;

use App\Models\Order;
use Illuminate\Support\Carbon;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class Sales extends Component
{
    use WithPagination;

    // Filter berdasarkan bulan dan tahun saat ini
    public string $filterMonth;

    public function mount()
    {
        // Set default ke bulan ini (Format: YYYY-MM)
        $this->filterMonth = now()->format('Y-m');
    }

    public function updatingFilterMonth(): void
    {
        $this->resetPage();
    }

    #[Computed]
    public function salesData()
    {
        // Pisahkan tahun dan bulan dari input filter (misal: "2026-07")
        $year = Carbon::parse($this->filterMonth)->year;
        $month = Carbon::parse($this->filterMonth)->month;

        return Order::with(['user', 'items'])
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->whereIn('status', ['dikirim', 'selesai']) // Hanya hitung yang benar-benar valid
            ->latest()
            ->paginate(15);
    }

    #[Computed]
    public function summary()
    {
        $year = Carbon::parse($this->filterMonth)->year;
        $month = Carbon::parse($this->filterMonth)->month;

        $validOrders = Order::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->whereIn('status', ['dikirim', 'selesai']);

        return [
            'total_revenue' => $validOrders->sum('total_amount'),
            'total_orders' => $validOrders->count(),
        ];
    }
    public function render()
    {
        return view('livewire.kepala.report.sales');
    }
}
