<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PriceHistory extends Model
{
    protected $fillable = [
        'asset_id',
        'price',
        'high_price',
        'low_price',
        'fetched_at',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:4',
            'high_price' => 'decimal:4',
            'low_price'  => 'decimal:4',
            'fetched_at' => 'datetime',
        ];
    }

    protected function asset()
    {
        return $this->belongsTo(Asset::class);
    }
}
