<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Asset;

class AssetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $assets = [
        [
            'code' => 'USD',
            'name' => 'Dólar Americano',
            'type' => 'fiat',
            'symbol' => '$',
        ],
        [
            'code' => 'EUR',
            'name' => 'Euro',
            'type' => 'fiat',
            'symbol' => '€',
        ],
        [
            'code' => 'GBP',
            'name' => 'Libra Esterlina',
            'type' => 'fiat',
            'symbol' => '£',
        ],
        [
            'code' => 'BTC',
            'name' => 'Bitcoin',
            'type' => 'crypto',
            'symbol' =>  '₿',
        ],
        [
            'code' => 'ETH',
            'name' => 'Ethereum',
            'type' => 'crypto',
            'symbol' => 'Ξ',
        ],
    ];

    foreach ($assets as $asset) {
        Asset::updateOrCreate(
            ['code' => $asset['code']],
            $asset
        );
    }
    }
}
