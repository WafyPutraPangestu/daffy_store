<div style="padding:32px;max-width:1400px;margin:0 auto">

    <div style="margin-bottom:24px">
        <a href="{{ route('admin.produk.index') }}" wire:navigate
            style="font-size:12px;color:var(--color-ink-3);text-decoration:none;display:inline-flex;align-items:center;gap:4px;margin-bottom:8px">
            <i class="ti ti-arrow-left"></i> Kembali ke daftar produk
        </a>
        <h1 style="font-size:24px;font-weight:700;color:var(--color-ink);margin:0">Aksi Massal</h1>
    </div>

    {{-- Filter --}}
    <div style="display:flex;gap:12px;margin-bottom:16px;flex-wrap:wrap">
        <div style="position:relative;flex:1;min-width:220px">
            <i class="ti ti-search"
                style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--color-ink-3);font-size:16px"></i>
            <input type="text" wire:model.live.debounce.400ms="search" placeholder="Cari nama atau SKU produk..."
                style="width:100%;padding:10px 12px 10px 36px;border:1px solid var(--color-line);background:var(--color-paper);color:var(--color-ink);font-size:13px">
        </div>
        <select wire:model.live="categoryFilter"
            style="padding:10px 12px;border:1px solid var(--color-line);background:var(--color-paper);color:var(--color-ink);font-size:13px;min-width:160px">
            <option value="">Semua Kategori</option>
            @foreach ($this->categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
    </div>

    {{-- Toolbar aksi massal, muncul kalau ada yang dicentang --}}
    @if (count($selected) > 0)
        <div
            style="display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap;
                    background:rgba(0,87,255,.06);border:1px solid #0057ff;padding:12px 16px;margin-bottom:16px">
            <div style="font-size:13px;color:var(--color-ink);font-weight:600">
                {{ count($selected) }} produk dipilih
            </div>
            <div style="display:flex;gap:8px;flex-wrap:wrap">
                <button wire:click="openPriceModal"
                    style="display:inline-flex;align-items:center;gap:6px;padding:8px 14px;border:1px solid var(--color-line);background:var(--color-paper);color:var(--color-ink);font-size:12px;font-weight:600;cursor:pointer">
                    <i class="ti ti-currency-dollar"></i> Ubah Harga
                </button>
                <button wire:click="openStockModal"
                    style="display:inline-flex;align-items:center;gap:6px;padding:8px 14px;border:1px solid var(--color-line);background:var(--color-paper);color:var(--color-ink);font-size:12px;font-weight:600;cursor:pointer">
                    <i class="ti ti-box"></i> Tambah Stok
                </button>
                <button wire:click="bulkActivate"
                    style="display:inline-flex;align-items:center;gap:6px;padding:8px 14px;border:1px solid var(--color-line);background:var(--color-paper);color:var(--color-ink);font-size:12px;font-weight:600;cursor:pointer">
                    <i class="ti ti-eye"></i> Aktifkan
                </button>
                <button wire:click="bulkDeactivate"
                    style="display:inline-flex;align-items:center;gap:6px;padding:8px 14px;border:1px solid var(--color-line);background:var(--color-paper);color:var(--color-ink);font-size:12px;font-weight:600;cursor:pointer">
                    <i class="ti ti-eye-off"></i> Nonaktifkan
                </button>
                <button wire:click="openDeleteModal"
                    style="display:inline-flex;align-items:center;gap:6px;padding:8px 14px;border:none;background:#e53e3e;color:#fff;font-size:12px;font-weight:600;cursor:pointer">
                    <i class="ti ti-trash"></i> Hapus
                </button>
                <button wire:click="clearSelection"
                    style="padding:8px 10px;border:none;background:none;color:var(--color-ink-3);font-size:12px;cursor:pointer">
                    Batalkan Pilihan
                </button>
            </div>
        </div>
    @endif

    {{-- Table --}}
    <div style="border:1px solid var(--color-line);background:var(--color-paper);overflow-x:auto">
        <table style="width:100%;border-collapse:collapse;font-size:13px">
            <thead>
                <tr style="border-bottom:1px solid var(--color-line)">
                    <th style="padding:12px 16px;width:40px">
                        <input type="checkbox" wire:model.live="selectPage" style="width:16px;height:16px">
                    </th>
                    <th
                        style="text-align:left;padding:12px 16px;color:var(--color-ink-3);font-size:11px;letter-spacing:1px;text-transform:uppercase">
                        Produk</th>
                    <th
                        style="text-align:left;padding:12px 16px;color:var(--color-ink-3);font-size:11px;letter-spacing:1px;text-transform:uppercase">
                        SKU</th>
                    <th
                        style="text-align:right;padding:12px 16px;color:var(--color-ink-3);font-size:11px;letter-spacing:1px;text-transform:uppercase">
                        Harga</th>
                    <th
                        style="text-align:center;padding:12px 16px;color:var(--color-ink-3);font-size:11px;letter-spacing:1px;text-transform:uppercase">
                        Stok</th>
                    <th
                        style="text-align:center;padding:12px 16px;color:var(--color-ink-3);font-size:11px;letter-spacing:1px;text-transform:uppercase">
                        Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($this->products as $product)
                    <tr wire:key="bulk-{{ $product->id }}" style="border-bottom:1px solid var(--color-line)">
                        <td style="padding:12px 16px">
                            <input type="checkbox" wire:model.live="selected" value="{{ $product->id }}"
                                style="width:16px;height:16px">
                        </td>
                        <td style="padding:12px 16px;color:var(--color-ink);font-weight:600">{{ $product->name }}</td>
                        <td style="padding:12px 16px;color:var(--color-ink-3);font-family:monospace">{{ $product->sku }}
                        </td>
                        <td style="padding:12px 16px;text-align:right;color:var(--color-ink)">Rp
                            {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td style="padding:12px 16px;text-align:center;color:var(--color-ink)">{{ $product->stock }}
                        </td>
                        <td style="padding:12px 16px;text-align:center">
                            <span
                                style="padding:3px 10px;font-size:11px;font-weight:700;
                                    background:{{ $product->is_active ? 'rgba(0,87,255,.1)' : 'rgba(229,62,62,.1)' }};
                                    color:{{ $product->is_active ? '#0057ff' : '#e53e3e' }}">
                                {{ $product->is_active ? 'AKTIF' : 'NONAKTIF' }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="padding:40px;text-align:center;color:var(--color-ink-3)">Tidak ada
                            produk ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:16px">
        {{ $this->products->links() }}
    </div>

    {{-- Modal: Ubah Harga Massal --}}
    @if ($showPriceModal)
        <div
            style="position:fixed;inset:0;background:rgba(0,0,0,.5);display:flex;align-items:center;justify-content:center;z-index:9998;padding:16px">
            <div wire:click.outside="$set('showPriceModal', false)"
                style="background:var(--color-paper);border:1px solid var(--color-line);width:100%;max-width:420px;padding:24px">
                <h3 style="margin:0 0 4px;font-size:16px;font-weight:700;color:var(--color-ink)">Ubah Harga Massal</h3>
                <p style="font-size:13px;color:var(--color-ink-3);margin:0 0 16px">Berlaku untuk {{ count($selected) }}
                    produk terpilih.</p>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:14px">
                    <select wire:model="priceMode"
                        style="padding:9px 10px;border:1px solid var(--color-line);background:var(--color-paper);color:var(--color-ink);font-size:13px">
                        <option value="percentage">Persentase (%)</option>
                        <option value="fixed_amount">Nominal Tetap (Rp)</option>
                        <option value="fixed_value">Set Harga Baru (Rp)</option>
                    </select>
                    <select wire:model="priceDirection" @if ($priceMode === 'fixed_value') disabled @endif
                        style="padding:9px 10px;border:1px solid var(--color-line);background:var(--color-paper);color:var(--color-ink);font-size:13px">
                        <option value="increase">Naikkan</option>
                        <option value="decrease">Turunkan</option>
                    </select>
                </div>

                <input type="number" wire:model="priceValue" min="0" step="0.01"
                    placeholder="{{ $priceMode === 'percentage' ? 'Contoh: 10 (untuk 10%)' : 'Contoh: 5000' }}"
                    style="width:100%;padding:10px 12px;border:1px solid var(--color-line);background:var(--color-paper);color:var(--color-ink);font-size:13px">
                @error('priceValue')
                    <div style="font-size:12px;color:#e53e3e;margin-top:4px">{{ $message }}</div>
                @enderror

                <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:20px">
                    <button wire:click="$set('showPriceModal', false)"
                        style="padding:9px 16px;border:1px solid var(--color-line);background:none;color:var(--color-ink);font-size:13px;font-weight:600;cursor:pointer">
                        Batal
                    </button>
                    <button wire:click="applyBulkPrice"
                        style="padding:9px 16px;border:none;background:#0057ff;color:#fff;font-size:13px;font-weight:600;cursor:pointer">
                        Terapkan
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- Modal: Tambah Stok Massal --}}
    @if ($showStockModal)
        <div
            style="position:fixed;inset:0;background:rgba(0,0,0,.5);display:flex;align-items:center;justify-content:center;z-index:9998;padding:16px">
            <div wire:click.outside="$set('showStockModal', false)"
                style="background:var(--color-paper);border:1px solid var(--color-line);width:100%;max-width:380px;padding:24px">
                <h3 style="margin:0 0 4px;font-size:16px;font-weight:700;color:var(--color-ink)">Tambah Stok Massal</h3>
                <p style="font-size:13px;color:var(--color-ink-3);margin:0 0 16px">Berlaku untuk {{ count($selected) }}
                    produk terpilih.</p>

                <label
                    style="display:block;font-size:12px;font-weight:600;color:var(--color-ink);margin-bottom:6px">Jumlah
                    Tambahan per Produk</label>
                <input type="number" wire:model="stockQty" min="1"
                    style="width:100%;padding:10px 12px;border:1px solid var(--color-line);background:var(--color-paper);color:var(--color-ink);font-size:13px">
                @error('stockQty')
                    <div style="font-size:12px;color:#e53e3e;margin-top:4px">{{ $message }}</div>
                @enderror

                <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:20px">
                    <button wire:click="$set('showStockModal', false)"
                        style="padding:9px 16px;border:1px solid var(--color-line);background:none;color:var(--color-ink);font-size:13px;font-weight:600;cursor:pointer">
                        Batal
                    </button>
                    <button wire:click="applyBulkStock"
                        style="padding:9px 16px;border:none;background:#0057ff;color:#fff;font-size:13px;font-weight:600;cursor:pointer">
                        Terapkan
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- Modal: Konfirmasi Hapus Massal --}}
    @if ($showDeleteModal)
        <div
            style="position:fixed;inset:0;background:rgba(0,0,0,.5);display:flex;align-items:center;justify-content:center;z-index:9998;padding:16px">
            <div wire:click.outside="$set('showDeleteModal', false)"
                style="background:var(--color-paper);border:1px solid var(--color-line);width:100%;max-width:400px;padding:24px">
                <div style="display:flex;align-items:center;gap:10px;margin-bottom:12px">
                    <i class="ti ti-alert-triangle" style="font-size:22px;color:#e53e3e"></i>
                    <h3 style="margin:0;font-size:16px;font-weight:700;color:var(--color-ink)">Hapus
                        {{ count($selected) }} Produk?</h3>
                </div>
                <p style="font-size:13px;color:var(--color-ink-3);line-height:1.6;margin-bottom:20px">
                    Produk yang sudah pernah dipesan akan otomatis dilewati dan tidak ikut terhapus.
                </p>
                <div style="display:flex;gap:10px;justify-content:flex-end">
                    <button wire:click="$set('showDeleteModal', false)"
                        style="padding:9px 16px;border:1px solid var(--color-line);background:none;color:var(--color-ink);font-size:13px;font-weight:600;cursor:pointer">
                        Batal
                    </button>
                    <button wire:click="applyBulkDelete"
                        style="padding:9px 16px;border:none;background:#e53e3e;color:#fff;font-size:13px;font-weight:600;cursor:pointer">
                        Ya, Hapus
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
