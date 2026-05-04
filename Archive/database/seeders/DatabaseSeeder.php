<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Setting::create([
            'app_name' => 'Aplikasi Hasil Kinerja',
            'school_name' => 'SMK Negeri 2 Konoha',
            'primary_color' => '#1e3c72',
            'secondary_color' => '#2a5298',
        ]);

        $roles = [
            'LABORAN',
            'KEPEGAWAIAN',
            'PERSURATAN',
            'KEUANGAN',
            'KESISWAAN',
            'DAPODIK',
            'PERPUSTAKAAN'
        ];

        foreach ($roles as $role) {
            $user = User::factory()->create([
                'name' => 'User ' . ucfirst(strtolower($role)),
                'email' => strtolower($role) . '@example.com',
                'password' => bcrypt('password'),
                'role' => $role,
            ]);

            // Buat 2 Laporan Dummy untuk setiap User
            \App\Models\WorkReport::create([
                'tanggal' => now()->format('Y-m-d'),
                'nama' => $user->name,
                'role' => $role,
                'category' => 'pelayanan',
                'uraian_tugas' => 'Melaksanakan tugas harian ' . $role . ' bagian pertama.',
                'keterangan' => 'Terlaksana',
            ]);

            \App\Models\WorkReport::create([
                'tanggal' => now()->subDay()->format('Y-m-d'),
                'nama' => $user->name,
                'role' => $role,
                'category' => 'administrasi',
                'uraian_tugas' => 'Melaksanakan tugas administrasi ' . $role . ' rutin.',
                'keterangan' => 'Terlaksana',
            ]);
        }
        
        // Admin user
        User::factory()->create([
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'ADMIN',
        ]);
    }
}
