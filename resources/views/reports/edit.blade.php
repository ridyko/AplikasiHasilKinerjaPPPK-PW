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

                        <div class="relative space-y-3">
                            <input type="file" name="image" id="image-input" capture="environment" class="w-full text-xs text-slate-500 file:mr-4 file:py-3 file:px-6 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-blue-600 file:text-white hover:file:bg-blue-700 transition-all" accept="image/*">
                            
                            <button type="button" onclick="openCamera()" class="text-[10px] font-bold text-blue-600 dark:text-blue-400 flex items-center hover:underline">
                                <i class="fas fa-camera mr-1"></i> Ambil Foto Baru dari Kamera
                            </button>
                            
                            <input type="hidden" name="captured_image" id="captured_image">
                            
                            <div id="camera-preview-container" class="hidden relative mt-2 inline-block">
                                <p class="text-[10px] font-bold text-blue-600 uppercase mb-1">Foto Baru (Kamera)</p>
                                <img id="camera-preview-img" class="w-24 h-24 object-cover rounded-xl border-2 border-blue-500 shadow-md">
                                <button type="button" onclick="resetCamera()" class="absolute -top-2 -right-2 bg-rose-500 text-white w-6 h-6 rounded-full text-xs flex items-center justify-center shadow-lg border-2 border-white dark:border-slate-900"><i class="fas fa-times"></i></button>
                            </div>

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
    </script>
</body>
</html>