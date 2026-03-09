@extends('layouts.admin')

@section('content')
    <div class="space-y-8 ">
        <div class="bg-white/5 backdrop-blur-md border border-white/10 rounded-2xl p-6 shadow-xl">
            <h1 class="text-3xl font-extrabold text-slate-800 mb-1">Laporan Praktikum</h1>
            <nav class="flex"><ol class="inline-flex items-center text-sm text-slate-500"><li><a href="{{ route('admin.home') }}">Dashboard</a></li><li><span class="mx-2">/</span></li><li class="text-sky-600 font-semibold">Laporan Praktikum</li></ol></nav>
        </div>

        <div class="bg-white rounded-3xl border border-slate-100 shadow-xl overflow-hidden">
            <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/50">
                <h4 class="text-xl font-bold text-slate-800 mb-1">Semua Laporan</h4>
                <p class="text-sm text-slate-500">Daftar laporan yang diunggah oleh peserta praktikum</p>
            </div>
            <div class="overflow-x-auto hidden md:block">
                <table class="w-full text-left text-sm">
                    <thead><tr class="border-b border-slate-100 text-xs text-slate-500 uppercase tracking-widest">
                        <th class="px-6 py-5">Judul</th><th class="px-6 py-5">Mata Kuliah</th><th class="px-6 py-5">Pendaftar</th><th class="px-6 py-5">Pengunggah</th><th class="px-6 py-5">Tanggal</th><th class="px-6 py-5 text-center">File</th>
                    </tr></thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($reports as $report)
                            <tr class="hover:bg-slate-50/80">
                                <td class="px-6 py-4 font-bold text-slate-800">{{ $report->title }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ $report->practicumRegistration->course_name ?? '-' }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ $report->practicumRegistration->user->name ?? '-' }}</td>
                                <td class="px-6 py-4 text-slate-500">{{ $report->submitter?->name ?? '-' }}</td>
                                <td class="px-6 py-4 text-slate-500 text-xs">{{ $report->submitted_at?->format('d M Y') }}</td>
                                <td class="px-6 py-4 text-center">
                                    @if($report->report_file)
                                        <a href="{{ asset('storage/' . $report->report_file) }}" target="_blank" class="px-3 py-1.5 text-xs font-semibold text-cyan-700 bg-cyan-50 rounded-lg hover:bg-cyan-100">Download</a>
                                    @else
                                        <span class="text-xs text-slate-400">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="px-6 py-12 text-center text-slate-400">Belum ada laporan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile Card View -->
            <div class="md:hidden divide-y divide-slate-100">
                @forelse($reports as $report)
                    <div class="p-4 block hover:bg-slate-50 transition-colors">
                        <h4 class="text-sm font-bold text-slate-800 mb-1 truncate">{{ $report->title }}</h4>
                        <div class="text-xs text-slate-500 mb-3 space-y-1">
                            <p><strong>Mata Kuliah:</strong> {{ $report->practicumRegistration->course_name ?? '-' }}</p>
                            <p><strong>Pendaftar:</strong> {{ $report->practicumRegistration->user->name ?? '-' }}</p>
                            <p><strong>Pengunggah:</strong> {{ $report->submitter?->name ?? '-' }}</p>
                            <p class="text-slate-400 mt-1">🕒 {{ $report->submitted_at?->format('d M Y') }}</p>
                        </div>
                        <div class="flex justify-end pt-2 border-t border-slate-50">
                            @if($report->report_file)
                                <a href="{{ asset('storage/' . $report->report_file) }}" target="_blank" class="px-4 py-1.5 text-xs font-semibold text-cyan-700 bg-cyan-50 rounded-lg hover:bg-cyan-100">Download Laporan</a>
                            @else
                                <span class="px-4 py-1.5 text-xs font-semibold text-slate-400 bg-slate-50 rounded-lg">File Tidak Tersedia</span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-slate-400 text-sm">Belum ada laporan.</div>
                @endforelse
            </div>
            @if($reports->hasPages())
                <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">{{ $reports->links('pagination::tailwind') }}</div>
            @endif
        </div>
    </div>
@endsection
