<div style="padding:32px;max-width:1200px;margin:0 auto">

    <div style="margin-bottom:24px">
        <div
            style="font-size:11px;letter-spacing:3px;text-transform:uppercase;color:var(--color-ink-3);margin-bottom:4px">
            Manajemen Katalog
        </div>
        <h1 style="font-size:24px;font-weight:700;color:var(--color-ink);margin:0">Peringatan Stok</h1>
    </div>

    {{-- Ringkasan --}}
    <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px;margin-bottom:24px">
        <div
            style="border:1px solid var(--color-line);border-left:3px solid #e53e3e;background:var(--color-paper);padding:16px">
            <div
                style="font-size:11px;letter-spacing:1px;text-transform:uppercase;color:var(--color-ink-3);margin-bottom:4px">
                Stok Habis</div>
            <div style="font-size:26px;font-weight:700;color:var(--color-ink)">{{ $this->outOfStockCount }}</div>
        </div>
        <div
            style="border:1px solid var(--color-line);border-left:3px solid #d97706;background:var(--color-paper);padding:16px">
            <div
                style="font-size:11px;letter-spacing:1px;text-transform:uppercase;color:var(--color-ink-3);margin-bottom:4px">
                Total Perlu Diawasi</div>
            <div style="font-size:26px;font-weight:700;color:var(--color-ink)">{{ $this->lowStockProducts->total() }}
            </div>
        </div>
        <div style="border:1px solid var(--color-line);background:var(--color-paper);padding:16px">
            <div
                style="font-size:11px;letter-spacing:1px;text-transform:uppercase;color:var(--color-ink-3);margin-bottom:8px">
                Ambang Batas Stok</div>
            <div style="display:flex;align-items:center;gap:8px">
                <input type="number" wire:model.live="threshold" min="0"
                    style="width:70px;padding:6px 8px;border:1px solid var(--color-line);background:var(--color-paper);color:var(--color-ink);font-size:13px">
                <span style="font-size:12px;color:var(--color-ink-3)">unit ke bawah</span>
            </div>
        </div>
    </div>

    <div style="border:1px solid var(--color-line);background:var(--color-paper);overflow-x:auto">
        <table style="width:100%;border-collapse:collapse;font-size:13px">
            <thead>
                <tr style="border-bottom:1px solid var(--color-line)">
                    <th
                        style="text-align:left;padding:12px 16px;color:var(--color-ink-3);font-size:11px;letter-spacing:1px;text-transform:uppercase">
                        Produk</th>
                    <th
                        style="text-align:left;padding:12px 16px;color:var(--color-ink-3);font-size:11px;letter-spacing:1px;text-transform:uppercase">
                        Kategori</th>
                    <th
                        style="text-align:center;padding:12px 16px;color:var(--color-ink-3);font-size:11px;letter-spacing:1px;text-transform:uppercase">
                        Sisa Stok</th>
                    <th
                        style="text-align:right;padding:12px 16px;color:var(--color-ink-3);font-size:11px;letter-spacing:1px;text-transform:uppercase">
                        Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($this->lowStockProducts as $product)
                    <tr wire:key="stock-{{ $product->id }}" style="border-bottom:1px solid var(--color-line)">
                        <td style="padding:12px 16px;color:var(--color-ink);font-weight:600">{{ $product->name }}</td>
                        <td style="padding:12px 16px;color:var(--color-ink-3)">{{ $product->category->name ?? '—' }}
                        </td>
                        <td style="padding:12px 16px;text-align:center">
                            <span
                                style="padding:3px 10px;font-size:12px;font-weight:700;
                                    background:{{ $product->stock == 0 ? 'rgba(229,62,62,.1)' : 'rgba(217,119,6,.1)' }};
                                    color:{{ $product->stock == 0 ? '#e53e3e' : '#d97706' }}">
                                {{ $product->stock == 0 ? 'HABIS' : $product->stock . ' unit' }}
                            </span>
                        </td>
                        <td style="padding:12px 16px;text-align:right">
                            <button wire:click="openRestock({{ $product->id }})"
                                style="display:inline-flex;align-items:center;gap:6px;padding:7px 14px;border:1px solid var(--color-line);background:none;color:var(--color-ink);font-size:12px;font-weight:600;cursor:pointer">
                                <i class="ti ti-plus"></i> Tambah Stok
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="padding:40px;text-align:center;color:var(--color-ink-3)">
                            <i class="ti ti-mood-happy" style="font-size:24px;display:block;margin-bottom:8px"></i>
                            Semua stok aman di atas ambang batas.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:16px">
        {{ $this->lowStockProducts->links() }}
    </div>

    {{-- Modal: Restock cepat --}}
    @if ($showRestockModal)
        <div
            style="position:fixed;inset:0;background:rgba(0,0,0,.5);display:flex;align-items:center;justify-content:center;z-index:9998;padding:16px">
            <div wire:click.outside="closeRestock"
                style="background:var(--color-paper);border:1px solid var(--color-line);width:100%;max-width:380px;padding:24px">
                <h3 style="margin:0 0 4px;font-size:16px;font-weight:700;color:var(--color-ink)">Tambah Stok</h3>
                <p style="font-size:13px;color:var(--color-ink-3);margin:0 0 16px">{{ $restockName }}</p>

                <label
                    style="display:block;font-size:12px;font-weight:600;color:var(--color-ink);margin-bottom:6px">Jumlah
                    Tambahan</label>
                <input type="number" wire:model="restockQty" min="1"
                    style="width:100%;padding:10px 12px;border:1px solid var(--color-line);background:var(--color-paper);color:var(--color-ink);font-size:13px;margin-bottom:4px">
                @error('restockQty')
                    <div style="font-size:12px;color:#e53e3e;margin-bottom:12px">{{ $message }}</div>
                @enderror

                <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:16px">
                    <button wire:click="closeRestock"
                        style="padding:9px 16px;border:1px solid var(--color-line);background:none;color:var(--color-ink);font-size:13px;font-weight:600;cursor:pointer">
                        Batal
                    </button>
                    <button wire:click="saveRestock"
                        style="padding:9px 16px;border:none;background:#0057ff;color:#fff;font-size:13px;font-weight:600;cursor:pointer">
                        Simpan
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
