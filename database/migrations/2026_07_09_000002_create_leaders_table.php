<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leaders', function (Blueprint $table) {
            $table->id();
            $table->string('name');                  // nama pejabat
            $table->string('position');              // mis. "Bupati", "Wakil Bupati", "Sekretaris Daerah"
            $table->string('term')->nullable();      // masa bakti, mis. "2025 - 2030"
            $table->string('photo')->nullable();     // path foto di disk public
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Data awal (placeholder — silakan edit dari panel admin). Idempotent.
        if (DB::table('leaders')->count() === 0) {
            DB::table('leaders')->insert([
                ['name' => 'Nama Bupati',           'position' => 'Bupati',             'term' => '2025 - 2030', 'photo' => null, 'sort_order' => 1, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
                ['name' => 'Nama Wakil Bupati',     'position' => 'Wakil Bupati',       'term' => '2025 - 2030', 'photo' => null, 'sort_order' => 2, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
                ['name' => 'Nama Sekretaris Daerah','position' => 'Sekretaris Daerah',  'term' => '2025 - 2030', 'photo' => null, 'sort_order' => 3, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('leaders');
    }
};
