@extends('layouts.admin')

@section('content')
    <div class="space-y-8 ">
        <div class="bg-white/5 backdrop-blur-md border border-white/10 rounded-2xl p-6 shadow-xl">
            <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight mb-1">Detail Permohonan #{{ $testRequest->request_code }}</h1>
            <nav class="flex"><ol class="inline-flex items-center text-sm text-slate-500 font-medium"><li><a href="{{ route('admin.home') }}">Dashboard</a></li><li><span class="mx-2">/</span></li><li><a href="{{ route('admin.test-requests.index') }}">Pengujian</a></li><li><span class="mx-2">/</span></li><li class="text-rose-600 font-semibold">{{ $testRequest->request_code }}</li></ol></nav>
        </div>

        @if(session('success'))
            <div class="p-4 text-sm text-emerald-800 rounded-xl bg-emerald-50 border border-emerald-200">✓ {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="p-4 text-sm text-rose-800 rounded-xl bg-rose-50 border border-rose-200">✕ {{ session('error') }}</div>
        @endif

        <!-- Status Tracking -->
        <div class="bg-white rounded-3xl border border-slate-100 shadow-xl p-8">
            <h3 class="text-lg font-bold text-slate-800 mb-6">Status Tracking</h3>
            <div class="flex flex-wrap gap-3">
                @php
                    $steps = ['pending_payment' => 'Menunggu Bayar', 'payment_uploaded' => 'Bukti Diunggah', 'payment_verified' => 'Terverifikasi', 'in_testing' => 'Pengujian', 'in_review' => 'Review', 'report_approved' => 'Laporan OK', 'completed' => 'Selesai'];
                    $currentIndex = array_search($testRequest->status, array_keys($steps));
                @endphp
                @foreach($steps as $key => $label)
                    @php $stepIndex = array_search($key, array_keys($steps)); @endphp
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold {{ $stepIndex <= $currentIndex ? 'bg-emerald-500 text-white' : 'bg-slate-200 text-slate-500' }}">{{ $stepIndex + 1 }}</div>
                        <span class="text-sm {{ $stepIndex <= $currentIndex ? 'font-bold text-slate-800' : 'text-slate-400' }}">{{ $label }}</span>
                        @if(!$loop->last) <svg class="w-4 h-4 text-slate-300 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg> @endif
                    </div>
                @endforeach
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Info Pemohon -->
            <div class="bg-white rounded-3xl border border-slate-100 shadow-xl p-8">
                <h3 class="text-lg font-bold text-slate-800 mb-6">Informasi Permohonan</h3>
                <dl class="space-y-3">
                    <div class="flex justify-between py-2 border-b border-slate-100"><dt class="text-sm text-slate-500">Pemohon</dt><dd class="text-sm font-bold text-slate-800">{{ $testRequest->user->name }}</dd></div>
                    <div class="flex justify-between py-2 border-b border-slate-100"><dt class="text-sm text-slate-500">Email</dt><dd class="text-sm text-slate-700">{{ $testRequest->user->email }}</dd></div>
                    <div class="flex justify-between py-2 border-b border-slate-100"><dt class="text-sm text-slate-500">Jenis Sampel</dt><dd><span class="px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $testRequest->sample_type === 'tanah' ? 'bg-amber-100 text-amber-700' : ($testRequest->sample_type === 'air' ? 'bg-cyan-100 text-cyan-700' : 'bg-green-100 text-green-700') }}">{{ $testRequest->sample_type_label }}</span></dd></div>
                    <div class="flex justify-between py-2 border-b border-slate-100"><dt class="text-sm text-slate-500">Jumlah Sampel</dt><dd class="text-sm font-bold text-slate-800">{{ $testRequest->num_samples }}</dd></div>
                    <div class="flex justify-between py-2 border-b border-slate-100"><dt class="text-sm text-slate-500">Total Harga</dt><dd class="text-sm font-bold text-emerald-600">Rp {{ number_format($testRequest->total_price, 0, ',', '.') }}</dd></div>
                    @if($testRequest->sample_description)
                        <div class="py-2"><dt class="text-sm text-slate-500 mb-1">Deskripsi Sampel</dt><dd class="text-sm text-slate-700">{{ $testRequest->sample_description }}</dd></div>
                    @endif
                    @if($testRequest->notes)
                        <div class="py-2"><dt class="text-sm text-slate-500 mb-1">Catatan</dt><dd class="text-sm text-slate-700">{{ $testRequest->notes }}</dd></div>
                    @endif
                </dl>
            </div>

            <!-- Actions -->
            <div class="space-y-6">
                <!-- Payment Verification -->
                @if($testRequest->status === 'payment_uploaded')
                    <div class="bg-white rounded-3xl border border-blue-200 shadow-xl p-8">
                        <h3 class="text-lg font-bold text-blue-800 mb-4">Verifikasi Pembayaran</h3>
                        @if($testRequest->payment_proof)
                            <a href="{{ asset('storage/' . $testRequest->payment_proof) }}" target="_blank" class="inline-flex items-center px-4 py-2 text-sm font-semibold text-blue-700 bg-blue-50 rounded-xl hover:bg-blue-100 mb-4">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                Lihat Bukti Bayar
                            </a>
                        @endif
                        <form method="POST" action="{{ route('admin.test-requests.verify-payment', $testRequest) }}">@csrf @method('PATCH')
                            <button type="submit" class="w-full px-5 py-3 text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl hover:from-blue-500 hover:to-indigo-500 shadow-lg" onclick="return confirm('Verifikasi pembayaran ini?')">✓ Verifikasi Pembayaran</button>
                        </form>
                    </div>
                @endif

                <!-- Assign Tester & Reviewer -->
                @if($testRequest->status === 'payment_verified')
                    <div class="bg-white rounded-3xl border border-violet-200 shadow-xl p-8">
                        <h3 class="text-lg font-bold text-violet-800 mb-4">Assign Penguji & Reviewer</h3>
                        <form method="POST" action="{{ route('admin.test-requests.assign', $testRequest) }}" class="space-y-4">@csrf @method('PATCH')
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Penguji</label>
                                <select name="assigned_tester_id" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm" required>
                                    <option value="">— Pilih Penguji —</option>
                                    @foreach(\App\Models\User::whereHas('role', fn($q) => $q->where('slug', 'penguji'))->get() as $tester)
                                        <option value="{{ $tester->id }}">{{ $tester->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Reviewer</label>
                                <select name="assigned_reviewer_id" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm" required>
                                    <option value="">— Pilih Reviewer —</option>
                                    @foreach(\App\Models\User::whereHas('role', fn($q) => $q->where('slug', 'reviewer'))->get() as $reviewer)
                                        <option value="{{ $reviewer->id }}">{{ $reviewer->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="w-full px-5 py-3 text-sm font-semibold text-white bg-gradient-to-r from-violet-600 to-purple-600 rounded-xl shadow-lg">Assign & Mulai Pengujian</button>
                        </form>
                    </div>
                @endif

                <!-- Approve Report -->
                @if($testRequest->status === 'in_review')
                    <div class="bg-white rounded-3xl border border-emerald-200 shadow-xl p-8">
                        <h3 class="text-lg font-bold text-emerald-800 mb-4">Approval Laporan</h3>
                        @if($testRequest->report_file)
                            <a href="{{ asset('storage/' . $testRequest->report_file) }}" target="_blank" class="inline-flex items-center px-4 py-2 text-sm font-semibold text-emerald-700 bg-emerald-50 rounded-xl hover:bg-emerald-100 mb-4">Lihat Laporan</a>
                        @endif
                        <form method="POST" action="{{ route('admin.test-requests.approve-report', $testRequest) }}">@csrf @method('PATCH')
                            <button type="submit" class="w-full px-5 py-3 text-sm font-semibold text-white bg-gradient-to-r from-emerald-600 to-green-600 rounded-xl shadow-lg" onclick="return confirm('Setujui laporan ini?')">✓ Setujui Laporan</button>
                        </form>
                    </div>
                @endif

                <!-- Complete (Send Email) -->
                @if($testRequest->status === 'report_approved')
                    <div class="bg-white rounded-3xl border border-green-200 shadow-xl p-8">
                        <h3 class="text-lg font-bold text-green-800 mb-4">Kirim Laporan</h3>
                        <p class="text-sm text-slate-500 mb-4">Klik tombol di bawah untuk menandakan bahwa laporan sudah dikirim via email ke pemohon.</p>
                        <form method="POST" action="{{ route('admin.test-requests.complete', $testRequest) }}">@csrf @method('PATCH')
                            <button type="submit" class="w-full px-5 py-3 text-sm font-semibold text-white bg-gradient-to-r from-green-600 to-emerald-600 rounded-xl shadow-lg">📧 Tandai Selesai & Kirim</button>
                        </form>
                    </div>
                @endif

                <!-- Upload Report File -->
                @if(in_array($testRequest->status, ['in_testing', 'in_review']))
                    <div class="bg-white rounded-3xl border border-slate-200 shadow-xl p-8">
                        <h3 class="text-lg font-bold text-slate-800 mb-4">Upload Laporan</h3>
                        <form method="POST" action="{{ route('admin.test-requests.upload-report', $testRequest) }}" enctype="multipart/form-data" class="space-y-4">@csrf
                            <input type="file" name="report_file" accept=".pdf,.doc,.docx" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm" required>
                            <button type="submit" class="w-full px-5 py-3 text-sm font-semibold text-white bg-slate-800 rounded-xl hover:bg-slate-700">Upload Laporan</button>
                        </form>
                    </div>
                @endif
            </div>
        </div>

        <!-- Test Results -->
        @if($testRequest->testResults->count() > 0)
            <div class="bg-white rounded-3xl border border-slate-100 shadow-xl overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="text-lg font-bold text-slate-800">Hasil Pengujian per Parameter</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead><tr class="border-b border-slate-100 text-xs text-slate-500 uppercase tracking-widest">
                            <th class="px-6 py-4">Parameter</th><th class="px-6 py-4">Satuan</th><th class="px-6 py-4">Hasil</th><th class="px-6 py-4">Status</th><th class="px-6 py-4">Catatan Reviewer</th>
                        </tr></thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach($testRequest->testResults as $result)
                                <tr class="hover:bg-slate-50/80">
                                    <td class="px-6 py-4 font-semibold text-slate-800">{{ $result->testParameter->name ?? '-' }}</td>
                                    <td class="px-6 py-4 text-slate-500">{{ $result->result_unit ?? $result->testParameter->unit ?? '-' }}</td>
                                    <td class="px-6 py-4 font-bold text-slate-800">{{ $result->result_value ?? '-' }}</td>
                                    <td class="px-6 py-4"><span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-{{ $result->status_badge }}-100 text-{{ $result->status_badge }}-700">{{ $result->status_label }}</span></td>
                                    <td class="px-6 py-4 text-slate-500 text-xs">{{ $result->reviewer_notes ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
@endsection
