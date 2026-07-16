<?php

namespace App\Livewire\Admin\Category;

use App\Models\Category;
use App\Traits\Notifies;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app', ['title' => 'Kategori Produk'])]
class Index extends Component
{
    use WithPagination, Notifies;
    public string $search = '';
    public int $perPage = 10;
    public bool $showModal = false;
    public bool $isEditing = false;
    public ?int $categoryId = null;
    public string $name = '';
    public string $slug = '';
    public ?string $description = null;
    public bool $showDeleteModal = false;
    public ?int $deleteId = null;
    public string $deleteName = '';
    public function updatingSearch(): void
    {
        $this->resetPage();
    }
    /**
     * Auto-generate slug tiap kali admin ngetik nama,
     * tapi cuma kalau slug belum diubah manual sama admin.
     */
    public function updatedName(string $value): void
    {
        $this->slug = Str::slug($value);
    }
    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'slug' => [
                'required',
                'string',
                'max:255',
                'alpha_dash',
                'unique:categories,slug,' . $this->categoryId,
            ],
            'description' => 'nullable|string|max:1000',
        ];
    }
    protected function messages(): array
    {
        return [
            'name.required' => 'Nama kategori wajib diisi.',
            'slug.required' => 'Slug wajib diisi.',
            'slug.alpha_dash' => 'Slug hanya boleh huruf, angka, strip, dan underscore.',
            'slug.unique' => 'Slug ini sudah dipakai kategori lain.',
        ];
    }
    public function openCreateModal(): void
    {
        $this->resetForm();
        $this->isEditing = false;
        $this->showModal = true;
    }
    public function openEditModal(int $id): void
    {
        $category = Category::findOrFail($id);
        $this->categoryId = $category->id;
        $this->name = $category->name;
        $this->slug = $category->slug;
        $this->description = $category->description;
        $this->isEditing = true;
        $this->showModal = true;
        $this->resetErrorBag();
    }
    public function closeModal(): void
    {
        $this->showModal = false;
        $this->resetForm();
    }
    public function save(): void
    {
        $validated = $this->validate();
        if ($this->isEditing && $this->categoryId) {
            $category = Category::findOrFail($this->categoryId);
            $category->update($validated);
            $this->notifySuccess(
                'Kategori "' . $category->name . '" berhasil diperbarui.',
                'DATA TERSIMPAN'
            );
        } else {
            Category::create($validated);
            $this->notifySuccess(
                'Kategori "' . $validated['name'] . '" berhasil ditambahkan.',
                'DATA TERSIMPAN'
            );
        }
        $this->closeModal();
    }
    public function confirmDelete(int $id): void
    {
        $category = Category::findOrFail($id);
        $this->deleteId = $category->id;
        $this->deleteName = $category->name;
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
        $category = Category::find($this->deleteId);
        if (! $category) {
            $this->notifyError('Kategori tidak ditemukan, mungkin sudah dihapus.', 'GAGAL');
            $this->cancelDelete();
            return;
        }
        if ($category->products()->exists()) {
            $this->notifyWarning(
                'Kategori "' . $category->name . '" masih dipakai oleh produk lain.',
                'TIDAK BISA DIHAPUS'
            );
            $this->cancelDelete();
            return;
        }
        $category->delete();
        $this->notifySuccess(
            'Kategori "' . $category->name . '" berhasil dihapus.',
            'DATA DIHAPUS'
        );
        $this->cancelDelete();
    }
    protected function resetForm(): void
    {
        $this->reset(['categoryId', 'name', 'slug', 'description']);
        $this->resetErrorBag();
        $this->resetValidation();
    }
    #[Computed]
    public function categories()
    {
        return Category::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('slug', 'like', '%' . $this->search . '%');
            })
            ->withCount('products')
            ->latest()
            ->paginate($this->perPage);
    }
    public function render()
    {
        return view('livewire.admin.category.index');
    }
}
