<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class RajaOngkirService
{
  // Data wilayah (provinsi/kota/kecamatan) praktis tidak pernah berubah,
  // jadi aman di-cache lama untuk menghindari kena rate limit harian API.
  private const REGION_CACHE_MINUTES = 60 * 24 * 30; // 30 hari

  public function getProvinces(): array
  {
    return Cache::remember('rajaongkir:provinces', self::REGION_CACHE_MINUTES, function () {
      $response = Http::withoutVerifying()->withHeaders([
        'key' => config('services.rajaongkir.key')
      ])->get('https://rajaongkir.komerce.id/api/v1/destination/province');

      if (!$response->successful()) {
        throw new \RuntimeException(
          'Gagal memuat provinsi: ' . $response->status() . ' - ' . $response->body()
        );
      }

      $json = $response->json();
      return is_array($json) && isset($json['data']) ? $json['data'] : [];
    });
  }

  public function getCities(string $provinceId): array
  {
    return Cache::remember("rajaongkir:cities:{$provinceId}", self::REGION_CACHE_MINUTES, function () use ($provinceId) {
      $response = Http::withoutVerifying()->withHeaders([
        'key' => config('services.rajaongkir.key')
      ])->get('https://rajaongkir.komerce.id/api/v1/destination/city/' . $provinceId);

      if (!$response->successful()) {
        throw new \RuntimeException(
          'Gagal memuat kota: ' . $response->status() . ' - ' . $response->body()
        );
      }

      $json = $response->json();
      return is_array($json) && isset($json['data']) ? $json['data'] : [];
    });
  }

  public function getDistricts(string $cityId): array
  {
    return Cache::remember("rajaongkir:districts:{$cityId}", self::REGION_CACHE_MINUTES, function () use ($cityId) {
      $response = Http::withoutVerifying()->withHeaders([
        'key' => config('services.rajaongkir.key')
      ])->get('https://rajaongkir.komerce.id/api/v1/destination/district/' . $cityId);

      if (!$response->successful()) {
        throw new \RuntimeException(
          'Gagal memuat kecamatan: ' . $response->status() . ' - ' . $response->body()
        );
      }

      $json = $response->json();
      return is_array($json) && isset($json['data']) ? $json['data'] : [];
    });
  }

  /**
   * Hitung ongkir TIDAK di-cache lama seperti data wilayah, karena tarif
   * bisa berubah sewaktu-waktu. Boleh dicache singkat (opsional) untuk
   * menghindari klik ganda pada kombinasi tujuan+kurir yang sama persis.
   */
  public function calculateCost(string $origin, string $destination, int $weight, string $courier): array
  {
    $cacheKey = "rajaongkir:cost:{$origin}:{$destination}:{$weight}:{$courier}";

    return Cache::remember($cacheKey, 15, function () use ($origin, $destination, $weight, $courier) {
      $response = Http::withoutVerifying()
        ->withHeaders(['key' => config('services.rajaongkir.key')])
        ->asForm()
        ->post('https://rajaongkir.komerce.id/api/v1/calculate/domestic-cost', [
          'origin'      => $origin,
          'destination' => $destination,
          'weight'      => $weight,
          'courier'     => $courier,
        ]);

      if (!$response->successful()) {
        throw new \RuntimeException(
          'Gagal menghitung ongkir: ' . $response->status() . ' - ' . $response->body()
        );
      }

      $json = $response->json();
      return is_array($json) && isset($json['data']) ? $json['data'] : [];
    });
  }
}
