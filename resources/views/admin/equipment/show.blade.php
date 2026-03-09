@extends('layouts.admin')

@section('content')
    <div class="space-y-8 ">
        <div
            class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white/5 backdrop-blur-md border border-white/10 rounded-2xl p-6 shadow-xl relative overflow-hidden">
            <div
                class="absolute -top-24 -right-24 w-64 h-64 bg-violet-500/20 rounded-full mix-blend-screen filter blur-[80px] animate-pulse-slow">
            </div>
            <div class="relative z-10">
                <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight mb-1">{{ $equipment->name }}</h1>
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3 text-sm text-slate-500 font-medium">
                        <li><a href="{{ route('admin.home') }}"
                                class="hover:text-indigo-600 transition-colors">Dashboard</a></li>
                        <li><span class="mx-2">/</span></li>
                        <li><a href="{{ route('admin.equipment.index') }}"
                                class="hover:text-indigo-600 transition-colors">Alat</a></li>
                        <li><span class="mx-2">/</span></li>
                        <li class="text-indigo-600 font-semibold">Detail</li>
                    </ol>
                </nav>
            </div>
            <div class="relative z-10 flex gap-2">
                <a href="{{ route('admin.equipment.edit', $equipment) }}"
                    class="inline-flex items-center px-4 py-2 text-sm font-semibold text-amber-700 bg-amber-50 border border-amber-200 rounded-xl hover:bg-amber-100 transition-colors">Edit</a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="bg-white rounded-3xl border border-slate-100 shadow-xl p-8">
                <h3 class="text-lg font-bold text-slate-800 mb-6">Informasi Alat</h3>
                <dl class="space-y-4">
                    <div class="flex justify-between py-3 border-b border-slate-100">
                        <dt class="text-sm text-slate-500 font-medium">Kode</dt>
                        <dd class="text-sm font-mono font-bold text-slate-800">{{ $equipment->code }}</dd>
                    </div>
                    <div class="flex justify-between py-3 border-b border-slate-100">
                        <dt class="text-sm text-slate-500 font-medium">Kategori</dt>
                        <dd><span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-700">{{ $equipment->category_label }}</span>
                        </dd>
                    </div>
                    <div class="flex justify-between py-3 border-b border-slate-100">
                        <dt class="text-sm text-slate-500 font-medium">Ruangan</dt>
                        <dd class="text-sm font-semibold text-slate-800">{{ $equipment->room?->name ?? '-' }}</dd>
                    </div>
                    <div class="flex justify-between py-3 border-b border-slate-100">
                        <dt class="text-sm text-slate-500 font-medium">Kondisi</dt>
                        <dd><span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $equipment->condition === 'baik' ? 'bg-emerald-100 text-emerald-700' : ($equipment->condition === 'rusak_ringan' ? 'bg-amber-100 text-amber-700' : 'bg-rose-100 text-rose-700') }}">{{ $equipment->condition_label }}</span>
                        </dd>
                    </div>
                    <div class="flex justify-between py-3 border-b border-slate-100">
                        <dt class="text-sm text-slate-500 font-medium">Status</dt>
                        <dd>
                            @if($equipment->is_available)
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700"><span
                                        class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span>Tersedia</span>
                            @else
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-500">Tidak
                                    Tersedia</span>
                            @endif
                        </dd>
                    </div>
                    @if($equipment->description)
                        <div class="py-3">
                            <dt class="text-sm text-slate-500 font-medium mb-2">Deskripsi</dt>
                            <dd class="text-sm text-slate-700">{{ $equipment->description }}</dd>
                        </div>
                    @endif
                </dl>
            </div>

            <div class="bg-white rounded-3xl border border-slate-100 shadow-xl p-8">
                <h3 class="text-lg font-bold text-slate-800 mb-6">Riwayat Penggunaan Praktikum</h3>
                @if($equipment->practicumRegistrations->count() > 0)
                    <div class="space-y-3">
                        @foreach($equipment->practicumRegistrations->take(10) as $reg)
                            <div class="p-4 bg-slate-50 rounded-xl border border-slate-100">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="text-sm font-bold text-slate-800">{{ $reg->course_name }}</p>
                                        <p class="text-xs text-slate-500">{{ $reg->class_name }} —
                                            {{ $reg->schedule_date->format('d M Y') }}</p>
                                    </div>
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-{{ $reg->status_badge }}-100 text-{{ $reg->status_badge }}-700">{{ $reg->status_label }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 text-slate-400">
                        <p class="text-sm">Belum ada riwayat penggunaan.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <style>
        @keyframes fade-in {
            0% {
                opacity: 0;
                transform: translateY(10px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        . {
            animation: fade-in 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        @keyframes pulse-slow {

            0%,
            100% {
                opacity: 0.2;
            }

            50% {
                opacity: 0.3;
            }
        }

        .animate-pulse-slow {
            animation: pulse-slow 8s ease-in-out infinite;
        }
    </style>
@endsection
