<div style="padding: 24px;">

    <div class="section-header" style="padding: 0 0 16px 0; margin-bottom: 24px;">
        <div>
            <h1 class="rz" style="font-size: 24px; margin: 0; color: var(--color-ink);">AUDIT SESI & LOGIN</h1>
            <span style="font-size: 11px; color: var(--color-ink-3); letter-spacing: 2px; text-transform: uppercase;">
                >>> SECURITY / ACTIVE SESSIONS LOG
            </span>
        </div>
    </div>

    <div
        style="border: 1px solid var(--color-accent); background: rgba(58, 143, 255, 0.05); padding: 16px; margin-bottom: 24px; display: flex; align-items: flex-start; gap: 12px;">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--color-accent)"
            stroke-width="2">
            <circle cx="12" cy="12" r="10" />
            <line x1="12" y1="8" x2="12" y2="12" />
            <line x1="12" y1="16" x2="12.01" y2="16" />
        </svg>
        <div>
            <strong style="display: block; font-size: 12px; color: var(--color-ink); margin-bottom: 4px;">SYSTEM LOG
                TRACKING AKTIF</strong>
            <p style="margin: 0; font-size: 11px; color: var(--color-ink-2); line-height: 1.5;">Halaman ini menampilkan
                riwayat sesi perangkat secara *real-time*. Sesi *guest* (tanpa akun) tidak memiliki nama pengguna.</p>
        </div>
    </div>

    <div style="border: 1px solid var(--color-line);">
        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
                <tr style="border-bottom: 1px solid var(--color-line); background: var(--color-line-2);">
                    <th
                        style="padding: 16px; font-size: 11px; letter-spacing: 2px; color: var(--color-ink-3); font-weight: 600;">
                        AKUN PENGGUNA</th>
                    <th
                        style="padding: 16px; font-size: 11px; letter-spacing: 2px; color: var(--color-ink-3); font-weight: 600;">
                        IP ADDRESS</th>
                    <th
                        style="padding: 16px; font-size: 11px; letter-spacing: 2px; color: var(--color-ink-3); font-weight: 600;">
                        USER AGENT (DEVICE)</th>
                    <th
                        style="padding: 16px; font-size: 11px; letter-spacing: 2px; color: var(--color-ink-3); font-weight: 600; text-align: right;">
                        AKTIVITAS TERAKHIR</th>
                </tr>
            </thead>
            <tbody>
                @forelse($this->sessions as $session)
                    <tr style="border-bottom: 1px solid var(--color-line-2); transition: background 0.15s;"
                        onmouseover="this.style.background='var(--color-line-2)'"
                        onmouseout="this.style.background='transparent'">
                        <td style="padding: 16px;">
                            @if ($session->user_id)
                                <strong
                                    style="display: block; font-size: 13px; font-weight: 600; color: var(--color-ink);">{{ $session->name }}</strong>
                                <span
                                    style="font-size: 10px; color: var(--color-ink-3); text-transform: uppercase;">{{ $session->role }}</span>
                            @else
                                <strong
                                    style="display: block; font-size: 13px; font-weight: 600; color: var(--color-ink-3);">GUEST
                                    (TIDAK LOGIN)</strong>
                            @endif
                        </td>
                        <td
                            style="padding: 16px; font-size: 13px; font-family: monospace; color: var(--color-accent); font-weight: bold;">
                            {{ $session->ip_address }}
                        </td>
                        <td style="padding: 16px; font-size: 11px; color: var(--color-ink-2); max-width: 300px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"
                            title="{{ $session->user_agent }}">
                            {{ $session->user_agent }}
                        </td>
                        <td
                            style="padding: 16px; font-size: 12px; color: var(--color-ink); text-align: right; font-family: monospace;">
                            {{ \Carbon\Carbon::createFromTimestamp($session->last_activity)->diffForHumans() }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">
                            <div class="empty-state">
                                <h2 class="empty-state-title">DATA SESI KOSONG</h2>
                                <p class="empty-state-desc">Belum ada jejak aktivitas atau pastikan SESSION_DRIVER
                                    diatur ke database.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 24px;">{{ $this->sessions->links() }}</div>
</div>
