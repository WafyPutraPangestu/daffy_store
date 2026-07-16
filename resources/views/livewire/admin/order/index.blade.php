<div style="padding: 24px;">

    <!-- HEADER DINAMIS -->
    <div class="section-header" style="padding: 0 0 16px 0; margin-bottom: 24px;">
        <div>
            <h1 class="rz" style="font-size: 24px; margin: 0; color: var(--color-ink);">
                @if ($status === 'diproses')
                    PESANAN: PERLU DIPROSES
                @elseif($status === 'dikirim')
                    PESANAN: PERLU DIKIRIM
                @else
                    SEMUA PESANAN
                @endif
            </h1>
            <span style="font-size: 11px; color: var(--color-ink-3); letter-spacing: 2px; text-transform: uppercase;">
                >>> SYSTEM / LOGISTIC / {{ $status ? strtoupper(str_replace('_', ' ', $status)) : 'ALL' }}
            </span>
        </div>
    </div>

    <!-- PENCARIAN -->
    <div style="margin-bottom: 24px;">
        <input type="text" wire:model.live.debounce.500ms="search" placeholder="CARI NOMOR PESANAN..."
            style="background: transparent; border: 1px solid var(--color-line); color: var(--color-ink); padding: 12px 16px; width: 300px; font-size: 11px; letter-spacing: 2px; text-transform: uppercase; outline: none; transition: border-color 0.15s;"
            onfocus="this.style.borderColor='var(--color-ink)'" onblur="this.style.borderColor='var(--color-line)'">
    </div>

    <!-- TABEL DATA -->
    <div style="border: 1px solid var(--color-line);">
        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
                <tr style="border-bottom: 1px solid var(--color-line); background: var(--color-line-2);">
                    <th
                        style="padding: 16px; font-size: 11px; letter-spacing: 2px; color: var(--color-ink-3); font-weight: 600;">
                        TANGGAL</th>
                    <th
                        style="padding: 16px; font-size: 11px; letter-spacing: 2px; color: var(--color-ink-3); font-weight: 600;">
                        NOMOR PESANAN</th>
                    <th
                        style="padding: 16px; font-size: 11px; letter-spacing: 2px; color: var(--color-ink-3); font-weight: 600;">
                        PENERIMA</th>
                    <th
                        style="padding: 16px; font-size: 11px; letter-spacing: 2px; color: var(--color-ink-3); font-weight: 600;">
                        TOTAL</th>
                    <th
                        style="padding: 16px; font-size: 11px; letter-spacing: 2px; color: var(--color-ink-3); font-weight: 600;">
                        STATUS</th>
                    <th
                        style="padding: 16px; font-size: 11px; letter-spacing: 2px; color: var(--color-ink-3); font-weight: 600; text-align: right;">
                        AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($this->orders as $order)
                    <tr style="border-bottom: 1px solid var(--color-line); transition: background 0.15s;"
                        onmouseover="this.style.background='var(--color-line-2)'"
                        onmouseout="this.style.background='transparent'">
                        <td style="padding: 16px; font-size: 13px; color: var(--color-ink-2);">
                            {{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td
                            style="padding: 16px; font-size: 14px; font-family: var(--font-blueprint); font-weight: 700; color: var(--color-ink); letter-spacing: 1px;">
                            {{ $order->order_number }}</td>
                        <td style="padding: 16px; font-size: 13px; color: var(--color-ink);">
                            {{ $order->recipient_name }}</td>
                        <td
                            style="padding: 16px; font-size: 14px; color: var(--color-accent); font-family: monospace; font-weight: 600;">
                            Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>

                        <td style="padding: 16px;">
                            @if ($order->status === 'diproses')
                                <span
                                    style="border: 1px solid #ffb224; color: #ffb224; padding: 4px 8px; font-size: 9px; font-weight: 700; letter-spacing: 2px;">DIPROSES</span>
                            @elseif($order->status === 'dikirim')
                                <span
                                    style="border: 1px solid var(--color-accent); color: var(--color-accent); padding: 4px 8px; font-size: 9px; font-weight: 700; letter-spacing: 2px;">DIKIRIM</span>
                            @else
                                <span
                                    style="border: 1px solid var(--color-line); color: var(--color-ink); padding: 4px 8px; font-size: 9px; font-weight: 700; letter-spacing: 2px;">{{ strtoupper(str_replace('_', ' ', $order->status)) }}</span>
                            @endif
                        </td>

                        <td style="padding: 16px; text-align: right;">
                            <a href="{{ route('admin.order.show', $order->id) }}" wire:navigate class="btn-outline"
                                style="padding: 8px 16px; text-decoration: none; display: inline-block;">
                                DETAIL
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <h2 class="empty-state-title">TIDAK ADA DATA PESANAN</h2>
                                <p class="empty-state-desc">Belum ada transaksi dengan status yang dipilih.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 24px;">{{ $this->orders->links() }}</div>
</div>
