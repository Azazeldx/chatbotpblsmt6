<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Leader extends Model
{
    protected $fillable = [
        'name',
        'position',
        'term',
        'photo',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active'  => 'boolean',
        'sort_order' => 'integer',
    ];

    protected static function booted(): void
    {
        // Hapus file foto lama saat record dihapus.
        static::deleting(function (Leader $leader) {
            if ($leader->photo && Storage::disk('public')->exists($leader->photo)) {
                Storage::disk('public')->delete($leader->photo);
            }
        });
    }

    /** Pemimpin aktif, terurut untuk ditampilkan di beranda. */
    public static function active()
    {
        return static::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();
    }

    /** URL foto, atau avatar berdasarkan nama bila belum ada foto. */
    public function getPhotoUrlAttribute(): string
    {
        if ($this->photo && Storage::disk('public')->exists($this->photo)) {
            return Storage::url($this->photo);
        }

        return 'https://ui-avatars.com/api/?background=2563eb&color=fff&size=256&name=' . urlencode($this->name);
    }
}
