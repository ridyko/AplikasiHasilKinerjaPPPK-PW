<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard {{ ucfirst($role) }} - {{ $setting->app_name ?? 'Kinerja' }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Outfit', sans-serif; }
        .gradient-bg {
            background: linear-gradient(135deg, {{ $setting->primary_color ?? '#1e3c72' }} 0%, {{ $setting->secondary_color ?? '#2a5298' }} 100%);
        }
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
<body class="bg-slate-50 dark:bg-slate-950 transition-colors duration-300">

    <div class="min-h-screen flex flex-col relative">
        <!-- Floating Header Actions -->
        <div class="fixed top-6 right-8 z-[100] flex items-center space-x-4">
            <!-- Theme Toggle -->
            <button id="theme-toggle" class="bg-white/10 backdrop-blur-md border border-white/20 p-3 rounded-2xl text-white hover:bg-white/20 transition-all shadow-xl">
                <i id="theme-toggle-dark-icon" class="hidden fas fa-moon"></i>
                <i id="theme-toggle-light-icon" class="hidden fas fa-sun text-amber-400"></i>
            </button>

            <!-- Profile Dropdown -->
            <div class="relative">
                <button id="profileDropdownBtn" class="bg-white/10 backdrop-blur-md border border-white/20 p-1 pr-4 rounded-2xl text-white hover:bg-white/20 transition-all shadow-xl flex items-center space-x-3 group">
                    <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center font-bold group-hover:bg-white/30 transition-all">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div class="text-left hidden sm:block">
                        <p class="text-[10px] font-black uppercase tracking-tighter opacity-60 leading-none mb-1">Login Sebagai</p>
                        <p class="text-xs font-bold leading-none">{{ Auth::user()->role }}</p>
                    </div>
                    <i class="fas fa-chevron-down text-[10px] opacity-50"></i>
                </button>
                
                <!-- Dropdown Menu -->
                <div id="profileDropdownMenu" class="dropdown-menu absolute right-0 mt-3 w-48 bg-white dark:bg-slate-900 rounded-2xl shadow-2xl border border-slate-100 dark:border-slate-800 py-2 transition-all">
                    <div class="px-4 py-3 border-b border-slate-50 dark:border-slate-800 mb-2">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">User Aktif</p>
                        <p class="text-sm font-bold text-slate-800 dark:text-white truncate">{{ Auth::user()->name }}</p>
                    </div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-3 text-sm text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-900/20 flex items-center transition-all font-bold">
                            <i class="fas fa-sign-out-alt mr-3"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Header Section -->
        <header class="gradient-bg text-white px-8 py-20 rounded-b-[4rem] shadow-2xl relative overflow-hidden transition-all">
            <div class="absolute top-0 right-0 w-96 h-96 bg-white/10 rounded-full -mr-32 -mt-32 blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-black/10 rounded-full -ml-20 -mb-20 blur-2xl"></div>
            
            <div class="container mx-auto relative z-10">
                <div class="text-center md:text-left">
                    <p class="text-blue-100 text-sm font-bold uppercase tracking-widest mb-3 opacity-80">Selamat Datang</p>
                    <h1 class="text-7xl font-black mb-4 tracking-tight leading-none">{{ Auth::user()->name }}</h1>
                    <div class="flex items-center justify-center md:justify-start space-x-3">
                        <span class="text-blue-100/90 font-bold text-xl">Jabatan:</span>
                        <span class="bg-white/20 backdrop-blur-sm px-5 py-1.5 rounded-2xl border border-white/30 uppercase tracking-widest text-sm font-black">{{ $role }}</span>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="container mx-auto px-6 mt-12 pb-24 relative z-20">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                
                <!-- Action Card 1 -->
                <a href="{{ route('reports.input', $role) }}" class="group bg-white dark:bg-slate-900 p-12 rounded-[3rem] shadow-2xl hover:shadow-blue-500/10 transition-all border border-slate-100 dark:border-slate-800 transform hover:-translate-y-3">
                    <div class="w-20 h-20 bg-blue-50 dark:bg-blue-900/20 rounded-[2rem] flex items-center justify-center text-blue-600 dark:text-blue-400 mb-10 group-hover:bg-blue-600 group-hover:text-white transition-all duration-500 shadow-inner">
                        <i class="fas fa-edit text-3xl"></i>
                    </div>
                    <h3 class="text-3xl font-black text-slate-800 dark:text-white mb-4 tracking-tight">Input Laporan</h3>
                    <p class="text-slate-500 dark:text-slate-400 leading-relaxed mb-10 text-lg">Catat hasil kinerja harian Anda dengan mudah melalui formulir digital.</p>
                    <div class="flex items-center text-blue-600 dark:text-blue-400 font-black text-sm uppercase tracking-widest group-hover:translate-x-3 transition-transform">
                        Buka Formulir <i class="fas fa-arrow-right ml-3"></i>
                    </div>
                </a>

                <!-- Action Card 2 -->
                <a href="{{ route('reports.cetak', $role) }}" class="group bg-white dark:bg-slate-900 p-12 rounded-[3rem] shadow-2xl hover:shadow-rose-500/10 transition-all border border-slate-100 dark:border-slate-800 transform hover:-translate-y-3">
                    <div class="w-20 h-20 bg-rose-50 dark:bg-rose-900/20 rounded-[2rem] flex items-center justify-center text-rose-600 dark:text-rose-400 mb-10 group-hover:bg-rose-600 group-hover:text-white transition-all duration-500 shadow-inner">
                        <i class="fas fa-file-pdf text-3xl"></i>
                    </div>
                    <h3 class="text-3xl font-black text-slate-800 dark:text-white mb-4 tracking-tight">Cetak Laporan</h3>
                    <p class="text-slate-500 dark:text-slate-400 leading-relaxed mb-10 text-lg">Unduh rekapitulasi kinerja bulanan Anda dalam format PDF resmi.</p>
                    <div class="flex items-center text-rose-600 dark:text-rose-400 font-black text-sm uppercase tracking-widest group-hover:translate-x-3 transition-transform">
                        Unduh PDF <i class="fas fa-arrow-right ml-3"></i>
                    </div>
                </a>

                <!-- Info Card -->
                <div class="bg-slate-900 dark:bg-black p-12 rounded-[3rem] shadow-2xl text-white relative overflow-hidden border border-white/5">
                    <div class="absolute top-0 right-0 w-48 h-48 bg-blue-500/10 rounded-full -mr-16 -mt-16 blur-2xl"></div>
                    <div class="relative z-10">
                        <h3 class="text-3xl font-black mb-6 tracking-tight">Tips Kinerja</h3>
                        <p class="text-slate-400 leading-relaxed mb-10 text-lg">Pastikan setiap laporan disertai bukti foto yang jelas untuk mempermudah verifikasi.</p>
                        <div class="p-8 bg-white/5 rounded-[2rem] border border-white/10 backdrop-blur-md">
                            <p class="text-[10px] text-slate-500 uppercase font-black tracking-widest mb-3">Status Sistem</p>
                            <p class="text-emerald-400 font-black flex items-center text-2xl">
                                <span class="relative flex h-4 w-4 mr-4">
                                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                  <span class="relative inline-flex rounded-full h-4 w-4 bg-emerald-500 shadow-lg shadow-emerald-500/50"></span>
                                </span>
                                Terhubung
                            </p>
                        </div>
                    </div>
                </div>

            </div>
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