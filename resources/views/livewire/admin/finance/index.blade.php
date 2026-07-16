<div style="padding: 24px;">

    <div class="section-header" style="padding: 0 0 16px 0; margin-bottom: 24px;">
        <div>
            <h1 class="rz" style="font-size: 24px; margin: 0; color: var(--color-ink);">REKONSILIASI KEUANGAN</h1>
            <span style="font-size: 11px; color: var(--color-ink-3); letter-spacing: 2px; text-transform: uppercase;">
                >>> SYSTEM / FINANCE / RECONCILIATION
            </span>
        </div>
    </div>

    <div class="filter-bar" style="margin-bottom: 24px;">
        <span class="filter-bar-label">FILTER STATUS PENDANAAN:</span>
        <div wire:click="$set('paymentStatus', '')" class="filter-item {{ $paymentStatus === '' ? 'active' : '' }}">
            SEMUA TRANSAKSI
        </div>
        <div wire:click="$set('paymentStatus', 'pending')"
            class="filter-item {{ $paymentStatus === 'pending' ? 'active' : '' }}">
            MENUNGGU VERIFIKASI <span class="dot-status yellow" style="margin-left: 6px;"></span>
        </div>
        <div wire:click="$set('paymentStatus', 'paid')"
            class="filter-item {{ $paymentStatus === 'paid' ? 'active' : '' }}">
            DANA MASUK (PAID) <span class="dot-status green" style="margin-left: 6px;"></span>
        </div>
    </div>

    <div style="margin-bottom: 24px;">
        <input type="text" wire:model.live.debounce.500ms="search" placeholder="CARI NOMOR PESANAN..."
            style="background: transparent; border: 1px solid var(--color-line); color: var(--color-ink); padding: 12px 16px; width: 320px; font-size: 11px; letter-spacing: 2px; outline: none;">
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
                        METODE</th>
                    <th
                        style="padding: 16px; font-size: 11px; letter-spacing: 2px; color: var(--color-ink-3); font-weight: 600;">
                        NOMINAL</th>
                    <th
                        style="padding: 16px; font-size: 11px; letter-spacing: 2px; color: var(--color-ink-3); font-weight: 600;">
                        STATUS DANA</th>
                    <th
                        style="padding: 16px; font-size: 11px; letter-spacing: 2px; color: var(--color-ink-3); font-weight: 600; text-align: right;">
                        AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($this->payments as $payment)
                    <tr style="border-bottom: 1px solid var(--color-line-2); transition: background 0.15s;"
                        onmouseover="this.style.background='var(--color-line-2)'"
                        onmouseout="this.style.background='transparent'">
                        <td style="padding: 16px; font-size: 13px; color: var(--color-ink-2);">
                            {{ $payment->created_at->format('d/m H:i') }}</td>
                        <td
                            style="padding: 16px; font-size: 14px; font-family: var(--font-blueprint); font-weight: 700; color: var(--color-ink);">
                            {{ $payment->order->order_number ?? 'PESANAN DIHAPUS' }}
                        </td>

                        <td style="padding: 16px; font-size: 12px; color: var(--color-ink);">
                            <span style="border: 1px solid var(--color-line); padding: 4px 8px; font-weight: 600;">
                                {{ strtoupper($payment->payment_method ?? 'TRANSFER') }}
                            </span>
                        </td>

                        <td
                            style="padding: 16px; font-size: 14px; color: var(--color-ink); font-family: monospace; font-weight: 600;">
                            Rp {{ number_format($payment->amount, 0, ',', '.') }}
                        </td>

                        <td style="padding: 16px;">
                            @if ($payment->status === 'paid')
                                <span class="nav-badge-outline"
                                    style="border-color: #30a46c; color: #30a46c;">PAID</span>
                            @elseif($payment->status === 'failed' || $payment->status === 'expired')
                                <span class="nav-badge-outline"
                                    style="border-color: #e5484d; color: #e5484d;">{{ strtoupper($payment->status) }}</span>
                            @else
                                <span class="nav-badge-outline"
                                    style="border-color: #ffb224; color: #ffb224;">PENDING</span>
                            @endif
                        </td>

                        <td style="padding: 16px; text-align: right;">
                            @if ($payment->status === 'pending')
                                <button wire:click="verifyPayment({{ $payment->id }})" class="btn-primary"
                                    style="padding: 8px 16px;">
                                    VERIFIKASI
                                </button>
                            @elseif($payment->status === 'paid')
                                <span style="font-size: 11px; color: #30a46c; font-weight: 600; letter-spacing: 1px;">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2"
                                        style="display:inline; margin-bottom: -2px;">
                                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                                        <polyline points="22 4 12 14.01 9 11.01" />
                                    </svg> CLEAR
                                </span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <h2 class="empty-state-title">DATA TRANSAKSI KOSONG</h2>
                                <p class="empty-state-desc">Tidak ditemukan transaksi dengan filter yang aktif saat ini.
                                </p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="margin-top: 24px;">{{ $this->payments->links() }}</div>
</div>
