<div style="padding: 24px; max-width: 800px; margin: 0 auto;">

    <div style="margin-bottom: 32px; border-bottom: 1px solid var(--color-line); padding-bottom: 20px;">
        <h1 class="rz" style="font-size: 28px; margin: 0; color: var(--color-ink);">KEAMANAN AKUN</h1>
        <span style="font-size: 11px; color: var(--color-ink-3); letter-spacing: 2px; text-transform: uppercase;">
            >>> USER / ACCOUNT SETTINGS / SECURITY
        </span>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 3fr; gap: 32px; align-items: start;">

        <div
            style="display: flex; flex-direction: column; gap: 8px; border: 1px solid var(--color-line); background: var(--color-paper); padding: 16px;">
            <a href="{{ route('pelanggan.profile.index') }}" wire:navigate
                style="padding: 10px 12px; text-decoration: none; font-size: 13px; color: var(--color-ink-2);">Profil
                Dasar</a>
            <a href="{{ route('pelanggan.profile.address') }}" wire:navigate
                style="padding: 10px 12px; text-decoration: none; font-size: 13px; color: var(--color-ink-2);">Buku
                Alamat</a>
            <a href="{{ route('pelanggan.profile.password') }}" wire:navigate
                style="padding: 10px 12px; text-decoration: none; font-size: 13px; font-weight: 600; background: rgba(0, 87, 255, 0.1); color: #0057ff; border-left: 2px solid #0057ff;">Keamanan
                Sandi</a>
        </div>

        <div style="border: 1px solid var(--color-line); background: var(--color-paper); padding: 32px;">
            <form wire:submit="updatePassword">

                <div style="margin-bottom: 20px;">
                    <label
                        style="display: block; font-size: 10px; color: var(--color-ink-3); letter-spacing: 2px; margin-bottom: 8px; text-transform: uppercase;">KATA
                        SANDI SAAT INI (LAMA)</label>
                    <input type="password" wire:model="current_password"
                        style="width: 100%; background: transparent; border: 1px solid var(--color-line); color: var(--color-ink); padding: 12px; font-size: 13px; outline: none; box-sizing: border-box; font-family: monospace;">
                    @error('current_password')
                        <span
                            style="color: #e5484d; font-size: 11px; display: block; margin-top: 6px;">{{ $message }}</span>
                    @enderror
                </div>

                <div style="margin-bottom: 20px;">
                    <label
                        style="display: block; font-size: 10px; color: var(--color-ink-3); letter-spacing: 2px; margin-bottom: 8px; text-transform: uppercase;">KATA
                        SANDI BARU</label>
                    <input type="password" wire:model="new_password" placeholder="Minimal 8 karakter unik..."
                        style="width: 100%; background: transparent; border: 1px solid var(--color-line); color: var(--color-ink); padding: 12px; font-size: 13px; outline: none; box-sizing: border-box; font-family: monospace;">
                    @error('new_password')
                        <span
                            style="color: #e5484d; font-size: 11px; display: block; margin-top: 6px;">{{ $message }}</span>
                    @enderror
                </div>

                <div style="margin-bottom: 24px;">
                    <label
                        style="display: block; font-size: 10px; color: var(--color-ink-3); letter-spacing: 2px; margin-bottom: 8px; text-transform: uppercase;">ULANGI
                        KATA SANDI BARU</label>
                    <input type="password" wire:model="new_password_confirmation"
                        style="width: 100%; background: transparent; border: 1px solid var(--color-line); color: var(--color-ink); padding: 12px; font-size: 13px; outline: none; box-sizing: border-box; font-family: monospace;">
                </div>

                <div style="border-top: 1px solid var(--color-line); padding-top: 24px; text-align: right;">
                    <button type="submit" wire:loading.attr="disabled" class="btn-primary"
                        style="padding: 12px 24px; font-size: 12px;">
                        <span wire:loading.remove wire:target="updatePassword">ENKRIPSI SANDI BARU</span>
                        <span wire:loading wire:target="updatePassword">MEMPROSES...</span>
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
