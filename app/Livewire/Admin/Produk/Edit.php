<?php

namespace App\Livewire\Admin\Produk;

use App\Models\Category;
use App\Models\Product;
use App\Traits\Notifies;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads, Notifies;

    public Product $product;

    public ?int $category_id = null;
    public string $name = '';
    public string $sku = '';
    public ?string $description = null;
    public $price = null;
    public int $weight = 500;
    public int $stock = 0;
    public bool $is_active = true;

    public ?string $currentImage = null;
    public $image = null;

    public function mount(Product $product): void
    {
        $this->product = $product;

        $this->category_id = $product->category_id;
        $this->name = $product->name;
        $this->sku = $product->sku;
        $this->description = $product->description;
        $this->price = $product->price;
        $this->weight = $product->weight ?? 500; // Load dari DB
        $this->stock = $product->stock;
        $this->is_active = $product->is_active;
        $this->currentImage = $product->image_path;
    }

    public function updatedImage(): void
    {
        $this->validateOnly('image');
    }

    protected function rules(): array
    {
        return [
            'category_id' => 'nullable|exists:categories,id',
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:255|unique:products,sku,' . $this->product->id,
            'description' => 'nullable|string|max:2000',
            'price' => 'required|numeric|min:0|max:999999999999.99',
            'weight' => 'required|integer|min:1',
            'stock' => 'required|integer|min:0',
            'is_active' => 'boolean',
            'image' => 'nullable|image|max:2048',
        ];
    }

    protected function messages(): array
    {
        return [
            'name.required' => 'Nama produk wajib diisi.',
            'sku.required' => 'SKU wajib diisi.',
            'sku.unique' => 'SKU ini sudah dipakai produk lain.',
            'price.required' => 'Harga wajib diisi.',
            'weight.required' => 'Berat barang wajib diisi.',
            'image.image' => 'File harus berupa gambar.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
        ];
    }

    public function removeCurrentImage(): void
    {
        if ($this->currentImage && Storage::disk('public')->exists($this->currentImage)) {
            Storage::disk('public')->delete($this->currentImage);
        }

        $this->currentImage = null;
        $this->product->update(['image_path' => null]);

        $this->notifyInfo('Foto produk dihapus.', 'FOTO DIHAPUS');
    }

    public function update()
    {
        $validated = $this->validate();

        if ($this->image) {
            if ($this->currentImage && Storage::disk('public')->exists($this->currentImage)) {
                Storage::disk('public')->delete($this->currentImage);
            }
            $validated['image_path'] = $this->image->store('products', 'public');
        }
        unset($validated['image']);

        $this->product->update($validated);

        $this->notifySuccess(
            $this->product->name . ' berhasil diperbarui.',
            'PRODUK TERSIMPAN'
        );

        return $this->redirect(route('admin.produk.index'), navigate: true);
    }

    #[Computed]
    public function categories()
    {
        return Category::orderBy('name')->get();
    }

    public function render()
    {
        return view('livewire.admin.produk.edit');
    }
}
