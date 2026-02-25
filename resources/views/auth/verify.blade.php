@extends('layouts.auth')

@section('content')
    <div class="w-full max-w-md mx-auto px-4">
        <div class="text-center mb-8">
            <div
                class="w-14 h-14 mx-auto rounded-2xl bg-gradient-to-br from-navy-500 to-navy-700 flex items-center justify-center shadow-lg shadow-navy-500/30 mb-4 border border-gold-400/30">
                <svg class="w-7 h-7 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                    </path>
                </svg>
            </div>
            <h1 class="text-2xl font-extrabold text-white">Verifikasi Email</h1>
        </div>
        <div class="bg-white/10 backdrop-blur-xl border border-white/20 rounded-3xl shadow-2xl p-8">
            @if (session('resent'))
                <div class="p-4 mb-4 text-sm text-success-200 bg-success-500/20 border border-success-400/30 rounded-xl">
                    {{ __('A fresh verification link has been sent to your email address.') }}</div>
            @endif
            <p class="text-sm text-navy-200 mb-4">
                {{ __('Before proceeding, please check your email for a verification link.') }}</p>
            <p class="text-sm text-navy-200">
                {{ __('If you did not receive the email') }},
            <form class="inline" method="POST" action="{{ route('verification.resend') }}">
                @csrf
                <button type="submit"
                    class="text-gold-400 underline hover:text-white font-medium transition-colors">{{ __('click here to request another') }}</button>.
            </form>
            </p>
        </div>
    </div>
@endsection