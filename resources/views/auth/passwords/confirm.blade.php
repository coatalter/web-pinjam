@extends('layouts.auth')

@section('content')
    <div class="w-full max-w-md mx-auto px-4">
        <div class="text-center mb-8">
            <div class="w-14 h-14 mx-auto rounded-2xl bg-gradient-to-br from-navy-500 to-navy-700 flex items-center justify-center shadow-lg shadow-navy-500/30 mb-4 border border-gold-400/30">
                <svg class="w-7 h-7 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
            </div>
            <h1 class="text-2xl font-extrabold text-white">Konfirmasi Password</h1>
        </div>
        <div class="bg-white/10 backdrop-blur-xl border border-white/20 rounded-3xl shadow-2xl p-8">
            <p class="text-sm text-navy-200 mb-5">{{ __('Please confirm your password before continuing.') }}</p>
            <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">
                @csrf
                <div class="space-y-2">
                    <label for="password" class="block text-sm font-semibold text-navy-100">{{ __('Password') }}</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                        class="block w-full px-4 py-3 bg-white/10 border @error('password') border-danger-400 @else border-white/20 @enderror rounded-xl text-white placeholder-navy-300 text-sm focus:ring-2 focus:ring-gold-400 focus:border-gold-400 focus:outline-none">
                    @error('password')<p class="text-sm text-danger-300">{{ $message }}</p>@enderror
                </div>
                <button type="submit" class="w-full py-3 px-4 text-sm font-bold text-navy-900 bg-gold-500 rounded-xl hover:bg-gold-400 transition-all shadow-lg shadow-gold-500/20">{{ __('Confirm Password') }}</button>
                @if (Route::has('password.request'))
                    <div class="text-center"><a href="{{ route('password.request') }}" class="text-sm text-navy-200 hover:text-white">Lupa Password?</a></div>
                @endif
            </form>
        </div>
    </div>
@endsection
