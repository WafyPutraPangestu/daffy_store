<div style="padding: 24px; max-width: 1000px; margin: 0 auto;" x-data="{}"
    @open-snap.window="
        let snapToken = $event.detail.token;
        if (!snapToken) return;
        window.snap.pay(snapToken, {
            onSuccess: function(result) {
                alert('Pembayaran berhasil diselesaikan!');
                window.location.reload();
            },
            onPending: function(result) {
                alert('Menunggu penyelesaian pembayaran Anda!');
                window.location.reload();
            },
            onError: function(result) {
                alert('Pembayaran gagal atau dibatalkan.');
            }
        });
    ">

    <div style="margin-bottom: 24px; display: flex; align-items: center; gap: 16px;">
        <a href="{{ route('pelanggan.transaction.index') }}" wire:navigate class="btn-outline"
            style="padding: 10px 16px; text-decoration: none; font-size: 10px;">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                style="display:inline; margin-right:4px;">
                <path d="M15 18l-6-6 6-6" />
            </svg> KEMBALI
        </a>
        <h1 class="rz" style="margin: 0; font-size: 24px; color: var(--color-ink);">
            DETAIL TRANSAKSI // {{ $order->order_number }}
        </h1>
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px; align-items: start;">

        <div>
            <div
                style="border: 1px solid var(--color-line); padding: 24px; margin-bottom: 24px; background: var(--color-paper);">
                <h3 class="rz"
                    style="font-size: 16px; color: var(--color-ink); margin-top: 0; border-bottom: 1px solid var(--color-line); padding-bottom: 12px; margin-bottom: 16px;">
                    INFO PENGIRIMAN
                </h3>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; font-size: 13px;">
                    <div>
                        <span
                            style="display: block; font-size: 10px; color: var(--color-ink-3); letter-spacing: 2px; text-transform: uppercase;">PENERIMA</span>
                        <strong
                            style="color: var(--color-ink); font-weight: 600; display: block; margin-top: 4px;">{{ $order->recipient_name }}</strong>
                    </div>
                    <div>
                        <span
                            style="display: block; font-size: 10px; color: var(--color-ink-3); letter-spacing: 2px; text-transform: uppercase;">EKSPEDISI
                            & RESI</span>
                        <strong
                            style="color: var(--color-ink); font-weight: 600; display: block; margin-top: 4px; text-transform: uppercase;">
                            {{ $order->courier }} - {{ $order->courier_service }}
                        </strong>
                        @if ($order->tracking_number)
                            <span
                                style="display: inline-block; margin-top: 4px; font-family: monospace; font-size: 11px; background: rgba(58, 143, 255, 0.1); color: var(--color-accent); padding: 2px 6px; border: 1px solid var(--color-accent);">RESI:
                                {{ $order->tracking_number }}</span>
                        @endif
                    </div>
                    <div style="grid-column: span 2;">
                        <span
                            style="display: block; font-size: 10px; color: var(--color-ink-3); letter-spacing: 2px; text-transform: uppercase;">ALAMAT
                            LENGKAP</span>
                        <p style="margin: 4px 0 0 0; color: var(--color-ink-2); line-height: 1.6;">
                            {{ $order->shipping_address }}, {{ $order->city }}, {{ $order->province }}
                            ({{ $order->postal_code }})
                        </p>
                    </div>
                </div>
            </div>

            <div style="border: 1px solid var(--color-line); padding: 24px; background: var(--color-paper);">
                <h3 class="rz"
                    style="font-size: 16px; color: var(--color-ink); margin-top: 0; border-bottom: 1px solid var(--color-line); padding-bottom: 12px; margin-bottom: 16px;">
                    RINCIAN BARANG
                </h3>
                <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13px;">
                    <thead>
                        <tr>
                            <th
                                style="padding-bottom: 12px; font-size: 10px; font-weight: 500; letter-spacing: 2px; text-transform: uppercase; color: var(--color-ink-3); border-bottom: 1px solid var(--color-line);">
                                PRODUK</th>
                            <th
                                style="padding-bottom: 12px; font-size: 10px; font-weight: 500; letter-spacing: 2px; text-transform: uppercase; color: var(--color-ink-3); border-bottom: 1px solid var(--color-line); text-align: center;">
                                QTY</th>
                            <th
                                style="padding-bottom: 12px; font-size: 10px; font-weight: 500; letter-spacing: 2px; text-transform: uppercase; color: var(--color-ink-3); border-bottom: 1px solid var(--color-line); text-align: right;">
                                SUBTOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->items as $item)
                            <tr>
                                <td
                                    style="padding: 16px 0; color: var(--color-ink); border-bottom: 1px solid var(--color-line-2);">
                                    <strong
                                        style="display: block; font-weight: 600;">{{ $item->product->name ?? 'Produk Dihapus' }}</strong>
                                    <span style="font-size: 11px; color: var(--color-ink-3); font-family: monospace;">Rp
                                        {{ number_format($item->unit_price, 0, ',', '.') }}</span>
                                </td>
                                <td
                                    style="padding: 16px 0; color: var(--color-ink-2); border-bottom: 1px solid var(--color-line-2); text-align: center;">
                                    x{{ $item->quantity }}</td>
                                <td
                                    style="padding: 16px 0; color: var(--color-ink); font-family: monospace; text-align: right; border-bottom: 1px solid var(--color-line-2);">
                                    Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div style="position: sticky; top: 24px; display: flex; flex-direction: column; gap: 24px;">

            <div style="border: 1px solid var(--color-line); background: var(--color-line-2); padding: 24px;">
                <span
                    style="display: block; font-size: 10px; color: var(--color-ink-3); letter-spacing: 2px; text-transform: uppercase; margin-bottom: 16px;">RINGKASAN
                    PEMBAYARAN</span>

                <div
                    style="display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 12px; color: var(--color-ink-2);">
                    <span>Total Harga Barang</span>
                    <span style="font-family: monospace;">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                </div>

                <div
                    style="display: flex; justify-content: space-between; margin-bottom: 16px; font-size: 12px; color: var(--color-ink-2); border-bottom: 1px dashed var(--color-line); padding-bottom: 16px;">
                    <span>Total Ongkos Kirim</span>
                    <span style="font-family: monospace;">Rp
                        {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-size: 11px; letter-spacing: 2px; font-weight: 600; color: var(--color-ink);">TOTAL
                        TAGIHAN</span>
                    <strong style="font-size: 20px; font-family: monospace; color: var(--color-accent);">Rp
                        {{ number_format($order->total_amount, 0, ',', '.') }}</strong>
                </div>
            </div>

            <div style="border: 1px solid var(--color-line); padding: 24px; background: var(--color-paper);">
                <span
                    style="display: block; font-size: 10px; color: var(--color-ink-3); letter-spacing: 2px; text-transform: uppercase; margin-bottom: 12px;">STATUS
                    TRANSAKSI</span>

                <h2 class="rz" style="font-size: 20px; margin: 0 0 16px 0; color: var(--color-ink);">
                    {{ strtoupper(str_replace('_', ' ', $order->status)) }}
                </h2>

                @if ($order->status === 'menunggu_pembayaran')
                    <div wire:poll.10s="checkPaymentStatus"></div>

                    <p style="font-size: 12px; color: var(--color-ink-2); line-height: 1.5; margin-bottom: 24px;">
                        Silakan selesaikan pembayaran Anda agar pesanan ini dapat segera kami proses dan kirim.
                    </p>

                    <div style="display: flex; flex-direction: column; gap: 10px;">
                        <button wire:click="pay" wire:loading.attr="disabled" class="btn-primary"
                            style="width: 100%; background: #ffb224; color: #000; border-color: #ffb224; font-size: 12px; padding: 14px; cursor: pointer;">
                            LANJUTKAN PEMBAYARAN
                        </button>

                        <button wire:click="checkPaymentStatus(false)" wire:loading.attr="disabled" class="btn-outline"
                            style="width: 100%; font-size: 11px; padding: 10px; cursor: pointer; text-align: center; border: 1px solid var(--color-line);">
                            <span wire:loading.remove wire:target="checkPaymentStatus">CEK STATUS PEMBAYARAN</span>
                            <span wire:loading wire:target="checkPaymentStatus">MENYINKRONKAN...</span>
                        </button>
                    </div>
                @elseif($order->status === 'diproses')
                    <div
                        style="padding: 12px; background: rgba(58, 143, 255, 0.1); border: 1px solid var(--color-accent); color: var(--color-accent); font-size: 12px; text-align: center; font-weight: 600; letter-spacing: 1px;">
                        PESANAN SEDANG DIPROSES ADMIN
                    </div>
                @elseif($order->status === 'dikirim' && $order->tracking_number)
                    <a href="{{ route('pelanggan.transaction.tracking') }}?resi={{ $order->tracking_number }}"
                        wire:navigate class="btn-primary"
                        style="display: block; text-align: center; width: 100%; text-decoration: none; font-size: 12px; padding: 14px;">
                        LACAK LOKASI PAKET
                    </a>
                @elseif($order->status === 'selesai')
                    <div
                        style="padding: 12px; background: rgba(48, 164, 108, 0.1); border: 1px solid #30a46c; color: #30a46c; font-size: 12px; text-align: center; font-weight: 600;">
                        TRANSAKSI TELAH SELESAI
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>
