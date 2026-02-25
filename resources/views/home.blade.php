@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto px-4">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-lg p-8">
            <h2 class="text-xl font-bold text-slate-800 mb-4">{{ __('Dashboard') }}</h2>
            @if (session('status'))
                <div class="p-4 mb-4 text-sm text-emerald-800 bg-emerald-50 border border-emerald-200 rounded-xl">
                    {{ session('status') }}</div>
            @endif
            <p class="text-slate-600">{{ __('You are logged in!') }}</p>
        </div>
    </div>
@endsection