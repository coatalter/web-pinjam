@extends('layouts.admin')

@section('content')
    <div class="space-y-8 animate-fade-in">
        <div class="bg-white/5 backdrop-blur-md border border-white/10 rounded-2xl p-6 shadow-xl">
            <h1 class="text-3xl font-extrabold text-slate-800 mb-1">{{ $practicum->course_name }}</h1>
            <nav class="flex">
                <ol class="inline-flex items-center text-sm text-slate-500">
                    <li><a href="{{ route('admin.home') }}">Dashboard</a></li>
                    <li><span class="mx-2">/</span></li>
                    <li><a href="{{ route('admin.practicum.index') }}">Praktikum</a></li>
                    <li><span class="mx-2">/</span></li>
                    <li class="text-sky-600 font-semibold">Detail</li>
                </ol>
            </nav>
        </div>

        @if(session('success'))
            <div class="p-4 text-sm text-emerald-800 rounded-xl bg-emerald-50 border border-emerald-200">✓
                {{ session('success') }}</div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="bg-white rounded-3xl border border-slate-100 shadow-xl p-8">
                <h3 class="text-lg font-bold text-slate-800 mb-6">Informasi Praktikum</h3>
                <dl class="space-y-3">
                    <div class="flex justify-between py-2 border-b border-slate-100">
                        <dt class="text-sm text-slate-500">Mata Kuliah</dt>
                        <dd class="text-sm font-bold text-slate-800">{{ $practicum->course_name }}</dd>
                    </div>
                    <div class="flex justify-between py-2 border-b border-slate-100">
                        <dt class="text-sm text-slate-500">Kelas</dt>
                        <dd class="text-sm text-slate-700">{{ $practicum->class_name }}</dd>
                    </div>
                    <div class="flex justify-between py-2 border-b border-slate-100">
                        <dt class="text-sm text-slate-500">Dosen</dt>
                        <dd class="text-sm text-slate-700">{{ $practicum->lecturer_name }}</dd>
                    </div>
                    <div class="flex justify-between py-2 border-b border-slate-100">
                        <dt class="text-sm text-slate-500">Semester / TA</dt>
                        <dd class="text-sm text-slate-700">{{ $practicum->semester }} / {{ $practicum->academic_year }}</dd>
                    </div>
                    <div class="flex justify-between py-2 border-b border-slate-100">
                        <dt class="text-sm text-slate-500">Ruangan</dt>
                        <dd class="text-sm text-slate-700">{{ $practicum->room?->name ?? '-' }}</dd>
                    </div>
                    <div class="flex justify-between py-2 border-b border-slate-100">
                        <dt class="text-sm text-slate-500">Jadwal</dt>
                        <dd class="text-sm text-slate-700">{{ $practicum->schedule_date->format('d M Y') }} |
                            {{ $practicum->start_time }} — {{ $practicum->end_time }}</dd>
                    </div>
                    <div class="flex justify-between py-2 border-b border-slate-100">
                        <dt class="text-sm text-slate-500">Jumlah Mahasiswa</dt>
                        <dd class="text-sm font-bold text-slate-800">{{ $practicum->num_students }}</dd>
                    </div>
                    <div class="flex justify-between py-2 border-b border-slate-100">
                        <dt class="text-sm text-slate-500">Pendaftar</dt>
                        <dd class="text-sm text-slate-700">{{ $practicum->user->name }}</dd>
                    </div>
                    <div class="flex justify-between py-2">
                        <dt class="text-sm text-slate-500">Status</dt>
                        <dd>
                            <form method="POST" action="{{ route('admin.practicum.update-status', $practicum) }}"
                                class="flex gap-2">@csrf @method('PATCH')
                                <select name="status" class="px-3 py-1 text-xs border border-slate-200 rounded-lg"
                                    onchange="this.form.submit()">
                                    <option value="registered" {{ $practicum->status === 'registered' ? 'selected' : '' }}>
                                        Terdaftar</option>
                                    <option value="in_progress" {{ $practicum->status === 'in_progress' ? 'selected' : '' }}>
                                        Berlangsung</option>
                                    <option value="completed" {{ $practicum->status === 'completed' ? 'selected' : '' }}>
                                        Selesai</option>
                                </select>
                            </form>
                        </dd>
                    </div>
                </dl>
            </div>

            <div class="space-y-8">
                <!-- Equipment Used -->
                <div class="bg-white rounded-3xl border border-slate-100 shadow-xl p-8">
                    <h3 class="text-lg font-bold text-slate-800 mb-4">Alat yang Digunakan</h3>
                    @if($practicum->equipment->count() > 0)
                        <div class="space-y-2">
                            @foreach($practicum->equipment as $eq)
                                <div class="flex justify-between items-center p-3 bg-slate-50 rounded-xl border border-slate-100">
                                    <div>
                                        <p class="text-sm font-semibold text-slate-800">{{ $eq->name }}</p>
                                        <p class="text-xs text-slate-500">{{ $eq->code }}</p>
                                    </div>
                                    <span class="text-sm font-bold text-slate-600">x{{ $eq->pivot->quantity }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-slate-400 text-center py-4">Tidak ada alat yang digunakan.</p>
                    @endif
                </div>

                <!-- Reports -->
                <div class="bg-white rounded-3xl border border-slate-100 shadow-xl p-8">
                    <h3 class="text-lg font-bold text-slate-800 mb-4">Laporan Praktikum</h3>
                    @if($practicum->reports->count() > 0)
                        <div class="space-y-3">
                            @foreach($practicum->reports as $report)
                                <div class="p-4 bg-slate-50 rounded-xl border border-slate-100">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <p class="text-sm font-bold text-slate-800">{{ $report->title }}</p>
                                            <p class="text-xs text-slate-500">{{ $report->submitter?->name }} —
                                                {{ $report->submitted_at?->format('d M Y H:i') }}</p>
                                        </div>
                                        @if($report->report_file)
                                            <a href="{{ asset('storage/' . $report->report_file) }}" target="_blank"
                                                class="text-xs text-cyan-600 hover:underline font-semibold">Download</a>
                                        @endif
                                    </div>
                                    @if($report->notes)
                                        <p class="text-xs text-slate-500 mt-2">{{ $report->notes }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-slate-400 text-center py-4">Belum ada laporan.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection