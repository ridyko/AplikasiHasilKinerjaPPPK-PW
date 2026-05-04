<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - {{ $setting->app_name ?? 'Aplikasi' }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #020617;
            overflow: hidden;
        }
        
        .mesh-gradient {
            position: absolute;
            width: 100%;
            height: 100%;
            background-image: 
                radial-gradient(at 0% 0%, hsla(220,100%,15%,1) 0, transparent 50%), 
                radial-gradient(at 50% 0%, hsla(230,100%,20%,1) 0, transparent 50%), 
                radial-gradient(at 100% 0%, hsla(240,100%,15%,1) 0, transparent 50%), 
                radial-gradient(at 0% 50%, {{ $setting->primary_color ?? '#1e3a8a' }}55 0, transparent 50%), 
                radial-gradient(at 100% 50%, {{ $setting->secondary_color ?? '#3b82f6' }}55 0, transparent 50%), 
                radial-gradient(at 0% 100%, hsla(220,100%,10%,1) 0, transparent 50%), 
                radial-gradient(at 50% 100%, hsla(230,100%,15%,1) 0, transparent 50%), 
                radial-gradient(at 100% 100%, hsla(240,100%,10%,1) 0, transparent 50%);
            filter: blur(100px);
            z-index: -1;
            animation: meshMove 20s ease infinite alternate;
        }

        @keyframes meshMove {
            0% { transform: scale(1); }
            100% { transform: scale(1.2); }
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(25px) saturate(180%);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .input-glass {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }

        .input-glass:focus {
            background: rgba(255, 255, 255, 0.08);
            border-color: {{ $setting->secondary_color ?? '#3b82f6' }};
            box-shadow: 0 0 20px {{ $setting->secondary_color ?? '#3b82f6' }}33;
        }

        .btn-glow:hover {
            box-shadow: 0 0 30px {{ $setting->secondary_color ?? '#3b82f6' }}66;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">
    <div class="mesh-gradient"></div>

    <div class="w-full max-w-lg glass-card rounded-[2.5rem] p-10 lg:p-14 relative overflow-hidden">
        <!-- Decoration Orb -->
        <div class="absolute -top-10 -right-10 w-32 h-32 bg-blue-500/20 rounded-full blur-2xl"></div>
        
        <div class="text-center mb-12 relative text-white">
            <div class="inline-block p-4 bg-white/5 rounded-2xl mb-6 border border-white/10 shadow-inner">
                <img src="{{ $setting->logo ? (file_exists(public_path('storage/' . $setting->logo)) ? asset('storage/' . $setting->logo) : asset($setting->logo)) : 'https://upload.wikimedia.org/wikipedia/commons/b/b9/Coat_of_arms_of_Jakarta.svg' }}" alt="Logo" class="w-16 h-16 object-contain">
            </div>
            <h1 class="text-4xl font-extrabold tracking-tight mb-3">
                {{ $setting->app_name ?? 'Portal Kinerja' }}
            </h1>
            <p class="text-slate-400 font-medium">Selamat datang kembali, silakan login.</p>
        </div>

        <form action="{{ route('login.post') }}" method="POST" class="space-y-6">
            @csrf
            <div class="space-y-2 text-white">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-widest ml-1">Email Pegawai</label>
                <div class="relative group">
                    <span class="absolute inset-y-0 left-0 pl-5 flex items-center text-slate-500 group-focus-within:text-blue-400 transition-colors">
                        <i class="fas fa-envelope"></i>
                    </span>
                    <input type="email" name="email" class="w-full pl-14 pr-6 py-5 input-glass rounded-2xl text-white placeholder-slate-600 outline-none" placeholder="Masukkan email anda" required>
                </div>
                @error('email')
                    <p class="text-rose-400 text-xs mt-2 italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2 text-white">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-widest ml-1">Kata Sandi</label>
                <div class="relative group">
                    <span class="absolute inset-y-0 left-0 pl-5 flex items-center text-slate-500 group-focus-within:text-blue-400 transition-colors">
                        <i class="fas fa-lock"></i>
                    </span>
                    <input type="password" name="password" class="w-full pl-14 pr-6 py-5 input-glass rounded-2xl text-white placeholder-slate-600 outline-none" placeholder="••••••••" required>
                </div>
            </div>

            <button type="submit" class="w-full py-5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold rounded-2xl hover:from-blue-500 hover:to-indigo-500 transform hover:-translate-y-1 active:scale-95 transition-all shadow-xl btn-glow mt-4 uppercase tracking-widest">
                MASUK KE SISTEM <i class="fas fa-sign-in-alt ml-2"></i>
            </button>
        </form>

        <div class="mt-12 pt-8 border-t border-white/5 text-center">
            <a href="{{ route('dashboard.utama') }}" class="text-slate-500 hover:text-white text-sm font-semibold transition-all">
                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Beranda
            </a>
        </div>
    </div>
</body>
</html>
