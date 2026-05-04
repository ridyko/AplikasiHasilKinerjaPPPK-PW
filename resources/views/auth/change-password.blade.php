<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ganti Password - SMK Negeri 2 Konoha</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .sidebar { background: #1e293b; color: white; }
        .dropdown-menu { display: none; }
        .dropdown-menu.show { display: block; }
    </style>
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
            <a href="{{ route('admin.reports.all') }}" class="block p-3 rounded-lg hover:bg-slate-700 transition-all"><i class="fas fa-file-lines mr-3"></i> Semua Laporan</a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col">
        <!-- Top Header -->
        <header class="bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 p-4 flex justify-between items-center px-8 relative z-[100]">
            <h2 class="text-xl font-semibold text-slate-800 dark:text-white">Pengaturan Akun</h2>
            
            <div class="flex items-center space-x-6">
                <!-- Profile Dropdown -->
                <div class="relative">
                    <button id="profileDropdownBtn" class="flex items-center space-x-3 hover:bg-slate-50 dark:hover:bg-slate-800 p-1 pr-3 rounded-xl transition-all group">
                        <div class="w-10 h-10 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 dark:text-blue-400 font-bold">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <i class="fas fa-chevron-down text-[10px] text-slate-400"></i>
                    </button>
                    
                    <!-- Dropdown Menu -->
                    <div id="profileDropdownMenu" class="dropdown-menu absolute right-0 mt-2 w-48 bg-white dark:bg-slate-900 rounded-2xl shadow-2xl border border-slate-100 dark:border-slate-800 py-2 transition-all">
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

        <!-- Content Body (FORM GANTI PASSWORD) -->
        <main class="p-8 flex justify-center">
            <div class="w-full max-w-md bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 p-8">
                <h3 class="text-2xl font-bold mb-6 text-slate-800 dark:text-white text-center">Ganti Password</h3>

                @if(session('success'))
                    <div class="bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 text-emerald-600 dark:text-emerald-400 px-4 py-3 rounded-xl mb-6 text-sm font-bold">
                        <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('password.update') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label class="block text-slate-500 dark:text-slate-400 text-xs font-bold uppercase mb-2">Password Saat Ini</label>
                        <input type="password" name="current_password" class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-xl px-4 py-3 text-slate-800 dark:text-white focus:ring-2 focus:ring-blue-500 @error('current_password') ring-2 ring-rose-500 @enderror">
                        @error('current_password') <p class="text-rose-500 text-[10px] mt-1 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-slate-500 dark:text-slate-400 text-xs font-bold uppercase mb-2">Password Baru</label>
                        <input type="password" name="new_password" class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-xl px-4 py-3 text-slate-800 dark:text-white focus:ring-2 focus:ring-blue-500 @error('new_password') ring-2 ring-rose-500 @enderror">
                        @error('new_password') <p class="text-rose-500 text-[10px] mt-1 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-slate-500 dark:text-slate-400 text-xs font-bold uppercase mb-2">Konfirmasi Password Baru</label>
                        <input type="password" name="new_password_confirmation" class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-xl px-4 py-3 text-slate-800 dark:text-white focus:ring-2 focus:ring-blue-500">
                    </div>

                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-xl shadow-lg shadow-blue-500/30 transition-all transform hover:scale-[1.02]">
                        Update Password
                    </button>
                </form>
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
    </script>
</body>
</html>
