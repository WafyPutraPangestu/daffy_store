<?php

namespace App\Livewire\Admin\Produk;

use App\Models\Category;
use App\Models\Product;
use App\Traits\Notifies;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads, Notifies;

    public ?int $category_id = null;
    public string $name = '';
    public string $sku = '';
    public ?string $description = null;
    public $price = null;
    public int $weight = 500; // Default asumsi 500 gram
    public int $stock = 0;
    public bool $is_active = true;

    /** @var \Livewire\Features\SupportFileUploads\TemporaryUploadedFile|null */
    public $image = null;

    public function updatedName(string $value): void
    {
        if (blank($this->sku)) {
            $this->sku = Str::upper(Str::slug($value, '-'));
        }
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
            'sku' => 'required|string|max:255|unique:products,sku',
            'description' => 'nullable|string|max:2000',
            'price' => 'required|numeric|min:0|max:999999999999.99',
            'weight' => 'required|integer|min:1', // Validasi Berat
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
            'price.numeric' => 'Harga harus berupa angka.',
            'weight.required' => 'Berat barang wajib diisi.',
            'image.image' => 'File harus berupa gambar.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
        ];
    }

    public function save()
    {
        $validated = $this->validate();

        if ($this->image) {
            $validated['image_path'] = $this->image->store('products', 'public');
        }

        unset($validated['image']);
        $product = Product::create($validated);

        $this->notifySuccess(
            $product->name . ' berhasil ditambahkan ke katalog.',
            'PRODUK TERSIMPAN'
        );

        return $this->redirect(route('admin.produk.index'), navigate: true);
    }

    public function saveAndAddAnother(): void
    {
        $validated = $this->validate();

        if ($this->image) {
            $validated['image_path'] = $this->image->store('products', 'public');
        }

        unset($validated['image']);

        $product = Product::create($validated);

        $this->notifySuccess(
            $product->name . ' berhasil ditambahkan. Silakan input produk berikutnya.',
            'PRODUK TERSIMPAN'
        );

        $this->reset(['category_id', 'name', 'sku', 'description', 'price', 'weight', 'stock', 'image']);
        $this->is_active = true;
    }

    #[Computed]
    public function categories()
    {
        return Category::orderBy('name')->get();
    }

    public function render()
    {
        return view('livewire.admin.produk.create');
    }
}
