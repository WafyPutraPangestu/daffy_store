<?php

namespace App\Services;

class RajaOngkirService
{
  public function getProvinces(): array
  {
    return [
      ['id' => '31', 'name' => 'DKI Jakarta'],
      ['id' => '32', 'name' => 'Jawa Barat'],
      ['id' => '33', 'name' => 'Jawa Tengah'],
      ['id' => '34', 'name' => 'DI Yogyakarta'],
      ['id' => '35', 'name' => 'Jawa Timur'],
      ['id' => '36', 'name' => 'Banten'],
    ];
  }

  public function getCities(string $provinceId): array
  {
    return [
      ['id' => $provinceId . '01', 'name' => 'Kota Utama Demo', 'type' => 'Kota'],
      ['id' => $provinceId . '02', 'name' => 'Kabupaten Demo', 'type' => 'Kabupaten'],
    ];
  }

  public function getDistricts(string $cityId): array
  {
    return [
      ['id' => $cityId . '01', 'name' => 'Kecamatan Demo 1'],
      ['id' => $cityId . '02', 'name' => 'Kecamatan Demo 2'],
    ];
  }

  public function calculateCost(string $origin, string $destination, int $weight, string $courier): array
  {
    // Mengembalikan data ongkir palsu/dummy
    $baseCost = ($weight > 0 ? ceil($weight / 1000) : 1) * 10000;
    
    return [
      [
        'service' => 'REG',
        'description' => 'Layanan Reguler (Demo)',
        'cost' => [
          [
            'value' => $baseCost + 5000,
            'etd' => '2-3 Hari'
          ]
        ]
      ],
      [
        'service' => 'EXPRESS',
        'description' => 'Layanan Kilat (Demo)',
        'cost' => [
          [
            'value' => $baseCost + 15000,
            'etd' => '1 Hari'
          ]
        ]
      ]
    ];
  }
}
