@extends('layouts.admin')

@section('content')
    <div class="space-y-8 ">
        <div
            class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white/5 backdrop-blur-md border border-white/10 rounded-2xl p-6 shadow-xl relative overflow-hidden">
            <div
                class="absolute -top-24 -right-24 w-64 h-64 bg-sky-500/20 rounded-full mix-blend-screen filter blur-[80px]">
            </div>
            <div class="relative z-10">
                <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight mb-1">Riwayat Praktikum</h1>
                <nav class="flex">
                    <ol class="inline-flex items-center text-sm text-slate-500">
                        <li><a href="{{ route('home') }}">Dashboard</a></li>
                        <li><span class="mx-2">/</span></li>
                        <li class="text-sky-600 font-semibold">Praktikum Saya</li>
                    </ol>
                </nav>
            </div>
            <div class="relative z-10">
                <a href="{{ route('practicum.create') }}"
                    class="inline-flex items-center px-5 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-sky-600 to-blue-600 rounded-xl hover:from-sky-500 hover:to-blue-500 shadow-lg transform hover:-translate-y-0.5 transition-all">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Daftar Praktikum
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="p-4 text-sm text-emerald-800 rounded-xl bg-emerald-50 border border-emerald-200">✓
                {{ session('success') }}</div>
        @endif

        <div class="space-y-4">
            @forelse($registrations as $reg)
                <a href="{{ route('practicum.show', $reg) }}"
                    class="block bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-xl transition-all p-6 group">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <div
                                class="w-12 h-12 rounded-2xl bg-sky-50 border border-sky-100 text-sky-600 flex items-center justify-center shadow-sm">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-slate-800">{{ $reg->course_name }}</p>
                                <p class="text-xs text-slate-500">{{ $reg->class_name }} • {{ $reg->lecturer_name }} •
                                    {{ $reg->schedule_date->format('d M Y') }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="text-xs text-slate-500">{{ $reg->room?->name ?? '-' }}</span>
                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                        {{ $reg->status === 'registered' ? 'bg-blue-100 text-blue-700' : '' }}
                                        {{ $reg->status === 'in_progress' ? 'bg-amber-100 text-amber-700' : '' }}
                                        {{ $reg->status === 'completed' ? 'bg-emerald-100 text-emerald-700' : '' }}
                                    ">{{ $reg->status_label }}</span>
                            <svg class="w-5 h-5 text-slate-400 group-hover:text-slate-600 transition-colors" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </a>
            @empty
                <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-12 text-center">
                    <div
                        class="w-16 h-16 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 mx-auto mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                            </path>
                        </svg></div>
                    <h5 class="text-slate-800 font-bold mb-1">Belum ada registrasi praktikum</h5>
                    <p class="text-sm text-slate-500 mb-4">Daftarkan praktikum baru untuk memulai.</p>
                    <a href="{{ route('practicum.create') }}"
                        class="inline-flex items-center px-5 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-sky-600 to-blue-600 rounded-xl shadow-lg">Daftar
                        Praktikum</a>
                </div>
            @endforelse
        </div>

        @if($registrations->hasPages())
            <div class="py-4">{{ $registrations->links('pagination::tailwind') }}</div>
        @endif
    </div>
@endsection
