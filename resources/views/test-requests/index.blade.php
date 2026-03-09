@extends('layouts.admin')

@section('content')
    <div class="space-y-8 ">
        <div
            class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white/5 backdrop-blur-md border border-white/10 rounded-2xl p-6 shadow-xl relative overflow-hidden">
            <div
                class="absolute -top-24 -right-24 w-64 h-64 bg-rose-500/20 rounded-full mix-blend-screen filter blur-[80px]">
            </div>
            <div class="relative z-10">
                <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight mb-1">Tracking Pengujian</h1>
                <nav class="flex">
                    <ol class="inline-flex items-center text-sm text-slate-500">
                        <li><a href="{{ route('home') }}">Dashboard</a></li>
                        <li><span class="mx-2">/</span></li>
                        <li class="text-rose-600 font-semibold">Pengujian Saya</li>
                    </ol>
                </nav>
            </div>
            <div class="relative z-10">
                <a href="{{ route('test-requests.create') }}"
                    class="inline-flex items-center px-5 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-rose-600 to-pink-600 rounded-xl hover:from-rose-500 hover:to-pink-500 shadow-lg transform hover:-translate-y-0.5 transition-all">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Ajukan Pengujian
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="p-4 text-sm text-emerald-800 rounded-xl bg-emerald-50 border border-emerald-200">✓
                {{ session('success') }}</div>
        @endif

        <div class="space-y-4">
            @forelse($requests as $req)
                <a href="{{ route('test-requests.show', $req) }}"
                    class="block bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 p-6 group">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl flex items-center justify-center shadow-sm
                                        {{ $req->sample_type === 'tanah' ? 'bg-amber-50 border-amber-100 text-amber-600' : '' }}
                                        {{ $req->sample_type === 'air' ? 'bg-cyan-50 border-cyan-100 text-cyan-600' : '' }}
                                        {{ $req->sample_type === 'jaringan_tanaman' ? 'bg-green-50 border-green-100 text-green-600' : '' }}
                                        border">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-mono font-bold text-slate-800">{{ $req->request_code }}</p>
                                <p class="text-xs text-slate-500">{{ $req->sample_type_label }} • {{ $req->num_samples }} sampel
                                    • {{ $req->created_at->format('d M Y') }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                        {{ $req->status === 'pending_payment' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $req->status === 'payment_uploaded' ? 'bg-blue-100 text-blue-800' : '' }}
                                        {{ $req->status === 'payment_verified' ? 'bg-indigo-100 text-indigo-800' : '' }}
                                        {{ $req->status === 'in_testing' ? 'bg-violet-100 text-violet-800' : '' }}
                                        {{ $req->status === 'in_review' ? 'bg-purple-100 text-purple-800' : '' }}
                                        {{ $req->status === 'report_approved' ? 'bg-emerald-100 text-emerald-800' : '' }}
                                        {{ $req->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                    ">{{ $req->status_label }}</span>
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
                                d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z">
                            </path>
                        </svg></div>
                    <h5 class="text-slate-800 font-bold mb-1">Belum ada permohonan pengujian</h5>
                    <p class="text-sm text-slate-500 mb-4">Ajukan permohonan pengujian baru untuk memulai.</p>
                    <a href="{{ route('test-requests.create') }}"
                        class="inline-flex items-center px-5 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-rose-600 to-pink-600 rounded-xl shadow-lg">Ajukan
                        Pengujian Baru</a>
                </div>
            @endforelse
        </div>

        @if($requests->hasPages())
            <div class="py-4">{{ $requests->links('pagination::tailwind') }}</div>
        @endif
    </div>
@endsection
