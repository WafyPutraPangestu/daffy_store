<div style="padding: 24px; max-width: 800px; margin: 0 auto;">

    <div class="section-header"
        style="padding: 0 0 16px 0; margin-bottom: 32px; text-align: center; border-bottom: 1px solid var(--color-line);">
        <h1 class="rz" style="font-size: 28px; margin: 0; color: var(--color-ink);">LACAK PENGIRIMAN</h1>
        <span style="font-size: 11px; color: var(--color-ink-3); letter-spacing: 2px; text-transform: uppercase;">
            >>> REAL-TIME LOGISTIC TRACKING SYSTEM
        </span>
    </div>

    <div
        style="border: 1px solid var(--color-line); padding: 24px; background: var(--color-line-2); margin-bottom: 32px;">
        <label
            style="display: block; font-size: 10px; color: var(--color-ink-3); letter-spacing: 2px; text-transform: uppercase; margin-bottom: 12px;">INPUT
            NOMOR RESI PENGIRIMAN</label>

        <form wire:submit="track" style="display: flex; gap: 12px;">
            <input type="text" wire:model="resi" placeholder="Contoh: JP5432109876"
                style="flex: 1; background: var(--color-paper); border: 1px solid var(--color-line); color: var(--color-ink); padding: 14px; font-family: monospace; font-size: 14px; outline: none; transition: border-color 0.15s;"
                onfocus="this.style.borderColor='var(--color-ink)'" onblur="this.style.borderColor='var(--color-line)'">

            <button type="submit" class="btn-primary"
                style="padding: 0 24px; display: flex; align-items: center; gap: 8px;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <circle cx="11" cy="11" r="8" />
                    <line x1="21" y1="21" x2="16.65" y2="16.65" />
                </svg>
                LACAK
            </button>
        </form>
        @error('resi')
            <span style="color: #e5484d; font-size: 11px; display: block; margin-top: 8px;">{{ $message }}</span>
        @enderror
    </div>

    @if ($resi !== '' && !$trackedOrder)
        <div class="empty-state" style="border: 1px dashed #e5484d;">
            <h2 class="empty-state-title" style="color: #e5484d;">RESI TIDAK DITEMUKAN</h2>
            <p class="empty-state-desc">Pastikan nomor resi diketik dengan benar atau paket mungkin belum diproses oleh
                pihak kurir.</p>
        </div>
    @elseif($trackedOrder)
        <div style="border: 1px solid var(--color-line); background: var(--color-paper); padding: 32px;">

            <div
                style="margin-bottom: 32px; padding-bottom: 24px; border-bottom: 1px solid var(--color-line); display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <span
                        style="display: block; font-size: 10px; color: var(--color-ink-3); letter-spacing: 2px; text-transform: uppercase; margin-bottom: 4px;">EKSPEDISI
                        & LAYANAN</span>
                    <strong
                        style="font-size: 18px; color: var(--color-ink); text-transform: uppercase;">{{ $trackedOrder->courier }}
                        - {{ $trackedOrder->courier_service }}</strong>
                </div>
                <div style="text-align: right;">
                    <span
                        style="display: block; font-size: 10px; color: var(--color-ink-3); letter-spacing: 2px; text-transform: uppercase; margin-bottom: 4px;">NOMOR
                        PESANAN</span>
                    <strong
                        style="font-size: 14px; font-family: var(--font-blueprint); color: var(--color-accent);">{{ $trackedOrder->order_number }}</strong>
                </div>
            </div>

            <div style="position: relative; padding-left: 24px; border-left: 2px solid var(--color-line-2);">

                <div style="position: relative; margin-bottom: 32px;">
                    <div
                        style="position: absolute; left: -31px; top: 0; width: 14px; height: 14px; background: var(--color-ink); border-radius: 50%;">
                    </div>
                    <strong
                        style="display: block; font-size: 13px; color: var(--color-ink); margin-bottom: 4px;">Pesanan
                        Diterima Sistem</strong>
                    <span
                        style="font-size: 11px; color: var(--color-ink-3);">{{ $trackedOrder->created_at->format('d M Y, H:i') }}
                        WIB</span>
                </div>

                <div style="position: relative; margin-bottom: 32px;">
                    <div
                        style="position: absolute; left: -31px; top: 0; width: 14px; height: 14px; background: var(--color-ink); border-radius: 50%;">
                    </div>
                    <strong
                        style="display: block; font-size: 13px; color: var(--color-ink); margin-bottom: 4px;">Pesanan
                        Sedang Diproses Penjual</strong>
                    <span style="font-size: 11px; color: var(--color-ink-3);">Menunggu penyerahan paket ke pihak
                        logistik.</span>
                </div>

                <div style="position: relative; margin-bottom: 32px;">
                    @php $isShipped = in_array($trackedOrder->status, ['dikirim', 'selesai']); @endphp
                    <div
                        style="position: absolute; left: -31px; top: 0; width: 14px; height: 14px; background: {{ $isShipped ? '#3a8fff' : 'var(--color-line-2)' }}; border-radius: 50%;">
                    </div>
                    <strong
                        style="display: block; font-size: 13px; color: {{ $isShipped ? 'var(--color-ink)' : 'var(--color-ink-3)' }}; margin-bottom: 4px;">Paket
                        Diserahkan ke Kurir</strong>
                    @if ($isShipped)
                        <span style="font-size: 11px; color: var(--color-ink-2);">Nomor Resi: <span
                                style="font-family: monospace;">{{ $trackedOrder->tracking_number }}</span> telah
                            diterbitkan. Paket sedang dalam perjalanan ke alamat tujuan.</span>
                    @else
                        <span style="font-size: 11px; color: var(--color-ink-3);">Menunggu update resi dari
                            penjual.</span>
                    @endif
                </div>

                <div style="position: relative;">
                    @php $isDone = $trackedOrder->status === 'selesai'; @endphp
                    <div
                        style="position: absolute; left: -31px; top: 0; width: 14px; height: 14px; background: {{ $isDone ? '#30a46c' : 'var(--color-line-2)' }}; border-radius: 50%;">
                    </div>
                    <strong
                        style="display: block; font-size: 13px; color: {{ $isDone ? '#30a46c' : 'var(--color-ink-3)' }}; margin-bottom: 4px;">Paket
                        Telah Diterima</strong>
                    @if ($isDone)
                        <span style="font-size: 11px; color: var(--color-ink-2);">Transaksi selesai. Terima kasih telah
                            berbelanja.</span>
                    @endif
                </div>
            </div>

        </div>
    @endif
</div>
