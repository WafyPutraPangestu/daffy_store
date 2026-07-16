<div style="padding: 24px;">

    <!-- HEADER KHUSUS LAYAR (Disembunyikan saat di-print) -->
    <div class="no-print section-header" style="padding: 0 0 16px 0; margin-bottom: 32px;">
        <div>
            <h1 class="rz" style="font-size: 24px; margin: 0;">MANIFEST PENGIRIMAN</h1>
            <span style="font-size: 11px; color: var(--color-ink-3); letter-spacing: 2px; text-transform: uppercase;">
                >>> DAFTAR PESANAN SIAP PICK-UP HARI INI
            </span>
        </div>

        <div style="display: flex; gap: 12px;">
            <button onclick="window.print()" class="btn-outline">
                CETAK DOKUMEN
            </button>
            <button wire:click="markAllAsShipped" class="btn-primary">
                TANDAI SEMUA TELAH DIKIRIM
            </button>
        </div>
    </div>

    <!-- AREA DOKUMEN CETAK -->
    <div class="print-area" style="border: 1px solid var(--color-line); padding: 32px;">

        <div
            style="text-align: center; margin-bottom: 32px; border-bottom: 2px solid var(--color-ink); padding-bottom: 16px;">
            <h2 class="rz" style="margin: 0; font-size: 28px; color: var(--color-ink);">DAFFY STORE</h2>
            <p style="margin: 4px 0 0 0; color: var(--color-ink-2); font-size: 14px;">Manifest Pengiriman Harian -
                Dicetak pada: {{ now()->format('d F Y H:i') }}</p>
        </div>

        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 12px;">
            <thead>
                <tr style="border-bottom: 2px solid var(--color-ink);">
                    <th style="padding: 12px 8px; font-weight: 600; letter-spacing: 1px; color: var(--color-ink);">NO
                    </th>
                    <th style="padding: 12px 8px; font-weight: 600; letter-spacing: 1px; color: var(--color-ink);">NOMOR
                        PESANAN</th>
                    <th style="padding: 12px 8px; font-weight: 600; letter-spacing: 1px; color: var(--color-ink);">
                        EKSPEDISI & PENERIMA</th>
                    <th style="padding: 12px 8px; font-weight: 600; letter-spacing: 1px; color: var(--color-ink);">
                        KONTAK</th>
                    <th style="padding: 12px 8px; font-weight: 600; letter-spacing: 1px; color: var(--color-ink);">PARAF
                        KURIR</th>
                </tr>
            </thead>
            <tbody>
                @forelse($this->readyOrders as $index => $order)
                    <tr style="border-bottom: 1px solid var(--color-line);">
                        <td style="padding: 16px 8px; color: var(--color-ink);">{{ $index + 1 }}</td>
                        <td
                            style="padding: 16px 8px; font-family: var(--font-blueprint); font-weight: 700; font-size: 14px; color: var(--color-ink);">
                            {{ $order->order_number }}</td>
                        <td style="padding: 16px 8px;">
                            <span
                                style="display: block; font-size: 10px; font-weight: bold; color: var(--color-ink-3); margin-bottom: 4px;">{{ strtoupper($order->courier) }}
                                - {{ strtoupper($order->courier_service) }}</span>
                            <strong
                                style="display: block; font-size: 14px; color: var(--color-ink);">{{ $order->recipient_name }}</strong>
                            <span style="display: block; margin-top: 4px; line-height: 1.4; color: var(--color-ink-2);">
                                {{ $order->shipping_address }}, {{ $order->city }}, {{ $order->province }}
                                ({{ $order->postal_code }})
                            </span>
                        </td>
                        <td style="padding: 16px 8px; color: var(--color-ink);">
                            <!-- Mengambil nomor HP dari profil pembeli -->
                            {{ $order->user->customerProfile->phone ?? 'Tidak ada kontak' }}
                        </td>
                        <td style="padding: 16px 8px;">
                            <div style="width: 80px; height: 40px; border: 1px dashed var(--color-ink-3);"></div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">
                            <div class="empty-state" style="padding: 40px 0;">
                                <p class="empty-state-desc">Tidak ada pesanan berstatus "Diproses" hari ini.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- CSS UNTUK PRINTING -->
    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            .print-area,
            .print-area * {
                visibility: visible;
                color: #000 !important;
                border-color: #000 !important;
            }

            .print-area {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                border: none !important;
                padding: 0 !important;
            }

            .no-print {
                display: none !important;
            }

            body,
            html {
                background: white !important;
            }
        }
    </style>
</div>
