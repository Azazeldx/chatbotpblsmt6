<?php

use App\Models\ChatbotSession;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

/**
 * Bersihkan session chatbot milik TAMU (user_id null) yang tidak aktif > 7 hari.
 * Pesan ikut terhapus otomatis (foreign key cascadeOnDelete).
 * Session milik user login TIDAK disentuh.
 */
Artisan::command('chatbot:prune-guests {--days=7}', function () {
    $days = (int) $this->option('days');

    $count = ChatbotSession::whereNull('user_id')
        ->where('updated_at', '<', now()->subDays($days))
        ->count();

    ChatbotSession::whereNull('user_id')
        ->where('updated_at', '<', now()->subDays($days))
        ->delete();

    $this->info("Menghapus {$count} session tamu yang tidak aktif > {$days} hari.");
})->purpose('Hapus session chatbot tamu yang tidak aktif');

// Jalankan otomatis setiap hari dini hari.
Schedule::command('chatbot:prune-guests')->dailyAt('03:00');
