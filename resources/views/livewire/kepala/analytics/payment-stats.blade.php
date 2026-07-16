<div style="padding: 24px;">

    <div class="section-header"
        style="padding: 0 0 16px 0; margin-bottom: 24px; display: flex; justify-content: space-between; align-items: flex-end;">
        <div>
            <h1 class="rz" style="font-size: 24px; margin: 0; color: var(--color-ink);">STATISTIK METODE PEMBAYARAN
            </h1>
            <span style="font-size: 11px; color: var(--color-ink-3); letter-spacing: 2px; text-transform: uppercase;">
                >>> EXECUTIVE / ANALYTICS / PAYMENT GATEWAY
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

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px; margin-bottom: 24px;">

        <div style="border: 1px solid var(--color-line);">
            <table style="width: 100%; border-collapse: collapse; text-align: left;">
                <thead>
                    <tr style="border-bottom: 1px solid var(--color-line); background: var(--color-line-2);">
                        <th
                            style="padding: 16px; font-size: 11px; letter-spacing: 2px; color: var(--color-ink-3); font-weight: 600;">
                            METODE PEMBAYARAN</th>
                        <th
                            style="padding: 16px; font-size: 11px; letter-spacing: 2px; color: var(--color-ink-3); font-weight: 600; text-align: center;">
                            JUMLAH TRANSAKSI</th>
                        <th
                            style="padding: 16px; font-size: 11px; letter-spacing: 2px; color: var(--color-ink-3); font-weight: 600; text-align: right;">
                            TOTAL VOLUME DANA</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($this->stats as $stat)
                        <tr style="border-bottom: 1px solid var(--color-line-2);">
                            <td style="padding: 16px;">
                                <strong
                                    style="font-size: 14px; color: var(--color-ink); text-transform: uppercase;">{{ $stat->payment_method ?? 'TRANSFER MANUAL' }}</strong>
                            </td>
                            <td style="padding: 16px; text-align: center;">
                                <span
                                    style="font-size: 13px; font-weight: 600; font-family: monospace; color: var(--color-ink);">{{ $stat->total_trx }}
                                    TRX</span>
                            </td>
                            <td
                                style="padding: 16px; font-size: 14px; color: var(--color-accent); font-family: monospace; font-weight: 600; text-align: right;">
                                Rp {{ number_format($stat->total_amount, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" style="padding: 32px; text-align: center; color: var(--color-ink-3);">
                                Belum ada transaksi berhasil di periode ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="border: 1px solid var(--color-line); padding: 24px; display: flex; flex-direction: column;">
            <h3 class="rz"
                style="font-size: 14px; color: var(--color-ink); margin: 0 0 20px 0; border-bottom: 1px solid var(--color-line); padding-bottom: 12px; text-align: center;">
                DISTRIBUSI PENGGUNAAN</h3>
            <div style="flex: 1; min-height: 250px; position: relative;">
                @if ($this->stats->count() > 0)
                    <canvas id="paymentChart"></canvas>
                @else
                    <div
                        style="position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; color: var(--color-ink-3); font-size: 11px; letter-spacing: 1px;">
                        GRAFIK KOSONG</div>
                @endif
            </div>
        </div>

    </div>

    @if ($this->stats->count() > 0)
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        @script
            <script>
                const rawData = @json($this->stats);

                // Ekstrak label dan data untuk grafik
                const labels = rawData.map(item => (item.payment_method || 'MANUAL').toUpperCase());
                const dataValues = rawData.map(item => item.total_trx);

                Chart.defaults.color = '#888888';
                Chart.defaults.font.family = '"Instrument Sans", sans-serif';

                const ctx = document.getElementById('paymentChart').getContext('2d');

                // Hancurkan chart lama jika ada (mencegah bug saat ganti filter bulan)
                if (window.myPaymentChart) {
                    window.myPaymentChart.destroy();
                }

                window.myPaymentChart = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: labels,
                        datasets: [{
                            data: dataValues,
                            backgroundColor: [
                                '#3a8fff', '#30a46c', '#ffb224', '#e5484d', '#8e4ec6', '#888888'
                            ],
                            borderColor: 'transparent',
                            borderWidth: 2,
                            hoverOffset: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '65%',
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    padding: 20,
                                    boxWidth: 12
                                }
                            }
                        }
                    }
                });
            </script>
        @endscript
    @endif

</div>
