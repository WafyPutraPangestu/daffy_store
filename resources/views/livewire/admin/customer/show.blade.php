<div style="padding: 24px;">

    <div style="margin-bottom: 24px; display: flex; align-items: center; gap: 16px;">
        <a href="{{ route('admin.customer.index') }}" wire:navigate class="btn-outline"
            style="padding: 10px 16px; text-decoration: none; font-size: 10px;">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                style="display:inline; margin-right:4px;">
                <path d="M15 18l-6-6 6-6" />
            </svg> KEMBALI
        </a>
        <h1 class="rz" style="margin: 0; font-size: 24px; color: var(--color-ink);">
            PROFIL // {{ $user->name }}
        </h1>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 24px; align-items: start;">

        <div style="border: 1px solid var(--color-line); padding: 24px; position: sticky; top: 24px;">
            <div
                style="text-align: center; margin-bottom: 24px; border-bottom: 1px solid var(--color-line); padding-bottom: 24px;">
                <div
                    style="width: 64px; height: 64px; background: var(--color-line-2); border: 1px solid var(--color-line); margin: 0 auto 16px auto; display: flex; align-items: center; justify-content: center; font-size: 24px; font-weight: bold; color: var(--color-ink); font-family: var(--font-blueprint);">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <h2 class="rz" style="font-size: 20px; color: var(--color-ink); margin: 0 0 4px 0;">
                    {{ $user->name }}</h2>
                <span style="font-size: 11px; color: var(--color-ink-3); text-transform: uppercase;">Bergabung:
                    {{ $user->created_at->format('d M Y') }}</span>
            </div>

            <div style="margin-bottom: 24px;">
                <span
                    style="display: block; font-size: 10px; color: var(--color-ink-3); letter-spacing: 2px; margin-bottom: 4px; text-transform: uppercase;">EMAIL
                    ADDRESS</span>
                <strong style="font-size: 13px; color: var(--color-ink);">{{ $user->email }}</strong>
            </div>

            <div style="margin-bottom: 24px;">
                <span
                    style="display: block; font-size: 10px; color: var(--color-ink-3); letter-spacing: 2px; margin-bottom: 4px; text-transform: uppercase;">PHONE
                    NUMBER</span>
                <strong
                    style="font-size: 13px; color: var(--color-ink);">{{ $user->customerProfile->phone ?? '-' }}</strong>
            </div>

            <div style="background: var(--color-line-2); border: 1px solid var(--color-line); padding: 16px;">
                <span
                    style="display: block; font-size: 10px; color: var(--color-ink-3); letter-spacing: 2px; margin-bottom: 4px; text-transform: uppercase;">TOTAL
                    SPENT VALUE</span>
                <strong class="rz" style="font-size: 24px; color: var(--color-accent);">Rp
                    {{ number_format($user->orders->sum('total_amount'), 0, ',', '.') }}</strong>
            </div>
        </div>

        <div style="border: 1px solid var(--color-line);">
            <div style="padding: 20px; border-bottom: 1px solid var(--color-line); background: var(--color-line-2);">
                <h3 class="rz" style="font-size: 16px; color: var(--color-ink); margin: 0;">RIWAYAT PESANAN
                    ({{ $user->orders->count() }})</h3>
            </div>
            <table style="width: 100%; border-collapse: collapse; text-align: left;">
                <thead>
                    <tr style="border-bottom: 1px solid var(--color-line);">
                        <th style="padding: 16px; font-size: 11px; letter-spacing: 2px; color: var(--color-ink-3);">
                            TANGGAL</th>
                        <th style="padding: 16px; font-size: 11px; letter-spacing: 2px; color: var(--color-ink-3);">
                            NOMOR PESANAN</th>
                        <th style="padding: 16px; font-size: 11px; letter-spacing: 2px; color: var(--color-ink-3);">
                            STATUS</th>
                        <th
                            style="padding: 16px; font-size: 11px; letter-spacing: 2px; color: var(--color-ink-3); text-align: right;">
                            TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($user->orders as $order)
                        <tr style="border-bottom: 1px solid var(--color-line-2);">
                            <td style="padding: 16px; font-size: 13px; color: var(--color-ink-2);">
                                {{ $order->created_at->format('d/m/Y') }}</td>
                            <td
                                style="padding: 16px; font-size: 13px; font-family: var(--font-blueprint); font-weight: 700; color: var(--color-ink);">
                                <a href="{{ route('admin.order.show', $order->id) }}" wire:navigate
                                    style="color: inherit; text-decoration: underline;">
                                    {{ $order->order_number }}
                                </a>
                            </td>
                            <td style="padding: 16px;">
                                <span class="nav-badge-outline"
                                    style="border-color: var(--color-accent); color: var(--color-accent);">{{ strtoupper($order->status) }}</span>
                            </td>
                            <td
                                style="padding: 16px; font-size: 13px; color: var(--color-ink); font-family: monospace; font-weight: 600; text-align: right;">
                                Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4"
                                style="padding: 32px; text-align: center; color: var(--color-ink-3); font-size: 11px; letter-spacing: 1px;">
                                BELUM ADA RIWAYAT TRANSAKSI.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>
