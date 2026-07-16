<?php

use App\Livewire\Admin\Dashboard as AdminDashboard;
use App\Livewire\Admin\Category\Index as CategoryIndex;
use App\Livewire\Admin\Produk\Index as ProdukIndex;
use App\Livewire\Admin\Produk\Create as ProdukCreate;
use App\Livewire\Admin\Produk\Edit as ProdukEdit;
use App\Livewire\Admin\Produk\StockAlert;
use App\Livewire\Admin\Produk\BulkManager;
// =========================================
use App\Livewire\Admin\Order\Index as OrderIndex;
use App\Livewire\Admin\Order\Show as OrderShow;
use App\Livewire\Admin\Order\Manifest as OrderManifest;
// ========================================
use App\Livewire\Admin\Finance\Index as FinanceIndex;
use App\Livewire\Admin\Customer\Index as CustomerIndex;
use App\Livewire\Admin\Customer\Show as CustomerShow;
// =======================================
use App\Livewire\Kepala\Report\Sales as ReportSales;
use App\Livewire\Kepala\Report\Payment as ReportPayment;
use App\Livewire\Kepala\Report\ExportCenter;
// ========================================
use App\Livewire\Kepala\Analytics\BestSeller;
use App\Livewire\Kepala\Analytics\PaymentStats;
// ======================================
use App\Livewire\Kepala\Security\AdminManagement;
use App\Livewire\Kepala\Security\SessionAudit;
// =========================================
use App\Livewire\Pelanggan\ProductCatalog;
// ========================================
use App\Livewire\Pelanggan\Transaction\Index as TransactionIndex;
use App\Livewire\Pelanggan\Transaction\Show as TransactionShow;
use App\Livewire\Pelanggan\Transaction\Tracking as TransactionTracking;
// ========================================
use App\Livewire\Pelanggan\Cart as PelangganCart;
use App\Livewire\Pelanggan\Checkout as PelangganCheckout;
// ========================================
use App\Livewire\Kepala\Dashboard as KepalaDashboard;
use App\Livewire\Auth\Login;
use App\Livewire\Home;
use Illuminate\Support\Facades\Route;


Route::get('/', Home::class)->name('home');
Route::middleware(['guest'])->group(function () {
    Route::get('/auth/login', Login::class)->name('login');
});
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', AdminDashboard::class)->name('dashboard');
    Route::get('/kategori', CategoryIndex::class)->name('category.index');
    Route::get('/produk', ProdukIndex::class)->name('produk.index');
    Route::get('/produk/tambah', ProdukCreate::class)->name('produk.create');
    Route::get('/produk/peringatan-stok', StockAlert::class)->name('produk.stock-alert');
    Route::get('/produk/bulk-manager', BulkManager::class)->name('produk.bulk-manager');
    Route::get('/produk/{product}/edit', ProdukEdit::class)->name('produk.edit');

    Route::prefix('pesanan')->name('order.')->group(function () {
        Route::get('/', OrderIndex::class)->name('index');
        Route::get('/manifest', OrderManifest::class)->name('manifest');
        Route::get('/{order}', OrderShow::class)->name('show');
    });

    Route::prefix('keuangan')->name('finance.')->group(function () {
        Route::get('/rekonsiliasi', FinanceIndex::class)->name('index');
    });


    Route::prefix('pelanggan')->name('customer.')->group(function () {
        Route::get('/', CustomerIndex::class)->name('index');
        Route::get('/{user}', CustomerShow::class)->name('show');
    });
});
Route::middleware(['auth', 'pelanggan'])->prefix('pelanggan')->name('pelanggan.')->group(function () {
    Route::get('/katalog', ProductCatalog::class)->name('katalog');
    Route::prefix('transaksi')->name('transaction.')->group(function () {
        Route::get('/', TransactionIndex::class)->name('index');
        Route::get('/lacak-resi', TransactionTracking::class)->name('tracking');
        Route::get('/{order}', TransactionShow::class)->name('show');
    });
    // Rute Etalase & Transaksi sebelumnya...
    Route::get('/katalog', [App\Livewire\Pelanggan\ProductCatalog::class, '__invoke'])->name('katalog');

    // Halaman Keranjang Belanja Pelanggan
    Route::get('/keranjang', PelangganCart::class)->name('cart');

    // Rute katalog dan transaksi lainnya...
    Route::get('/keranjang', [App\Livewire\Pelanggan\Cart::class, '__invoke'])->name('cart');

    // Halaman Checkout & RajaOngkir
    Route::get('/checkout', PelangganCheckout::class)->name('checkout');

    Route::prefix('profil')->name('profile.')->group(function () {
        Route::get('/', App\Livewire\Pelanggan\Profile\Index::class)->name('index');
        Route::get('/alamat', App\Livewire\Pelanggan\Profile\Address::class)->name('address');
        Route::get('/password', App\Livewire\Pelanggan\Profile\Password::class)->name('password');
    });
});


Route::middleware(['auth', 'kepala'])->prefix('kepala')->name('kepala.')->group(function () {
    Route::get('/dashboard', KepalaDashboard::class)->name('dashboard');
    Route::prefix('/laporan')->name('report.')->group(function () {
        Route::get('/penjualan', ReportSales::class)->name('sales');
        Route::get('/pembayaran', ReportPayment::class)->name('payment');
        Route::get('/export-center', ExportCenter::class)->name('export');
    });

    Route::prefix('/analisis')->name('analytics.')->group(function () {
        Route::get('/produk-terlaris', BestSeller::class)->name('best-seller');
        Route::get('/metode-pembayaran', PaymentStats::class)->name('payment-stats');
    });
    Route::prefix('/keamanan')->name('security.')->group(function () {
        Route::get('/manajemen-admin', AdminManagement::class)->name('admin');
        Route::get('/audit-sesi', SessionAudit::class)->name('audit');
    });
});
