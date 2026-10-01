<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    protected $fillabe = [
        'code',
        'name',
        'type',
        'symbol',
        'current_price',
        'high_price',
        'low_price',
        'variation_24h',
    ];

    protected function casts(): array
    {
        return [
            'current_price' => 'decimal:4',
            'high_price'    => 'decimal:4',
            'low_price'     => 'decimal:4',
            'variation_24h' => 'decimal:2',
        ];
    }

    public function priceHistories()
    {
        return $this->hasMany(PriceHistory::class);
    }

    public function alerts()
    {
        return $this->hasMany(PriceAlert::class);
    }
}
