<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    /**
     * Ambil satu nilai setting berdasarkan key.
     * Di-cache 1 jam supaya tidak query DB berulang-ulang di checkout.
     */
    public static function get(string $key, $default = null)
    {
        return Cache::remember("setting:{$key}", 3600, function () use ($key, $default) {
            return static::where('key', $key)->value('value') ?? $default;
        });
    }

    /**
     * Simpan/update satu nilai setting, sekaligus hapus cache lama.
     */
    public static function set(string $key, $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
        Cache::forget("setting:{$key}");
    }

    /**
     * Ambil beberapa setting sekaligus sebagai array associative.
     * Berguna untuk halaman "Pengaturan Toko" di admin panel.
     */
    public static function getMany(array $keys): array
    {
        return collect($keys)->mapWithKeys(function ($key) {
            return [$key => static::get($key)];
        })->toArray();
    }
}
