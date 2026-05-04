<?php

use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Super Admin Routes
Route::middleware(['auth'])->group(function () {
    // Change Password
    Route::get('/change-password', [AdminController::class, 'showChangePassword'])->name('password.change');
    Route::post('/change-password', [AdminController::class, 'updatePassword'])->name('password.update');

    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    
    // User Management
    Route::get('/admin/users', [AdminController::class, 'manageUsers'])->name('admin.users');
    Route::post('/admin/users', [AdminController::class, 'createUser'])->name('admin.users.store');
    Route::post('/admin/users/reset/{id}', [AdminController::class, 'resetPassword'])->name('admin.users.reset');
    Route::delete('/admin/users/{id}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
    
    // Reports Management
    Route::get('/admin/reports', [AdminController::class, 'allReports'])->name('admin.reports.all');
    Route::delete('/admin/reports/{id}', [AdminController::class, 'deleteReport'])->name('admin.reports.delete');

    Route::get('/admin/settings', [AdminController::class, 'settings'])->name('admin.settings');
    Route::put('/admin/settings', [AdminController::class, 'updateSettings'])->name('admin.settings.update');

    // Dashboard & Reports
    Route::get('/dashboard/{role}', [ReportController::class, 'dashboardJabatan'])->name('dashboard.jabatan');
    Route::get('/input/{role}', [ReportController::class, 'inputPage'])->name('reports.input');
    Route::get('/cetak/{role}', [ReportController::class, 'cetakPage'])->name('reports.cetak');
    Route::post('/store', [ReportController::class, 'store'])->name('reports.store');
    Route::get('/export-pdf/{role}/{category}', [ReportController::class, 'exportPdf'])->name('reports.export');
    Route::get('/report/{id}/edit', [ReportController::class, 'edit'])->name('reports.edit');
    Route::put('/report/{id}', [ReportController::class, 'update'])->name('reports.update');
    Route::delete('/report/{id}', [ReportController::class, 'destroy'])->name('reports.destroy');
});

Route::get('/', [ReportController::class, 'dashboardUtama'])->name('dashboard.utama');

Route::get('/install', function () {
    return view('install.index');
})->name('install.index');

Route::post('/install/setup', function (Illuminate\Http\Request $request) {
    // 1. Update file .env secara dinamis
    $envPath = base_path('.env');
    $envContent = file_get_contents($envPath);
    
    $envContent = preg_replace('/DB_DATABASE=.*/', 'DB_DATABASE=' . $request->db_name, $envContent);
    $envContent = preg_replace('/DB_USERNAME=.*/', 'DB_USERNAME=' . $request->db_user, $envContent);
    $envContent = preg_replace('/DB_PASSWORD=.*/', 'DB_PASSWORD=' . $request->db_pass, $envContent);

    file_put_contents($envPath, $envContent);

    // 3. Jalankan Migrasi & Link Storage
    try {
        Artisan::call('migrate:fresh', ['--force' => true]);
        Artisan::call('storage:link');
        Artisan::call('optimize:clear');
    } catch (\Exception $e) {
        // Abaikan jika symlink sudah ada
    }

    return redirect('/')->with('success', 'Instalasi & Aktivasi Berhasil!');
})->name('install.setup');