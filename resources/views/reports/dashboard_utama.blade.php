<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $setting->app_name ?? 'Aplikasi Hasil Kinerja' }}</title>
    
    <link rel="icon" type="image/jpg" href="{{ $setting->logo ? asset('storage/' . $setting->logo) : 'https://upload.wikimedia.org/wikipedia/commons/b/b9/Coat_of_arms_of_Jakarta.svg' }}">
    
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body { 
            font-family: 'Outfit', sans-serif; 
            background-color: #0f172a;
        }
        .hero-gradient {
            background: radial-gradient(circle at top right, {{ $setting->secondary_color ?? '#3b82f6' }}44, transparent),
                        radial-gradient(circle at bottom left, {{ $setting->primary_color ?? '#1e3c72' }}44, transparent);
        }
        .glass-nav {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }
    </style>
</head>
<body class="text-white overflow-x-hidden">

    <!-- Navigation -->
    <nav class="fixed top-0 w-full z-50 glass-nav px-6 py-4 flex justify-between items-center">
        <div class="flex items-center space-x-3">
            <img src="{{ $setting->logo ? (file_exists(public_path('storage/' . $setting->logo)) ? asset('storage/' . $setting->logo) : asset($setting->logo)) : 'https://upload.wikimedia.org/wikipedia/commons/b/b9/Coat_of_arms_of_Jakarta.svg' }}" alt="Logo" class="w-10">
            <span class="font-extrabold text-xl tracking-tight">{{ $setting->app_name ?? 'KinerjaApp' }}</span>
        </div>
        <a href="{{ route('login') }}" class="px-6 py-2 bg-white text-slate-900 rounded-full font-bold hover:bg-opacity-90 transition-all text-sm">
            LOGIN ADMIN
        </a>
    </nav>

    <!-- Hero Section -->
    <section class="relative min-h-screen flex items-center justify-center pt-20 hero-gradient">
        <div class="container mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            
            <!-- Left Content -->
            <div class="space-y-8 text-center lg:text-left z-10">
                <div class="inline-block px-4 py-1 rounded-full bg-blue-500/10 border border-blue-500/20 text-blue-400 text-xs font-bold tracking-widest uppercase">
                    {{ $setting->hero_badge ?? 'Platform Rekapitulasi Kinerja Modern' }}
                </div>
                <h1 class="text-5xl lg:text-7xl font-extrabold leading-tight">
                    @php
                        $title = $setting->hero_title ?? 'Transformasi Digital Pelaporan Kinerja.';
                        $parts = explode(' ', $title);
                        $last = array_pop($parts);
                        $first = implode(' ', $parts);
                    @endphp
                    {{ $first }} <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-emerald-400">{{ $last }}</span>
                </h1>
                <p class="text-slate-400 text-lg lg:text-xl max-w-xl mx-auto lg:mx-0 leading-relaxed">
                    @if($setting->hero_description)
                        {{ $setting->hero_description }}
                    @else
                        {{ $setting->school_name ?? 'Institusi Anda' }} kini hadir dengan solusi pelaporan kerja yang lebih cerdas, cepat, dan transparan. Pantau produktivitas setiap divisi dalam satu genggaman.
                    @endif
                </p>
                <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4 justify-center lg:justify-start">
                    <a href="{{ route('login') }}" class="px-10 py-5 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl font-bold text-lg hover:shadow-2xl hover:shadow-blue-500/30 transform hover:-translate-y-1 transition-all">
                        MULAI LAPOR SEKARANG <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
                <div class="flex items-center justify-center lg:justify-start space-x-6 text-slate-500 pt-4">
                    <div class="flex items-center"><i class="fas fa-check-circle text-emerald-500 mr-2"></i> Aman</div>
                    <div class="flex items-center"><i class="fas fa-check-circle text-emerald-500 mr-2"></i> Cepat</div>
                    <div class="flex items-center"><i class="fas fa-check-circle text-emerald-500 mr-2"></i> Akurat</div>
                </div>
            </div>

            <!-- Right Visual -->
            <div class="relative hidden lg:block">
                <div class="absolute -top-20 -left-20 w-64 h-64 bg-blue-500/20 rounded-full blur-3xl animate-pulse"></div>
                <div class="absolute -bottom-20 -right-20 w-64 h-64 bg-emerald-500/20 rounded-full blur-3xl animate-pulse"></div>
                
                <div class="relative glass-card bg-white/5 border border-white/10 rounded-[2rem] p-4 shadow-2xl animate-float">
                    @if($setting->hero_image)
                        <img src="{{ asset('storage/hero/' . $setting->hero_image) }}" alt="Dashboard Preview" class="rounded-[1.5rem] w-full h-auto shadow-2xl">
                    @else
                        <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&q=80&w=1000" alt="Dashboard Preview" class="rounded-[1.5rem] opacity-80 mix-blend-lighten">
                    @endif
                    
                    <!-- Floating Cards -->
                    <div class="absolute -right-10 top-1/4 bg-white p-4 rounded-2xl shadow-2xl animate-float" style="animation-delay: 1s">
                        <div class="flex items-center space-x-3 text-slate-900">
                            <div class="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center text-emerald-600">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold opacity-50 uppercase">Statistik</p>
                                <p class="text-sm font-extrabold">+24% Efisiensi</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-12 border-t border-white/5 text-center text-slate-500 text-sm">
        &copy; 2026 {{ $setting->school_name ?? 'KinerjaApp' }}. All rights reserved.
    </footer>

</body>
</html>