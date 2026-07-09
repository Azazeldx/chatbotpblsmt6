<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class KnowledgeBase extends Model
{
    protected $fillable = [
        'title',
        'file_path',
        'content',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function booted(): void
    {
        // Bersihkan cache retrieval saat data knowledge base berubah.
        static::saved(fn () => Cache::forget('kb_pdf_active_content'));
        static::deleted(fn () => Cache::forget('kb_pdf_active_content'));
    }

    /**
     * Gabungan teks seluruh knowledge base PDF yang aktif (di-cache).
     */
    public static function activeContent(): string
    {
        return Cache::rememberForever('kb_pdf_active_content', function () {
            return static::query()
                ->where('is_active', true)
                ->whereNotNull('content')
                ->orderBy('id')
                ->pluck('content')
                ->implode("\n\n");
        });
    }
}
