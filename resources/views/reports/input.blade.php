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

                    <!-- Image Upload & Submit (Responsive Fix) -->
                    <div class="flex flex-col sm:flex-row items-end gap-4">
                        <div class="w-full space-y-2">
                            <label class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest ml-1">Bukti Foto (Kamera/Galeri)</label>
                            <div class="flex flex-col space-y-2">
                                <input type="file" name="image" id="image-input" capture="environment" class="w-full text-xs text-slate-500 file:mr-4 file:py-3 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-blue-50 dark:file:bg-blue-900/30 file:text-blue-700 dark:file:text-blue-400 hover:file:bg-blue-100 transition-all" accept="image/*">
                                <button type="button" onclick="openCamera()" class="text-[10px] font-bold text-blue-600 dark:text-blue-400 flex items-center hover:underline">
                                    <i class="fas fa-camera mr-1"></i> Ambil Foto dari Kamera
                                </button>
                                <input type="hidden" name="captured_image" id="captured_image">
                                <div id="camera-preview-container" class="hidden relative mt-2">
                                    <img id="camera-preview-img" class="w-20 h-20 object-cover rounded-xl border-2 border-blue-500 shadow-sm">
                                    <button type="button" onclick="resetCamera()" class="absolute -top-2 -right-2 bg-rose-500 text-white w-5 h-5 rounded-full text-[10px] flex items-center justify-center shadow-lg"><i class="fas fa-times"></i></button>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="w-full sm:w-auto bg-blue-600 text-white px-8 py-4 rounded-2xl font-bold hover:bg-blue-700 shadow-lg shadow-blue-200 dark:shadow-none transform active:scale-95 transition-all">
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

    <!-- Camera Modal -->
    <div id="camera-modal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-slate-900/80 backdrop-blur-sm">
        <div class="bg-white dark:bg-slate-900 w-full max-w-lg rounded-[2.5rem] shadow-2xl overflow-hidden border border-slate-100 dark:border-slate-800">
            <div class="p-6 border-b border-slate-100 dark:border-slate-800 flex justify-between items-center">
                <h3 class="font-bold dark:text-white">Ambil Foto</h3>
                <button onclick="closeCamera()" class="text-slate-400 hover:text-slate-600"><i class="fas fa-times"></i></button>
            </div>
            <div class="p-6">
                <div class="relative bg-black rounded-2xl overflow-hidden aspect-video">
                    <video id="webcam" autoplay playsinline class="w-full h-full object-cover"></video>
                    <canvas id="canvas" class="hidden"></canvas>
                </div>
                <div class="mt-6 flex space-x-3">
                    <button type="button" onclick="takeSnapshot()" class="flex-1 bg-blue-600 text-white py-4 rounded-2xl font-bold hover:bg-blue-700 transition-all shadow-lg shadow-blue-200 dark:shadow-none">
                        <i class="fas fa-circle mr-2"></i> JEPRET
                    </button>
                    <button type="button" onclick="closeCamera()" class="px-6 py-4 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 rounded-2xl font-bold hover:bg-slate-200 transition-all">
                        BATAL
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let stream = null;

        async function openCamera() {
            const modal = document.getElementById('camera-modal');
            const video = document.getElementById('webcam');
            
            modal.classList.remove('hidden');
            
            try {
                stream = await navigator.mediaDevices.getUserMedia({ 
                    video: { facingMode: 'environment' }, 
                    audio: false 
                });
                video.srcObject = stream;
            } catch (err) {
                console.error("Error accessing camera: ", err);
                Swal.fire({
                    icon: 'error',
                    title: 'Kamera Tidak Terdeteksi',
                    text: 'Pastikan Anda memberikan izin akses kamera di browser Anda.'
                });
                closeCamera();
            }
        }

        function closeCamera() {
            const modal = document.getElementById('camera-modal');
            const video = document.getElementById('webcam');
            
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
            }
            
            video.srcObject = null;
            modal.classList.add('hidden');
        }

        function takeSnapshot() {
            const video = document.getElementById('webcam');
            const canvas = document.getElementById('canvas');
            const context = canvas.getContext('2d');
            const preview = document.getElementById('camera-preview-img');
            const previewContainer = document.getElementById('camera-preview-container');
            const hiddenInput = document.getElementById('captured_image');
            const fileInput = document.getElementById('image-input');

            // Set canvas size to match video
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;

            // Draw image to canvas
            context.drawImage(video, 0, 0, canvas.width, canvas.height);

            // Get data URL
            const dataUrl = canvas.toDataURL('image/jpeg');
            
            // Set values
            hiddenInput.value = dataUrl;
            preview.src = dataUrl;
            previewContainer.classList.remove('hidden');
            
            // Clear file input if used
            fileInput.value = "";

            closeCamera();
        }

        function resetCamera() {
            document.getElementById('captured_image').value = "";
            document.getElementById('camera-preview-container').classList.add('hidden');
        }

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