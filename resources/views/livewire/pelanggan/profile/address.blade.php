<div style="padding: 24px; max-width: 800px; margin: 0 auto;">

    <div style="margin-bottom: 32px; border-bottom: 1px solid var(--color-line); padding-bottom: 20px;">
        <h1 class="rz" style="font-size: 28px; margin: 0; color: var(--color-ink);">BUKU ALAMAT</h1>
        <span style="font-size: 11px; color: var(--color-ink-3); letter-spacing: 2px; text-transform: uppercase;">
            >>> USER / ACCOUNT SETTINGS / SHIPPING ADDRESS
        </span>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 3fr; gap: 32px; align-items: start;">

        <div
            style="display: flex; flex-direction: column; gap: 8px; border: 1px solid var(--color-line); background: var(--color-paper); padding: 16px;">
            <a href="{{ route('pelanggan.profile.index') }}" wire:navigate
                style="padding: 10px 12px; text-decoration: none; font-size: 13px; color: var(--color-ink-2);">Profil
                Dasar</a>
            <a href="{{ route('pelanggan.profile.address') }}" wire:navigate
                style="padding: 10px 12px; text-decoration: none; font-size: 13px; font-weight: 600; background: rgba(0, 87, 255, 0.1); color: #0057ff; border-left: 2px solid #0057ff;">Buku
                Alamat</a>
            <a href="{{ route('pelanggan.profile.password') }}" wire:navigate
                style="padding: 10px 12px; text-decoration: none; font-size: 13px; color: var(--color-ink-2);">Keamanan
                Sandi</a>
        </div>

        <div style="border: 1px solid var(--color-line); background: var(--color-paper); padding: 32px;">
            <form wire:submit="saveAddress">

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                    <div>
                        <label
                            style="display: block; font-size: 10px; color: var(--color-ink-3); letter-spacing: 2px; margin-bottom: 8px; text-transform: uppercase;">PROVINSI</label>
                        <select wire:model.live="province_id"
                            style="width: 100%; background: var(--color-paper); border: 1px solid var(--color-line); color: var(--color-ink); padding: 12px; font-size: 13px; outline: none;">
                            <option value="">-- PILIH PROVINSI --</option>
                            @foreach ($provinces as $prov)
                                <option value="{{ $prov['id'] }}">{{ strtoupper($prov['name']) }}</option>
                            @endforeach
                        </select>
                        @error('province_id')
                            <span
                                style="color: #e5484d; font-size: 11px; display: block; margin-top: 6px;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label
                            style="display: block; font-size: 10px; color: var(--color-ink-3); letter-spacing: 2px; margin-bottom: 8px; text-transform: uppercase;">KOTA
                            / KABUPATEN</label>
                        <select wire:model.live="city_id" {{ empty($province_id) ? 'disabled' : '' }}
                            style="width: 100%; background: var(--color-paper); border: 1px solid var(--color-line); color: var(--color-ink); padding: 12px; font-size: 13px; outline: none; opacity: {{ empty($province_id) ? '0.5' : '1' }};">
                            <option value="">-- PILIH KOTA --</option>
                            @foreach ($cities as $city)
                                <option value="{{ $city['id'] }}">{{ strtoupper($city['name']) }}</option>
                            @endforeach
                        </select>
                        @error('city_id')
                            <span
                                style="color: #e5484d; font-size: 11px; display: block; margin-top: 6px;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div style="margin-bottom: 16px;">
                    <label
                        style="display: block; font-size: 10px; color: var(--color-ink-3); letter-spacing: 2px; margin-bottom: 8px; text-transform: uppercase;">KODE
                        POS PENGIRIMAN</label>
                    <input type="text" wire:model="postal_code" placeholder="Contoh: 15138"
                        style="width: 100%; background: transparent; border: 1px solid var(--color-line); color: var(--color-ink); padding: 12px; font-size: 13px; outline: none; box-sizing: border-box; font-family: monospace;">
                    @error('postal_code')
                        <span
                            style="color: #e5484d; font-size: 11px; display: block; margin-top: 6px;">{{ $message }}</span>
                    @enderror
                </div>

                <div style="margin-bottom: 24px;">
                    <label
                        style="display: block; font-size: 10px; color: var(--color-ink-3); letter-spacing: 2px; margin-bottom: 8px; text-transform: uppercase;">DETAIL
                        ALAMAT LENGKAP RUMAH</label>
                    <textarea wire:model="default_address" rows="4"
                        placeholder="Tuliskan detail jalan, blok bangunan, nomor rumah, dan RT/RW secara rinci..."
                        style="width: 100%; background: transparent; border: 1px solid var(--color-line); color: var(--color-ink); padding: 12px; font-size: 13px; outline: none; box-sizing: border-box; resize: vertical;"></textarea>
                    @error('default_address')
                        <span
                            style="color: #e5484d; font-size: 11px; display: block; margin-top: 6px;">{{ $message }}</span>
                    @enderror
                </div>

                <div style="border-top: 1px solid var(--color-line); padding-top: 24px; text-align: right;">
                    <button type="submit" wire:loading.attr="disabled" class="btn-primary"
                        style="padding: 12px 24px; font-size: 12px;">
                        <span wire:loading.remove wire:target="saveAddress">SIMPAN BUKU ALAMAT</span>
                        <span wire:loading wire:target="saveAddress">MENYIMPAN...</span>
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
