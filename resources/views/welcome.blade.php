<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PinRuang — Sistem Peminjaman Ruangan</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-navy-950 text-white font-sans antialiased overflow-x-hidden">

    <!-- Navbar -->
    <nav class="fixed top-0 inset-x-0 z-50 bg-navy-950/70 backdrop-blur-xl border-b border-white/5">
        <div class="max-w-6xl mx-auto px-6 h-16 flex items-center justify-between">
            <a href="/" class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-navy-500 to-navy-700 flex items-center justify-center shadow-lg shadow-navy-500/20 border border-gold-400/30">
                    <svg class="w-4 h-4 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
                <span class="text-lg font-extrabold tracking-tight">PinRuang</span>
            </a>
            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ in_array(auth()->user()->role?->slug, ['admin', 'admin-fakultas']) ? route('admin.home') : route('home') }}"
                       class="px-5 py-2 text-sm font-bold text-navy-900 bg-gold-500 rounded-xl hover:bg-gold-400 transition-all shadow-lg shadow-gold-500/20">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-medium text-slate-300 hover:text-white transition-colors">Login</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="px-5 py-2 text-sm font-bold text-navy-900 bg-gold-500 rounded-xl hover:bg-gold-400 transition-all shadow-lg shadow-gold-500/20">
                            Register
                        </a>
                    @endif
                @endauth
            </div>
        </div>
    </nav>

    <!-- Hero -->
    <section class="relative min-h-screen flex items-center justify-center pt-16">
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-1/4 left-1/2 -translate-x-1/2 w-[800px] h-[500px] bg-gradient-to-r from-navy-500/20 via-navy-600/15 to-navy-700/20 rounded-full blur-[120px]"></div>
            <div class="absolute bottom-0 left-0 w-[400px] h-[300px] bg-gold-500/10 rounded-full blur-[100px]"></div>
            <div class="absolute top-20 right-0 w-[300px] h-[300px] bg-navy-400/10 rounded-full blur-[100px]"></div>
            <!-- Floating Particles -->
            <div class="absolute top-[15%] left-[10%] w-2 h-2 bg-gold-400/30 rounded-full animate-float-slow"></div>
            <div class="absolute top-[40%] right-[15%] w-1.5 h-1.5 bg-navy-400/40 rounded-full animate-float-medium"></div>
            <div class="absolute bottom-[30%] left-[20%] w-1 h-1 bg-gold-500/20 rounded-full animate-float-fast"></div>
            <div class="absolute top-[60%] right-[25%] w-2.5 h-2.5 bg-navy-300/20 rounded-full animate-float-slow" style="animation-delay: 2s;"></div>
            <div class="absolute top-[25%] right-[35%] w-1.5 h-1.5 bg-gold-400/25 rounded-full animate-float-medium" style="animation-delay: 1s;"></div>
        </div>
        <div class="absolute inset-0 opacity-[0.03]" style="background-image: url('data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%2260%22 height=%2260%22%3E%3Cpath d=%22M0 0h60v60H0z%22 fill=%22none%22 stroke=%22white%22 stroke-width=%220.5%22/%3E%3C/svg%3E');"></div>

        <div class="relative z-10 max-w-4xl mx-auto px-6 text-center">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/5 border border-gold-500/20 text-sm text-gold-400 font-medium mb-8 backdrop-blur-sm">
                <span class="w-2 h-2 rounded-full bg-gold-400 animate-pulse"></span>
                Sistem Peminjaman Ruangan UPR
            </div>
            <h1 class="text-5xl sm:text-6xl lg:text-7xl font-black tracking-tight leading-[1.1] mb-6">
                Pinjam Ruangan
                <span class="bg-gradient-to-r from-gold-400 via-gold-500 to-gold-600 bg-clip-text text-transparent">Lebih Mudah</span>
                & Cepat
            </h1>
            <p class="text-lg sm:text-xl text-slate-400 max-w-2xl mx-auto mb-10 leading-relaxed">
                Platform digital untuk peminjaman ruangan kampus UPR. Ajukan, lacak, dan kelola peminjaman ruangan dalam satu tempat yang terintegrasi.
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                @auth
                    <a href="{{ in_array(auth()->user()->role?->slug, ['admin', 'admin-fakultas']) ? route('admin.home') : route('home') }}"
                       class="group px-8 py-3.5 text-sm font-bold text-navy-900 bg-gold-500 rounded-2xl hover:bg-gold-400 transition-all shadow-xl shadow-gold-500/25 transform hover:-translate-y-0.5 flex items-center gap-2">
                        Masuk Dashboard
                        <svg class="w-4 h-4 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                @else
                    <a href="{{ route('register') }}"
                       class="group px-8 py-3.5 text-sm font-bold text-navy-900 bg-gold-500 rounded-2xl hover:bg-gold-400 transition-all shadow-xl shadow-gold-500/25 transform hover:-translate-y-0.5 flex items-center gap-2">
                        Mulai Sekarang
                        <svg class="w-4 h-4 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                    <a href="{{ route('login') }}"
                       class="px-8 py-3.5 text-sm font-semibold text-slate-300 bg-white/5 border border-white/10 rounded-2xl hover:bg-white/10 hover:text-white transition-all backdrop-blur-sm">
                        Login
                    </a>
                @endauth
            </div>
        </div>
    </section>

    <!-- Features -->
    <section class="relative py-24">
        <div class="max-w-6xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight mb-4">Fitur Utama</h2>
                <p class="text-slate-400 max-w-xl mx-auto">Semua yang kamu butuhkan untuk mengelola peminjaman ruangan kampus</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach([
                    ['icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z', 'title' => 'Booking Online', 'desc' => 'Ajukan peminjaman ruangan kapan saja dan di mana saja melalui platform digital.', 'color' => 'gold'],
                    ['icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'title' => 'Approval Cepat', 'desc' => 'Sistem persetujuan terintegrasi oleh admin dengan deteksi konflik otomatis.', 'color' => 'success'],
                    ['icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5', 'title' => 'Kelola Ruangan', 'desc' => 'Data ruangan lengkap dengan kapasitas, fasilitas, dan jadwal ketersediaan.', 'color' => 'navy'],
                ] as $feature)
                    <div class="group relative rounded-2xl bg-white/[0.03] border border-white/[0.06] p-8 hover:bg-white/[0.06] hover:border-white/10 transition-all duration-300 hover:shadow-lg hover:shadow-white/5 hover:-translate-y-1">
                        <div class="w-12 h-12 rounded-2xl bg-{{ $feature['color'] }}-500/10 border border-{{ $feature['color'] }}-500/20 flex items-center justify-center text-{{ $feature['color'] }}-400 mb-5">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $feature['icon'] }}"></path></svg>
                        </div>
                        <h3 class="text-lg font-bold mb-2">{{ $feature['title'] }}</h3>
                        <p class="text-sm text-slate-400 leading-relaxed">{{ $feature['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="border-t border-white/5 py-8">
        <div class="max-w-6xl mx-auto px-6 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-2 text-sm text-slate-500">
                <div class="w-5 h-5 rounded bg-gradient-to-br from-navy-500 to-navy-700 flex items-center justify-center border border-gold-500/30">
                    <svg class="w-2.5 h-2.5 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"></path></svg>
                </div>
                PinRuang © {{ date('Y') }}
            </div>
            <p class="text-xs text-slate-600">Universitas Palangka Raya</p>
        </div>
    </footer>

    <style>
        @keyframes float-slow { 0%,100% { transform: translateY(0) translateX(0); } 25% { transform: translateY(-20px) translateX(10px); } 50% { transform: translateY(-10px) translateX(-5px); } 75% { transform: translateY(-25px) translateX(5px); } }
        @keyframes float-medium { 0%,100% { transform: translateY(0) translateX(0); } 33% { transform: translateY(-15px) translateX(-8px); } 66% { transform: translateY(-8px) translateX(12px); } }
        @keyframes float-fast { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-12px); } }
        .animate-float-slow { animation: float-slow 8s ease-in-out infinite; }
        .animate-float-medium { animation: float-medium 6s ease-in-out infinite; }
        .animate-float-fast { animation: float-fast 4s ease-in-out infinite; }
    </style>
</body>
</html>
