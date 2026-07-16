<div style="padding: 24px;">
    <div class="section-header" style="padding: 0 0 16px 0; margin-bottom: 24px;">
        <div>
            <h1 class="rz" style="font-size: 24px; margin: 0; color: var(--color-ink);">DATABASE PELANGGAN</h1>
            <span style="font-size: 11px; color: var(--color-ink-3); letter-spacing: 2px; text-transform: uppercase;">
                >>> SYSTEM / CUSTOMERS / DIRECTORY
            </span>
        </div>
    </div>

    <div style="margin-bottom: 24px;">
        <input type="text" wire:model.live.debounce.500ms="search" placeholder="CARI NAMA ATAU EMAIL..."
            style="background: transparent; border: 1px solid var(--color-line); color: var(--color-ink); padding: 12px 16px; width: 320px; font-size: 11px; letter-spacing: 2px; outline: none; transition: border-color 0.15s;"
            onfocus="this.style.borderColor='var(--color-ink)'" onblur="this.style.borderColor='var(--color-line)'">
    </div>

    <div style="border: 1px solid var(--color-line);">
        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
                <tr style="border-bottom: 1px solid var(--color-line); background: var(--color-line-2);">
                    <th
                        style="padding: 16px; font-size: 11px; letter-spacing: 2px; color: var(--color-ink-3); font-weight: 600;">
                        PELANGGAN</th>
                    <th
                        style="padding: 16px; font-size: 11px; letter-spacing: 2px; color: var(--color-ink-3); font-weight: 600;">
                        KONTAK</th>
                    <th
                        style="padding: 16px; font-size: 11px; letter-spacing: 2px; color: var(--color-ink-3); font-weight: 600; text-align: center;">
                        TOTAL TRANSAKSI</th>
                    <th
                        style="padding: 16px; font-size: 11px; letter-spacing: 2px; color: var(--color-ink-3); font-weight: 600; text-align: right;">
                        TOTAL SPEND</th>
                    <th
                        style="padding: 16px; font-size: 11px; letter-spacing: 2px; color: var(--color-ink-3); font-weight: 600; text-align: right;">
                        AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($this->customers as $user)
                    <tr style="border-bottom: 1px solid var(--color-line); transition: background 0.15s;"
                        onmouseover="this.style.background='var(--color-line-2)'"
                        onmouseout="this.style.background='transparent'">
                        <td style="padding: 16px;">
                            <strong
                                style="display: block; font-size: 14px; font-weight: 600; color: var(--color-ink);">{{ $user->name }}</strong>
                            <span style="font-size: 11px; color: var(--color-ink-3);">Terdaftar:
                                {{ $user->created_at->format('d M Y') }}</span>
                        </td>
                        <td style="padding: 16px; font-size: 13px; color: var(--color-ink-2);">
                            <span style="display: block;">{{ $user->email }}</span>
                            <span
                                style="display: block; font-family: monospace;">{{ $user->customerProfile->phone ?? 'Belum isi no HP' }}</span>
                        </td>
                        <td style="padding: 16px; text-align: center;">
                            <span
                                style="border: 1px solid var(--color-line); padding: 4px 12px; font-size: 12px; font-weight: 700; color: var(--color-ink);">
                                {{ $user->orders_count ?? 0 }}
                            </span>
                        </td>
                        <td
                            style="padding: 16px; font-size: 14px; color: var(--color-accent); font-family: monospace; font-weight: 600; text-align: right;">
                            Rp {{ number_format($user->orders_sum_total_amount ?? 0, 0, ',', '.') }}
                        </td>
                        <td style="padding: 16px; text-align: right;">
                            <a href="{{ route('admin.customer.show', $user->id) }}" wire:navigate class="btn-outline"
                                style="padding: 8px 16px; text-decoration: none; display: inline-block;">
                                RIWAYAT
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">
                            <div class="empty-state">
                                <h2 class="empty-state-title">DATA PELANGGAN KOSONG</h2>
                                <p class="empty-state-desc">Belum ada pelanggan yang terdaftar.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="margin-top: 24px;">{{ $this->customers->links() }}</div>
</div>
