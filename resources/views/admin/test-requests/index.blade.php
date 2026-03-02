@extends('layouts.admin')

@section('content')
    <div class="space-y-8 animate-fade-in">
        <div
            class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white/5 backdrop-blur-md border border-white/10 rounded-2xl p-6 shadow-xl relative overflow-hidden">
            <div
                class="absolute -top-24 -right-24 w-64 h-64 bg-rose-500/20 rounded-full mix-blend-screen filter blur-[80px]">
            </div>
            <div class="relative z-10">
                <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight mb-1">Permohonan Pengujian</h1>
                <nav class="flex">
                    <ol class="inline-flex items-center text-sm text-slate-500 font-medium">
                        <li><a href="{{ route('admin.home') }}" class="hover:text-rose-600">Dashboard</a></li>
                        <li><span class="mx-2">/</span></li>
                        <li class="text-rose-600 font-semibold">Pengujian</li>
                    </ol>
                </nav>
            </div>
        </div>

        @if(session('success'))
            <div class="p-4 text-sm text-emerald-800 rounded-xl bg-emerald-50 border border-emerald-200" id="successAlert">
                <div class="flex items-center"><svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd"></path>
                    </svg>{{ session('success') }}</div>
            </div>
        @endif

        <!-- Status Filter Tabs -->
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.test-requests.index') }}"
                class="px-4 py-2 text-sm font-semibold rounded-xl {{ !request('status') ? 'bg-slate-800 text-white' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' }} transition-colors">Semua</a>
            @foreach(['pending_payment' => 'Menunggu Bayar', 'payment_uploaded' => 'Bukti Diunggah', 'payment_verified' => 'Terverifikasi', 'in_testing' => 'Pengujian', 'in_review' => 'Review', 'report_approved' => 'Laporan OK', 'completed' => 'Selesai'] as $status => $label)
                <a href="{{ route('admin.test-requests.index', ['status' => $status]) }}"
                    class="px-4 py-2 text-sm font-semibold rounded-xl {{ request('status') === $status ? 'bg-slate-800 text-white' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' }} transition-colors">{{ $label }}</a>
            @endforeach
        </div>

        <div class="bg-white rounded-3xl border border-slate-100 shadow-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-max">
                    <thead>
                        <tr
                            class="bg-white border-b border-slate-100 text-slate-500 text-xs font-bold uppercase tracking-widest">
                            <th class="px-6 py-5">Kode</th>
                            <th class="px-6 py-5">Pemohon</th>
                            <th class="px-6 py-5">Jenis Sampel</th>
                            <th class="px-6 py-5 text-center">Jml Sampel</th>
                            <th class="px-6 py-5">Status</th>
                            <th class="px-6 py-5">Tanggal</th>
                            <th class="px-6 py-5 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 text-sm">
                        @forelse($requests as $req)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="px-6 py-4"><span
                                        class="font-mono font-bold text-slate-800 text-xs bg-slate-100 px-2.5 py-1 rounded-md border border-slate-200">{{ $req->request_code }}</span>
                                </td>
                                <td class="px-6 py-4 font-semibold text-slate-800">{{ $req->user->name ?? '-' }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold
                                                {{ $req->sample_type === 'tanah' ? 'bg-amber-100 text-amber-700' : '' }}
                                                {{ $req->sample_type === 'air' ? 'bg-cyan-100 text-cyan-700' : '' }}
                                                {{ $req->sample_type === 'jaringan_tanaman' ? 'bg-green-100 text-green-700' : '' }}
                                            ">{{ $req->sample_type_label }}</span>
                                </td>
                                <td class="px-6 py-4 text-center font-semibold">{{ $req->num_samples }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold
                                                {{ $req->status === 'pending_payment' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                {{ $req->status === 'payment_uploaded' ? 'bg-blue-100 text-blue-800' : '' }}
                                                {{ $req->status === 'payment_verified' ? 'bg-indigo-100 text-indigo-800' : '' }}
                                                {{ $req->status === 'in_testing' ? 'bg-violet-100 text-violet-800' : '' }}
                                                {{ $req->status === 'in_review' ? 'bg-purple-100 text-purple-800' : '' }}
                                                {{ $req->status === 'report_approved' ? 'bg-emerald-100 text-emerald-800' : '' }}
                                                {{ $req->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                            ">{{ $req->status_label }}</span>
                                </td>
                                <td class="px-6 py-4 text-slate-500 text-xs">{{ $req->created_at->format('d M Y H:i') }}</td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('admin.test-requests.show', $req) }}"
                                        class="inline-flex items-center px-3 py-1.5 text-xs font-semibold text-cyan-700 bg-cyan-50 rounded-lg hover:bg-cyan-100 transition-colors">Detail</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-slate-400">Tidak ada permohonan pengujian.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($requests->hasPages())
                <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">{{ $requests->links('pagination::tailwind') }}
                </div>
            @endif
        </div>
    </div>
@endsection