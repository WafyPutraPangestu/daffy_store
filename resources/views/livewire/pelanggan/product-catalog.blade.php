<div style="padding: 24px;">

    <div style="margin-bottom: 32px; border-bottom: 1px solid var(--color-line); padding-bottom: 20px;">
        <h1 class="rz" style="font-size: 28px; margin: 0; color: var(--color-ink);">KATALOG PRODUK</h1>
        <span style="font-size: 11px; color: var(--color-ink-3); letter-spacing: 2px; text-transform: uppercase;">
            >>> DAFFY STORE / PRODUCTS / DIRECTORY
        </span>
    </div>

    <div style="display: flex; flex-direction: column; gap: 20px; margin-bottom: 32px;">
        <div>
            <input type="text" wire:model.live.debounce.400ms="search" placeholder="CARI ITEM PRODUK..."
                style="background: transparent; border: 1px solid var(--color-line); color: var(--color-ink); padding: 12px 16px; width: 100%; max-width: 400px; font-size: 11px; letter-spacing: 2px; text-transform: uppercase; outline: none; transition: border-color 0.15s;"
                onfocus="this.style.borderColor='var(--color-ink)'" onblur="this.style.borderColor='var(--color-line)'">
        </div>

        <div class="filter-bar">
            <span class="filter-bar-label">ARSIP KATEGORI:</span>
            <div wire:click="$set('category', '')" class="filter-item {{ $category === '' ? 'active' : '' }}">
                SEMUA PRODUK
            </div>
            @foreach ($this->categories as $cat)
                <div wire:click="$set('category', '{{ $cat->slug }}')"
                    class="filter-item {{ $category === $cat->slug ? 'active' : '' }}">
                    {{ strtoupper($cat->name) }}
                </div>
            @endforeach
        </div>
    </div>

    <div
        style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); border-left: 1px solid var(--color-line); border-top: 1px solid var(--color-line);">
        @forelse($this->products as $product)
            <div class="card-blueprint"
                style="display: flex; flex-direction: column; justify-content: space-between; gap: 16px;">
                <div>
                    <div
                        style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                        <span class="card-tag-blueprint">{{ $product->category->name ?? 'UMUM' }}</span>
                        <span class="card-number">SYS_#{{ sprintf('%03d', $product->id) }}</span>
                    </div>

                    <div class="card-img-blueprint">
                        @if ($product->image_path)
                            <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}"
                                style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none"
                                stroke="var(--color-ink-3)" stroke-width="1" style="opacity: 0.4;">
                                <path
                                    d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" />
                                <polyline points="3.27 6.96 12 12.01 20.73 6.96" />
                                <line x1="12" y1="22.08" x2="12" y2="12" />
                            </svg>
                        @endif
                    </div>

                    <h3 class="rz" style="font-size: 15px; margin: 16px 0 6px 0; color: var(--color-ink);">
                        {{ $product->name }}</h3>
                    <p
                        style="font-size: 12px; color: var(--color-ink-3); line-height: 1.5; margin: 0; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; min-height: 36px;">
                        {{ $product->description ?? 'Tidak ada rincian spesifikasi untuk item ini.' }}
                    </p>

                    <span
                        style="display: block; font-size: 10px; color: var(--color-ink-2); margin-top: 8px; font-family: monospace;">STOK
                        DIGITAL: {{ $product->stock }} UNITS</span>
                </div>

                <div
                    style="display: flex; justify-content: space-between; align-items: center; border-top: 1px dashed var(--color-line); padding-top: 12px; margin-top: 12px;">
                    <span
                        style="font-family: monospace; font-size: 15px; font-weight: 700; color: var(--color-accent);">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </span>

                    @if ($product->stock > 0)
                        <button wire:click="addToCart({{ $product->id }})" class="btn-add-cart">
                            + KERANJANG
                        </button>
                    @else
                        <span
                            style="font-size: 9px; letter-spacing: 1px; color: #e5484d; border: 1px solid #e5484d; padding: 4px 8px; font-weight: 700;">OUT
                            OF STOCK</span>
                    @endif
                </div>
            </div>
        @empty
            <div class="empty-state">
                <div class="empty-state-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.5">
                        <circle cx="12" cy="12" r="10" />
                        <line x1="15" y1="9" x2="9" y2="15" />
                        <line x1="9" y1="9" x2="15" y2="15" />
                    </svg>
                </div>
                <h2 class="empty-state-title">PRODUK TIDAK TERSEDIA</h2>
                <p class="empty-state-desc">Item yang dicari atau kategori aktif belum memiliki suplai komoditas barang.
                </p>
            </div>
        @endforelse
    </div>

    <div style="margin-top: 32px;">
        {{ $this->products->links() }}
    </div>
</div>
