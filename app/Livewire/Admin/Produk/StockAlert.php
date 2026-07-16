<?php

namespace App\Livewire\Admin\Produk;

use App\Models\Product;
use App\Traits\Notifies;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class StockAlert extends Component
{
    use WithPagination, Notifies;

    /** Ambang batas stok menipis, bisa diubah admin langsung dari UI */
    public int $threshold = 5;
    public int $perPage = 10;

    // Popup restock cepat
    public bool $showRestockModal = false;
    public ?int $restockId = null;
    public string $restockName = '';
    public int $restockQty = 10;

    public function updatingThreshold(): void
    {
        $this->resetPage();
    }

    public function openRestock(int $id): void
    {
        $product = Product::findOrFail($id);

        $this->restockId = $product->id;
        $this->restockName = $product->name;
        $this->restockQty = 10;
        $this->showRestockModal = true;
    }

    public function closeRestock(): void
    {
        $this->showRestockModal = false;
        $this->restockId = null;
        $this->restockName = '';
    }

    public function saveRestock(): void
    {
        $this->validate([
            'restockQty' => 'required|integer|min:1|max:100000',
        ], [
            'restockQty.required' => 'Jumlah stok tambahan wajib diisi.',
            'restockQty.min' => 'Minimal tambah 1 stok.',
        ]);

        $product = Product::find($this->restockId);

        if (! $product) {
            $this->notifyError('Produk tidak ditemukan.', 'GAGAL');
            $this->closeRestock();
            return;
        }

        $product->increment('stock', $this->restockQty);

        $this->notifySuccess(
            'Stok ' . $product->name . ' bertambah ' . $this->restockQty . ' unit. Total sekarang: ' . $product->stock . '.',
            'STOK DIPERBARUI'
        );

        $this->closeRestock();
    }

    #[Computed]
    public function outOfStockCount(): int
    {
        return Product::where('stock', 0)->count();
    }

    #[Computed]
    public function lowStockProducts()
    {
        return Product::query()
            ->with('category')
            ->where('stock', '<=', $this->threshold)
            ->where('is_active', true)
            ->orderBy('stock', 'asc')
            ->paginate($this->perPage);
    }

    public function render()
    {
        return view('livewire.admin.produk.stock-alert');
    }
}
