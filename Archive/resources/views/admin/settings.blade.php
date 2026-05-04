<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Branding Settings - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .sidebar { background: #1e293b; color: white; }
        .dropdown-menu { display: none; }
        .dropdown-menu.show { display: block; }
    </style>
    <script>
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
</head>
<body class="flex min-h-screen bg-slate-50 dark:bg-slate-950 transition-colors duration-300">
    <!-- Sidebar -->
    <div class="w-64 sidebar hidden md:flex flex-col">
        <div class="p-6 text-2xl font-bold border-b border-slate-700">
            <i class="fas fa-shield-halved mr-2 text-blue-400"></i> ADMIN
        </div>
        <nav class="flex-1 p-4 space-y-2">
            <a href="{{ route('admin.dashboard') }}" class="block p-3 rounded-lg hover:bg-slate-700 transition-all"><i class="fas fa-home mr-3"></i> Dashboard</a>
            <a href="{{ route('admin.users') }}" class="block p-3 rounded-lg hover:bg-slate-700 transition-all"><i class="fas fa-users mr-3"></i> Manajemen User</a>
            <a href="{{ route('admin.settings') }}" class="block p-3 rounded-lg bg-blue-600 text-white shadow-lg"><i class="fas fa-palette mr-3"></i> White Label</a>
            <a href="{{ route('admin.reports.all') }}" class="block p-3 rounded-lg hover:bg-slate-700 transition-all"><i class="fas fa-file-lines mr-3"></i> Semua Laporan</a>
        </nav>
        <div class="p-4 border-t border-slate-700 text-slate-500 text-[10px] uppercase font-bold tracking-widest text-center">
            System v1.0
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col">
        <header class="bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 p-4 flex justify-between items-center px-8 transition-colors relative z-[100]">
            <h2 class="text-xl font-semibold text-slate-800 dark:text-white">White-Label Branding</h2>
            
            <div class="flex items-center space-x-6">
                <!-- Dark Mode Toggle -->
                <button id="theme-toggle" class="text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 focus:outline-none focus:ring-4 focus:ring-slate-200 dark:focus:ring-slate-700 rounded-lg text-sm p-2.5 transition-all">
                    <i id="theme-toggle-dark-icon" class="hidden fas fa-moon text-xl"></i>
                    <i id="theme-toggle-light-icon" class="hidden fas fa-sun text-xl text-amber-400"></i>
                </button>

                <!-- Profile Dropdown -->
                <div class="relative">
                    <button id="profileDropdownBtn" class="flex items-center space-x-3 hover:bg-slate-50 dark:hover:bg-slate-800 p-2 rounded-xl transition-all">
                        <div class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 dark:text-blue-400 font-bold border-2 border-blue-50 dark:border-blue-800">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    </button>
                    
                    <!-- Dropdown Menu -->
                    <div id="profileDropdownMenu" class="dropdown-menu absolute right-0 mt-2 w-48 bg-white dark:bg-slate-900 rounded-2xl shadow-2xl border border-slate-100 dark:border-slate-800 py-2 transition-all">
                        <div class="px-4 py-2 border-b border-slate-50 dark:border-slate-800 mb-2 text-center">
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">{{ Auth::user()->name }}</p>
                        </div>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-3 text-sm text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-900/20 flex items-center transition-all">
                                <i class="fas fa-sign-out-alt mr-3"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <main class="p-8 max-w-4xl">
            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-400 rounded-xl">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 p-8 space-y-8 transition-colors">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-4">
                        <h3 class="text-lg font-bold text-slate-800 dark:text-white flex items-center">
                            <i class="fas fa-font mr-2 text-blue-500"></i> Identitas Aplikasi
                        </h3>
                        <div>
                            <label class="block text-sm font-semibold text-slate-600 dark:text-slate-400 mb-2">Nama Aplikasi</label>
                            <input type="text" name="app_name" value="{{ $setting->app_name }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-800 text-slate-800 dark:text-white outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-600 dark:text-slate-400 mb-2">Nama Instansi / Sekolah</label>
                            <input type="text" name="school_name" value="{{ $setting->school_name }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-800 text-slate-800 dark:text-white outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    <div class="space-y-4">
                        <h3 class="text-lg font-bold text-slate-800 dark:text-white flex items-center">
                            <i class="fas fa-image mr-2 text-blue-500"></i> Logo & Ikon
                        </h3>
                        <div class="flex items-center space-x-4">
                            <div class="w-24 h-24 rounded-2xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center overflow-hidden border border-slate-200 dark:border-slate-800 transition-colors">
                                @if($setting->logo)
                                    <img src="{{ file_exists(public_path('storage/' . $setting->logo)) ? asset('storage/' . $setting->logo) : asset($setting->logo) }}" class="w-full h-full object-contain">
                                @else
                                    <i class="fas fa-image text-slate-300 dark:text-slate-600 text-2xl"></i>
                                @endif
                            </div>
                            <div class="flex-1">
                                <label class="block text-sm font-semibold text-slate-600 dark:text-slate-400 mb-2">Ganti Logo</label>
                                <input type="file" name="logo" class="text-sm text-slate-500 dark:text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 dark:file:bg-blue-900/30 file:text-blue-700 dark:file:text-blue-400 hover:file:bg-blue-100 dark:hover:file:bg-blue-900/50">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-8 border-t border-slate-100 dark:border-slate-800 space-y-4 transition-colors">
                    <h3 class="text-lg font-bold text-slate-800 dark:text-white flex items-center">
                        <i class="fas fa-palette mr-2 text-blue-500"></i> Tema Warna
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label class="block text-sm font-semibold text-slate-600 dark:text-slate-400 mb-2">Warna Utama (Gradient Start)</label>
                            <div class="flex items-center space-x-3">
                                <input type="color" name="primary_color" value="{{ $setting->primary_color }}" class="w-12 h-12 rounded-lg cursor-pointer bg-transparent border-none">
                                <input type="text" value="{{ $setting->primary_color }}" class="flex-1 px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-800 text-slate-500 dark:text-slate-400 text-sm" readonly>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-600 dark:text-slate-400 mb-2">Warna Sekunder (Gradient End)</label>
                            <div class="flex items-center space-x-3">
                                <input type="color" name="secondary_color" value="{{ $setting->secondary_color }}" class="w-12 h-12 rounded-lg cursor-pointer bg-transparent border-none">
                                <input type="text" value="{{ $setting->secondary_color }}" class="flex-1 px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-800 text-slate-500 dark:text-slate-400 text-sm" readonly>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-8 border-t border-slate-100 dark:border-slate-800 space-y-4 transition-colors">
                    <h3 class="text-lg font-bold text-slate-800 dark:text-white flex items-center">
                        <i class="fas fa-desktop mr-2 text-blue-500"></i> Konfigurasi Landing Page (Hero Section)
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-semibold text-slate-600 dark:text-slate-400 mb-2">Teks Badge (Headline Kecil)</label>
                                <input type="text" name="hero_badge" value="{{ $setting->hero_badge }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-800 text-slate-800 dark:text-white outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-600 dark:text-slate-400 mb-2">Judul Hero (Headline Besar)</label>
                                <input type="text" name="hero_title" value="{{ $setting->hero_title }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-800 text-slate-800 dark:text-white outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-600 dark:text-slate-400 mb-2">Deskripsi Hero</label>
                                <textarea name="hero_description" rows="3" class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-800 text-slate-800 dark:text-white outline-none focus:ring-2 focus:ring-blue-500">{{ $setting->hero_description }}</textarea>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-600 dark:text-slate-400 mb-2">Gambar Hero (Laptop Preview)</label>
                            <div class="flex flex-col space-y-4">
                                <div class="w-full h-40 rounded-2xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center overflow-hidden border border-slate-200 dark:border-slate-800">
                                    @if($setting->hero_image)
                                        <img src="{{ asset('storage/hero/' . $setting->hero_image) }}" class="w-full h-full object-cover">
                                    @else
                                        <i class="fas fa-laptop text-slate-300 dark:text-slate-600 text-3xl"></i>
                                    @endif
                                </div>
                                <input type="file" name="hero_image" class="text-sm text-slate-500 dark:text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 dark:file:bg-blue-900/30 file:text-blue-700 dark:file:text-blue-400 hover:file:bg-blue-100">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-8 flex justify-end">
                    <button type="submit" class="px-8 py-4 bg-blue-600 text-white font-bold rounded-2xl hover:bg-blue-700 transform hover:scale-105 active:scale-95 transition-all shadow-xl shadow-blue-200 dark:shadow-none">
                        SIMPAN PERUBAHAN BRANDING
                    </button>
                </div>
            </form>
        </main>
    </div>

    <script>
        // Dropdown Logic
        const profileDropdownBtn = document.getElementById('profileDropdownBtn');
        const profileDropdownMenu = document.getElementById('profileDropdownMenu');

        profileDropdownBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            profileDropdownMenu.classList.toggle('show');
        });

        document.addEventListener('click', function() {
            profileDropdownMenu.classList.remove('show');
        });

        // Theme Toggle
        var themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
        var themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            themeToggleLightIcon.classList.remove('hidden');
        } else {
            themeToggleDarkIcon.classList.remove('hidden');
        }

        var themeToggleBtn = document.getElementById('theme-toggle');

        themeToggleBtn.addEventListener('click', function() {
            themeToggleDarkIcon.classList.toggle('hidden');
            themeToggleLightIcon.classList.toggle('hidden');

            if (localStorage.getItem('color-theme')) {
                if (localStorage.getItem('color-theme') === 'light') {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('color-theme', 'dark');
                } else {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('color-theme', 'light');
                }
            } else {
                if (document.documentElement.classList.contains('dark')) {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('color-theme', 'light');
                } else {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('color-theme', 'dark');
                }
            }
        });
    </script>
</body>
</html>
