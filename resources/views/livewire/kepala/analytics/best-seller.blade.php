<div style="padding: 24px;">

    <div class="section-header"
        style="padding: 0 0 16px 0; margin-bottom: 24px; display: flex; justify-content: space-between; align-items: flex-end;">
        <div>
            <h1 class="rz" style="font-size: 24px; margin: 0; color: var(--color-ink);">ANALISIS PRODUK TERLARIS</h1>
            <span style="font-size: 11px; color: var(--color-ink-3); letter-spacing: 2px; text-transform: uppercase;">
                >>> EXECUTIVE / ANALYTICS / BEST SELLERS
            </span>
        </div>

        <div>
            <span
                style="display: block; font-size: 10px; color: var(--color-ink-3); letter-spacing: 2px; text-transform: uppercase; margin-bottom: 8px;">PERIODE
                PENJUALAN</span>
            <input type="month" wire:model.live="filterMonth"
                style="background: transparent; border: 1px solid var(--color-line); color: var(--color-ink); padding: 10px 16px; font-family: monospace; font-size: 13px; outline: none;">
        </div>
    </div>

    <div style="border: 1px solid var(--color-line);">
        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
                <tr style="border-bottom: 1px solid var(--color-line); background: var(--color-line-2);">
                    <th
                        style="padding: 16px; font-size: 11px; letter-spacing: 2px; color: var(--color-ink-3); font-weight: 600; width: 60px; text-align: center;">
                        RANK</th>
                    <th
                        style="padding: 16px; font-size: 11px; letter-spacing: 2px; color: var(--color-ink-3); font-weight: 600;">
                        PRODUK</th>
                    <th
                        style="padding: 16px; font-size: 11px; letter-spacing: 2px; color: var(--color-ink-3); font-weight: 600;">
                        KATEGORI</th>
                    <th
                        style="padding: 16px; font-size: 11px; letter-spacing: 2px; color: var(--color-ink-3); font-weight: 600; text-align: center;">
                        TERJUAL</th>
                    <th
                        style="padding: 16px; font-size: 11px; letter-spacing: 2px; color: var(--color-ink-3); font-weight: 600; text-align: right;">
                        KONTRIBUSI PENDAPATAN</th>
                </tr>
            </thead>
            <tbody>
                @forelse($this->bestSellers as $index => $item)
                    <tr style="border-bottom: 1px solid var(--color-line-2); transition: background 0.15s;"
                        onmouseover="this.style.background='var(--color-line-2)'"
                        onmouseout="this.style.background='transparent'">
                        <td style="padding: 16px; text-align: center;">
                            @if ($index === 0 && $this->bestSellers->onFirstPage())
                                <span
                                    style="display: inline-block; background: #ffb224; color: #000; font-weight: bold; width: 24px; height: 24px; line-height: 24px; border-radius: 50%; font-size: 12px;">1</span>
                            @elseif($index === 1 && $this->bestSellers->onFirstPage())
                                <span
                                    style="display: inline-block; background: var(--color-ink-3); color: #fff; font-weight: bold; width: 24px; height: 24px; line-height: 24px; border-radius: 50%; font-size: 12px;">2</span>
                            @elseif($index === 2 && $this->bestSellers->onFirstPage())
                                <span
                                    style="display: inline-block; background: #ab6e41; color: #fff; font-weight: bold; width: 24px; height: 24px; line-height: 24px; border-radius: 50%; font-size: 12px;">3</span>
                            @else
                                <span
                                    style="color: var(--color-ink-3); font-family: monospace; font-size: 14px;">{{ ($this->bestSellers->currentPage() - 1) * $this->bestSellers->perPage() + $index + 1 }}</span>
                            @endif
                        </td>
                        <td style="padding: 16px;">
                            <strong
                                style="display: block; font-size: 14px; font-weight: 600; color: var(--color-ink);">{{ $item->product->name ?? 'Produk Dihapus' }}</strong>
                            <span style="font-size: 11px; color: var(--color-ink-3); font-family: monospace;">SKU:
                                {{ $item->product->sku ?? 'N/A' }}</span>
                        </td>
                        <td style="padding: 16px; font-size: 12px; color: var(--color-ink-2);">
                            {{ $item->product->category->name ?? 'Tanpa Kategori' }}
                        </td>
                        <td style="padding: 16px; text-align: center;">
                            <span
                                style="border: 1px solid var(--color-accent); color: var(--color-accent); padding: 4px 12px; font-size: 13px; font-weight: 700; font-family: monospace;">
                                {{ $item->total_qty }}
                            </span>
                        </td>
                        <td
                            style="padding: 16px; font-size: 14px; color: var(--color-ink); font-family: monospace; font-weight: 600; text-align: right;">
                            Rp {{ number_format($item->total_revenue, 0, ',', '.') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">
                            <div class="empty-state">
                                <h2 class="empty-state-title">DATA TIDAK DITEMUKAN</h2>
                                <p class="empty-state-desc">Belum ada data penjualan produk yang valid pada periode ini.
                                </p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="margin-top: 24px;">{{ $this->bestSellers->links() }}</div>
</div>
