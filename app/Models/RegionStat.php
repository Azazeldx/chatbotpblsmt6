<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegionStat extends Model
{
    protected $fillable = [
        'label',
        'value',
        'color',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active'  => 'boolean',
        'sort_order' => 'integer',
    ];

    /** Indikator makro aktif, terurut untuk ditampilkan di beranda. */
    public static function active()
    {
        return static::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();
    }
}
