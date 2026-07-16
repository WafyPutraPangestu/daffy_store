<div style="padding: 24px;">

    <div class="section-header" style="padding: 0 0 16px 0; margin-bottom: 24px;">
        <div>
            <h1 class="rz" style="font-size: 24px; margin: 0; color: var(--color-ink);">COMMAND CENTER</h1>
            <span style="font-size: 11px; color: var(--color-ink-3); letter-spacing: 2px; text-transform: uppercase;">
                >>> SYSTEM / OVERVIEW / ANALYTICS
            </span>
        </div>
    </div>

    <div
        style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 24px; margin-bottom: 24px;">
        <div
            style="border: 1px solid var(--color-line); background: var(--color-line-2); padding: 24px; border-left: 4px solid var(--color-accent);">
            <span
                style="display: block; font-size: 10px; color: var(--color-ink-3); letter-spacing: 2px; text-transform: uppercase; margin-bottom: 8px;">TOTAL
                PENDAPATAN</span>
            <strong class="rz" style="font-size: 28px; color: var(--color-ink); display: block;">
                Rp {{ number_format($this->kpi['revenue'], 0, ',', '.') }}
            </strong>
        </div>

        <div style="border: 1px solid var(--color-line); padding: 24px;">
            <span
                style="display: block; font-size: 10px; color: var(--color-ink-3); letter-spacing: 2px; text-transform: uppercase; margin-bottom: 8px;">PESANAN
                (BULAN INI)</span>
            <strong class="rz" style="font-size: 28px; color: var(--color-ink); display: block;">
                {{ number_format($this->kpi['orders']) }} <span
                    style="font-size: 14px; color: var(--color-ink-3);">TRX</span>
            </strong>
        </div>

        <div style="border: 1px solid var(--color-line); padding: 24px;">
            <span
                style="display: block; font-size: 10px; color: var(--color-ink-3); letter-spacing: 2px; text-transform: uppercase; margin-bottom: 8px;">TOTAL
                PELANGGAN</span>
            <strong class="rz" style="font-size: 28px; color: var(--color-ink); display: block;">
                {{ number_format($this->kpi['customers']) }} <span
                    style="font-size: 14px; color: var(--color-ink-3);">USER</span>
            </strong>
        </div>

        <div style="border: 1px solid var(--color-line); padding: 24px;">
            <span
                style="display: block; font-size: 10px; color: var(--color-ink-3); letter-spacing: 2px; text-transform: uppercase; margin-bottom: 8px;">PRODUK
                AKTIF</span>
            <strong class="rz" style="font-size: 28px; color: var(--color-ink); display: block;">
                {{ number_format($this->kpi['products']) }} <span
                    style="font-size: 14px; color: var(--color-ink-3);">ITEM</span>
            </strong>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px; margin-bottom: 24px;">

        <div style="border: 1px solid var(--color-line); padding: 24px;">
            <h3 class="rz"
                style="font-size: 14px; color: var(--color-ink); margin: 0 0 20px 0; border-bottom: 1px solid var(--color-line); padding-bottom: 12px;">
                GRAFIK PENJUALAN (7 HARI TERAKHIR)</h3>
            <div style="height: 300px; width: 100%;">
                <canvas id="salesChart"></canvas>
            </div>
        </div>

        <div style="border: 1px solid var(--color-line); padding: 24px;">
            <h3 class="rz"
                style="font-size: 14px; color: var(--color-ink); margin: 0 0 20px 0; border-bottom: 1px solid var(--color-line); padding-bottom: 12px;">
                DISTRIBUSI STATUS PESANAN</h3>
            <div style="height: 300px; width: 100%; display: flex; justify-content: center;">
                <canvas id="statusChart"></canvas>
            </div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">

        <div style="border: 1px solid var(--color-line);">
            <div
                style="padding: 16px 20px; border-bottom: 1px solid var(--color-line); background: var(--color-line-2);">
                <h3 class="rz" style="font-size: 14px; color: var(--color-ink); margin: 0;">PESANAN MASUK TERBARU
                </h3>
            </div>
            <table style="width: 100%; border-collapse: collapse; text-align: left;">
                <tbody>
                    @forelse($this->recentOrders as $order)
                        <tr style="border-bottom: 1px solid var(--color-line);">
                            <td
                                style="padding: 16px; font-size: 13px; font-family: var(--font-blueprint); font-weight: 700; color: var(--color-ink);">
                                <a href="{{ route('admin.order.show', $order->id) }}" wire:navigate
                                    style="color: inherit; text-decoration: none;">
                                    {{ $order->order_number }}
                                </a>
                            </td>
                            <td style="padding: 16px; font-size: 12px; color: var(--color-ink-2);">
                                {{ $order->user->name ?? 'Guest' }}</td>
                            <td
                                style="padding: 16px; font-size: 12px; color: var(--color-ink); font-family: monospace; text-align: right;">
                                Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3"
                                style="padding: 24px; text-align: center; color: var(--color-ink-3); font-size: 11px; letter-spacing: 1px;">
                                BELUM ADA PESANAN</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="border: 1px solid var(--color-line);">
            <div
                style="padding: 16px 20px; border-bottom: 1px solid var(--color-line); background: var(--color-line-2); display: flex; justify-content: space-between;">
                <h3 class="rz" style="font-size: 14px; color: #e5484d; margin: 0;">PERINGATAN STOK MENIPIS</h3>
                <span class="nav-badge-outline" style="border-color: #e5484d; color: #e5484d;">
                    <= 5 ITEM</span>
            </div>
            <table style="width: 100%; border-collapse: collapse; text-align: left;">
                <tbody>
                    @forelse($this->lowStockProducts as $product)
                        <tr style="border-bottom: 1px solid var(--color-line);">
                            <td style="padding: 16px; font-size: 12px; color: var(--color-ink);">{{ $product->name }}
                            </td>
                            <td
                                style="padding: 16px; font-size: 12px; color: var(--color-ink-3); font-family: monospace;">
                                SKU: {{ $product->sku }}</td>
                            <td style="padding: 16px; text-align: right;">
                                <span
                                    style="background: rgba(229, 72, 77, 0.1); color: #e5484d; border: 1px solid #e5484d; padding: 4px 8px; font-size: 11px; font-weight: 700;">
                                    SISA {{ $product->stock }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3"
                                style="padding: 24px; text-align: center; color: #30a46c; font-size: 11px; letter-spacing: 1px;">
                                SEMUA STOK PRODUK AMAN</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @script
        <script>
            // Mengambil data dari komponen PHP Livewire
            const salesData = @json($this->salesChartData);
            const statusData = @json($this->orderStatusData);

            // Styling Global agar cocok dengan Tema Blueprint (Dark/Light mode compliant)
            Chart.defaults.color = '#888888';
            Chart.defaults.font.family = '"Instrument Sans", sans-serif';

            // 1. Inisialisasi Sales Line Chart
            const ctxSales = document.getElementById('salesChart').getContext('2d');
            new Chart(ctxSales, {
                type: 'line',
                data: {
                    labels: salesData.labels,
                    datasets: [{
                        label: 'Pendapatan Harian (Rp)',
                        data: salesData.data,
                        borderColor: '#3a8fff', // Warna Accent
                        backgroundColor: 'rgba(58, 143, 255, 0.1)',
                        borderWidth: 2,
                        pointBackgroundColor: '#0a0a0a',
                        pointBorderColor: '#3a8fff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        fill: true,
                        tension: 0.1 // Garis agak kaku ala blueprint
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(136, 136, 136, 0.1)'
                            },
                            border: {
                                dash: [4, 4]
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });

            // 2. Inisialisasi Status Doughnut Chart
            const ctxStatus = document.getElementById('statusChart').getContext('2d');
            new Chart(ctxStatus, {
                type: 'doughnut',
                data: {
                    labels: statusData.labels,
                    datasets: [{
                        data: statusData.data,
                        backgroundColor: [
                            '#ffb224', // Pending / Proses (Kuning)
                            '#3a8fff', // Dikirim (Biru)
                            '#30a46c', // Selesai (Hijau)
                            '#e5484d', // Batal (Merah)
                            '#888888' // Lainnya (Abu-abu)
                        ],
                        borderColor: '#0a0a0a', // Sesuai warna background agar ada celah
                        borderWidth: 2,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '75%', // Lubang tengah yang besar
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

</div>
