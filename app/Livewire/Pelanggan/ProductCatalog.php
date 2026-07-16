<?php

namespace App\Livewire\Pelanggan; // <-- FIX: Namespace sub-folder Pelanggan

use App\Models\Product;
use App\Models\Category;
use App\Models\Cart;
use App\Models\CartItem;
use App\Traits\Notifies;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;
use Livewire\Attributes\Computed;

class ProductCatalog extends Component
{
    use WithPagination, Notifies;

    // Menyimpan pencarian dan filter ke URL query string agar bisa di-bookmark (?search=...&category=...)
    #[Url(history: true)]
    public string $search = '';

    #[Url(history: true)]
    public string $category = '';

    public int $perPage = 12;

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingCategory(): void
    {
        $this->resetPage();
    }

    // Aksi masukkan produk ke keranjang belanja
    public function addToCart(int $productId): void
    {
        // 1. Validasi ganda: Pastikan user benar-benar sudah login
        if (!Auth::check()) {
            $this->notifyError('Silakan login terlebih dahulu untuk mulai berbelanja.', 'AKSES DITOLAK');
            return;
        }

        $product = Product::findOrFail($productId);

        // 2. Validasi ketersediaan stok barang
        if ($product->stock <= 0) {
            $this->notifyWarning('Maaf, produk ini sedang kehabisan stok.', 'STOK KOSONG');
            return;
        }

        // 3. Ambil atau buat keranjang belanja baru untuk id user yang aktif
        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);

        // 4. Periksa apakah barang serupa sudah ada di dalam keranjang
        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            // Jika sudah ada, naikkan kuantitas + 1
            $cartItem->increment('quantity');
        } else {
            // Jika belum ada di tabel item keranjang, buat baris baru
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => 1
            ]);
        }

        // 5. Notifikasi sukses bawaan trait Anda
        $this->notifySuccess(
            $product->name . ' berhasil dimasukkan ke keranjang belanja Anda.',
            'SYSTEM LOG: SUCCESS'
        );

        // Menyiarkan event global jika navbar keranjang di atas butuh update realtime counter
        $this->dispatch('cartUpdated');
    }

    #[Computed]
    public function products()
    {
        return Product::query()
            ->where('is_active', true) // Hanya memuat produk komoditas aktif
            ->when($this->category, function ($query) {
                $query->whereHas('category', function ($q) {
                    $q->where('slug', $this->category);
                });
            })
            ->when($this->search, function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('sku', 'like', '%' . $this->search . '%');
                });
            })
            ->latest()
            ->paginate($this->perPage);
    }

    #[Computed]
    public function categories()
    {
        // Mengambil kumpulan kategori yang memiliki minimal 1 produk aktif
        return Category::whereHas('products', function ($q) {
            $q->where('is_active', true);
        })->get();
    }

    public function render()
    {
        return view('livewire.pelanggan.product-catalog'); // <-- FIX: Mengarah ke folder pelanggan
    }
}
