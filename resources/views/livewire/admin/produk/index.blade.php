<div style="padding:32px;max-width:1400px;margin:0 auto">

    {{-- Header --}}
    <div
        style="display:flex;justify-content:space-between;align-items:flex-end;margin-bottom:24px;gap:16px;flex-wrap:wrap">
        <div>
            <div
                style="font-size:11px;letter-spacing:3px;text-transform:uppercase;color:var(--color-ink-3);margin-bottom:4px">
                Manajemen Katalog
            </div>
            <h1 style="font-size:24px;font-weight:700;color:var(--color-ink);margin:0">Semua Produk</h1>
        </div>
        <div style="display:flex;gap:10px">
            <a href="{{ route('admin.produk.bulk-manager') }}" wire:navigate
                style="display:inline-flex;align-items:center;gap:6px;padding:10px 16px;border:1px solid var(--color-line);color:var(--color-ink);text-decoration:none;font-size:13px;font-weight:600">
                <i class="ti ti-checklist"></i> Aksi Massal
            </a>
            <a href="{{ route('admin.produk.create') }}" wire:navigate
                style="display:inline-flex;align-items:center;gap:6px;padding:10px 16px;background:#0057ff;color:#fff;text-decoration:none;font-size:13px;font-weight:600">
                <i class="ti ti-plus"></i> Tambah Produk
            </a>
        </div>
    </div>

    {{-- Filter bar --}}
    <div style="display:flex;gap:12px;margin-bottom:20px;flex-wrap:wrap">
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
        <select wire:model.live="statusFilter"
            style="padding:10px 12px;border:1px solid var(--color-line);background:var(--color-paper);color:var(--color-ink);font-size:13px">
            <option value="all">Semua Status</option>
            <option value="active">Aktif</option>
            <option value="inactive">Nonaktif</option>
        </select>
    </div>

    {{-- Table --}}
    <div style="border:1px solid var(--color-line);background:var(--color-paper);overflow-x:auto">
        <table style="width:100%;border-collapse:collapse;font-size:13px">
            <thead>
                <tr style="border-bottom:1px solid var(--color-line)">
                    <th
                        style="text-align:left;padding:12px 16px;color:var(--color-ink-3);font-size:11px;letter-spacing:1px;text-transform:uppercase">
                        Produk</th>
                    <th
                        style="text-align:left;padding:12px 16px;color:var(--color-ink-3);font-size:11px;letter-spacing:1px;text-transform:uppercase">
                        SKU</th>
                    <th
                        style="text-align:left;padding:12px 16px;color:var(--color-ink-3);font-size:11px;letter-spacing:1px;text-transform:uppercase">
                        Kategori</th>
                    <th
                        style="text-align:right;padding:12px 16px;color:var(--color-ink-3);font-size:11px;letter-spacing:1px;text-transform:uppercase">
                        Harga</th>
                    <th
                        style="text-align:center;padding:12px 16px;color:var(--color-ink-3);font-size:11px;letter-spacing:1px;text-transform:uppercase">
                        Berat</th>
                    <th
                        style="text-align:center;padding:12px 16px;color:var(--color-ink-3);font-size:11px;letter-spacing:1px;text-transform:uppercase">
                        Stok</th>
                    <th
                        style="text-align:center;padding:12px 16px;color:var(--color-ink-3);font-size:11px;letter-spacing:1px;text-transform:uppercase">
                        Status</th>
                    <th
                        style="text-align:right;padding:12px 16px;color:var(--color-ink-3);font-size:11px;letter-spacing:1px;text-transform:uppercase">
                        Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($this->products as $product)
                    <tr wire:key="product-{{ $product->id }}" style="border-bottom:1px solid var(--color-line)">
                        <td style="padding:12px 16px">
                            <div style="display:flex;align-items:center;gap:10px">
                                <div
                                    style="width:38px;height:38px;flex-shrink:0;background:var(--color-line);overflow:hidden">
                                    @if ($product->image_path)
                                        <img src="{{ Storage::url($product->image_path) }}" alt="{{ $product->name }}"
                                            style="width:100%;height:100%;object-fit:cover">
                                    @else
                                        <div
                                            style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;color:var(--color-ink-3)">
                                            <i class="ti ti-photo" style="font-size:16px"></i>
                                        </div>
                                    @endif
                                </div>
                                <span style="color:var(--color-ink);font-weight:600">{{ $product->name }}</span>
                            </div>
                        </td>
                        <td style="padding:12px 16px;color:var(--color-ink-3);font-family:monospace">{{ $product->sku }}
                        </td>
                        <td style="padding:12px 16px;color:var(--color-ink)">{{ $product->category->name ?? '—' }}</td>
                        <td style="padding:12px 16px;text-align:right;color:var(--color-ink)">Rp
                            {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td style="padding:12px 16px;text-align:center;font-family:monospace;color:var(--color-ink-2)">
                            {{ $product->weight }}g
                        </td>
                        <td style="padding:12px 16px;text-align:center">
                            <span
                                style="color:{{ $product->stock <= 5 ? '#e53e3e' : 'var(--color-ink)' }};font-weight:{{ $product->stock <= 5 ? '700' : '400' }}">
                                {{ $product->stock }}
                            </span>
                        </td>
                        <td style="padding:12px 16px;text-align:center">
                            <button wire:click="toggleActive({{ $product->id }})"
                                style="border:none;cursor:pointer;padding:4px 10px;font-size:11px;font-weight:600;letter-spacing:1px;text-transform:uppercase;
                                       background:{{ $product->is_active ? 'rgba(0,87,255,.1)' : 'rgba(229,62,62,.1)' }};
                                       color:{{ $product->is_active ? '#0057ff' : '#e53e3e' }}">
                                {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                            </button>
                        </td>
                        <td style="padding:12px 16px;text-align:right">
                            <div style="display:flex;gap:8px;justify-content:flex-end">
                                <a href="{{ route('admin.produk.edit', $product) }}" wire:navigate
                                    style="color:var(--color-ink-3);text-decoration:none" title="Edit">
                                    <i class="ti ti-edit" style="font-size:17px"></i>
                                </a>
                                <button wire:click="confirmDelete({{ $product->id }})"
                                    style="background:none;border:none;cursor:pointer;color:#e53e3e;padding:0"
                                    title="Hapus">
                                    <i class="ti ti-trash" style="font-size:17px"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="padding:40px;text-align:center;color:var(--color-ink-3)">
                            Belum ada produk yang cocok dengan filter ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:16px">
        {{ $this->products->links() }}
    </div>

    {{-- Modal: Konfirmasi Hapus --}}
    @if ($showDeleteModal)
        <div x-data x-init="$el.focus()" tabindex="-1" @keydown.escape.window="$wire.cancelDelete()"
            style="position:fixed;inset:0;background:rgba(0,0,0,.5);display:flex;align-items:center;justify-content:center;z-index:9998;padding:16px">
            <div wire:click.outside="cancelDelete"
                style="background:var(--color-paper);border:1px solid var(--color-line);width:100%;max-width:400px;padding:24px">
                <div style="display:flex;align-items:center;gap:10px;margin-bottom:12px">
                    <i class="ti ti-alert-triangle" style="font-size:22px;color:#e53e3e"></i>
                    <h3 style="margin:0;font-size:16px;font-weight:700;color:var(--color-ink)">Hapus Produk?</h3>
                </div>
                <p style="font-size:13px;color:var(--color-ink-3);line-height:1.6;margin-bottom:20px">
                    Produk <strong style="color:var(--color-ink)">{{ $deleteName }}</strong> akan dihapus permanen.
                    Tindakan ini tidak bisa dibatalkan.
                </p>
                <div style="display:flex;gap:10px;justify-content:flex-end">
                    <button wire:click="cancelDelete"
                        style="padding:9px 16px;border:1px solid var(--color-line);background:none;color:var(--color-ink);font-size:13px;font-weight:600;cursor:pointer">
                        Batal
                    </button>
                    <button wire:click="delete"
                        style="padding:9px 16px;border:none;background:#e53e3e;color:#fff;font-size:13px;font-weight:600;cursor:pointer">
                        Ya, Hapus
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
