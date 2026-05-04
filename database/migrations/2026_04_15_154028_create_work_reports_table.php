<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('work_reports', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('nama');
            $table->string('role'); // Jabatan (Laboran, Keuangan, dll)
            $table->string('category');
            $table->text('uraian_tugas');
            $table->string('keterangan')->default('Terlaksana');
            $table->string('image')->nullable(); // Tambahkan ini agar bisa kosong
            $table->timestamps();
        }); // <--- PASTIKAN ADA TITIK KOMA DAN KURUNG PENUTUP DI SINI
    }

    public function down(): void
    {
        Schema::dropIfExists('work_reports');
    }
};