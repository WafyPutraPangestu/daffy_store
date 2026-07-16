<div style="min-height:100vh;background:var(--color-paper);display:flex;flex-direction:column">

    {{-- Top bar --}}
    {{-- <div
        style="padding:20px 32px;border-bottom:1px solid var(--color-line);display:flex;align-items:center;justify-content:space-between">
        <a href="{{ route('home') }}" wire:navigate class="nav-logo">
            DAFFY<span style="color:var(--color-accent)">.</span>STORE
        </a>
        <span style="font-size:10px;letter-spacing:3px;text-transform:uppercase;color:var(--color-ink-3)">
            Portal Akses Sistem
        </span>
    </div> --}}

    {{-- Main --}}
    <div style="flex:1;display:flex;align-items:center;justify-content:center;padding:48px 24px">
        <div style="width:100%;max-width:440px">

            {{-- Header --}}
            <div style="margin-bottom:40px">
                <div
                    style="font-size:10px;letter-spacing:4px;text-transform:uppercase;color:var(--color-accent);margin-bottom:12px;display:flex;align-items:center;gap:8px">
                    <span style="display:block;width:24px;height:1px;background:var(--color-accent)"></span>
                    Autentikasi
                </div>
                <h1 class="rz" style="font-size:36px;line-height:1;color:var(--color-ink);margin-bottom:8px">
                    Masuk ke<br>Akun Anda
                </h1>
                <p style="font-size:13px;color:var(--color-ink-3);font-weight:300;letter-spacing:.3px">
                    Masukkan kredensial untuk mengakses sistem Daffy Store.
                </p>
            </div>

            {{-- Form --}}
            <form wire:submit.prevent="login" style="display:flex;flex-direction:column;gap:0">

                {{-- Email --}}
                <div style="margin-bottom:20px">
                    <label
                        style="display:block;font-size:10px;letter-spacing:3px;text-transform:uppercase;color:var(--color-ink-3);margin-bottom:8px">
                        Alamat Email
                    </label>
                    <input type="email" wire:model="email" placeholder="nama@email.com" autocomplete="email"
                        style="
                            width:100%;padding:14px 16px;
                            background:transparent;
                            border:1px solid var(--color-line);
                            border-radius:0;
                            font-size:14px;
                            color:var(--color-ink);
                            outline:none;
                            transition:border-color .15s;
                            font-family:var(--font-sans);
                        "
                        onfocus="this.style.borderColor='var(--color-accent)'"
                        onblur="this.style.borderColor='var(--color-line)'">
                    @error('email')
                        <div
                            style="margin-top:6px;font-size:11px;letter-spacing:1px;color:#e53e3e;display:flex;align-items:center;gap:6px">
                            <i class="ti ti-alert-circle" style="font-size:13px" aria-hidden="true"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Password --}}
                <div style="margin-bottom:28px">
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px">
                        <label
                            style="font-size:10px;letter-spacing:3px;text-transform:uppercase;color:var(--color-ink-3)">
                            Password
                        </label>
                    </div>
                    <input type="password" wire:model="password" placeholder="••••••••" autocomplete="current-password"
                        style="
                            width:100%;padding:14px 16px;
                            background:transparent;
                            border:1px solid var(--color-line);
                            border-radius:0;
                            font-size:14px;
                            color:var(--color-ink);
                            outline:none;
                            transition:border-color .15s;
                            font-family:var(--font-sans);
                        "
                        onfocus="this.style.borderColor='var(--color-accent)'"
                        onblur="this.style.borderColor='var(--color-line)'">
                    @error('password')
                        <div
                            style="margin-top:6px;font-size:11px;letter-spacing:1px;color:#e53e3e;display:flex;align-items:center;gap:6px">
                            <i class="ti ti-alert-circle" style="font-size:13px" aria-hidden="true"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Remember me --}}
                <div style="display:flex;align-items:center;gap:10px;margin-bottom:28px">
                    <input type="checkbox" wire:model="remember" id="remember"
                        style="width:14px;height:14px;border-radius:0;accent-color:var(--color-accent);cursor:pointer">
                    <label for="remember"
                        style="font-size:11px;letter-spacing:2px;text-transform:uppercase;color:var(--color-ink-3);cursor:pointer">
                        Ingat Saya
                    </label>
                </div>

                {{-- Submit --}}
                <button type="submit" class="btn-primary"
                    style="width:100%;padding:16px;font-size:11px;letter-spacing:3px;position:relative"
                    wire:loading.attr="disabled">
                    <span wire:loading.remove>Masuk ke Sistem</span>
                    <span wire:loading style="display:none;align-items:center;justify-content:center;gap:8px">
                        <i class="ti ti-loader" style="font-size:14px;animation:spin 1s linear infinite"
                            aria-hidden="true"></i>
                        Memverifikasi...
                    </span>
                </button>

            </form>

            {{-- Divider --}}
            <div style="display:flex;align-items:center;gap:16px;margin:28px 0">
                <div style="flex:1;height:1px;background:var(--color-line)"></div>
                <span
                    style="font-size:10px;letter-spacing:2px;text-transform:uppercase;color:var(--color-ink-3)">atau</span>
                <div style="flex:1;height:1px;background:var(--color-line)"></div>
            </div>

            {{-- Register link --}}
            <div style="text-align:center">
                <span style="font-size:12px;color:var(--color-ink-3)">Belum punya akun? </span>
                <a href="#" wire:navigate
                    style="font-size:12px;font-weight:600;letter-spacing:1px;text-transform:uppercase;color:var(--color-accent);text-decoration:none">
                    Daftar Sekarang
                </a>
            </div>

        </div>
    </div>

    {{-- Bottom bar --}}
    <div
        style="padding:16px 32px;border-top:1px solid var(--color-line);display:flex;align-items:center;justify-content:space-between">
        <span style="font-size:10px;letter-spacing:2px;text-transform:uppercase;color:var(--color-ink-3)">
            Daffy Store · 2025
        </span>
        <span style="font-size:10px;letter-spacing:2px;text-transform:uppercase;color:var(--color-ink-3)">
            Sistem E-Commerce Perikanan
        </span>
    </div>

</div>

<style>
    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }
</style>
