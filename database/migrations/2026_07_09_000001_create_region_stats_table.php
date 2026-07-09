<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('region_stats', function (Blueprint $table) {
            $table->id();
            $table->string('label');                 // mis. "Ekonomi", "IPM", "Kemiskinan"
            $table->string('value');                 // mis. "5,85%", "75,50", "7,50%"
            $table->string('color')->default('#2563eb'); // warna angka (hex)
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Data awal sesuai tampilan lama (idempotent — hanya bila kosong).
        if (DB::table('region_stats')->count() === 0) {
            DB::table('region_stats')->insert([
                ['label' => 'Ekonomi',    'value' => '5,85%', 'color' => '#2563eb', 'sort_order' => 1, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
                ['label' => 'IPM',        'value' => '75,50', 'color' => '#059669', 'sort_order' => 2, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
                ['label' => 'Kemiskinan', 'value' => '7,50%', 'color' => '#f97316', 'sort_order' => 3, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('region_stats');
    }
};
