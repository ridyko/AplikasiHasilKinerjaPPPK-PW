<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan - {{ ucfirst($role) }}</title>
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
        .gradient-text {
            background: linear-gradient(135deg, {{ $setting->primary_color ?? '#1e3c72' }} 0%, {{ $setting->secondary_color ?? '#2a5298' }} 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
    <script>
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
</head>
<body class="bg-slate-50 dark:bg-slate-950 min-h-screen transition-colors duration-300 pb-20">

    <div class="container mx-auto px-4 pt-10">
        <!-- Header -->
        <div class="flex justify-between items-center mb-10">
            <h2 class="text-3xl font-extrabold tracking-tight dark:text-white">
                <span class="gradient-text">Cetak Laporan</span> 
                <span class="text-slate-400 font-light">({{ ucfirst($role) }})</span>
            </h2>
            <div class="flex items-center space-x-4">
                <button id="theme-toggle" class="bg-white dark:bg-slate-900 p-3 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800 text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition-all">
                    <i id="theme-toggle-dark-icon" class="hidden fas fa-moon"></i>
                    <i id="theme-toggle-light-icon" class="hidden fas fa-sun text-amber-400"></i>
                </button>
                <a href="{{ route('dashboard.jabatan', $role) }}" class="bg-slate-200 dark:bg-slate-800 text-slate-600 dark:text-slate-400 px-6 py-2.5 rounded-xl font-bold text-sm hover:opacity-80 transition-all">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
            </div>
        </div>

        <!-- Print Form Card -->
        <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] shadow-xl border border-slate-100 dark:border-slate-800 p-8 lg:p-12 max-w-4xl mx-auto transition-colors">
            <div class="flex items-center space-x-6 mb-10">
                <div class="w-16 h-16 bg-rose-50 dark:bg-rose-900/20 rounded-2xl flex items-center justify-center text-rose-600 dark:text-rose-400">
                    <i class="fas fa-file-pdf text-2xl"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-slate-800 dark:text-white">Konfigurasi PDF</h3>
                    <p class="text-slate-500 dark:text-slate-400">Pilih periode dan kategori untuk mengunduh laporan.</p>
                </div>
            </div>

            <form action="{{ route('reports.export', ['role' => $role, 'category' => 'placeholder']) }}" method="GET" id="printForm" class="space-y-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Category -->
                    <div class="space-y-3">
                        <label class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest ml-1">Pilih Kategori Laporan</label>
                        <select name="category_select" id="category_select" class="w-full px-5 py-4 bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-2xl text-slate-800 dark:text-white outline-none focus:ring-2 focus:ring-rose-500 transition-all cursor-pointer" required>
                            @foreach($categories as $key => $name)
                                <option value="{{ $key }}">{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Month/Year -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-3">
                            <label class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest ml-1">Bulan</label>
                            <select name="month" class="w-full px-5 py-4 bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-2xl text-slate-800 dark:text-white outline-none focus:ring-2 focus:ring-rose-500 transition-all cursor-pointer">
                                @for($i=1; $i<=12; $i++)
                                    <option value="{{ sprintf('%02d', $i) }}" {{ date('m') == $i ? 'selected' : '' }}>
                                        {{ date('F', mktime(0, 0, 0, $i, 10)) }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="space-y-3">
                            <label class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest ml-1">Tahun</label>
                            <select name="year" class="w-full px-5 py-4 bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-2xl text-slate-800 dark:text-white outline-none focus:ring-2 focus:ring-rose-500 transition-all cursor-pointer">
                                @for($i=date('Y'); $i>=2024; $i--)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>

                <div class="pt-6 space-y-4">
                    <button type="button" onclick="exportData('download')" class="w-full bg-rose-600 text-white py-5 rounded-[1.5rem] font-bold text-lg hover:bg-rose-700 shadow-xl shadow-rose-200 dark:shadow-none transform active:scale-[0.98] transition-all flex items-center justify-center">
                        <i class="fas fa-download mr-3"></i> UNDUH REKAPITULASI (PDF)
                    </button>
                    
                    <button type="button" onclick="exportData('preview')" class="w-full bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 py-4 rounded-[1.5rem] font-bold hover:bg-slate-200 dark:hover:bg-slate-700 transition-all flex items-center justify-center border border-slate-200 dark:border-slate-700">
                        <i class="fas fa-eye mr-3"></i> PREVIEW LAPORAN
                    </button>

                    <p class="text-center text-slate-400 text-[10px] mt-6 uppercase tracking-widest font-bold">
                        <i class="fas fa-info-circle mr-1"></i> Pastikan data untuk periode yang dipilih sudah diinput.
                    </p>
                </div>
            </form>
        </div>
    </div>

    <script>
        function exportData(type) {
            const category = document.getElementById('category_select').value;
            const month = document.getElementsByName('month')[0].value;
            const year = document.getElementsByName('year')[0].value;
            
            const baseUrl = "{{ route('reports.export', ['role' => $role, 'category' => 'TEMP_CAT']) }}";
            let finalUrl = baseUrl.replace('TEMP_CAT', category) + `?month=${month}&year=${year}`;
            
            if (type === 'preview') {
                finalUrl += '&stream=1';
                window.open(finalUrl, '_blank');
            } else {
                window.location.href = finalUrl;
            }
        }

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