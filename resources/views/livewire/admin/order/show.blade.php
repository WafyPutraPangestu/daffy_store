<div style="padding: 24px;">

    <div style="margin-bottom: 24px; display: flex; align-items: center; gap: 16px;">
        <a href="{{ route('admin.order.index') }}" wire:navigate class="btn-outline"
            style="padding: 10px 16px; text-decoration: none; font-size: 10px;">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                style="display:inline; margin-right:4px;">
                <path d="M15 18l-6-6 6-6" />
            </svg> KEMBALI
        </a>
        <h1 class="rz" style="margin: 0; font-size: 24px; color: var(--color-ink);">
            ORDER // {{ $order->order_number }}
        </h1>
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px; align-items: start;">

        <div>
            <div style="border: 1px solid var(--color-line); padding: 24px; margin-bottom: 24px;">
                <h3 class="rz"
                    style="font-size: 16px; color: var(--color-ink); margin-top: 0; border-bottom: 1px solid var(--color-line); padding-bottom: 12px; margin-bottom: 16px;">
                    DATA PENGIRIMAN
                </h3>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; font-size: 13px;">
                    <div>
                        <span
                            style="display: block; font-size: 10px; color: var(--color-ink-3); letter-spacing: 2px; text-transform: uppercase;">NAMA
                            RECIPIENT</span>
                        <strong
                            style="color: var(--color-ink); font-weight: 600; display: block; margin-top: 4px;">{{ $order->recipient_name }}</strong>
                    </div>
                    <div>
                        <span
                            style="display: block; font-size: 10px; color: var(--color-ink-3); letter-spacing: 2px; text-transform: uppercase;">AKUN
                            PEMBELI</span>
                        <strong
                            style="color: var(--color-ink); font-weight: 600; display: block; margin-top: 4px;">{{ $order->user->name ?? 'Guest' }}</strong>
                    </div>
                    <div style="grid-column: span 2;">
                        <span
                            style="display: block; font-size: 10px; color: var(--color-ink-3); letter-spacing: 2px; text-transform: uppercase;">ALAMAT
                            TUJUAN PENGIRIMAN</span>
                        <p style="margin: 4px 0 0 0; color: var(--color-ink-2); line-height: 1.6;">
                            {{ $order->shipping_address }}, {{ $order->city }}, {{ $order->province }}
                            ({{ $order->postal_code }})
                        </p>
                    </div>
                    <div>
                        <span
                            style="display: block; font-size: 10px; color: var(--color-ink-3); letter-spacing: 2px; text-transform: uppercase;">EKSPEDISI</span>
                        <strong
                            style="color: var(--color-ink); font-weight: 600; display: block; margin-top: 4px;">{{ strtoupper($order->courier) }}
                            - {{ $order->courier_service }}</strong>
                    </div>
                    <div>
                        <span
                            style="display: block; font-size: 10px; color: var(--color-ink-3); letter-spacing: 2px; text-transform: uppercase;">ONGKOS
                            KIRIM</span>
                        <strong style="color: var(--color-ink); font-weight: 600; display: block; margin-top: 4px;">Rp
                            {{ number_format($order->shipping_cost, 0, ',', '.') }}</strong>
                    </div>
                </div>
            </div>

            <div style="border: 1px solid var(--color-line); padding: 24px;">
                <h3 class="rz"
                    style="font-size: 16px; color: var(--color-ink); margin-top: 0; border-bottom: 1px solid var(--color-line); padding-bottom: 12px; margin-bottom: 16px;">
                    RINCIAN BARANG Belanjaan
                </h3>
                <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13px;">
                    <thead>
                        <tr>
                            <th
                                style="padding-bottom: 12px; font-size: 10px; font-weight: 500; letter-spacing: 2px; text-transform: uppercase; color: var(--color-ink-3); border-bottom: 1px solid var(--color-line);">
                                PRODUK</th>
                            <th
                                style="padding-bottom: 12px; font-size: 10px; font-weight: 500; letter-spacing: 2px; text-transform: uppercase; color: var(--color-ink-3); border-bottom: 1px solid var(--color-line);">
                                HARGA SATUAN</th>
                            <th
                                style="padding-bottom: 12px; font-size: 10px; font-weight: 500; letter-spacing: 2px; text-transform: uppercase; color: var(--color-ink-3); border-bottom: 1px solid var(--color-line);">
                                QTY</th>
                            <th
                                style="padding-bottom: 12px; font-size: 10px; font-weight: 500; letter-spacing: 2px; text-transform: uppercase; color: var(--color-ink-3); border-bottom: 1px solid var(--color-line); text-align: right;">
                                SUBTOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($order->items)
                            @foreach ($order->items as $item)
                                <tr>
                                    <td
                                        style="padding: 16px 0; color: var(--color-ink); border-bottom: 1px solid var(--color-line-2);">
                                        {{ $item->product->name ?? 'Produk Dihapus' }}</td>
                                    <td
                                        style="padding: 16px 0; color: var(--color-ink-2); border-bottom: 1px solid var(--color-line-2); font-family: monospace;">
                                        Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                                    <td
                                        style="padding: 16px 0; color: var(--color-ink-2); border-bottom: 1px solid var(--color-line-2);">
                                        x{{ $item->quantity }}</td>
                                    <td
                                        style="padding: 16px 0; color: var(--color-ink); font-family: monospace; text-align: right; border-bottom: 1px solid var(--color-line-2);">
                                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3"
                                style="padding-top: 16px; text-align: right; font-size: 11px; color: var(--color-ink-3);">
                                SUBTOTAL BARANG:</td>
                            <td
                                style="padding-top: 16px; text-align: right; color: var(--color-ink); font-family: monospace;">
                                Rp {{ number_format($order->subtotal, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td colspan="3"
                                style="padding-top: 8px; text-align: right; font-size: 11px; color: var(--color-ink-3);">
                                ONGKOS KIRIM:</td>
                            <td
                                style="padding-top: 8px; text-align: right; color: var(--color-ink); font-family: monospace;">
                                + Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td colspan="3"
                                style="padding-top: 16px; text-align: right; font-size: 11px; letter-spacing: 2px; text-transform: uppercase; color: var(--color-ink-3); font-weight: bold;">
                                TOTAL TAGIHAN:</td>
                            <td
                                style="padding-top: 16px; text-align: right; font-weight: 700; color: var(--color-accent); font-size: 18px; font-family: monospace;">
                                Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div style="border: 1px solid var(--color-line); position: sticky; top: 24px;">
            <div style="padding: 24px; border-bottom: 1px solid var(--color-line);">
                <span
                    style="display: block; font-size: 10px; color: var(--color-ink-3); letter-spacing: 2px; text-transform: uppercase;">STATUS
                    LOGISTIK</span>
                <h2 class="rz" style="font-size: 24px; margin: 4px 0 0 0; color: var(--color-accent);">
                    {{ strtoupper(str_replace('_', ' ', $order->status)) }}
                </h2>
            </div>

            <div style="padding: 24px;">
                <label
                    style="display: block; font-size: 10px; color: var(--color-ink-3); letter-spacing: 2px; text-transform: uppercase; margin-bottom: 10px;">INPUT
                    NOMOR RESI PENGIRIMAN</label>
                <div style="display: flex; gap: 8px; margin-bottom: 24px;">
                    <input type="text" wire:model="trackingNumber" placeholder="Ketik resi kurir..."
                        style="flex: 1; background: transparent; border: 1px solid var(--color-line); color: var(--color-ink); padding: 12px; font-family: monospace; font-size: 13px; outline: none;">
                    <button wire:click="saveTrackingNumber" class="btn-primary" style="padding: 0 16px;">
                        SIMPAN
                    </button>
                </div>
                @error('trackingNumber')
                    <span
                        style="color: #e5484d; font-size: 11px; display: block; margin-top: -16px; margin-bottom: 16px;">{{ $message }}</span>
                @enderror

                <hr style="border: 0; border-top: 1px solid var(--color-line); margin-bottom: 24px;">

                <span
                    style="display: block; font-size: 10px; color: var(--color-ink-3); letter-spacing: 2px; text-transform: uppercase; margin-bottom: 12px;">UBAH
                    STATUS MANUALLY</span>
                <div style="display: flex; flex-direction: column; gap: 8px;">

                    <button wire:click="updateStatus('diproses')"
                        class="{{ $order->status == 'diproses' ? 'btn-primary' : 'btn-outline' }}"
                        style="width: 100%; text-align: left; padding: 14px; {{ $order->status == 'diproses' ? 'background: #ffb224; color: #000;' : '' }}">
                        TANDAI SEDANG DIPROSES
                    </button>

                    <button wire:click="updateStatus('dikirim')"
                        class="{{ $order->status == 'dikirim' ? 'btn-primary' : 'btn-outline' }}"
                        style="width: 100%; text-align: left; padding: 14px;">
                        TANDAI TELAH DIKIRIM
                    </button>

                    <button wire:click="updateStatus('selesai')"
                        class="{{ $order->status == 'selesai' ? 'btn-primary' : 'btn-outline' }}"
                        style="width: 100%; text-align: left; padding: 14px; {{ $order->status == 'selesai' ? 'background: #30a46c; color: #fff;' : '' }}">
                        TANDAI SELESAI TUNTAS
                    </button>

                    <button wire:click="updateStatus('dibatalkan')"
                        class="{{ $order->status == 'dibatalkan' ? 'btn-primary' : 'btn-outline' }}"
                        style="width: 100%; text-align: left; padding: 14px; {{ $order->status == 'dibatalkan' ? 'background: #e5484d; color: #fff;' : '' }}">
                        BATALKAN TRANSAKSI
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>
