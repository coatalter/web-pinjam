@extends('layouts.admin')

@section('content')
    <div class="space-y-8 ">
        <div class="bg-white/5 backdrop-blur-md border border-white/10 rounded-2xl p-6 shadow-xl">
            <h1 class="text-3xl font-extrabold text-slate-800 mb-1">Verifikasi Pembayaran</h1>
            <nav class="flex">
                <ol class="inline-flex items-center text-sm text-slate-500">
                    <li><a href="{{ route('admin.home') }}">Dashboard</a></li>
                    <li><span class="mx-2">/</span></li>
                    <li class="text-rose-600 font-semibold">Verif Pembayaran</li>
                </ol>
            </nav>
        </div>

        @if(session('success'))
            <div class="p-4 text-sm text-emerald-800 rounded-xl bg-emerald-50 border border-emerald-200">✓
                {{ session('success') }}</div>
        @endif

        <div class="bg-white rounded-3xl border border-slate-100 shadow-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="border-b border-slate-100 text-xs text-slate-500 uppercase tracking-widest">
                            <th class="px-6 py-5">Kode</th>
                            <th class="px-6 py-5">Pemohon</th>
                            <th class="px-6 py-5">Jenis Sampel</th>
                            <th class="px-6 py-5 text-right">Total</th>
                            <th class="px-6 py-5">Status</th>
                            <th class="px-6 py-5 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($requests as $req)
                            <tr class="hover:bg-slate-50/80">
                                <td class="px-6 py-4 font-mono font-bold text-xs">{{ $req->request_code }}</td>
                                <td class="px-6 py-4 font-semibold text-slate-800">{{ $req->user->name }}</td>
                                <td class="px-6 py-4">{{ $req->sample_type_label }}</td>
                                <td class="px-6 py-4 text-right font-semibold">Rp
                                    {{ number_format($req->total_price, 0, ',', '.') }}</td>
                                <td class="px-6 py-4"><span
                                        class="px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $req->status === 'payment_uploaded' ? 'bg-blue-100 text-blue-800' : 'bg-emerald-100 text-emerald-800' }}">{{ $req->status_label }}</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('admin.test-requests.show', $req) }}"
                                        class="inline-flex items-center px-3 py-1.5 text-xs font-semibold text-cyan-700 bg-cyan-50 rounded-lg hover:bg-cyan-100">Detail</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-slate-400">Tidak ada pembayaran yang menunggu
                                    verifikasi.</td>
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
