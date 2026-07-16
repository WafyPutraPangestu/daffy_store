<div style="padding: 24px; max-width: 800px; margin: 0 auto;">

    <div class="section-header"
        style="padding: 0 0 16px 0; margin-bottom: 32px; text-align: center; border-bottom: 1px solid var(--color-line);">
        <h1 class="rz" style="font-size: 28px; margin: 0; color: var(--color-ink);">DATA EXPORT CENTER</h1>
        <span style="font-size: 11px; color: var(--color-ink-3); letter-spacing: 2px; text-transform: uppercase;">
            >>> DATA EXTRACTION PROTOCOL
        </span>
    </div>

    <div style="border: 1px solid var(--color-line); padding: 32px; background: var(--color-line-2);">

        <form wire:submit="exportCSV">

            <div style="margin-bottom: 24px;">
                <label
                    style="display: block; font-size: 11px; color: var(--color-ink-3); letter-spacing: 2px; text-transform: uppercase; margin-bottom: 8px;">1.
                    PILIH JENIS LAPORAN</label>
                <select wire:model="reportType"
                    style="width: 100%; background: var(--color-paper); border: 1px solid var(--color-line); color: var(--color-ink); padding: 12px; font-size: 13px; letter-spacing: 1px; outline: none;">
                    <option value="penjualan">Laporan Data Penjualan (Pesanan Selesai)</option>
                    <option value="pembayaran">Laporan Mutasi Pembayaran (Dana Masuk)</option>
                </select>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 32px;">
                <div>
                    <label
                        style="display: block; font-size: 11px; color: var(--color-ink-3); letter-spacing: 2px; text-transform: uppercase; margin-bottom: 8px;">2.
                        TANGGAL MULAI</label>
                    <input type="date" wire:model="startDate"
                        style="width: 100%; background: var(--color-paper); border: 1px solid var(--color-line); color: var(--color-ink); padding: 12px; font-family: monospace; font-size: 14px; outline: none;">
                    @error('startDate')
                        <span
                            style="color: #e5484d; font-size: 11px; display: block; margin-top: 8px;">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label
                        style="display: block; font-size: 11px; color: var(--color-ink-3); letter-spacing: 2px; text-transform: uppercase; margin-bottom: 8px;">3.
                        TANGGAL AKHIR</label>
                    <input type="date" wire:model="endDate"
                        style="width: 100%; background: var(--color-paper); border: 1px solid var(--color-line); color: var(--color-ink); padding: 12px; font-family: monospace; font-size: 14px; outline: none;">
                    @error('endDate')
                        <span
                            style="color: #e5484d; font-size: 11px; display: block; margin-top: 8px;">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div
                style="border-top: 1px solid var(--color-line); padding-top: 24px; display: flex; justify-content: flex-end;">
                <button type="submit" class="btn-primary"
                    style="display: flex; align-items: center; gap: 8px; font-size: 12px;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                        <polyline points="7 10 12 15 17 10" />
                        <line x1="12" y1="15" x2="12" y2="3" />
                    </svg>
                    GENERATE CSV FILE
                </button>
            </div>

        </form>

    </div>

    <p style="text-align: center; font-size: 11px; color: var(--color-ink-3); margin-top: 24px;">
        Format CSV (Comma Separated Values) kompatibel untuk dibuka di Microsoft Excel, Google Sheets, dan Apple
        Numbers.
    </p>

</div>
