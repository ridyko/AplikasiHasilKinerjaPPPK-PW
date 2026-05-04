<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kinerja - {{ ucfirst($role) }}</title>
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
    </style>
    <script>
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
</head>
<body class="bg-slate-50 dark:bg-slate-950 min-h-screen transition-colors duration-300 py-12">

    <div class="container mx-auto px-4">
        <div class="max-w-2xl mx-auto">
            
            <div class="bg-white dark:bg-slate-900 rounded-[3rem] shadow-2xl border border-slate-100 dark:border-slate-800 p-10 lg:p-14 transition-colors">
                <div class="text-center mb-10">
                    <h2 class="text-3xl font-black text-slate-800 dark:text-white mb-2">✏️ Edit Data Kinerja</h2>
                    <p class="text-slate-400 text-sm">Sesuaikan data laporan Anda di bawah ini.</p>
                </div>

                <form action="{{ route('reports.update', $report->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="role" value="{{ $role }}">

                    <!-- Date -->
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest ml-1">Tanggal</label>
                        <input type="date" name="tanggal" value="{{ $report->tanggal }}" class="w-full px-6 py-4 bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-2xl text-slate-800 dark:text-white outline-none focus:ring-2 focus:ring-blue-500 transition-all" required>
                    </div>

                    <!-- Category -->
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest ml-1">Kategori Laporan</label>
                        <select name="category" class="w-full px-6 py-4 bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-2xl text-slate-800 dark:text-white outline-none focus:ring-2 focus:ring-blue-500 transition-all cursor-pointer" required>
                            @foreach($categories as $key => $name)
                                <option value="{{ $key }}" {{ $report->category == $key ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Task -->
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest ml-1">Uraian Tugas</label>
                        <textarea name="uraian_tugas" rows="3" class="w-full px-6 py-4 bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-2xl text-slate-800 dark:text-white outline-none focus:ring-2 focus:ring-blue-500 transition-all" required>{{ $report->uraian_tugas }}</textarea>
                    </div>

                    <!-- Image Upload -->
                    <div class="space-y-3">
                        <label class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest ml-1">Bukti Foto / Gambar</label>
                        
                        @if($report->image)
                            <div class="mb-3 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-2xl border border-blue-100 dark:border-blue-800 flex items-center space-x-4">
                                <img src="{{ asset('storage/reports/' . $report->image) }}" class="w-20 h-20 object-cover rounded-xl border border-white dark:border-slate-700 shadow-sm">
                                <div class="flex-1">
                                    <p class="text-xs font-bold text-blue-600 dark:text-blue-400 uppercase">Gambar Saat Ini</p>
                                    <p class="text-[10px] text-slate-500 truncate max-w-[200px]">{{ $report->image }}</p>
                                </div>
                            </div>
                        @endif

                        <div class="relative">
                            <input type="file" name="image" class="w-full text-xs text-slate-500 file:mr-4 file:py-3 file:px-6 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-blue-600 file:text-white hover:file:bg-blue-700 transition-all" accept="image/*">
                            <p class="text-[10px] text-slate-400 mt-2 italic"><i class="fas fa-info-circle mr-1"></i> Biarkan kosong jika tidak ingin mengubah gambar.</p>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex flex-col sm:flex-row gap-4 pt-6">
                        <button type="submit" class="flex-1 bg-blue-600 text-white py-4 rounded-2xl font-bold hover:bg-blue-700 shadow-xl shadow-blue-200 dark:shadow-none transition-all active:scale-95">
                            UPDATE DATA
                        </button>
                        <a href="{{ route('reports.input', $role) }}" class="flex-1 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 py-4 rounded-2xl font-bold hover:bg-slate-200 dark:hover:bg-slate-700 transition-all text-center">
                            BATAL
                        </a>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <script>
        // Set dark mode icon on load
        const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
        const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');
        // (Icon logic removed as there is no toggle on this specific small modal page, 
        // but it follows the html.dark class)
    </script>
</body>
</html>