@extends('layouts.admin')

@section('content')
    <div class="space-y-8 ">
        <div
            class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white/5 backdrop-blur-md border border-white/10 rounded-2xl p-6 shadow-xl relative overflow-hidden">
            <div
                class="absolute -top-24 -right-24 w-64 h-64 bg-sky-500/20 rounded-full mix-blend-screen filter blur-[80px]">
            </div>
            <div class="relative z-10">
                <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight mb-1">Registrasi Praktikum</h1>
                <nav class="flex">
                    <ol class="inline-flex items-center text-sm text-slate-500">
                        <li><a href="{{ route('admin.home') }}">Dashboard</a></li>
                        <li><span class="mx-2">/</span></li>
                        <li class="text-sky-600 font-semibold">Praktikum</li>
                    </ol>
                </nav>
            </div>
            <div class="relative z-10 flex gap-3">
                <a href="{{ route('admin.practicum.export') }}"
                    class="inline-flex items-center px-5 py-2.5 text-sm font-semibold text-emerald-700 bg-emerald-50 border border-emerald-200 rounded-xl hover:bg-emerald-100 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    Export Excel
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="p-4 text-sm text-emerald-800 rounded-xl bg-emerald-50 border border-emerald-200">✓
                {{ session('success') }}
            </div>
        @endif

        <div class="flex flex-wrap gap-2" hx-target="#table-container" hx-select="#table-container"
            hx-swap="outerHTML swap:200ms settle:200ms" hx-push-url="true">
            <a href="{{ route('admin.practicum.index') }}"
                class="px-4 py-2 text-sm font-semibold rounded-xl {{ !request('status') ? 'bg-slate-800 text-white' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' }}">Semua</a>
            @foreach(['registered' => 'Terdaftar', 'in_progress' => 'Berlangsung', 'completed' => 'Selesai'] as $s => $l)
                <a href="{{ route('admin.practicum.index', ['status' => $s]) }}"
                    class="px-4 py-2 text-sm font-semibold rounded-xl {{ request('status') === $s ? 'bg-slate-800 text-white' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' }}">{{ $l }}</a>
            @endforeach
        </div>

        <!-- Table Container (Specific swap target) -->
        <div id="table-container" class="table-transition">
            <div class="bg-white rounded-3xl border border-slate-100 shadow-xl overflow-hidden">
                <!-- Desktop Table -->
                <div class="overflow-x-auto hidden md:block">
                    <table class="w-full text-left text-sm">
                        <thead>
                            <tr class="border-b border-slate-100 text-xs text-slate-500 uppercase tracking-widest">
                                <th class="px-6 py-5">Mata Kuliah</th>
                                <th class="px-6 py-5">Kelas</th>
                                <th class="px-6 py-5">Dosen</th>
                                <th class="px-6 py-5">Ruangan</th>
                                <th class="px-6 py-5">Tanggal</th>
                                <th class="px-6 py-5 text-center">Jumlah</th>
                                <th class="px-6 py-5">Status</th>
                                <th class="px-6 py-5 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($registrations as $reg)
                                <tr class="hover:bg-slate-50/80">
                                    <td class="px-6 py-4 font-bold text-slate-800">{{ $reg->course_name }}</td>
                                    <td class="px-6 py-4 text-slate-600">{{ $reg->class_name }}</td>
                                    <td class="px-6 py-4 text-slate-600">{{ $reg->lecturer_name }}</td>
                                    <td class="px-6 py-4 text-slate-500">{{ $reg->room?->name ?? '-' }}</td>
                                    <td class="px-6 py-4 text-slate-500 text-xs">{{ $reg->schedule_date->format('d M Y') }}</td>
                                    <td class="px-6 py-4 text-center font-semibold">{{ $reg->num_students }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold
                                                                {{ $reg->status === 'registered' ? 'bg-blue-100 text-blue-700' : '' }}
                                                                {{ $reg->status === 'in_progress' ? 'bg-amber-100 text-amber-700' : '' }}
                                                                {{ $reg->status === 'completed' ? 'bg-emerald-100 text-emerald-700' : '' }}
                                                            ">{{ $reg->status_label }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <a href="{{ route('admin.practicum.show', $reg) }}"
                                            class="px-3 py-1.5 text-xs font-semibold text-cyan-700 bg-cyan-50 rounded-lg hover:bg-cyan-100">Detail</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-12 text-center text-slate-400">Belum ada registrasi
                                        praktikum.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Card View -->
                <div class="md:hidden divide-y divide-slate-100">
                    @forelse($registrations as $reg)
                        <div class="p-4">
                            <div class="flex items-center justify-between mb-2">
                                <h5 class="text-sm font-bold text-slate-800 truncate pr-2">{{ $reg->course_name }}</h5>
                                <span class="shrink-0 px-2.5 py-0.5 rounded-full text-[10px] font-semibold flex items-center
                                                {{ $reg->status === 'registered' ? 'bg-blue-100 text-blue-700' : '' }}
                                                {{ $reg->status === 'in_progress' ? 'bg-amber-100 text-amber-700' : '' }}
                                                {{ $reg->status === 'completed' ? 'bg-emerald-100 text-emerald-700' : '' }}
                                            ">{{ $reg->status_label }}</span>
                            </div>
                            <div class="text-xs text-slate-500 space-y-1 mb-3">
                                <p><strong>Kelas:</strong> {{ $reg->class_name }}</p>
                                <p><strong>Dosen:</strong> {{ $reg->lecturer_name }}</p>
                                <p><strong>Ruangan:</strong> {{ $reg->room?->name ?? '-' }}</p>
                                <div class="flex justify-between items-center mt-2">
                                    <span class="text-slate-400">📅 {{ $reg->schedule_date->format('d M Y') }}</span>
                                    <span class="font-semibold text-slate-700">👥 {{ $reg->num_students }} Mhs</span>
                                </div>
                            </div>
                            <div class="flex justify-end pt-2 border-t border-slate-50">
                                <a href="{{ route('admin.practicum.show', $reg) }}"
                                    class="inline-flex items-center px-4 py-1.5 text-xs font-semibold text-cyan-700 bg-cyan-50 rounded-lg hover:bg-cyan-100">Detail</a>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-slate-400 text-sm">Belum ada registrasi praktikum.</div>
                    @endforelse
                </div>
                @if($registrations->hasPages())
                    <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
                        {{ $registrations->links('pagination::tailwind') }}
                    </div>
                @endif
            </div>
        </div>
@endsection