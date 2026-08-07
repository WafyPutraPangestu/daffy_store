<div style="padding: 24px; max-width: 900px; margin: 0 auto;">

    <div class="section-header" style="padding: 0 0 16px 0; margin-bottom: 24px;">
        <h1 class="rz" style="font-size: 24px; margin: 0; color: var(--color-ink);">DAFTAR TRANSAKSI</h1>
        <span style="font-size: 11px; color: var(--color-ink-3); letter-spacing: 2px; text-transform: uppercase;">
            >>> USER / ORDER HISTORY / {{ $status ? str_replace('_', ' ', $status) : 'ALL' }}
        </span>
    </div>

    <div class="filter-bar" style="margin-bottom: 24px; overflow-x: auto; white-space: nowrap;">
        <div wire:click="$set('status', '')" class="filter-item {{ $status === '' ? 'active' : '' }}">
            SEMUA
        </div>
        <div wire:click="$set('status', 'menunggu_pembayaran')"
            class="filter-item {{ $status === 'menunggu_pembayaran' ? 'active' : '' }}">
            MENUNGGU PEMBAYARAN
        </div>
        <div wire:click="$set('status', 'diproses')" class="filter-item {{ $status === 'diproses' ? 'active' : '' }}">
            DIPROSES
        </div>
        <div wire:click="$set('status', 'dikirim')" class="filter-item {{ $status === 'dikirim' ? 'active' : '' }}">
            DIKIRIM
        </div>
        <div wire:click="$set('status', 'selesai')" class="filter-item {{ $status === 'selesai' ? 'active' : '' }}">
            SELESAI
        </div>
        <div wire:click="$set('status', 'dibatalkan')"
            class="filter-item {{ $status === 'dibatalkan' ? 'active' : '' }}">
            DIBATALKAN
        </div>
    </div>

    <div style="display: flex; flex-direction: column; gap: 24px;">
        @forelse($this->orders as $order)
            <div style="border: 1px solid var(--color-line); background: var(--color-paper);">

                <div
                    style="padding: 16px 24px; border-bottom: 1px solid var(--color-line); background: var(--color-line-2); display: flex; justify-content: space-between; align-items: center;">
                    <div style="display: flex; gap: 16px; align-items: center;">
                        <span
                            style="font-size: 12px; color: var(--color-ink-2);">{{ $order->created_at->format('d M Y') }}</span>
                        <span
                            style="font-size: 14px; font-family: var(--font-blueprint); font-weight: 700; color: var(--color-ink);">{{ $order->order_number }}</span>
                    </div>

                    <div>
                        @if ($order->status === 'menunggu_pembayaran')
                            <span class="nav-badge-outline" style="border-color: #ffb224; color: #ffb224;">MENUNGGU
                                PEMBAYARAN</span>
                        @elseif($order->status === 'diproses')
                            <span class="nav-badge-outline"
                                style="border-color: var(--color-ink); color: var(--color-ink);">SEDANG DIPROSES</span>
                        @elseif($order->status === 'dikirim')
                            <span class="nav-badge-outline" style="border-color: #3a8fff; color: #3a8fff;">SEDANG
                                DIKIRIM</span>
                        @elseif($order->status === 'selesai')
                            <span class="nav-badge-outline"
                                style="border-color: #30a46c; color: #30a46c;">SELESAI</span>
                        @elseif($order->status === 'dibatalkan')
                            <span class="nav-badge-outline"
                                style="border-color: #e5484d; color: #e5484d;">DIBATALKAN</span>
                        @endif
                    </div>
                </div>

                <div style="padding: 24px; display: flex; gap: 24px; align-items: center;">
                    @php $firstItem = $order->items->first(); @endphp

                    @if ($firstItem && $firstItem->product)
                        <div style="width: 80px; height: 80px; border: 1px solid var(--color-line); flex-shrink: 0;">
                            @if ($firstItem->product->image_path)
                                <img src="{{ asset('storage/' . $firstItem->product->image_path) }}"
                                    alt="{{ $firstItem->product->name }}"
                                    style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <div
                                    style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: var(--color-line-2);">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        stroke="var(--color-ink-3)" stroke-width="1.5">
                                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2" />
                                        <circle cx="8.5" cy="8.5" r="1.5" />
                                        <polyline points="21 15 16 10 5 21" />
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <div style="flex: 1;">
                            <h3 class="rz" style="font-size: 16px; margin: 0 0 4px 0; color: var(--color-ink);">
                                {{ $firstItem->product->name }}</h3>
                            <span
                                style="display: block; font-size: 12px; color: var(--color-ink-3); margin-bottom: 8px;">{{ $firstItem->quantity }}
                                barang x Rp {{ number_format($firstItem->unit_price, 0, ',', '.') }}</span>

                            @if ($order->items->count() > 1)
                                <span
                                    style="font-size: 11px; color: var(--color-accent); font-weight: 600; letter-spacing: 1px;">
                                    + {{ $order->items->count() - 1 }} PRODUK LAINNYA
                                </span>
                            @endif
                        </div>
                    @else
                        <div style="flex: 1; color: var(--color-ink-3); font-size: 12px;">Produk dalam pesanan ini telah
                            dihapus dari sistem.</div>
                    @endif

                    <div style="text-align: right; border-left: 1px dashed var(--color-line); padding-left: 24px;">
                        <span
                            style="display: block; font-size: 10px; color: var(--color-ink-3); letter-spacing: 2px; text-transform: uppercase; margin-bottom: 4px;">TOTAL
                            BELANJA</span>
                        <strong style="font-size: 18px; color: var(--color-ink); font-family: monospace;">Rp
                            {{ number_format($order->total_amount, 0, ',', '.') }}</strong>
                    </div>
                </div>

                <div
                    style="padding: 16px 24px; border-top: 1px solid var(--color-line); display: flex; justify-content: flex-end; gap: 12px; background: var(--color-line-2);">

                    <a href="{{ route('pelanggan.transaction.show', $order->id) }}" class="btn-outline"
                        style="text-decoration: none; padding: 8px 16px;">
                        LIHAT DETAIL
                    </a>

                    @if ($order->status === 'menunggu_pembayaran')
                        <a href="{{ route('pelanggan.transaction.show', $order->id) }}"
                            class="btn-primary"
                            style="text-decoration: none; padding: 8px 16px; background: #ffb224; color: #000; border-color: #ffb224;">
                            BAYAR SEKARANG
                        </a>
                    @elseif($order->status === 'dikirim' && $order->tracking_number)
                        <a href="{{ route('pelanggan.transaction.tracking') }}?resi={{ $order->tracking_number }}"
                            wire:navigate class="btn-primary" style="text-decoration: none; padding: 8px 16px;">
                            LACAK PAKET
                        </a>
                    @endif

                </div>

            </div>
        @empty
            <div class="empty-state">
                <div class="empty-state-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.5">
                        <rect x="2" y="3" width="20" height="14" rx="2" ry="2" />
                        <line x1="8" y1="21" x2="16" y2="21" />
                        <line x1="12" y1="17" x2="12" y2="21" />
                    </svg>
                </div>
                <h2 class="empty-state-title">TIDAK ADA TRANSAKSI</h2>
                <p class="empty-state-desc">Belum ada riwayat pesanan yang sesuai dengan filter pencarian Anda.</p>
                <a href="{{ route('pelanggan.katalog') }}" wire:navigate class="btn-primary"
                    style="text-decoration: none; display: inline-block; margin-top: 16px;">
                    MULAI BELANJA
                </a>
            </div>
        @endforelse
    </div>

    <div style="margin-top: 32px;">
        {{ $this->orders->links() }}
    </div>

</div>
