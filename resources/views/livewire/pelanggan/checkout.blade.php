<div style="padding: 24px; max-width: 1100px; margin: 0 auto;">

    <div style="margin-bottom: 32px; border-bottom: 1px solid var(--color-line); padding-bottom: 20px;">
        <h1 class="rz" style="font-size: 28px; margin: 0; color: var(--color-ink);">PROSES PENGIRIMAN (CHECKOUT)</h1>
        <span style="font-size: 11px; color: var(--color-ink-3); letter-spacing: 2px; text-transform: uppercase;">
            >>> SECURITY GATEWAY / RAJAONGKIR INTEGRATION / MANIFEST
        </span>
    </div>

    <form wire:submit="placeOrder" style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px; align-items: start;">

        <div style="display: flex; flex-direction: column; gap: 24px;">

            <div style="border: 1px solid var(--color-line); padding: 24px; background: var(--color-paper);">
                <h3 class="rz"
                    style="font-size: 14px; margin: 0 0 20px 0; color: var(--color-ink); border-bottom: 1px solid var(--color-line); padding-bottom: 10px;">
                    [01] MANIFEST DATA PENERIMA
                </h3>

                @if ($addressPrefilled)
                    <div
                        style="display: flex; align-items: center; gap: 8px; background: var(--color-line-2); border: 1px dashed var(--color-line); padding: 10px 14px; margin-bottom: 16px; font-size: 11px; color: var(--color-ink-2);">
                        <span class="dot-status green"></span>
                        <span>ALAMAT DIAMBIL DARI PROFIL KAMU &mdash; SILAKAN EDIT JIKA PERLU.</span>
                    </div>
                @endif

                <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 16px; margin-bottom: 16px;">
                    <div>
                        <label
                            style="display: block; font-size: 10px; color: var(--color-ink-3); letter-spacing: 1px; margin-bottom: 6px; text-transform: uppercase;">NAMA
                            LENGKAP PENERIMA</label>
                        <input type="text" wire:model="recipient_name"
                            style="width: 100%; background: transparent; border: 1px solid var(--color-line); color: var(--color-ink); padding: 10px; font-size: 13px; outline: none; box-sizing: border-box;">
                        @error('recipient_name')
                            <span
                                style="color: #e5484d; font-size: 11px; display: block; margin-top: 4px;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label
                            style="display: block; font-size: 10px; color: var(--color-ink-3); letter-spacing: 1px; margin-bottom: 6px; text-transform: uppercase;">KODE
                            POS</label>
                        <input type="text" wire:model="postal_code" placeholder="Contoh: 55281"
                            style="width: 100%; background: transparent; border: 1px solid var(--color-line); color: var(--color-ink); padding: 10px; font-size: 13px; outline: none; box-sizing: border-box; font-family: monospace;">
                        @error('postal_code')
                            <span
                                style="color: #e5484d; font-size: 11px; display: block; margin-top: 4px;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div style="margin-bottom: 16px;">
                    <label
                        style="display: block; font-size: 10px; color: var(--color-ink-3); letter-spacing: 1px; margin-bottom: 6px; text-transform: uppercase;">ALAMAT
                        LENGKAP DOMISILI RUMAH</label>
                    <textarea wire:model="shipping_address" rows="3"
                        placeholder="Tuliskan nama jalan, RT/RW, nomor rumah atau gedung khusus..."
                        style="width: 100%; background: transparent; border: 1px solid var(--color-line); color: var(--color-ink); padding: 10px; font-size: 13px; outline: none; box-sizing: border-box; resize: vertical;"></textarea>
                    @error('shipping_address')
                        <span
                            style="color: #e5484d; font-size: 11px; display: block; margin-top: 4px;">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div style="border: 1px solid var(--color-line); padding: 24px; background: var(--color-paper);">
                <h3 class="rz"
                    style="font-size: 14px; margin: 0 0 20px 0; color: var(--color-ink); border-bottom: 1px solid var(--color-line); padding-bottom: 10px;">
                    [02] WILAYAH TUJUAN PENGIRIMAN (ALAMAT KAMU) & PILIHAN EKSPEDISI
                </h3>
                <p style="font-size: 11px; color: var(--color-ink-3); margin: -12px 0 20px 0;">
                    Pilih provinsi, kota, dan kecamatan sesuai domisili kamu &mdash; ini menentukan tarif ongkos kirim
                    dari toko ke alamat kamu.
                </p>

                @if ($province_id && $city_id && !$district_id)
                    <div
                        style="display: flex; align-items: center; gap: 8px; background: var(--color-line-2); border: 1px dashed var(--color-line); padding: 10px 14px; margin-bottom: 16px; font-size: 11px; color: var(--color-ink-2);">
                        <span class="dot-status yellow"></span>
                        <span>PROVINSI & KOTA TERISI OTOMATIS. SILAKAN PILIH KECAMATAN SECARA MANUAL.</span>
                    </div>
                @endif

                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                    <div>
                        <label
                            style="display: block; font-size: 10px; color: var(--color-ink-3); letter-spacing: 1px; margin-bottom: 6px; text-transform: uppercase;">PROVINSI</label>
                        <select wire:model.live="province_id"
                            style="width: 100%; background: var(--color-paper); border: 1px solid var(--color-line); color: var(--color-ink); padding: 10px; font-size: 13px; outline: none;">
                            <option value="">-- PILIH --</option>
                            @foreach ($provinces as $prov)
                                <option value="{{ $prov['province_id'] }}">{{ strtoupper($prov['province']) }}</option>
                            @endforeach
                        </select>
                        @error('province_id')
                            <span
                                style="color: #e5484d; font-size: 11px; display: block; margin-top: 4px;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label
                            style="display: block; font-size: 10px; color: var(--color-ink-3); letter-spacing: 1px; margin-bottom: 6px; text-transform: uppercase;">KOTA
                            / KABUPATEN</label>
                        <select wire:model.live="city_id" {{ empty($province_id) ? 'disabled' : '' }}
                            style="width: 100%; background: var(--color-paper); border: 1px solid var(--color-line); color: var(--color-ink); padding: 10px; font-size: 13px; outline: none; opacity: {{ empty($province_id) ? '0.5' : '1' }};">
                            <option value="">-- PILIH --</option>
                            @foreach ($cities as $city)
                                <option value="{{ $city['city_id'] }}">{{ strtoupper($city['city_name']) }}</option>
                            @endforeach
                        </select>
                        @error('city_id')
                            <span
                                style="color: #e5484d; font-size: 11px; display: block; margin-top: 4px;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label
                            style="display: block; font-size: 10px; color: var(--color-ink-3); letter-spacing: 1px; margin-bottom: 6px; text-transform: uppercase;">KECAMATAN</label>
                        <select wire:model.live="district_id" {{ empty($city_id) ? 'disabled' : '' }}
                            style="width: 100%; background: var(--color-paper); border: 1px solid var(--color-line); color: var(--color-ink); padding: 10px; font-size: 13px; outline: none; opacity: {{ empty($city_id) ? '0.5' : '1' }};">
                            <option value="">-- PILIH --</option>
                            @foreach ($districts as $dist)
                                <option value="{{ $dist['district_id'] }}">{{ strtoupper($dist['district_name']) }}
                                </option>
                            @endforeach
                        </select>
                        @error('district_id')
                            <span
                                style="color: #e5484d; font-size: 11px; display: block; margin-top: 4px;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                    <div>
                        <label
                            style="display: block; font-size: 10px; color: var(--color-ink-3); letter-spacing: 1px; margin-bottom: 6px; text-transform: uppercase;">KODE
                            EKSPEDISI</label>
                        <select wire:model.live="courier" {{ empty($district_id) ? 'disabled' : '' }}
                            style="width: 100%; background: var(--color-paper); border: 1px solid var(--color-line); color: var(--color-ink); padding: 10px; font-size: 13px; outline: none; opacity: {{ empty($district_id) ? '0.5' : '1' }};">
                            <option value="">-- PILIH KURIR --</option>
                            <option value="jne">JNE (JALUR NUGRAHA EKAKURIR)</option>
                            <option value="pos">POS INDONESIA</option>
                            <option value="sicepat">SICEPAT EXPRESS</option>
                        </select>
                        @error('courier')
                            <span
                                style="color: #e5484d; font-size: 11px; display: block; margin-top: 4px;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label
                            style="display: block; font-size: 10px; color: var(--color-ink-3); letter-spacing: 1px; margin-bottom: 6px; text-transform: uppercase;">LAYANAN
                            TARIF ONGKIR</label>
                        <select wire:model.live="selected_service" {{ empty($courierServices) ? 'disabled' : '' }}
                            style="width: 100%; background: var(--color-paper); border: 1px solid var(--color-line); color: var(--color-ink); padding: 10px; font-size: 13px; outline: none; opacity: {{ empty($courierServices) ? '0.5' : '1' }};">
                            <option value="">-- PILIH LAYANAN TARIF --</option>
                            @foreach ($courierServices as $srv)
                                <option value="{{ $srv['service'] }}|{{ $srv['cost'] }}">
                                    {{ strtoupper($srv['service']) }} ({{ $srv['description'] ?? '' }}) - Rp
                                    {{ number_format($srv['cost'], 0, ',', '.') }}
                                </option>
                            @endforeach
                        </select>
                        <div wire:loading wire:target="courier,district_id"
                            style="font-size: 11px; color: var(--color-accent); margin-top: 4px; font-family: monospace;">
                            SYSTEM LOG: MENGHITUNG TARIF ONGKIR...</div>
                        @error('selected_service')
                            <span
                                style="color: #e5484d; font-size: 11px; display: block; margin-top: 4px;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

            </div>
        </div>

        <div style="position: sticky; top: 24px; display: flex; flex-direction: column; gap: 24px;">

            <div style="border: 1px solid var(--color-line); background: var(--color-line-2); padding: 24px;">
                <span
                    style="display: block; font-size: 10px; color: var(--color-ink-3); letter-spacing: 2px; text-transform: uppercase; margin-bottom: 16px;">STRUKTUR
                    MANIFEST BELANJA</span>

                <div
                    style="display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 12px; color: var(--color-ink-2);">
                    <span>Total Berat Barang</span>
                    <span style="font-family: monospace;">{{ number_format($this->totalWeight) }} Gram</span>
                </div>

                <div
                    style="display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 12px; color: var(--color-ink-2);">
                    <span>Subtotal Produk</span>
                    <span style="font-family: monospace;">Rp {{ number_format($this->subtotal, 0, ',', '.') }}</span>
                </div>

                <div
                    style="display: flex; justify-content: space-between; margin-bottom: 16px; font-size: 12px; color: var(--color-ink-2); border-bottom: 1px dashed var(--color-line); padding-bottom: 16px;">
                    <span>Biaya Ongkir ({{ strtoupper($courier) }})</span>
                    <span style="font-family: monospace;">Rp
                        {{ number_format($this->shipping_cost, 0, ',', '.') }}</span>
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-size: 11px; letter-spacing: 2px; font-weight: 600; color: var(--color-ink);">TOTAL
                        TAGIHAN</span>
                    <strong style="font-size: 20px; font-family: monospace; color: var(--color-accent);">Rp
                        {{ number_format($this->totalAmount, 0, ',', '.') }}</strong>
                </div>
            </div>

            <div>
                <button type="submit" wire:loading.attr="disabled" wire:target="placeOrder" class="btn-primary"
                    style="width: 100%; font-size: 12px; padding: 16px 0; cursor: pointer;">
                    <span wire:loading.remove wire:target="placeOrder">TERBITKAN INVOICE (ORDER)</span>
                    <span wire:loading wire:target="placeOrder">MEMPROSES DATA...</span>
                </button>
            </div>
        </div>

    </form>
</div>
