<div>
    <nav class="nav-blueprint" style="position:relative">

        {{-- Logo --}}
        <a href="{{ route('home') }}" wire:navigate class="nav-logo">
            DAFFY<span style="color:var(--color-accent)">.</span>STORE
        </a>

        {{-- Nav Links --}}
        <ul class="flex items-center gap-0" style="list-style:none;margin:0;padding:0">

            <li class="nav-item-wrap">
                <a href="{{ route('home') }}" wire:navigate class="nav-link" style="padding:16px 20px;display:block">
                    Home
                </a>
            </li>

            {{-- ============================================================
                 GUEST / SEMUA ORANG — Katalog Publik
            ============================================================ --}}
            <li class="nav-item-wrap" x-data="{ open: false }" @click.outside="open = false">
                <button type="button" @click="open = !open" class="nav-link-btn" :class="{ 'is-open': open }">
                    Produk
                    <svg class="nav-caret" :class="{ 'is-open': open }" viewBox="0 0 12 12" fill="none">
                        <path d="M2 4L6 8L10 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                    </svg>
                </button>
                <div x-show="open" x-transition style="display:none" class="nav-dropdown-menu">
                    <div class="nav-dropdown-group-title">Katalog</div>
                    <a href="#" wire:navigate class="nav-dropdown-item">
                        Semua Produk
                    </a>
                    <a href="#" wire:navigate class="nav-dropdown-item">
                        Filter Lanjutan
                        <span class="nav-badge-outline">Harga · Stok</span>
                    </a>
                    <a href="#" wire:navigate class="nav-dropdown-item">
                        Kategori Produk
                    </a>
                    <a href="#" wire:navigate class="nav-dropdown-item">
                        Produk Terlaris
                        <span class="nav-badge">Populer</span>
                    </a>
                </div>
            </li>

            {{-- ============================================================
                 PELANGGAN
            ============================================================ --}}
            @can('pelanggan')
                <li class="nav-item-wrap">
                    <a href="{{ route('pelanggan.katalog') }}" wire:navigate class="nav-link-btn"
                        style="text-decoration: none;">
                        Katalog Produk
                    </a>
                </li>

                <li class="nav-item-wrap" x-data="{ open: false }" @click.outside="open = false">
                    <button type="button" @click="open = !open" class="nav-link-btn" :class="{ 'is-open': open }">
                        Transaksi Saya
                        <svg class="nav-caret" :class="{ 'is-open': open }" viewBox="0 0 12 12" fill="none">
                            <path d="M2 4L6 8L10 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                        </svg>
                    </button>
                    <div x-show="open" x-transition style="display:none" class="nav-dropdown-menu">
                        <div class="nav-dropdown-group-title">Riwayat Pesanan</div>

                        <a href="{{ route('pelanggan.transaction.index') }}" wire:navigate class="nav-dropdown-item">
                            Semua Pesanan
                        </a>

                        <a href="{{ route('pelanggan.transaction.index', ['status' => 'menunggu_pembayaran']) }}"
                            wire:navigate class="nav-dropdown-item">
                            Menunggu Pembayaran
                            <span class="dot-status yellow"></span>
                        </a>
                        <a href="{{ route('pelanggan.transaction.index', ['status' => 'diproses']) }}" wire:navigate
                            class="nav-dropdown-item">Diproses</a>
                        <a href="{{ route('pelanggan.transaction.index', ['status' => 'dikirim']) }}" wire:navigate
                            class="nav-dropdown-item">Dikirim</a>
                        <a href="{{ route('pelanggan.transaction.index', ['status' => 'selesai']) }}" wire:navigate
                            class="nav-dropdown-item">Selesai</a>
                        <a href="{{ route('pelanggan.transaction.index', ['status' => 'dibatalkan']) }}" wire:navigate
                            class="nav-dropdown-item">Dibatalkan</a>

                        <div class="nav-dropdown-group-title">Lainnya</div>

                        <a href="{{ route('pelanggan.transaction.tracking') }}" wire:navigate class="nav-dropdown-item">
                            Lacak Resi
                            <span class="nav-badge-outline">Real-time</span>
                        </a>
                    </div>
                </li>

                <li class="nav-item-wrap" x-data="{ open: false }" @click.outside="open = false">
                    <button type="button" @click="open = !open" class="nav-link-btn" :class="{ 'is-open': open }">
                        Akun Saya
                        <svg class="nav-caret" :class="{ 'is-open': open }" viewBox="0 0 12 12" fill="none">
                            <path d="M2 4L6 8L10 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                        </svg>
                    </button>
                    <div x-show="open" x-transition style="display:none" class="nav-dropdown-menu">
                        <a href="{{ route('pelanggan.profile.index') }}" wire:navigate class="nav-dropdown-item">Profil
                            Saya</a>
                        <a href="{{ route('pelanggan.profile.address') }}" wire:navigate class="nav-dropdown-item">Buku
                            Alamat</a>
                        <a href="{{ route('pelanggan.profile.password') }}" wire:navigate class="nav-dropdown-item">Ubah
                            Password</a>
                        <div style="height: 1px; background: var(--color-line-2); margin: 4px 0;"></div>
                    </div>
                </li>
            @endcan

            {{-- ============================================================
                 ADMIN
            ============================================================ --}}
            @can('admin')
                <li class="nav-item-wrap">
                    <a href="{{ route('admin.dashboard') }}" wire:navigate class="nav-link"
                        style="padding:16px 20px;display:block">
                        Dashboard
                    </a>
                </li>

                <li class="nav-item-wrap" x-data="{ open: false }" @click.outside="open = false">
                    <button type="button" @click="open = !open" class="nav-link-btn" :class="{ 'is-open': open }">
                        Produk & Inventaris
                        <svg class="nav-caret" :class="{ 'is-open': open }" viewBox="0 0 12 12" fill="none">
                            <path d="M2 4L6 8L10 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                        </svg>
                    </button>
                    <div x-show="open" x-transition style="display:none" class="nav-dropdown-menu">
                        <a href="{{ route('admin.produk.index') }}" wire:navigate class="nav-dropdown-item">Semua
                            Produk</a>
                        <a href="{{ route('admin.produk.create') }}" wire:navigate class="nav-dropdown-item">Tambah
                            Produk
                            Baru</a>
                        <a href="{{ route('admin.category.index') }}" wire:navigate class="nav-dropdown-item">Kelola
                            Kategori</a>
                        <a href="{{ route('admin.produk.stock-alert') }}" wire:navigate class="nav-dropdown-item">
                            Peringatan Stok
                            <span class="dot-status yellow" title="Stok menipis"></span>
                        </a>
                        <a href="{{ route('admin.produk.bulk-manager') }}" wire:navigate class="nav-dropdown-item">Bulk
                            Action Manager</a>
                    </div>
                </li>

                <li class="nav-item-wrap" x-data="{ open: false }" @click.outside="open = false">
                    <button type="button" @click="open = !open" class="nav-link-btn" :class="{ 'is-open': open }">
                        Pesanan & Logistik
                        <svg class="nav-caret" :class="{ 'is-open': open }" viewBox="0 0 12 12" fill="none">
                            <path d="M2 4L6 8L10 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                        </svg>
                    </button>
                    <div x-show="open" x-transition style="display:none" class="nav-dropdown-menu">
                        <a href="{{ route('admin.order.index') }}" wire:navigate class="nav-dropdown-item">Semua
                            Pesanan</a>

                        <a href="{{ route('admin.order.index', ['status' => 'diproses']) }}" wire:navigate
                            class="nav-dropdown-item">Perlu Diproses</a>

                        <a href="{{ route('admin.order.index', ['status' => 'dikirim']) }}" wire:navigate
                            class="nav-dropdown-item">Perlu Dikirim</a>

                        <a href="{{ route('admin.order.manifest') }}" wire:navigate class="nav-dropdown-item">Cetak
                            Manifest Pengiriman</a>
                    </div>
                </li>

                <li class="nav-item-wrap" x-data="{ open: false }" @click.outside="open = false">
                    <button type="button" @click="open = !open" class="nav-link-btn" :class="{ 'is-open': open }">
                        Keuangan & Pelanggan
                        <svg class="nav-caret" :class="{ 'is-open': open }" viewBox="0 0 12 12" fill="none">
                            <path d="M2 4L6 8L10 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                        </svg>
                    </button>
                    <div x-show="open" x-transition style="display:none" class="nav-dropdown-menu">
                        <a href="{{ route('admin.finance.index') }}" wire:navigate class="nav-dropdown-item">Rekonsiliasi
                            Pembayaran</a>
                        <a href="{{ route('admin.customer.index') }}" wire:navigate class="nav-dropdown-item">Database
                            Pelanggan</a>
                    </div>
                </li>
            @endcan

            {{-- ============================================================
                 KEPALA / OWNER
            ============================================================ --}}
            @can('kepala')
                <li class="nav-item-wrap">
                    <a href="{{ route('kepala.dashboard') }}" wire:navigate class="nav-link"
                        style="padding:16px 20px;display:block">
                        Dashboard BI
                    </a>
                </li>

                <li class="nav-item-wrap" x-data="{ open: false }" @click.outside="open = false">
                    <button type="button" @click="open = !open" class="nav-link-btn" :class="{ 'is-open': open }">
                        Laporan
                        <svg class="nav-caret" :class="{ 'is-open': open }" viewBox="0 0 12 12" fill="none">
                            <path d="M2 4L6 8L10 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                        </svg>
                    </button>
                    <div x-show="open" x-transition style="display:none" class="nav-dropdown-menu">
                        <a href="{{ route('kepala.report.sales') }}" wire:navigate class="nav-dropdown-item">Laporan
                            Penjualan</a>

                        <a href="{{ route('kepala.report.payment') }}" wire:navigate class="nav-dropdown-item">Laporan
                            Pembayaran</a>

                        <a href="{{ route('kepala.report.export') }}" wire:navigate class="nav-dropdown-item">
                            Export Center
                            <span class="nav-badge-outline">CSV · PDF</span>
                        </a>
                    </div>
                </li>

                <li class="nav-item-wrap" x-data="{ open: false }" @click.outside="open = false">
                    <button type="button" @click="open = !open" class="nav-link-btn" :class="{ 'is-open': open }">
                        Analisis Bisnis
                        <svg class="nav-caret" :class="{ 'is-open': open }" viewBox="0 0 12 12" fill="none">
                            <path d="M2 4L6 8L10 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                        </svg>
                    </button>
                    <div x-show="open" x-transition style="display:none" class="nav-dropdown-menu">
                        <a href="{{ route('kepala.analytics.best-seller') }}" wire:navigate
                            class="nav-dropdown-item">Produk Terlaris</a>
                        <a href="{{ route('kepala.analytics.payment-stats') }}" wire:navigate
                            class="nav-dropdown-item">Statistik Pembayaran</a>
                    </div>
                </li>

                <li class="nav-item-wrap" x-data="{ open: false }" @click.outside="open = false">
                    <button type="button" @click="open = !open" class="nav-link-btn" :class="{ 'is-open': open }">
                        Keamanan Sistem
                        <svg class="nav-caret" :class="{ 'is-open': open }" viewBox="0 0 12 12" fill="none">
                            <path d="M2 4L6 8L10 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                        </svg>
                    </button>
                    <div x-show="open" x-transition style="display:none" class="nav-dropdown-menu">
                        <a href="{{ route('kepala.security.admin') }}" wire:navigate class="nav-dropdown-item">Manajemen
                            User Admin</a>
                        <a href="{{ route('kepala.security.audit') }}" wire:navigate class="nav-dropdown-item">
                            Audit Sesi & Login
                            <span class="nav-badge-outline">IP · Device</span>
                        </a>
                    </div>
                </li>
            @endcan
        </ul>

        {{-- Auth Area --}}
        <div class="flex items-center gap-3">

            {{-- Live Cart Counter — hanya pelanggan --}}
            @can('pelanggan')
                <div class="nav-item-wrap" x-data="{ cartOpen: false }" @click.outside="cartOpen = false"
                    style="position: relative;">

                    <button type="button" @click="cartOpen = !cartOpen" class="cart-icon-wrap"
                        title="Keranjang Belanja"
                        style="background: transparent; border: none; cursor: pointer; padding: 0; outline: none; display: flex; align-items: center;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                            <path
                                d="M3 3h2l.4 2M7 13h10l3-8H5.4M7 13L5.4 5M7 13l-1.5 6h11.5M9 21a1 1 0 100-2 1 1 0 000 2zM17 21a1 1 0 100-2 1 1 0 000 2z"
                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                        @if ($cartCount > 0)
                            <span class="cart-count-badge">{{ $cartCount }}</span>
                        @endif
                    </button>

                    <div x-show="cartOpen" x-transition
                        style="display: none; position: absolute; right: 0; top: 100%; margin-top: 16px; width: 320px; background: var(--color-paper); border: 1px solid var(--color-line); z-index: 9999; box-shadow: 0 4px 24px rgba(0,0,0,0.1);">

                        <div
                            style="padding: 12px 16px; border-bottom: 1px solid var(--color-line); display: flex; justify-content: space-between; align-items: center; background: var(--color-line-2);">
                            <span
                                style="font-size: 10px; font-weight: 600; letter-spacing: 2px; color: var(--color-ink-3); text-transform: uppercase;">ISI
                                KERANJANG ({{ $cartCount }})</span>
                            <button type="button" @click="cartOpen = false"
                                style="background: none; border: none; font-size: 16px; cursor: pointer; color: var(--color-ink-3);">&times;</button>
                        </div>

                        <div style="max-height: 280px; overflow-y: auto; padding: 16px;">
                            @if ($this->cartData && $this->cartData->items->count() > 0)
                                <div style="display: flex; flex-direction: column; gap: 16px;">

                                    {{-- Menampilkan maksimal 3 barang saja sebagai preview --}}
                                    @foreach ($this->cartData->items->take(3) as $item)
                                        @if ($item->product)
                                            <div
                                                style="display: flex; gap: 12px; align-items: center; border-bottom: 1px dashed var(--color-line-2); padding-bottom: 12px;">
                                                <div
                                                    style="width: 48px; height: 48px; flex-shrink: 0; border: 1px solid var(--color-line); background: var(--color-line-2);">
                                                    @if ($item->product->image_path)
                                                        <img src="{{ asset('storage/' . $item->product->image_path) }}"
                                                            style="width: 100%; height: 100%; object-fit: cover;">
                                                    @else
                                                        <div
                                                            style="width:100%; height:100%; display:flex; align-items:center; justify-content:center;">
                                                            <i class="ti ti-photo"
                                                                style="font-size:14px; color:var(--color-ink-3)"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div style="flex: 1; overflow: hidden;">
                                                    <div
                                                        style="font-size: 12px; font-weight: 600; color: var(--color-ink); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                        {{ $item->product->name }}</div>
                                                    <div
                                                        style="font-size: 10px; color: var(--color-ink-3); margin-top: 4px; font-family: monospace;">
                                                        {{ $item->quantity }}x Rp
                                                        {{ number_format($item->product->price, 0, ',', '.') }}</div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach

                                    {{-- Jika barang lebih dari 3, tampilkan teks sisa --}}
                                    @if ($this->cartData->items->count() > 3)
                                        <div
                                            style="font-size: 10px; text-align: center; color: var(--color-ink-3); font-weight: 600; letter-spacing: 1px;">
                                            + {{ $this->cartData->items->count() - 3 }} ITEM LAINNYA
                                        </div>
                                    @endif

                                </div>
                            @else
                                <div style="text-align: center; padding: 24px 0;">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        stroke="var(--color-ink-3)" stroke-width="1.5" style="margin-bottom: 8px;">
                                        <circle cx="12" cy="12" r="10" />
                                        <polyline points="12 6 12 12 16 14" />
                                    </svg>
                                    <div style="color: var(--color-ink-3); font-size: 11px; letter-spacing: 1px;">KERANJANG
                                        KOSONG</div>
                                </div>
                            @endif
                        </div>

                        @if ($this->cartData && $this->cartData->items->count() > 0)
                            <div style="padding: 16px; border-top: 1px solid var(--color-line);">
                                <a href="{{ route('pelanggan.cart') }}" wire:navigate class="btn-primary"
                                    style="display: block; text-align: center; text-decoration: none; font-size: 11px; padding: 12px;">
                                    LIHAT DETAIL KERANJANG
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @endcan

            {{-- Bell Notifikasi — hanya admin --}}
            @can('admin')
                <div class="nav-item-wrap" x-data="{ bellOpen: false }" @click.outside="bellOpen = false"
                    style="position: relative;">

                    <button type="button" @click="bellOpen = !bellOpen"
                        style="background: transparent; border: none; cursor: pointer; padding: 0; outline: none; display: flex; align-items: center; position: relative;"
                        title="Notifikasi">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" stroke="currentColor"
                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M13.73 21a2 2 0 0 1-3.46 0" stroke="currentColor" stroke-width="1.5"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        @if ($unreadCount > 0)
                            <span
                                style="position: absolute; top: -6px; right: -6px; background: #e5484d; color: white; border-radius: 50%; font-size: 9px; font-weight: 700; min-width: 16px; height: 16px; display: flex; align-items: center; justify-content: center; padding: 0 3px; line-height: 1;">
                                {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                            </span>
                        @endif
                    </button>

                    {{-- Dropdown Notifikasi --}}
                    <div x-show="bellOpen" x-transition style="display: none; position: absolute; right: 0; top: calc(100% + 16px); width: 340px; background: var(--color-paper); border: 1px solid var(--color-line); z-index: 9999; box-shadow: 0 4px 24px rgba(0,0,0,0.12);">

                        {{-- Header --}}
                        <div style="padding: 12px 16px; border-bottom: 1px solid var(--color-line); display: flex; justify-content: space-between; align-items: center; background: var(--color-line-2);">
                            <span style="font-size: 10px; font-weight: 700; letter-spacing: 2px; color: var(--color-ink-3); text-transform: uppercase;">
                                NOTIFIKASI
                                @if ($unreadCount > 0)
                                    <span style="background: #e5484d; color: white; border-radius: 4px; padding: 1px 5px; font-size: 9px; margin-left: 4px;">
                                        {{ $unreadCount }} BARU
                                    </span>
                                @endif
                            </span>
                            @if ($unreadCount > 0)
                                <button type="button" wire:click="markAllRead"
                                    style="background: none; border: none; font-size: 10px; cursor: pointer; color: var(--color-accent); letter-spacing: 1px; font-weight: 600;">
                                    TANDAI SEMUA DIBACA
                                </button>
                            @endif
                        </div>

                        {{-- List Notifikasi --}}
                        <div style="max-height: 320px; overflow-y: auto;">
                            @forelse ($recentNotifications as $notif)
                                <div wire:key="notif-{{ $notif->id }}"
                                    style="padding: 14px 16px; border-bottom: 1px solid var(--color-line-2); display: flex; gap: 12px; align-items: flex-start; {{ $notif->read_at ? 'opacity: 0.6;' : 'background: rgba(58,143,255,0.04);' }}">

                                    {{-- Dot indikator unread --}}
                                    <div style="margin-top: 4px; flex-shrink: 0; width: 8px; height: 8px; border-radius: 50%; background: {{ $notif->read_at ? 'var(--color-line)' : '#3a8fff' }};"></div>

                                    <div style="flex: 1; overflow: hidden;">
                                        <div style="font-size: 12px; font-weight: 600; color: var(--color-ink); margin-bottom: 2px;">
                                            Order Baru — {{ $notif->data['order_number'] }}
                                        </div>
                                        <div style="font-size: 11px; color: var(--color-ink-3);">
                                            {{ $notif->data['customer_name'] }} ·
                                            Rp {{ number_format($notif->data['total_amount'], 0, ',', '.') }}
                                        </div>
                                        <div style="font-size: 10px; color: var(--color-ink-3); margin-top: 4px;">
                                            {{ $notif->created_at->diffForHumans() }}
                                        </div>
                                    </div>

                                    {{-- Tombol lihat & mark read --}}
                                    <div style="display: flex; flex-direction: column; gap: 4px; flex-shrink: 0;">
                                        <a href="{{ $notif->data['order_url'] }}" wire:navigate
                                            @click="bellOpen = false"
                                            wire:click="markAsRead('{{ $notif->id }}')"
                                            style="font-size: 10px; color: var(--color-accent); text-decoration: none; font-weight: 600; letter-spacing: 1px; white-space: nowrap;">
                                            LIHAT →
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <div style="padding: 32px 16px; text-align: center; color: var(--color-ink-3); font-size: 11px; letter-spacing: 1px;">
                                    BELUM ADA NOTIFIKASI
                                </div>
                            @endforelse
                        </div>

                    </div>
                </div>
            @endcan

            @guest
                <a href="{{ route('login') }}" wire:navigate class="btn-outline"
                    style="padding:8px 20px;font-size:10px">
                    Login
                </a>
            @endguest

            @auth
                {{-- User Info --}}
                <div style="text-align:right">
                    <div
                        style="font-family:var(--font-blueprint);font-weight:700;font-size:13px;letter-spacing:1px;text-transform:uppercase;color:var(--color-ink)">
                        {{ Auth::user()->name }}
                    </div>
                    <div style="font-size:10px;letter-spacing:2px;text-transform:uppercase;color:var(--color-accent)">
                        {{ Auth::user()->role }}
                    </div>
                </div>

                {{-- Divider --}}
                <div style="width:1px;height:32px;background:var(--color-line)"></div>

                {{-- Logout --}}
                <form wire:submit.prevent='logout'>
                    <button type="submit" class="btn-outline" style="padding:8px 20px;font-size:10px">
                        Logout
                    </button>
                </form>
            @endauth
        </div>

    </nav>
</div>
