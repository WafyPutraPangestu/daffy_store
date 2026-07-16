<div style="padding: 24px; max-width: 1000px; margin: 0 auto;">

    <div style="margin-bottom: 32px; border-bottom: 1px solid var(--color-line); padding-bottom: 20px;">
        <h1 class="rz" style="font-size: 28px; margin: 0; color: var(--color-ink);">KERANJANG BELANJA</h1>
        <span style="font-size: 11px; color: var(--color-ink-3); letter-spacing: 2px; text-transform: uppercase;">
            >>> USER / SHOPPING CART / MANIFEST
        </span>
    </div>

    @if ($this->cartData && $this->cartData->items->count() > 0)
        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px; align-items: start;">

            <div style="border: 1px solid var(--color-line); background: var(--color-paper);">
                <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13px;">
                    <thead>
                        <tr style="border-bottom: 1px solid var(--color-line); background: var(--color-line-2);">
                            <th
                                style="padding: 16px; font-size: 10px; font-weight: 600; letter-spacing: 2px; text-transform: uppercase; color: var(--color-ink-3);">
                                KOMODITAS PRODUK</th>
                            <th
                                style="padding: 16px; font-size: 10px; font-weight: 600; letter-spacing: 2px; text-transform: uppercase; color: var(--color-ink-3); text-align: center; width: 120px;">
                                KUANTITAS</th>
                            <th
                                style="padding: 16px; font-size: 10px; font-weight: 600; letter-spacing: 2px; text-transform: uppercase; color: var(--color-ink-3); text-align: right; width: 160px;">
                                SUBTOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($this->cartData->items as $item)
                            @if ($item->product)
                                <tr style="border-bottom: 1px solid var(--color-line-2);">
                                    <td style="padding: 16px;">
                                        <div style="display: flex; gap: 16px; align-items: center;">
                                            <div
                                                style="width: 60px; height: 60px; border: 1px solid var(--color-line); flex-shrink: 0; overflow: hidden; background: var(--color-line-2);">
                                                @if ($item->product->image_path)
                                                    <img src="{{ asset('storage/' . $item->product->image_path) }}"
                                                        alt="{{ $item->product->name }}"
                                                        style="width: 100%; height: 100%; object-fit: cover;">
                                                @else
                                                    <div
                                                        style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: var(--color-ink-3);">
                                                        <i class="ti ti-photo"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div>
                                                <strong
                                                    style="display: block; font-size: 14px; color: var(--color-ink);">{{ $item->product->name }}</strong>
                                                <span
                                                    style="font-size: 11px; color: var(--color-ink-3); font-family: monospace;">Rp
                                                    {{ number_format($item->product->price, 0, ',', '.') }}</span>
                                                <button wire:click="removeItem({{ $item->id }})"
                                                    style="background: transparent; border: none; color: #e5484d; font-size: 11px; cursor: pointer; padding: 0; display: block; margin-top: 4px; text-decoration: underline;">HAPUS
                                                    ITEM</button>
                                            </div>
                                        </div>
                                    </td>

                                    <td style="padding: 16px; text-align: center;">
                                        <div
                                            style="display: inline-flex; border: 1px solid var(--color-line); align-items: center; background: var(--color-paper);">
                                            <button type="button" wire:click="decrementQuantity({{ $item->id }})"
                                                style="background: transparent; border: none; color: var(--color-ink); padding: 6px 12px; cursor: pointer; font-weight: bold;">-</button>
                                            <span
                                                style="width: 32px; font-family: monospace; font-size: 13px; color: var(--color-ink); font-weight: 600;">{{ $item->quantity }}</span>
                                            <button type="button" wire:click="incrementQuantity({{ $item->id }})"
                                                style="background: transparent; border: none; color: var(--color-ink); padding: 6px 12px; cursor: pointer; font-weight: bold;">+</button>
                                        </div>
                                    </td>

                                    <td
                                        style="padding: 16px; text-align: right; font-family: monospace; font-size: 14px; color: var(--color-ink); font-weight: 600;">
                                        Rp {{ number_format($item->quantity * $item->product->price, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div
                style="border: 1px solid var(--color-line); padding: 24px; background: var(--color-line-2); position: sticky; top: 24px;">
                <span
                    style="display: block; font-size: 10px; color: var(--color-ink-3); letter-spacing: 2px; text-transform: uppercase; margin-bottom: 20px;">RINGKASAN
                    PROTOKOL PENGELUARAN</span>

                <div
                    style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 24px; padding-bottom: 16px; border-bottom: 1px dashed var(--color-line);">
                    <span style="font-size: 12px; color: var(--color-ink-2);">SUBTOTAL BELANJA</span>
                    <strong style="font-size: 18px; font-family: monospace; color: var(--color-ink);">Rp
                        {{ number_format($this->subtotal, 0, ',', '.') }}</strong>
                </div>

                <a href="{{ route('pelanggan.checkout') }}" wire:navigate class="btn-primary"
                    style="display: block; text-align: center; text-decoration: none; font-size: 12px; padding: 14px;">
                    PROSES LANJUT (CHECKOUT)
                </a>
            </div>
        </div>
    @else
        <div class="empty-state" style="padding: 60px 0;">
            <div class="empty-state-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="1.5">
                    <circle cx="12" cy="12" r="10" />
                    <polyline points="12 6 12 12 16 14" />
                </svg>
            </div>
            <h2 class="empty-state-title">KERANJANG BELANJA KOSONG</h2>
            <p class="empty-state-desc">Belum ada pasokan item barang yang Anda antrekan untuk masuk ke modul
                pembayaran.</p>
            <a href="{{ route('pelanggan.katalog') }}" wire:navigate class="btn-primary"
                style="text-decoration: none; display: inline-block; margin-top: 20px;">
                KEMBALI KE KATALOG
            </a>
        </div>
    @endif
</div>
