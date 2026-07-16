<?php

namespace App\Livewire\Kepala\Analytics;

use App\Models\OrderItem;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class BestSeller extends Component
{
    use WithPagination;

    public string $filterMonth;

    public function mount()
    {
        $this->filterMonth = now()->format('Y-m'); // Default bulan ini
    }

    public function updatingFilterMonth(): void
    {
        $this->resetPage();
    }

    #[Computed]
    public function bestSellers()
    {
        $year = Carbon::parse($this->filterMonth)->year;
        $month = Carbon::parse($this->filterMonth)->month;

        // Mengambil data item pesanan, dijumlahkan berdasarkan product_id
        return OrderItem::select(
            'product_id',
            DB::raw('SUM(quantity) as total_qty'),
            DB::raw('SUM(subtotal) as total_revenue')
        )
            ->whereHas('order', function ($query) use ($year, $month) {
                // Hanya hitung pesanan di bulan tersebut yang statusnya valid
                $query->whereYear('created_at', $year)
                    ->whereMonth('created_at', $month)
                    ->whereIn('status', ['dikirim', 'selesai']);
            })
            ->with('product.category') // Load relasi produk dan kategorinya
            ->groupBy('product_id')
            ->orderByDesc('total_qty') // Urutkan dari yang paling banyak terjual
            ->paginate(15);
    }

    public function render()
    {
        return view('livewire.kepala.analytics.best-seller');
    }
}
