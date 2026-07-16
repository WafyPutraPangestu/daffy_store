<?php

namespace App\Livewire\Admin\Produk;

use App\Models\Category;
use App\Models\Product;
use App\Traits\Notifies;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class BulkManager extends Component
{
    use WithPagination, Notifies;

    public string $search = '';
    public ?int $categoryFilter = null;
    public int $perPage = 15;

    /** ID produk yang dicentang admin */
    public array $selected = [];
    public bool $selectPage = false;

    // Popup: Ubah Harga Massal
    public bool $showPriceModal = false;
    public string $priceMode = 'percentage'; // percentage | fixed_amount | fixed_value
    public string $priceDirection = 'increase'; // increase | decrease
    public $priceValue = null;

    // Popup: Tambah Stok Massal
    public bool $showStockModal = false;
    public int $stockQty = 0;

    // Popup: Konfirmasi Hapus Massal
    public bool $showDeleteModal = false;

    public function updatingSearch(): void
    {
        $this->resetPage();
        $this->selected = [];
        $this->selectPage = false;
    }

    public function updatingCategoryFilter(): void
    {
        $this->resetPage();
        $this->selected = [];
        $this->selectPage = false;
    }

    public function updatedSelectPage(bool $value): void
    {
        $idsOnPage = $this->products->pluck('id')->map(fn($id) => (string) $id)->toArray();

        if ($value) {
            $this->selected = array_values(array_unique(array_merge($this->selected, $idsOnPage)));
        } else {
            $this->selected = array_values(array_diff($this->selected, $idsOnPage));
        }
    }

    public function clearSelection(): void
    {
        $this->selected = [];
        $this->selectPage = false;
    }

    protected function requireSelection(): bool
    {
        if (empty($this->selected)) {
            $this->notifyWarning('Pilih minimal satu produk terlebih dahulu.', 'BELUM ADA YANG DIPILIH');
            return false;
        }

        return true;
    }

    // ==== Bulk: Ubah Harga ====
    public function openPriceModal(): void
    {
        if (! $this->requireSelection()) {
            return;
        }

        $this->priceMode = 'percentage';
        $this->priceDirection = 'increase';
        $this->priceValue = null;
        $this->showPriceModal = true;
    }

    public function applyBulkPrice(): void
    {
        $this->validate([
            'priceValue' => 'required|numeric|min:0.01',
        ], [
            'priceValue.required' => 'Nilai perubahan harga wajib diisi.',
        ]);

        $products = Product::whereIn('id', $this->selected)->get();
        $sign = $this->priceDirection === 'increase' ? 1 : -1;

        foreach ($products as $product) {
            $newPrice = match ($this->priceMode) {
                'percentage' => $product->price + ($sign * $product->price * ($this->priceValue / 100)),
                'fixed_amount' => $product->price + ($sign * $this->priceValue),
                'fixed_value' => $this->priceValue,
                default => $product->price,
            };

            $product->update(['price' => max(0, round($newPrice, 2))]);
        }

        $this->notifySuccess(
            'Harga ' . $products->count() . ' produk berhasil diperbarui.',
            'HARGA MASSAL DITERAPKAN'
        );

        $this->showPriceModal = false;
        $this->clearSelection();
    }

    // ==== Bulk: Tambah Stok ====
    public function openStockModal(): void
    {
        if (! $this->requireSelection()) {
            return;
        }

        $this->stockQty = 0;
        $this->showStockModal = true;
    }

    public function applyBulkStock(): void
    {
        $this->validate([
            'stockQty' => 'required|integer|min:1|max:100000',
        ], [
            'stockQty.required' => 'Jumlah stok wajib diisi.',
        ]);

        $count = Product::whereIn('id', $this->selected)->increment('stock', $this->stockQty);

        $this->notifySuccess(
            'Stok ' . count($this->selected) . ' produk masing-masing bertambah ' . $this->stockQty . ' unit.',
            'STOK MASSAL DITERAPKAN'
        );

        $this->showStockModal = false;
        $this->clearSelection();
    }

    // ==== Bulk: Toggle Status Aktif ====
    public function bulkActivate(): void
    {
        if (! $this->requireSelection()) {
            return;
        }

        Product::whereIn('id', $this->selected)->update(['is_active' => true]);
        $this->notifySuccess(count($this->selected) . ' produk diaktifkan.', 'STATUS DIPERBARUI');
        $this->clearSelection();
    }

    public function bulkDeactivate(): void
    {
        if (! $this->requireSelection()) {
            return;
        }

        Product::whereIn('id', $this->selected)->update(['is_active' => false]);
        $this->notifySuccess(count($this->selected) . ' produk dinonaktifkan.', 'STATUS DIPERBARUI');
        $this->clearSelection();
    }

    // ==== Bulk: Hapus ====
    public function openDeleteModal(): void
    {
        if (! $this->requireSelection()) {
            return;
        }

        $this->showDeleteModal = true;
    }

    public function applyBulkDelete(): void
    {
        $products = Product::whereIn('id', $this->selected)->withCount('orderItems')->get();

        $blocked = $products->filter(fn($p) => $p->order_items_count > 0);
        $deletable = $products->filter(fn($p) => $p->order_items_count === 0);

        foreach ($deletable as $product) {
            if ($product->image_path && \Storage::disk('public')->exists($product->image_path)) {
                \Storage::disk('public')->delete($product->image_path);
            }
            $product->delete();
        }

        if ($deletable->count() > 0) {
            $this->notifySuccess($deletable->count() . ' produk berhasil dihapus.', 'DATA DIHAPUS');
        }

        if ($blocked->count() > 0) {
            $this->notifyWarning(
                $blocked->count() . ' produk dilewati karena sudah pernah dipesan.',
                'SEBAGIAN TIDAK BISA DIHAPUS'
            );
        }

        $this->showDeleteModal = false;
        $this->clearSelection();
    }

    #[Computed]
    public function categories()
    {
        return Category::orderBy('name')->get();
    }

    #[Computed]
    public function products()
    {
        return Product::query()
            ->with('category')
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('sku', 'like', '%' . $this->search . '%');
            })
            ->when($this->categoryFilter, fn($q) => $q->where('category_id', $this->categoryFilter))
            ->latest()
            ->paginate($this->perPage);
    }

    public function render()
    {
        return view('livewire.admin.produk.bulk-manager');
    }
}
