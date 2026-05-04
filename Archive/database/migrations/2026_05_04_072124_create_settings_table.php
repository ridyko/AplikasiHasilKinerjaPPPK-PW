<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('app_name')->default('Aplikasi Hasil Kinerja');
            $table->string('school_name')->default('SMK Negeri 2 Konoha');
            $table->string('logo')->nullable();
            $table->string('primary_color')->default('#1e3c72');
            $table->string('secondary_color')->default('#2a5298');
            $table->string('hero_title')->default('Transformasi Digital Pelaporan Kinerja.');
            $table->text('hero_description')->nullable();
            $table->string('hero_image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
