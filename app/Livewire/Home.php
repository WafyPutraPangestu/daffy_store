<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;

class Home extends Component
{
    /**
     * Mapping slug kategori → icon Tabler Icons.
     * Fallback ke 'ti-package' kalau slug belum terdaftar di sini.
     */
    protected array $categoryIcons = [
        'joran' => 'ti-target',
        'reel' => 'ti-rotate-clockwise',
        'umpan' => 'ti-ripple',
        'jaring' => 'ti-layout-grid',
        'aksesoris' => 'ti-tool',
    ];

    public function addToCart(int $productId)
    {
        // TODO: implement setelah flow carts/cart_items siap.
        // Contoh nanti:
        // $cart = Cart::firstOrCreate(['user_id' => auth()->id()]);
        // $cart->items()->updateOrCreate(['product_id' => $productId], [...]);

        $this->dispatch('cart-updated');

        session()->flash('message', 'Produk ditambahkan ke keranjang.');
    }

    public function render()
    {
        $categories = Category::withCount('products')->get();

        $products = Product::with('category')
            ->where('is_active', true)
            ->latest()
            ->take(8)
            ->get();

        // Produk terlaris dihitung dari total quantity di order_items.
        // whereHas('orderItems') memastikan hanya produk yang sudah pernah terjual yang muncul.
        $bestSellers = Product::with('category')
            ->withSum('orderItems as total_sold', 'quantity')
            ->whereHas('orderItems')
            ->orderByDesc('total_sold')
            ->take(4)
            ->get();

        // Produk unggulan di hero: ambil salah satu produk terlaris,
        // fallback ke produk terbaru kalau belum ada histori penjualan.
        $featuredProduct = $bestSellers->first() ?? $products->first();

        return view('livewire.home', [
            'categories' => $categories,
            'products' => $products,
            'bestSellers' => $bestSellers,
            'featuredProduct' => $featuredProduct,
            'categoryIcons' => $this->categoryIcons,
        ]);
    }
}
