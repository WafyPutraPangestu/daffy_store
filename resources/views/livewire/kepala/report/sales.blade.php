<div style="padding: 24px;">

    <div class="section-header"
        style="padding: 0 0 16px 0; margin-bottom: 24px; display: flex; justify-content: space-between; align-items: flex-end;">
        <div>
            <h1 class="rz" style="font-size: 24px; margin: 0; color: var(--color-ink);">LAPORAN PENJUALAN</h1>
            <span style="font-size: 11px; color: var(--color-ink-3); letter-spacing: 2px; text-transform: uppercase;">
                >>> EXECUTIVE / REPORTS / SALES
            </span>
        </div>

        <div>
            <span
                style="display: block; font-size: 10px; color: var(--color-ink-3); letter-spacing: 2px; text-transform: uppercase; margin-bottom: 8px;">PERIODE
                LAPORAN</span>
            <input type="month" wire:model.live="filterMonth"
                style="background: transparent; border: 1px solid var(--color-line); color: var(--color-ink); padding: 10px 16px; font-family: monospace; font-size: 13px; outline: none;">
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 24px;">
        <div
            style="border: 1px solid var(--color-line); background: var(--color-line-2); padding: 24px; border-left: 4px solid var(--color-accent);">
            <span
                style="display: block; font-size: 10px; color: var(--color-ink-3); letter-spacing: 2px; text-transform: uppercase; margin-bottom: 8px;">PENDAPATAN
                BERSIH (PERIODE INI)</span>
            <strong class="rz" style="font-size: 28px; color: var(--color-ink); display: block;">
                Rp {{ number_format($this->summary['total_revenue'], 0, ',', '.') }}
            </strong>
        </div>

        <div style="border: 1px solid var(--color-line); background: var(--color-line-2); padding: 24px;">
            <span
                style="display: block; font-size: 10px; color: var(--color-ink-3); letter-spacing: 2px; text-transform: uppercase; margin-bottom: 8px;">TOTAL
                PESANAN SELESAI</span>
            <strong class="rz" style="font-size: 28px; color: var(--color-ink); display: block;">
                {{ number_format($this->summary['total_orders']) }} <span
                    style="font-size: 14px; color: var(--color-ink-3);">TRANSAKSI</span>
            </strong>
        </div>
    </div>

    <div style="border: 1px solid var(--color-line);">
        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
                <tr style="border-bottom: 1px solid var(--color-line); background: var(--color-line-2);">
                    <th
                        style="padding: 16px; font-size: 11px; letter-spacing: 2px; color: var(--color-ink-3); font-weight: 600;">
                        WAKTU</th>
                    <th
                        style="padding: 16px; font-size: 11px; letter-spacing: 2px; color: var(--color-ink-3); font-weight: 600;">
                        NOMOR PESANAN</th>
                    <th
                        style="padding: 16px; font-size: 11px; letter-spacing: 2px; color: var(--color-ink-3); font-weight: 600;">
                        PELANGGAN</th>
                    <th
                        style="padding: 16px; font-size: 11px; letter-spacing: 2px; color: var(--color-ink-3); font-weight: 600;">
                        RINCIAN BARANG</th>
                    <th
                        style="padding: 16px; font-size: 11px; letter-spacing: 2px; color: var(--color-ink-3); font-weight: 600; text-align: right;">
                        TOTAL NILAI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($this->salesData as $order)
                    <tr style="border-bottom: 1px solid var(--color-line-2); transition: background 0.15s;"
                        onmouseover="this.style.background='var(--color-line-2)'"
                        onmouseout="this.style.background='transparent'">
                        <td style="padding: 16px; font-size: 13px; color: var(--color-ink-2);">
                            {{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td
                            style="padding: 16px; font-size: 14px; font-family: var(--font-blueprint); font-weight: 700; color: var(--color-ink);">
                            {{ $order->order_number }}</td>
                        <td style="padding: 16px; font-size: 13px; color: var(--color-ink);">
                            {{ $order->user->name ?? 'Guest' }}</td>

                        <td style="padding: 16px; font-size: 12px; color: var(--color-ink-2);">
                            <ul style="margin: 0; padding-left: 16px;">
                                @foreach ($order->items as $item)
                                    <li>{{ $item->quantity }}x {{ $item->product->name ?? 'Produk Dihapus' }}</li>
                                @endforeach
                            </ul>
                        </td>

                        <td
                            style="padding: 16px; font-size: 14px; color: var(--color-ink); font-family: monospace; font-weight: 600; text-align: right;">
                            Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">
                            <div class="empty-state">
                                <h2 class="empty-state-title">TIDAK ADA DATA PENJUALAN</h2>
                                <p class="empty-state-desc">Belum ada transaksi selesai pada periode bulan ini.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 24px;">{{ $this->salesData->links() }}</div>
</div>
