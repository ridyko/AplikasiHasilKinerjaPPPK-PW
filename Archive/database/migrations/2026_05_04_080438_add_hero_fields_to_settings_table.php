<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('hero_title')->default('Transformasi Digital Pelaporan Kinerja.')->after('secondary_color');
            $table->text('hero_description')->nullable()->after('hero_title');
            $table->string('hero_image')->nullable()->after('hero_description');
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['hero_title', 'hero_description', 'hero_image']);
        });
    }
};
