<div style="padding:32px;max-width:840px;margin:0 auto">

    <div style="margin-bottom:24px">
        <a href="{{ route('admin.produk.index') }}" wire:navigate
            style="font-size:12px;color:var(--color-ink-3);text-decoration:none;display:inline-flex;align-items:center;gap:4px;margin-bottom:8px">
            <i class="ti ti-arrow-left"></i> Kembali ke daftar produk
        </a>
        <h1 style="font-size:24px;font-weight:700;color:var(--color-ink);margin:0">Tambah Produk Baru</h1>
    </div>

    <form wire:submit="save" style="border:1px solid var(--color-line);background:var(--color-paper);padding:28px">

        {{-- Upload Foto --}}
        <div style="margin-bottom:24px">
            <label style="display:block;font-size:12px;font-weight:600;color:var(--color-ink);margin-bottom:8px">Foto
                Produk</label>
            <div style="display:flex;gap:16px;align-items:center">
                <div
                    style="width:90px;height:90px;flex-shrink:0;background:var(--color-line);overflow:hidden;display:flex;align-items:center;justify-content:center">
                    @if ($image)
                        <img src="{{ $image->temporaryUrl() }}" style="width:100%;height:100%;object-fit:cover">
                    @else
                        <i class="ti ti-photo" style="font-size:24px;color:var(--color-ink-3)"></i>
                    @endif
                </div>
                <div style="flex:1">
                    <input type="file" wire:model="image" accept="image/*"
                        style="font-size:13px;color:var(--color-ink)">
                    <div wire:loading wire:target="image"
                        style="font-size:12px;color:var(--color-ink-3);margin-top:4px">Mengunggah...</div>
                    @error('image')
                        <div style="font-size:12px;color:#e53e3e;margin-top:4px">{{ $message }}</div>
                    @enderror
                    <div style="font-size:11px;color:var(--color-ink-3);margin-top:4px">JPG/PNG, maksimal 2MB.</div>
                </div>
            </div>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px">
            <div>
                <label
                    style="display:block;font-size:12px;font-weight:600;color:var(--color-ink);margin-bottom:6px">Nama
                    Produk</label>
                <input type="text" wire:model.live="name" placeholder="Contoh: Kaos Polos Combed 30s"
                    style="width:100%;padding:10px 12px;border:1px solid var(--color-line);background:var(--color-paper);color:var(--color-ink);font-size:13px">
                @error('name')
                    <div style="font-size:12px;color:#e53e3e;margin-top:4px">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label
                    style="display:block;font-size:12px;font-weight:600;color:var(--color-ink);margin-bottom:6px">SKU</label>
                <input type="text" wire:model="sku" placeholder="Kode unik produk"
                    style="width:100%;padding:10px 12px;border:1px solid var(--color-line);background:var(--color-paper);color:var(--color-ink);font-size:13px;font-family:monospace">
                @error('sku')
                    <div style="font-size:12px;color:#e53e3e;margin-top:4px">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div style="margin-bottom:16px">
            <label
                style="display:block;font-size:12px;font-weight:600;color:var(--color-ink);margin-bottom:6px">Deskripsi</label>
            <textarea wire:model="description" rows="4" placeholder="Deskripsi singkat produk..."
                style="width:100%;padding:10px 12px;border:1px solid var(--color-line);background:var(--color-paper);color:var(--color-ink);font-size:13px;resize:vertical"></textarea>
            @error('description')
                <div style="font-size:12px;color:#e53e3e;margin-top:4px">{{ $message }}</div>
            @enderror
        </div>

        {{-- Mengubah grid menjadi 2 baris agar rapi --}}
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px">
            <div>
                <label
                    style="display:block;font-size:12px;font-weight:600;color:var(--color-ink);margin-bottom:6px">Kategori</label>
                <select wire:model="category_id"
                    style="width:100%;padding:10px 12px;border:1px solid var(--color-line);background:var(--color-paper);color:var(--color-ink);font-size:13px">
                    <option value="">Tanpa Kategori</option>
                    @foreach ($this->categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label
                    style="display:block;font-size:12px;font-weight:600;color:var(--color-ink);margin-bottom:6px">Harga
                    (Rp)</label>
                <input type="number" wire:model="price" placeholder="0" min="0" step="0.01"
                    style="width:100%;padding:10px 12px;border:1px solid var(--color-line);background:var(--color-paper);color:var(--color-ink);font-size:13px">
                @error('price')
                    <div style="font-size:12px;color:#e53e3e;margin-top:4px">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label
                    style="display:block;font-size:12px;font-weight:600;color:var(--color-ink);margin-bottom:6px">Stok
                    Awal</label>
                <input type="number" wire:model="stock" placeholder="0" min="0"
                    style="width:100%;padding:10px 12px;border:1px solid var(--color-line);background:var(--color-paper);color:var(--color-ink);font-size:13px">
                @error('stock')
                    <div style="font-size:12px;color:#e53e3e;margin-top:4px">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label
                    style="display:block;font-size:12px;font-weight:600;color:var(--color-ink);margin-bottom:6px">Berat
                    (Gram)</label>
                <input type="number" wire:model="weight" placeholder="500" min="1"
                    style="width:100%;padding:10px 12px;border:1px solid var(--color-line);background:var(--color-paper);color:var(--color-ink);font-size:13px">
                @error('weight')
                    <div style="font-size:12px;color:#e53e3e;margin-top:4px">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <label style="display:flex;align-items:center;gap:8px;margin-bottom:24px;cursor:pointer">
            <input type="checkbox" wire:model="is_active" style="width:16px;height:16px">
            <span style="font-size:13px;color:var(--color-ink)">Aktifkan produk ini (langsung tampil di etalase)</span>
        </label>

        <div
            style="display:flex;gap:10px;justify-content:flex-end;border-top:1px solid var(--color-line);padding-top:20px">
            <a href="{{ route('admin.produk.index') }}" wire:navigate
                style="padding:10px 18px;border:1px solid var(--color-line);color:var(--color-ink);text-decoration:none;font-size:13px;font-weight:600">
                Batal
            </a>
            <button type="button" wire:click="saveAndAddAnother" wire:loading.attr="disabled"
                wire:target="saveAndAddAnother"
                style="padding:10px 18px;border:1px solid var(--color-line);background:none;color:var(--color-ink);font-size:13px;font-weight:600;cursor:pointer">
                Simpan &amp; Tambah Lagi
            </button>
            <button type="submit" wire:loading.attr="disabled" wire:target="save"
                style="padding:10px 18px;border:none;background:#0057ff;color:#fff;font-size:13px;font-weight:600;cursor:pointer">
                <span wire:loading.remove wire:target="save">Simpan Produk</span>
                <span wire:loading wire:target="save">Menyimpan...</span>
            </button>
        </div>
    </form>
</div>
