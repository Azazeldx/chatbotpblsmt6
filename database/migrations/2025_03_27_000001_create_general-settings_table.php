<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('general_settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_name')->nullable();
            $table->text('site_description')->nullable();
            $table->string('site_logo')->nullable();
            $table->string('site_favicon')->nullable();
            $table->string('site_url')->nullable();
            $table->string('site_dashboard_url')->nullable();
            $table->json('location')->nullable();
            $table->json('contacts')->nullable();
            $table->json('theme')->nullable();
            $table->json('email_settings')->nullable();
            $table->json('social_network')->nullable();
            $table->json('navigation')->nullable();
            $table->json('features')->nullable();
            $table->json('user_features')->nullable();
            $table->json('ai')->nullable();
            $table->json('google_analytics')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('general_settings');
    }

};
