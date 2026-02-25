@extends('layouts.auth')

@section('content')
    <div class="w-full max-w-md mx-auto px-4">
        <div class="text-center mb-8">
            <div class="w-14 h-14 mx-auto rounded-2xl bg-gradient-to-br from-navy-500 to-navy-700 flex items-center justify-center shadow-lg shadow-navy-500/30 mb-4 border border-gold-400/30">
                <svg class="w-7 h-7 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
            </div>
            <h1 class="text-2xl font-extrabold text-white">Reset Password</h1>
        </div>
        <div class="bg-white/10 backdrop-blur-xl border border-white/20 rounded-3xl shadow-2xl p-8">
            @if (session('status'))
                <div class="p-4 mb-4 text-sm text-success-200 bg-success-500/20 border border-success-400/30 rounded-xl">{{ session('status') }}</div>
            @endif
            <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                @csrf
                <div class="space-y-2">
                    <label for="email" class="block text-sm font-semibold text-navy-100">{{ __('Email Address') }}</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                        class="block w-full px-4 py-3 bg-white/10 border @error('email') border-danger-400 @else border-white/20 @enderror rounded-xl text-white placeholder-navy-300 text-sm focus:ring-2 focus:ring-gold-400 focus:border-gold-400 focus:outline-none" placeholder="email@example.com">
                    @error('email')<p class="text-sm text-danger-300">{{ $message }}</p>@enderror
                </div>
                <button type="submit" class="w-full py-3 px-4 text-sm font-bold text-navy-900 bg-gold-500 rounded-xl hover:bg-gold-400 transition-all shadow-lg shadow-gold-500/20">{{ __('Send Password Reset Link') }}</button>
                <div class="text-center"><a href="{{ route('login') }}" class="text-sm text-navy-200 hover:text-white">← Kembali ke Login</a></div>
            </form>
        </div>
    </div>
@endsection
