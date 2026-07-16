<?php

namespace App\Livewire\Pelanggan;

use App\Models\Cart as CartModel;
use App\Models\CartItem;
use App\Traits\Notifies;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Cart extends Component
{
    use Notifies;

    // Mengambil data model utama Cart pembeli yang aktif
    #[Computed]
    public function cartData()
    {
        return CartModel::with(['items.product' => function ($query) {
            $query->where('is_active', true);
        }])->where('user_id', Auth::id())->first();
    }

    // Mengkalkulasi total akumulasi subtotal harga belanjaan
    #[Computed]
    public function subtotal()
    {
        $total = 0;
        if ($this->cartData && $this->cartData->items) {
            foreach ($this->cartData->items as $item) {
                if ($item->product) {
                    $total += $item->quantity * $item->product->price;
                }
            }
        }
        return $total;
    }

    // Aksi menaikkan kuantitas kuota barang belanjaan (+ 1)
    public function incrementQuantity(int $itemId): void
    {
        $item = CartItem::with('product')->findOrFail($itemId);

        // Pengaman: Kuantitas tidak boleh melebihi sisa stok di database produk
        if ($item->quantity >= $item->product->stock) {
            $this->notifyWarning('Batas kuantitas melebihi kapasitas stok unit barang saat ini.', 'STOK TERBATAS');
            return;
        }

        $item->increment('quantity');
        $this->dispatch('cartUpdated'); // Refresh angka badge keranjang belanja di navbar
    }

    // Aksi menurunkan kuantitas kuota barang belanjaan (- 1)
    public function decrementQuantity(int $itemId): void
    {
        $item = CartItem::findOrFail($itemId);

        // Jika kuantitas sudah bernilai 1 lalu ditekan tombol minus, hapus baris item tersebut
        if ($item->quantity <= 1) {
            $this->removeItem($itemId);
            return;
        }

        $item->decrement('quantity');
        $this->dispatch('cartUpdated');
    }

    // Aksi menghapus item barang tertentu dari keranjang belanja
    public function removeItem(int $itemId): void
    {
        $item = CartItem::findOrFail($itemId);
        $item->delete();

        $this->notifyInfo('Item barang berhasil dikeluarkan dari daftar keranjang belanja.', 'LOG: ITEM DIHAPUS');
        $this->dispatch('cartUpdated');
    }

    public function render()
    {
        return view('livewire.pelanggan.cart');
    }
}
