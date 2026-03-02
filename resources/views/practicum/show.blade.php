@extends('layouts.admin')

@section('content')
    <div class="space-y-8 animate-fade-in">
        <div class="bg-white/5 backdrop-blur-md border border-white/10 rounded-2xl p-6 shadow-xl">
            <h1 class="text-3xl font-extrabold text-slate-800 mb-1">{{ $practicum->course_name }}</h1>
            <nav class="flex">
                <ol class="inline-flex items-center text-sm text-slate-500">
                    <li><a href="{{ route('home') }}">Dashboard</a></li>
                    <li><span class="mx-2">/</span></li>
                    <li><a href="{{ route('practicum.index') }}">Praktikum</a></li>
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
                        <dt class="text-sm text-slate-500">Jumlah</dt>
                        <dd class="text-sm font-bold">{{ $practicum->num_students }} mahasiswa</dd>
                    </div>
                    <div class="flex justify-between py-2">
                        <dt class="text-sm text-slate-500">Status</dt>
                        <dd>
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold
                                {{ $practicum->status === 'registered' ? 'bg-blue-100 text-blue-700' : '' }}
                                {{ $practicum->status === 'in_progress' ? 'bg-amber-100 text-amber-700' : '' }}
                                {{ $practicum->status === 'completed' ? 'bg-emerald-100 text-emerald-700' : '' }}
                            ">{{ $practicum->status_label }}</span>
                        </dd>
                    </div>
                </dl>

                @if($practicum->equipment->count() > 0)
                    <h4 class="text-sm font-bold text-slate-600 uppercase tracking-wider mt-6 mb-3">Alat yang Digunakan</h4>
                    <div class="space-y-2">
                        @foreach($practicum->equipment as $eq)
                            <div class="flex justify-between items-center p-3 bg-slate-50 rounded-xl border border-slate-100">
                                <span class="text-sm font-semibold text-slate-800">{{ $eq->name }}</span>
                                <span class="text-sm font-bold text-slate-600">x{{ $eq->pivot->quantity }}</span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="space-y-6">
                <!-- Submit Report -->
                <div class="bg-white rounded-3xl border border-sky-200 shadow-xl p-8">
                    <h3 class="text-lg font-bold text-sky-800 mb-4">Upload Laporan Praktikum</h3>
                    <form method="POST" action="{{ route('practicum.submit-report', $practicum) }}"
                        enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div>
                            <label for="title" class="block text-sm font-semibold text-slate-700 mb-2">Judul Laporan <span
                                    class="text-rose-500">*</span></label>
                            <input type="text" id="title" name="title"
                                class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-sky-500"
                                required placeholder="Contoh: Laporan Praktikum Kimia Dasar - Pertemuan 1">
                        </div>
                        <div>
                            <label for="report_file" class="block text-sm font-semibold text-slate-700 mb-2">File Laporan
                                <span class="text-rose-500">*</span></label>
                            <input type="file" id="report_file" name="report_file" accept=".pdf,.doc,.docx"
                                class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm" required>
                            <p class="text-xs text-slate-400 mt-1">Format: PDF, DOC, DOCX (maks 10MB)</p>
                        </div>
                        <div>
                            <label for="notes" class="block text-sm font-semibold text-slate-700 mb-2">Catatan</label>
                            <textarea id="notes" name="notes" rows="2"
                                class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-sky-500"></textarea>
                        </div>
                        <button type="submit"
                            class="w-full px-5 py-3 text-sm font-semibold text-white bg-gradient-to-r from-sky-600 to-blue-600 rounded-xl shadow-lg">Upload
                            Laporan</button>
                    </form>
                </div>

                <!-- Existing Reports -->
                <div class="bg-white rounded-3xl border border-slate-100 shadow-xl p-8">
                    <h3 class="text-lg font-bold text-slate-800 mb-4">Laporan yang Sudah Diunggah</h3>
                    @if($practicum->reports->count() > 0)
                        <div class="space-y-3">
                            @foreach($practicum->reports as $report)
                                <div class="p-4 bg-slate-50 rounded-xl border border-slate-100">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <p class="text-sm font-bold text-slate-800">{{ $report->title }}</p>
                                            <p class="text-xs text-slate-500">{{ $report->submitted_at?->format('d M Y H:i') }}</p>
                                        </div>
                                        @if($report->report_file)
                                            <a href="{{ asset('storage/' . $report->report_file) }}" target="_blank"
                                                class="text-xs text-cyan-600 hover:underline font-semibold">Download</a>
                                        @endif
                                    </div>
                                    @if($report->grade)
                                        <p class="text-xs text-emerald-600 font-bold mt-2">Nilai: {{ $report->grade }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-slate-400 text-center py-4">Belum ada laporan yang diunggah.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection