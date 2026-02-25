@extends('layouts.auth')

@section('content')
    <div class="w-full max-w-md mx-auto px-4">
        <div class="text-center mb-8">
            <div class="w-14 h-14 mx-auto rounded-2xl bg-gradient-to-br from-navy-500 to-navy-700 flex items-center justify-center shadow-lg shadow-navy-500/30 mb-4 border border-gold-400/30">
                <svg class="w-7 h-7 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
            </div>
            <h1 class="text-3xl font-extrabold text-white tracking-tight">PinRuang</h1>
            <p class="text-navy-200 text-sm mt-1">Sistem Peminjaman Ruangan UPR</p>
        </div>
        <div class="bg-white/10 backdrop-blur-xl border border-white/20 rounded-3xl shadow-2xl p-8">
            <h2 class="text-xl font-bold text-white mb-6">{{ __('Login') }}</h2>
            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf
                <div class="space-y-2">
                    <label for="email" class="block text-sm font-semibold text-navy-100">{{ __('Email Address') }}</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" autocomplete="email" autofocus
                        class="block w-full px-4 py-3 bg-white/10 border @error('email') border-danger-400 @else border-white/20 @enderror rounded-xl text-white placeholder-navy-300 text-sm focus:ring-2 focus:ring-gold-400 focus:border-gold-400 focus:bg-white/15 focus:outline-none transition-all"
                        placeholder="email@example.com">
                    @error('email')<p class="text-sm text-danger-300">{{ $message }}</p>@enderror
                </div>
                <div class="space-y-2">
                    <label for="password" class="block text-sm font-semibold text-navy-100">{{ __('Password') }}</label>
                    <input id="password" type="password" name="password" autocomplete="current-password"
                        class="block w-full px-4 py-3 bg-white/10 border @error('password') border-danger-400 @else border-white/20 @enderror rounded-xl text-white placeholder-navy-300 text-sm focus:ring-2 focus:ring-gold-400 focus:border-gold-400 focus:bg-white/15 focus:outline-none transition-all"
                        placeholder="••••••••">
                    @error('password')<p class="text-sm text-danger-300">{{ $message }}</p>@enderror
                </div>
                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}
                            class="w-4 h-4 rounded bg-white/10 border-white/30 text-gold-500 focus:ring-gold-400">
                        <span class="text-sm text-navy-200">{{ __('Remember Me') }}</span>
                    </label>
                </div>
                <button type="submit" class="w-full py-3 px-4 text-sm font-bold text-navy-900 bg-gold-500 rounded-xl hover:bg-gold-400 transition-all shadow-lg shadow-gold-500/20 transform hover:-translate-y-0.5">
                    {{ __('Login') }}
                </button>
                <div class="flex items-center justify-between text-sm">
                    <a href="{{ route('register') }}" class="text-gold-300 hover:text-white transition-colors font-medium">Buat Akun</a>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-navy-200 hover:text-white transition-colors">Lupa Password?</a>
                    @endif
                </div>
            </form>
        </div>
    </div>
@endsection
