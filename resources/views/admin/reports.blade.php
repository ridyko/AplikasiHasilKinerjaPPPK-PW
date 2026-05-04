<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Semua Laporan - Admin</title>
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
            <a href="{{ route('admin.settings') }}" class="block p-3 rounded-lg hover:bg-slate-700 transition-all"><i class="fas fa-palette mr-3"></i> White Label</a>
            <a href="{{ route('admin.reports.all') }}" class="block p-3 rounded-lg bg-blue-600 text-white shadow-lg"><i class="fas fa-file-lines mr-3"></i> Semua Laporan</a>
        </nav>
        <div class="p-4 border-t border-slate-700 text-slate-500 text-[10px] uppercase font-bold tracking-widest text-center">
            System v1.0
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col">
        <header class="bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 p-4 flex justify-between items-center px-8 transition-colors relative z-[100]">
            <h2 class="text-xl font-semibold text-slate-800 dark:text-white">Semua Laporan Kinerja</h2>
            
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

        <main class="p-8">
            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-400 rounded-xl">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 overflow-hidden transition-colors">
                <table class="w-full text-left">
                    <thead class="bg-slate-50 dark:bg-slate-800/50 text-slate-400 dark:text-slate-500 text-xs uppercase tracking-wider">
                        <tr>
                            <th class="px-6 py-4">Tanggal</th>
                            <th class="px-6 py-4">Nama Pegawai</th>
                            <th class="px-6 py-4">Jabatan</th>
                            <th class="px-6 py-4">Kategori</th>
                            <th class="px-6 py-4">Bukti</th>
                            <th class="px-6 py-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @forelse($reports as $report)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-all">
                            <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">{{ $report->tanggal }}</td>
                            <td class="px-6 py-4 font-bold text-slate-800 dark:text-white">{{ $report->nama }}</td>
                            <td class="px-6 py-4">
                                <span class="bg-slate-100 dark:bg-slate-800 px-2 py-1 rounded text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest">{{ $report->role }}</span>
                            </td>
                            <td class="px-6 py-4 text-slate-600 dark:text-slate-400 text-sm">{{ $report->category }}</td>
                            <td class="px-6 py-4">
                                @if($report->image)
                                    <a href="{{ asset('storage/reports/' . $report->image) }}" target="_blank" class="text-blue-500 dark:text-blue-400 hover:underline text-xs"><i class="fas fa-image mr-1"></i> Lihat Foto</a>
                                @else
                                    <span class="text-slate-300 dark:text-slate-700 text-xs italic">No Image</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <form action="{{ route('admin.reports.delete', $report->id) }}" method="POST" onsubmit="return confirm('Hapus laporan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-600 transition-all">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-slate-400 dark:text-slate-600 italic">Belum ada laporan yang masuk.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
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
