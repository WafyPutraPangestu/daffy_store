<?php

namespace App\Livewire\Admin;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Carbon;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Dashboard extends Component
{
    #[Computed]
    public function kpi()
    {
        // Metrik Utama (Key Performance Indicators)
        return [
            'revenue' => Order::where('status', '!=', 'dibatalkan')->sum('total_amount'),
            'orders' => Order::whereMonth('created_at', now()->month)->count(),
            'customers' => User::where('role', 'pelanggan')->count(),
            'products' => Product::where('is_active', true)->count(),
        ];
    }

    #[Computed]
    public function salesChartData()
    {
        // Mengambil data penjualan 7 hari terakhir
        $days = collect();
        for ($i = 6; $i >= 0; $i--) {
            $days->push(now()->subDays($i)->format('Y-m-d'));
        }

        $sales = Order::selectRaw('DATE(created_at) as date, SUM(total_amount) as total')
            ->where('created_at', '>=', now()->subDays(6)->startOfDay())
            ->where('status', '!=', 'dibatalkan')
            ->groupBy('date')
            ->pluck('total', 'date');

        $labels = [];
        $data = [];

        foreach ($days as $day) {
            $labels[] = Carbon::parse($day)->format('d M');
            $data[] = $sales->get($day, 0); // Jika hari itu tidak ada penjualan, set 0
        }

        return [
            'labels' => $labels,
            'data' => $data,
        ];
    }

    #[Computed]
    public function orderStatusData()
    {
        // Distribusi status pesanan untuk Doughnut Chart
        $statuses = Order::selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        return [
            'labels' => $statuses->keys()->map(fn($s) => strtoupper(str_replace('_', ' ', $s)))->toArray(),
            'data' => $statuses->values()->toArray(),
        ];
    }

    #[Computed]
    public function recentOrders()
    {
        // 5 Pesanan masuk terbaru
        return Order::with('user')->latest()->take(5)->get();
    }

    #[Computed]
    public function lowStockProducts()
    {
        // Peringatan: 5 Produk dengan stok menipis (di bawah 5)
        return Product::where('stock', '<=', 5)->orderBy('stock', 'asc')->take(5)->get();
    }

    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}
