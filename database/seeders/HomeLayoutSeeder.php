<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Menata ulang komposisi section halaman Home sesuai desain baru:
 *   1. Hero (heroes/carousel)
 *   2. Visi & Statistik (others/customs/descrip)
 *   3. Timeline Strategis RPJMD (others/timeline)  <-- section baru
 *   4. Kabar Pembangunan (loads/paginate_4_columns)
 *
 * Section "cuaca" (loads/weather) dilepas dari Home karena tidak ada di desain.
 * Idempotent — aman dijalankan berulang kali:
 *   php artisan db:seed --class=Database\\Seeders\\HomeLayoutSeeder
 */
class HomeLayoutSeeder extends Seeder
{
    public function run(): void
    {
        $home = DB::table('pages')->where('slug', 'home')->whereNull('deleted_at')->first();
        if (!$home) {
            $this->command?->warn('Halaman Home (slug=home) tidak ditemukan. Dilewati.');
            return;
        }

        // 1. Pastikan section Timeline terdaftar.
        $timeline = DB::table('sections')->where('layout_path', 'others/timeline')->first();
        if (!$timeline) {
            $timelineId = DB::table('sections')->insertGetId([
                'title'       => 'Timeline Strategis RPJMD',
                'layout_path' => 'others/timeline',
                'has_dataset' => 0,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        } else {
            $timelineId = $timeline->id;
        }

        // Ambil id section berdasarkan layout_path.
        $idOf = fn (string $path) => optional(DB::table('sections')->where('layout_path', $path)->first())->id;

        $order = array_filter([
            1 => $idOf('heroes/carousel'),
            2 => $idOf('others/customs/descrip'),
            3 => $timelineId,
            4 => $idOf('loads/paginate_4_columns'),
        ]);

        // 2. Susun ulang pivot Home (hapus semua lalu tanam sesuai urutan desain — cuaca otomatis terlepas).
        DB::table('page_sections')->where('page_id', $home->id)->delete();

        foreach ($order as $sort => $sectionId) {
            DB::table('page_sections')->insert([
                'page_id'    => $home->id,
                'section_id' => $sectionId,
                'sort_order' => $sort,
            ]);
        }

        $this->command?->info('Komposisi section Home berhasil ditata ulang sesuai desain baru.');
    }
}
