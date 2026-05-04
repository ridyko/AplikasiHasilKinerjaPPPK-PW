<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lisensi Tidak Valid - SMK Negeri 2 Konoha</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-950 flex items-center justify-center min-h-screen text-white font-sans overflow-hidden">
    <!-- Background Decoration -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0 opacity-20 pointer-events-none">
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-blue-600 rounded-full blur-[120px]"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-rose-600 rounded-full blur-[120px]"></div>
    </div>

    <div class="relative z-10 text-center p-12 border border-slate-800 rounded-[3rem] bg-slate-900/50 backdrop-blur-xl shadow-2xl max-w-lg mx-4">
        <div class="w-24 h-24 bg-rose-500/10 rounded-full flex items-center justify-center mx-auto mb-8 border border-rose-500/20">
            <i class="fas fa-lock text-4xl text-rose-500"></i>
        </div>
        
        <h1 class="text-3xl font-black mb-4 text-white tracking-tight">Akses Terkunci</h1>
        <p class="text-slate-400 mb-10 leading-relaxed">Maaf, aplikasi ini tidak memiliki lisensi resmi untuk berjalan di domain ini. Silakan hubungi pengembang untuk mendapatkan kunci aktivasi.</p>
        
        <div class="space-y-4">
            <div class="p-4 bg-slate-950/50 rounded-2xl border border-slate-800 text-left">
                <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Informasi Domain</p>
                <p class="text-sm font-mono text-blue-400 break-all">{{ request()->getHost() }}</p>
            </div>
            
            <div class="p-4 bg-slate-950/50 rounded-2xl border border-slate-800 text-left">
                <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Status Keamanan</p>
                <p class="text-sm font-bold text-rose-500 italic">UNAUTHORIZED_USE_DETECTED</p>
            </div>
        </div>

        <div class="mt-12 pt-8 border-t border-slate-800/50">
            <p class="text-[10px] text-slate-600 font-bold uppercase tracking-widest">Aplikasi Rekapitulasi Kinerja &copy; 2024</p>
        </div>
    </div>
</body>
</html>
