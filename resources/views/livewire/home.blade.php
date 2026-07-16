<div>

    {{-- HERO --}}
    <section style="padding:48px 32px 0;border-bottom:1px solid var(--color-line)">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:0;max-width:1200px;margin:0 auto">

            {{-- Kiri --}}
            <div style="padding-bottom:48px;padding-right:48px;border-right:1px solid var(--color-line)">
                <div
                    style="font-size:10px;letter-spacing:4px;text-transform:uppercase;color:var(--color-accent);margin-bottom:16px;display:flex;align-items:center;gap:8px">
                    <span style="display:block;width:24px;height:1px;background:var(--color-accent)"></span>
                    Koleksi Unggulan {{ now()->year }}
                </div>
                <h1 class="rz" style="font-size:64px;line-height:.95;color:var(--color-ink);margin-bottom:20px">
                    PERALATAN<br>PANCING<br><span style="color:var(--color-accent)">PRESISI</span>
                </h1>
                <p
                    style="font-size:13px;color:var(--color-ink-3);font-weight:300;line-height:1.7;max-width:360px;margin-bottom:36px;letter-spacing:.3px">
                    Dirancang untuk performa ekstrem. Setiap unit diuji di kondisi lapangan paling menantang — dari
                    sungai deras hingga laut dalam.
                </p>
                <div style="display:flex;gap:12px;align-items:center">
                    <a href="#katalog" class="btn-primary" style="text-decoration:none">Lihat Katalog</a>
                    <a href="#kategori" class="btn-outline" style="text-decoration:none">Jelajahi Kategori</a>
                </div>

                {{-- Stats --}}
                <div style="display:flex;gap:0;margin-top:48px;padding-top:24px;border-top:1px solid var(--color-line)">
                    <div style="flex:1">
                        <div class="rz" style="font-size:32px;color:var(--color-ink)">{{ $products->count() }}</div>
                        <div
                            style="font-size:10px;letter-spacing:2px;text-transform:uppercase;color:var(--color-ink-3);margin-top:2px">
                            Produk</div>
                    </div>
                    <div style="flex:1;padding-left:24px;border-left:1px solid var(--color-line)">
                        <div class="rz" style="font-size:32px;color:var(--color-ink)">{{ $categories->count() }}
                        </div>
                        <div
                            style="font-size:10px;letter-spacing:2px;text-transform:uppercase;color:var(--color-ink-3);margin-top:2px">
                            Kategori</div>
                    </div>
                    <div style="flex:1;padding-left:24px;border-left:1px solid var(--color-line)">
                        <div class="rz" style="font-size:32px;color:var(--color-ink)">{{ $bestSellers->count() }}
                        </div>
                        <div
                            style="font-size:10px;letter-spacing:2px;text-transform:uppercase;color:var(--color-ink-3);margin-top:2px">
                            Terlaris</div>
                    </div>
                </div>
            </div>

            {{-- Kanan - Featured Product --}}
            <div
                style="padding-left:48px;padding-bottom:48px;display:flex;flex-direction:column;justify-content:space-between">
                <div
                    style="font-size:10px;letter-spacing:3px;text-transform:uppercase;color:var(--color-ink-3);padding-bottom:16px;border-bottom:1px solid var(--color-line);margin-bottom:24px">
                    Produk Unggulan
                </div>

                @if ($featuredProduct)
                    <div class="card-img-blueprint" style="flex:1;margin-bottom:24px;min-height:240px">
                        @if ($featuredProduct->image_path)
                            <img src="{{ asset('storage/' . $featuredProduct->image_path) }}"
                                alt="{{ $featuredProduct->name }}" style="width:100%;height:100%;object-fit:cover">
                        @else
                            <i class="ti ti-fish" style="font-size:48px;color:var(--color-line)" aria-hidden="true"></i>
                        @endif
                        <div
                            style="position:absolute;top:10px;left:10px;font-size:10px;letter-spacing:2px;text-transform:uppercase;color:var(--color-ink-3);padding:4px 8px;background:var(--color-paper);border:1px solid var(--color-line)">
                            {{ $featuredProduct->sku }}
                        </div>
                    </div>

                    <div>
                        <div
                            style="font-size:10px;letter-spacing:2px;text-transform:uppercase;color:var(--color-accent);margin-bottom:6px">
                            {{ $featuredProduct->category?->name ?? 'Tanpa Kategori' }}</div>
                        <div class="rz" style="font-size:22px;color:var(--color-ink);margin-bottom:6px">
                            {{ $featuredProduct->name }}</div>
                        <p
                            style="font-size:12px;color:var(--color-ink-3);font-weight:300;margin-bottom:20px;line-height:1.6">
                            {{ \Illuminate\Support\Str::limit($featuredProduct->description, 90, '...') }}</p>
                        <div style="display:flex;align-items:center;justify-content:space-between">
                            <div class="rz" style="font-size:26px;color:var(--color-ink)">
                                <span
                                    style="font-size:13px;color:var(--color-ink-3);font-family:var(--font-sans);font-weight:400">Rp
                                </span>{{ number_format($featuredProduct->price, 0, ',', '.') }}
                            </div>
                            @if ($featuredProduct->stock > 0)
                                <span
                                    style="font-size:10px;letter-spacing:2px;text-transform:uppercase;color:var(--color-accent);border:1px solid var(--color-accent);padding:4px 12px">In
                                    Stock</span>
                            @else
                                <span
                                    style="font-size:10px;letter-spacing:2px;text-transform:uppercase;color:#e5484d;border:1px solid #e5484d;padding:4px 12px">Habis</span>
                            @endif
                        </div>
                    </div>
                @else
                    {{-- Empty state: belum ada produk sama sekali --}}
                    <div class="card-img-blueprint" style="flex:1;min-height:240px">
                        <div
                            style="display:flex;flex-direction:column;align-items:center;gap:12px;color:var(--color-ink-3)">
                            <i class="ti ti-package-off" style="font-size:40px" aria-hidden="true"></i>
                            <div style="text-align:center;max-width:220px">
                                <div class="rz" style="font-size:13px;color:var(--color-ink);margin-bottom:4px">
                                    Belum Ada
                                    Produk</div>
                                <p style="font-size:11px;font-weight:300;line-height:1.6">
                                    Produk unggulan akan tampil di sini setelah katalog diisi.</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    {{-- KATEGORI --}}
    <section id="kategori" style="border-bottom:1px solid var(--color-line)">
        <div style="max-width:1200px;margin:0 auto">
            <div class="section-header">
                <h2 class="rz" style="font-size:28px;color:var(--color-ink)">Kategori</h2>
                <span style="font-size:11px;letter-spacing:2px;text-transform:uppercase;color:var(--color-ink-3)">
                    {{ $categories->count() }} Kategori
                </span>
            </div>

            @if ($categories->isNotEmpty())
                <div style="display:grid;grid-template-columns:repeat({{ min($categories->count(), 5) }},1fr)">
                    @foreach ($categories as $cat)
                        <a href="#" wire:navigate class="category-tile">
                            <i class="ti {{ $categoryIcons[$cat->slug] ?? 'ti-package' }}"
                                style="font-size:28px;color:var(--color-ink-3);margin-bottom:12px"
                                aria-hidden="true"></i>
                            <div class="rz" style="font-size:14px;color:var(--color-ink);margin-bottom:4px">
                                {{ $cat->name }}</div>
                            <div
                                style="font-size:10px;letter-spacing:2px;text-transform:uppercase;color:var(--color-ink-3)">
                                {{ $cat->products_count }} produk</div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="ti ti-category-off" style="font-size:22px" aria-hidden="true"></i>
                    </div>
                    <div class="empty-state-title">Kategori Belum Tersedia</div>
                    <p class="empty-state-desc">
                        Kategori produk akan muncul di sini setelah admin menambahkan data kategori.
                    </p>
                </div>
            @endif
        </div>
    </section>

    {{-- KATALOG --}}
    <section id="katalog" style="border-bottom:1px solid var(--color-line)">
        <div style="max-width:1200px;margin:0 auto">
            <div class="section-header">
                <h2 class="rz" style="font-size:28px;color:var(--color-ink)">Produk Terbaru</h2>
                @if ($products->isNotEmpty())
                    <a href="#" wire:navigate
                        style="font-size:10px;letter-spacing:3px;text-transform:uppercase;color:var(--color-accent);text-decoration:none">
                        Lihat Semua <i class="ti ti-arrow-right" style="font-size:12px" aria-hidden="true"></i>
                    </a>
                @endif
            </div>

            @if ($products->isNotEmpty())
                {{-- Filter Advance: kategori, rentang harga, status stok --}}
                <div class="filter-bar">
                    <span class="filter-bar-label">Filter:</span>
                    <a href="#" wire:navigate class="filter-item active">Semua</a>
                    @foreach ($categories as $cat)
                        <a href="#" wire:navigate class="filter-item">{{ $cat->name }}</a>
                    @endforeach
                    <a href="#" wire:navigate class="filter-item"
                        style="margin-left:auto;color:var(--color-accent)">
                        <i class="ti ti-adjustments-horizontal" style="font-size:13px" aria-hidden="true"></i>
                        Rentang Harga & Stok
                    </a>
                </div>

                <div style="display:grid;grid-template-columns:repeat(4,1fr)">
                    @foreach ($products as $p)
                        @php
                            $stockStatus = match (true) {
                                $p->stock <= 0 => 'red',
                                $p->stock < 10 => 'yellow',
                                default => 'green',
                            };
                            $stockLabel = match ($stockStatus) {
                                'red' => 'Stok Habis',
                                'yellow' => 'Stok Menipis',
                                default => 'Stok Aman',
                            };
                        @endphp
                        <div class="card-blueprint">
                            <div
                                style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:16px">
                                <span class="card-number">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                                @if ($p->created_at?->gte(now()->subDays(7)))
                                    <span class="card-tag-blueprint">New</span>
                                @endif
                            </div>

                            <div class="card-img-blueprint" style="margin-bottom:16px">
                                @if ($p->image_path)
                                    <img src="{{ asset('storage/' . $p->image_path) }}" alt="{{ $p->name }}"
                                        style="width:100%;height:100%;object-fit:cover">
                                @else
                                    <i class="ti ti-fish" style="font-size:32px;color:var(--color-line)"
                                        aria-hidden="true"></i>
                                @endif
                            </div>

                            <div style="display:flex;align-items:center;gap:6px;margin-bottom:4px">
                                <span
                                    style="font-size:10px;letter-spacing:2px;text-transform:uppercase;color:var(--color-ink-3)">
                                    {{ $p->category?->name ?? 'Tanpa Kategori' }}</span>
                                <span class="dot-status {{ $stockStatus }}" title="{{ $stockLabel }}"></span>
                            </div>
                            <div class="rz"
                                style="font-size:15px;color:var(--color-ink);margin-bottom:4px;line-height:1.1">
                                {{ $p->name }}</div>
                            <p style="font-size:11px;color:var(--color-ink-3);font-weight:300;margin-bottom:16px">
                                {{ \Illuminate\Support\Str::limit($p->description, 45, '...') ?: 'Deskripsi belum tersedia.' }}
                            </p>

                            <div
                                style="display:flex;align-items:center;justify-content:space-between;border-top:1px solid var(--color-line);padding-top:14px">
                                <div class="rz" style="font-size:17px;color:var(--color-ink)">
                                    <span
                                        style="font-size:10px;color:var(--color-ink-3);font-family:var(--font-sans);font-weight:400">Rp
                                    </span>{{ number_format($p->price, 0, ',', '.') }}
                                </div>
                                <button class="btn-add-cart" wire:click="addToCart({{ $p->id }})"
                                    @disabled($p->stock <= 0)
                                    style="{{ $p->stock <= 0 ? 'opacity:.4;cursor:not-allowed' : '' }}">
                                    <i class="ti ti-plus" style="font-size:12px" aria-hidden="true"></i>
                                    {{ $p->stock <= 0 ? 'Habis' : 'Keranjang' }}
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                {{-- Empty state: belum ada produk aktif --}}
                <div class="empty-state" style="border-bottom:1px solid var(--color-line)">
                    <div class="empty-state-icon">
                        <i class="ti ti-box-off" style="font-size:22px" aria-hidden="true"></i>
                    </div>
                    <div class="empty-state-title">Belum Ada Produk</div>
                    <p class="empty-state-desc">
                        Katalog masih kosong. Produk yang ditambahkan admin dan berstatus aktif akan tampil otomatis
                        di sini.
                    </p>
                </div>
            @endif
        </div>
    </section>

    {{-- PRODUK TERLARIS --}}
    <section id="terlaris" style="border-bottom:1px solid var(--color-line)">
        <div style="max-width:1200px;margin:0 auto">
            <div class="section-header">
                <div>
                    <h2 class="rz" style="font-size:28px;color:var(--color-ink)">Produk Terlaris</h2>
                    <p style="font-size:11px;color:var(--color-ink-3);margin-top:4px">
                        Berdasarkan total unit terjual
                    </p>
                </div>
                @if ($bestSellers->isNotEmpty())
                    <a href="#" wire:navigate
                        style="font-size:10px;letter-spacing:3px;text-transform:uppercase;color:var(--color-accent);text-decoration:none">
                        Lihat Peringkat Lengkap <i class="ti ti-arrow-right" style="font-size:12px"
                            aria-hidden="true"></i>
                    </a>
                @endif
            </div>

            @if ($bestSellers->isNotEmpty())
                <div style="display:grid;grid-template-columns:repeat(4,1fr)">
                    @foreach ($bestSellers as $p)
                        <div class="card-blueprint">
                            <div
                                style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:16px">
                                <span class="rz"
                                    style="font-size:20px;color:var(--color-accent)">#{{ $loop->iteration }}</span>
                                <span class="card-tag-blueprint">
                                    <i class="ti ti-flame" style="font-size:10px" aria-hidden="true"></i> Terlaris
                                </span>
                            </div>
                            <div class="card-img-blueprint" style="margin-bottom:16px">
                                @if ($p->image_path)
                                    <img src="{{ asset('storage/' . $p->image_path) }}" alt="{{ $p->name }}"
                                        style="width:100%;height:100%;object-fit:cover">
                                @else
                                    <i class="ti ti-fish" style="font-size:32px;color:var(--color-line)"
                                        aria-hidden="true"></i>
                                @endif
                            </div>
                            <div class="rz"
                                style="font-size:14px;color:var(--color-ink);margin-bottom:4px;line-height:1.2">
                                {{ $p->name }}</div>
                            <p style="font-size:11px;color:var(--color-ink-3);margin-bottom:16px">
                                {{ (int) $p->total_sold }} terjual</p>
                            <div
                                style="display:flex;align-items:center;justify-content:space-between;border-top:1px solid var(--color-line);padding-top:14px">
                                <div class="rz" style="font-size:15px;color:var(--color-ink)">
                                    <span
                                        style="font-size:10px;color:var(--color-ink-3);font-family:var(--font-sans);font-weight:400">Rp
                                    </span>{{ number_format($p->price, 0, ',', '.') }}
                                </div>
                                <button class="btn-add-cart" wire:click="addToCart({{ $p->id }})">
                                    <i class="ti ti-plus" style="font-size:12px" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                {{-- Empty state: belum ada histori penjualan --}}
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="ti ti-chart-bar-off" style="font-size:22px" aria-hidden="true"></i>
                    </div>
                    <div class="empty-state-title">Belum Ada Data Penjualan</div>
                    <p class="empty-state-desc">
                        Peringkat produk terlaris akan muncul otomatis setelah transaksi pertama selesai diproses.
                    </p>
                </div>
            @endif
        </div>
    </section>

    {{-- BANNER CTA --}}
    <section style="border-bottom:1px solid var(--color-line)">
        <div
            style="max-width:1200px;margin:0 auto;padding:64px 32px;display:flex;align-items:center;justify-content:space-between">
            <div>
                <div
                    style="font-size:10px;letter-spacing:4px;text-transform:uppercase;color:var(--color-accent);margin-bottom:12px;display:flex;align-items:center;gap:8px">
                    <span style="display:block;width:24px;height:1px;background:var(--color-accent)"></span>
                    Gratis Ongkir
                </div>
                <h2 class="rz" style="font-size:40px;color:var(--color-ink);line-height:1">
                    BELANJA LEBIH DARI<br>
                    <span style="color:var(--color-accent)">Rp 500.000</span> GRATIS KIRIM
                </h2>
            </div>
            <div style="flex-shrink:0">
                <a href="#katalog" class="btn-primary" style="text-decoration:none;font-size:11px;padding:16px 36px">
                    Belanja Sekarang
                </a>
            </div>
        </div>
    </section>

    {{-- FOOTER --}}
    <footer style="border-top:1px solid var(--color-line)">
        <div
            style="max-width:1200px;margin:0 auto;padding:16px 32px;display:flex;align-items:center;justify-content:space-between">
            <span style="font-size:10px;letter-spacing:2px;text-transform:uppercase;color:var(--color-ink-3)">
                Daffy Store · Peralatan Perikanan Presisi
            </span>
            <span style="font-size:10px;letter-spacing:2px;text-transform:uppercase;color:var(--color-ink-3)">
                © {{ now()->year }}
            </span>
        </div>
    </footer>

</div>
