<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // 1. Pembuatan Akun Default Pengguna
        User::create([
            'name' => 'Kepala Toko',
            'email' => 'kepala@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'kepala',
        ]);

        User::create([
            'name' => 'Administrator',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Pelanggan Setia',
            'email' => 'user@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'pelanggan',
        ]);

        // 2. Pembuatan Data Kategori Dummy (Kategori ini yang punya kolom slug)
        $category = Category::create([
            'name' => 'Elektronik & Gadget',
            'slug' => Str::slug('Elektronik & Gadget'),
        ]);

        // 3. Pembuatan Data Produk Dummy (HANYA MENGGUNAKAN SKU)
        Product::create([
            'category_id' => $category->id,
            'name'        => 'Mechanical Keyboard Cyberpunk Edition',
            'sku'         => 'KB-CYBER-001',
            'description' => 'Keyboard mekanik bertema cetak biru masa depan dengan switch linier taktil yang presisi dan lampu latar RGB kustom.',
            'price'       => 750000.00,
            'weight'      => 800,
            'stock'       => 15,
            'image_path'  => null,
            'is_active'   => true,
        ]);

        // 4. Pengaturan Toko (Origin RajaOngkir & Info Umum)
        Setting::set('store_name', 'Daffy Store');
        Setting::set('store_origin_id', '73283'); // Alam Jaya, Jatiuwung, Tangerang, Banten
        Setting::set('store_origin_label', 'Alam Jaya, Jatiuwung, Tangerang, Banten, 15133');
        Setting::set('store_address', 'Alamat lengkap toko di sini'); // sesuaikan alamat detail (nama jalan, no rumah)
        Setting::set('store_phone', '0800-0000-0000');
    }
}
