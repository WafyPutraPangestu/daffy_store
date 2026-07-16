<?php

namespace App\Livewire\Admin\Produk;

use App\Models\Category;
use App\Models\Product;
use App\Traits\Notifies;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination, Notifies;

    public string $search = '';
    public ?int $categoryFilter = null;
    public string $statusFilter = 'all'; // all | active | inactive
    public int $perPage = 10;

    // Modal konfirmasi hapus
    public bool $showDeleteModal = false;
    public ?int $deleteId = null;
    public string $deleteName = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingCategoryFilter(): void
    {
        $this->resetPage();
    }

    public function updatingStatusFilter(): void
    {
        $this->resetPage();
    }

    public function toggleActive(int $id): void
    {
        $product = Product::findOrFail($id);
        $product->update(['is_active' => ! $product->is_active]);

        $this->notifySuccess(
            $product->name . ' sekarang ' . ($product->is_active ? 'aktif' : 'nonaktif') . '.',
            'STATUS DIPERBARUI'
        );
    }

    public function confirmDelete(int $id): void
    {
        $product = Product::findOrFail($id);

        $this->deleteId = $product->id;
        $this->deleteName = $product->name;
        $this->showDeleteModal = true;
    }

    public function cancelDelete(): void
    {
        $this->showDeleteModal = false;
        $this->deleteId = null;
        $this->deleteName = '';
    }

    public function delete(): void
    {
        if (! $this->deleteId) {
            return;
        }

        $product = Product::find($this->deleteId);

        if (! $product) {
            $this->notifyError('Produk tidak ditemukan, mungkin sudah dihapus.', 'GAGAL');
            $this->cancelDelete();
            return;
        }

        // Produk yang sudah pernah dipesan tidak boleh dihapus (restrictOnDelete di order_items)
        if ($product->orderItems()->exists()) {
            $this->notifyWarning(
                $product->name . ' sudah pernah dipesan dan tidak bisa dihapus. Nonaktifkan saja produknya.',
                'TIDAK BISA DIHAPUS'
            );
            $this->cancelDelete();
            return;
        }

        if ($product->image_path && \Storage::disk('public')->exists($product->image_path)) {
            \Storage::disk('public')->delete($product->image_path);
        }

        $product->delete();

        $this->notifySuccess($product->name . ' berhasil dihapus.', 'DATA DIHAPUS');
        $this->cancelDelete();
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
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('sku', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->categoryFilter, function ($query) {
                $query->where('category_id', $this->categoryFilter);
            })
            ->when($this->statusFilter === 'active', fn($q) => $q->where('is_active', true))
            ->when($this->statusFilter === 'inactive', fn($q) => $q->where('is_active', false))
            ->latest()
            ->paginate($this->perPage);
    }

    public function render()
    {
        return view('livewire.admin.produk.index');
    }
}
