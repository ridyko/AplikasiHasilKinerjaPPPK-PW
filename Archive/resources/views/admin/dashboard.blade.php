<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin Dashboard</title>
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
            <a href="{{ route('admin.dashboard') }}" class="block p-3 rounded-lg bg-blue-600 text-white shadow-lg"><i class="fas fa-home mr-3"></i> Dashboard</a>
            <a href="{{ route('admin.users') }}" class="block p-3 rounded-lg hover:bg-slate-700 transition-all"><i class="fas fa-users mr-3"></i> Manajemen User</a>
            <a href="{{ route('admin.settings') }}" class="block p-3 rounded-lg hover:bg-slate-700 transition-all"><i class="fas fa-palette mr-3"></i> White Label</a>
            <a href="{{ route('admin.reports.all') }}" class="block p-3 rounded-lg hover:bg-slate-700 transition-all"><i class="fas fa-file-lines mr-3"></i> Semua Laporan</a>
        </nav>
        <div class="p-4 border-t border-slate-700 text-slate-500 text-[10px] uppercase font-bold tracking-widest text-center">
            System v1.0
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col">
        <!-- Top Header -->
        <header class="bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 p-4 flex justify-between items-center px-8 transition-colors relative z-[100]">
            <h2 class="text-xl font-semibold text-slate-800 dark:text-white">Super Admin Overview</h2>
            
            <div class="flex items-center space-x-6">
                <!-- Dark Mode Toggle -->
                <button id="theme-toggle" class="text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 focus:outline-none focus:ring-4 focus:ring-slate-200 dark:focus:ring-slate-700 rounded-lg text-sm p-2.5 transition-all">
                    <i id="theme-toggle-dark-icon" class="hidden fas fa-moon text-xl"></i>
                    <i id="theme-toggle-light-icon" class="hidden fas fa-sun text-xl text-amber-400"></i>
                </button>

                <!-- Profile Dropdown -->
                <div class="relative">
                    <button id="profileDropdownBtn" class="flex items-center space-x-3 hover:bg-slate-50 dark:hover:bg-slate-800 p-1 pr-3 rounded-xl transition-all group">
                        <div class="w-10 h-10 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 dark:text-blue-400 font-bold border-2 border-blue-50 dark:border-blue-800 group-hover:scale-105 transition-transform">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div class="text-left hidden sm:block">
                            <p class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-tighter leading-none mb-1">Login Sebagai</p>
                            <p class="text-xs font-bold text-slate-800 dark:text-white leading-none">{{ Auth::user()->role }}</p>
                        </div>
                        <i class="fas fa-chevron-down text-[10px] text-slate-400 opacity-50"></i>
                    </button>
                    
                    <!-- Dropdown Menu -->
                    <div id="profileDropdownMenu" class="dropdown-menu absolute right-0 mt-2 w-48 bg-white dark:bg-slate-900 rounded-2xl shadow-2xl border border-slate-100 dark:border-slate-800 py-2 transition-all">
                        <div class="px-4 py-2 border-b border-slate-50 dark:border-slate-800 mb-2">
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Jabatan</p>
                            <p class="text-sm font-bold text-blue-600 dark:text-blue-400">{{ Auth::user()->role }}</p>
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

        <!-- Content Body -->
        <main class="p-8 space-y-8">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 transition-colors">
                    <div class="flex items-center">
                        <div class="p-3 bg-blue-50 dark:bg-blue-900/20 rounded-xl text-blue-600 dark:text-blue-400 mr-4">
                            <i class="fas fa-users text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-slate-500 dark:text-slate-400 text-sm">Total Pegawai</p>
                            <p class="text-2xl font-bold text-slate-800 dark:text-white">{{ $totalUsers }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 transition-colors">
                    <div class="flex items-center">
                        <div class="p-3 bg-emerald-50 dark:bg-emerald-900/20 rounded-xl text-emerald-600 dark:text-emerald-400 mr-4">
                            <i class="fas fa-file-signature text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-slate-500 dark:text-slate-400 text-sm">Total Laporan</p>
                            <p class="text-2xl font-bold text-slate-800 dark:text-white">{{ $totalReports }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 transition-colors">
                    <div class="flex items-center">
                        <div class="p-3 bg-amber-50 dark:bg-amber-900/20 rounded-xl text-amber-600 dark:text-amber-400 mr-4">
                            <i class="fas fa-building text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-slate-500 dark:text-slate-400 text-sm">Total Divisi</p>
                            <p class="text-2xl font-bold text-slate-800 dark:text-white">7</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detailed Tables -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Reports per Role -->
                <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 overflow-hidden transition-colors">
                    <div class="p-6 border-b border-slate-100 dark:border-slate-800 flex justify-between items-center">
                        <h3 class="font-bold text-slate-800 dark:text-white">Aktivitas per Jabatan</h3>
                        <span class="text-xs font-semibold bg-slate-100 dark:bg-slate-800 px-2 py-1 rounded text-slate-500 dark:text-slate-400 uppercase">Live Data</span>
                    </div>
                    <div class="p-6">
                        <table class="w-full">
                            <thead class="text-left text-slate-400 dark:text-slate-500 text-xs uppercase tracking-wider">
                                <tr>
                                    <th class="pb-4">Jabatan</th>
                                    <th class="pb-4 text-right">Laporan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                                @foreach($reportsPerRole as $stat)
                                <tr>
                                    <td class="py-4 font-medium text-slate-700 dark:text-slate-300">{{ strtoupper($stat->role) }}</td>
                                    <td class="py-4 text-right">
                                        <span class="bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 px-3 py-1 rounded-full text-sm font-bold">
                                            {{ $stat->total }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- User Management Quick View -->
                <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 overflow-hidden transition-colors">
                    <div class="p-6 border-b border-slate-100 dark:border-slate-800">
                        <h3 class="font-bold text-slate-800 dark:text-white">Daftar Akun Pegawai</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            @foreach($users as $user)
                            <div class="flex items-center justify-between p-3 hover:bg-slate-50 dark:hover:bg-slate-800/50 rounded-xl transition-all">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-lg bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-500 dark:text-slate-400 mr-4">
                                        <i class="fas fa-user text-sm"></i>
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-800 dark:text-white text-sm">{{ $user->name }}</p>
                                        <p class="text-slate-400 text-xs">{{ $user->email }}</p>
                                    </div>
                                </div>
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold {{ $user->role == 'ADMIN' ? 'bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400' : 'bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400' }}">
                                    {{ $user->role }}
                                </span>
                            </div>
                            @endforeach
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
