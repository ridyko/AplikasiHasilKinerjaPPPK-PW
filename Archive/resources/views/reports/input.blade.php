<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Kinerja - {{ ucfirst($role) }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
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
        <!-- Header & Nav -->
        <div class="flex justify-between items-center mb-10">
            <h2 class="text-3xl font-extrabold tracking-tight dark:text-white">
                <span class="gradient-text">Input Kinerja</span> 
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

        <!-- Main Form Card -->
        <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] shadow-xl border border-slate-100 dark:border-slate-800 p-8 lg:p-12 mb-12 transition-colors">
            <form action="{{ route('reports.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="role" value="{{ $role }}">

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Date -->
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest ml-1">Tanggal</label>
                        <input type="date" name="tanggal" class="w-full px-5 py-4 bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-2xl text-slate-800 dark:text-white outline-none focus:ring-2 focus:ring-blue-500 transition-all" required>
                    </div>

                    <!-- Category -->
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest ml-1">Kategori</label>
                        <select name="category" class="w-full px-5 py-4 bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-2xl text-slate-800 dark:text-white outline-none focus:ring-2 focus:ring-blue-500 transition-all cursor-pointer" required>
                            @foreach($categories as $key => $name)
                                <option value="{{ $key }}">{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Task Description -->
                    <div class="space-y-2 lg:col-span-1">
                        <label class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest ml-1">Uraian Tugas</label>
                        <input type="text" name="uraian_tugas" class="w-full px-5 py-4 bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-2xl text-slate-800 dark:text-white placeholder-slate-400 outline-none focus:ring-2 focus:ring-blue-500 transition-all" placeholder="Apa yang Anda kerjakan?" required>
                    </div>

                    <!-- Image Upload & Submit -->
                    <div class="flex items-end space-x-4">
                        <div class="flex-1 space-y-2">
                            <label class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest ml-1">Gambar (Opsional)</label>
                            <input type="file" name="image" class="w-full text-xs text-slate-500 file:mr-4 file:py-3 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-blue-50 dark:file:bg-blue-900/30 file:text-blue-700 dark:file:text-blue-400 hover:file:bg-blue-100 transition-all" accept="image/*">
                        </div>
                        <button type="submit" class="bg-blue-600 text-white px-8 py-4 rounded-2xl font-bold hover:bg-blue-700 shadow-lg shadow-blue-200 dark:shadow-none transform active:scale-95 transition-all">
                            SIMPAN
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- History Section -->
        <div class="space-y-6">
            <h3 class="text-xl font-bold text-slate-800 dark:text-white flex items-center">
                <i class="fas fa-history mr-3 text-blue-500"></i> History 5 Input Terakhir
            </h3>
            
            <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] shadow-xl border border-slate-100 dark:border-slate-800 overflow-hidden transition-colors">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-slate-50 dark:bg-slate-800/50 text-slate-400 dark:text-slate-500 text-[10px] uppercase font-black tracking-widest">
                            <tr>
                                <th class="px-8 py-6">Tanggal</th>
                                <th class="px-8 py-6">Kategori</th>
                                <th class="px-8 py-6">Uraian Tugas</th>
                                <th class="px-8 py-6">Gambar</th>
                                <th class="px-8 py-6 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            @forelse($recentData as $data)
                            <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-all">
                                <td class="px-8 py-6">
                                    <span class="text-sm font-bold text-slate-700 dark:text-slate-300">{{ date('d M Y', strtotime($data->tanggal)) }}</span>
                                </td>
                                <td class="px-8 py-6">
                                    <span class="text-xs bg-slate-100 dark:bg-slate-800 px-3 py-1.5 rounded-lg text-slate-500 dark:text-slate-400 font-medium">
                                        {{ $categories[$data->category] ?? $data->category }}
                                    </span>
                                </td>
                                <td class="px-8 py-6">
                                    <p class="text-sm text-slate-600 dark:text-slate-400 line-clamp-2 max-w-xs">{{ $data->uraian_tugas }}</p>
                                </td>
                                <td class="px-8 py-6">
                                    @if($data->image)
                                        <a href="{{ asset('storage/reports/' . $data->image) }}" target="_blank" class="group relative inline-block">
                                            <img src="{{ asset('storage/reports/' . $data->image) }}" class="w-12 h-12 object-cover rounded-xl border-2 border-white dark:border-slate-800 shadow-sm group-hover:scale-110 transition-transform">
                                        </a>
                                    @else
                                        <span class="text-[10px] text-slate-300 dark:text-slate-700 italic">No image</span>
                                    @endif
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex items-center justify-center space-x-3">
                                        <a href="{{ route('reports.edit', $data->id) }}" class="p-2 text-amber-500 hover:bg-amber-50 dark:hover:bg-amber-900/20 rounded-lg transition-all" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('reports.destroy', $data->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-2 text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-900/20 rounded-lg transition-all" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-8 py-12 text-center text-slate-400 dark:text-slate-600 italic">Belum ada data untuk jabatan ini.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if(session('success'))
            Swal.fire({ 
                icon: 'success', 
                title: 'Berhasil!', 
                text: "{{ session('success') }}", 
                showConfirmButton: false, 
                timer: 2000, 
                timerProgressBar: true,
                background: document.documentElement.classList.contains('dark') ? '#0f172a' : '#fff',
                color: document.documentElement.classList.contains('dark') ? '#fff' : '#000'
            });
        @endif

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