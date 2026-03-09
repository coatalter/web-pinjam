@extends('layouts.admin')

@section('content')
    <div class="space-y-8 ">
        <div class="bg-white/5 backdrop-blur-md border border-white/10 rounded-2xl p-6 shadow-xl">
            <h1 class="text-3xl font-extrabold text-slate-800 mb-1">{{ $testRequest->request_code }}</h1>
            <nav class="flex"><ol class="inline-flex items-center text-sm text-slate-500"><li><a href="{{ route('home') }}">Dashboard</a></li><li><span class="mx-2">/</span></li><li><a href="{{ route('test-requests.index') }}">Pengujian</a></li><li><span class="mx-2">/</span></li><li class="text-rose-600 font-semibold">Tracking</li></ol></nav>
        </div>

        @if(session('success'))
            <div class="p-4 text-sm text-emerald-800 rounded-xl bg-emerald-50 border border-emerald-200">✓ {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="p-4 text-sm text-rose-800 rounded-xl bg-rose-50 border border-rose-200">✕ {{ session('error') }}</div>
        @endif

        <!-- Status Tracker -->
        <div class="bg-white rounded-3xl border border-slate-100 shadow-xl p-8">
            <h3 class="text-lg font-bold text-slate-800 mb-6">Status Permohonan</h3>
            <div class="relative">
                @php
                    $steps = [
                        'pending_payment' => ['label' => 'Menunggu Pembayaran', 'icon' => '💳'],
                        'payment_uploaded' => ['label' => 'Bukti Diunggah', 'icon' => '📤'],
                        'payment_verified' => ['label' => 'Pembayaran Terverifikasi', 'icon' => '✅'],
                        'in_testing' => ['label' => 'Dalam Pengujian', 'icon' => '🔬'],
                        'in_review' => ['label' => 'Blind Review', 'icon' => '📋'],
                        'report_approved' => ['label' => 'Laporan Disetujui', 'icon' => '📝'],
                        'completed' => ['label' => 'Selesai', 'icon' => '🎉'],
                    ];
                    $currentIndex = array_search($testRequest->status, array_keys($steps));
                @endphp
                <div class="flex flex-col md:flex-row gap-3">
                    @foreach($steps as $key => $step)
                        @php $stepIndex = array_search($key, array_keys($steps)); @endphp
                        <div class="flex items-center gap-3 flex-1">
                            <div class="flex flex-col items-center">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold border-2 transition-all
                                    {{ $stepIndex < $currentIndex ? 'bg-emerald-500 border-emerald-500 text-white' : '' }}
                                    {{ $stepIndex === $currentIndex ? 'bg-rose-500 border-rose-500 text-white ring-4 ring-rose-100' : '' }}
                                    {{ $stepIndex > $currentIndex ? 'bg-slate-100 border-slate-200 text-slate-400' : '' }}
                                ">{{ $step['icon'] }}</div>
                                <span class="text-[10px] mt-1 text-center {{ $stepIndex <= $currentIndex ? 'text-slate-800 font-bold' : 'text-slate-400' }}">{{ $step['label'] }}</span>
                            </div>
                            @if(!$loop->last)
                                <div class="hidden md:block flex-1 h-0.5 {{ $stepIndex < $currentIndex ? 'bg-emerald-400' : 'bg-slate-200' }} mt-[-18px]"></div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Request Info -->
            <div class="bg-white rounded-3xl border border-slate-100 shadow-xl p-8">
                <h3 class="text-lg font-bold text-slate-800 mb-6">Detail Permohonan</h3>
                <dl class="space-y-3">
                    <div class="flex justify-between py-2 border-b border-slate-100"><dt class="text-sm text-slate-500">Kode</dt><dd class="text-sm font-mono font-bold text-slate-800">{{ $testRequest->request_code }}</dd></div>
                    <div class="flex justify-between py-2 border-b border-slate-100"><dt class="text-sm text-slate-500">Jenis Sampel</dt><dd><span class="px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $testRequest->sample_type === 'tanah' ? 'bg-amber-100 text-amber-700' : ($testRequest->sample_type === 'air' ? 'bg-cyan-100 text-cyan-700' : 'bg-green-100 text-green-700') }}">{{ $testRequest->sample_type_label }}</span></dd></div>
                    <div class="flex justify-between py-2 border-b border-slate-100"><dt class="text-sm text-slate-500">Jumlah Sampel</dt><dd class="text-sm font-bold">{{ $testRequest->num_samples }}</dd></div>
                    <div class="flex justify-between py-2 border-b border-slate-100"><dt class="text-sm text-slate-500">Total Harga</dt><dd class="text-sm font-bold text-emerald-600">Rp {{ number_format($testRequest->total_price, 0, ',', '.') }}</dd></div>
                    <div class="flex justify-between py-2"><dt class="text-sm text-slate-500">Tanggal Ajuan</dt><dd class="text-sm text-slate-700">{{ $testRequest->created_at->format('d M Y H:i') }}</dd></div>
                </dl>

                <!-- Parameters -->
                <h4 class="text-sm font-bold text-slate-600 uppercase tracking-wider mt-6 mb-3">Parameter yang Diuji</h4>
                <div class="space-y-2">
                    @foreach($parameterDetails as $param)
                        <div class="flex justify-between items-center p-3 bg-slate-50 rounded-xl border border-slate-100">
                            <span class="text-sm font-semibold text-slate-800">{{ $param->name }}</span>
                            <span class="text-xs text-slate-500">Rp {{ number_format($param->price, 0, ',', '.') }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Upload Payment / Results -->
            <div class="space-y-6">
                @if(in_array($testRequest->status, ['pending_payment', 'payment_uploaded']))
                    <div class="bg-white rounded-3xl border border-yellow-200 shadow-xl p-8">
                        <h3 class="text-lg font-bold text-yellow-800 mb-4">Upload Bukti Pembayaran</h3>
                        <p class="text-sm text-slate-500 mb-4">Silakan upload bukti transfer pembayaran Anda. File yang diterima: JPG, PNG, atau PDF (max 5MB).</p>
                        @if($testRequest->payment_proof)
                            <div class="p-3 bg-blue-50 rounded-xl border border-blue-200 mb-4">
                                <p class="text-xs text-blue-700 font-medium">Bukti bayar sudah diunggah. <a href="{{ asset('storage/' . $testRequest->payment_proof) }}" target="_blank" class="underline">Lihat file</a></p>
                            </div>
                        @endif
                        <form method="POST" action="{{ route('test-requests.upload-payment', $testRequest) }}" enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            <input type="file" name="payment_proof" accept=".jpg,.jpeg,.png,.pdf" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm" required>
                            <button type="submit" class="w-full px-5 py-3 text-sm font-semibold text-white bg-gradient-to-r from-yellow-600 to-amber-600 rounded-xl shadow-lg">Upload Bukti Bayar</button>
                        </form>
                    </div>
                @endif

                <!-- Test Results (when available) -->
                @if($testRequest->testResults->count() > 0 && in_array($testRequest->status, ['report_approved', 'completed']))
                    <div class="bg-white rounded-3xl border border-emerald-200 shadow-xl p-8">
                        <h3 class="text-lg font-bold text-emerald-800 mb-4">Hasil Pengujian</h3>
                        <div class="space-y-2">
                            @foreach($testRequest->testResults as $result)
                                <div class="flex justify-between items-center p-3 bg-emerald-50 rounded-xl border border-emerald-100">
                                    <span class="text-sm font-semibold text-slate-800">{{ $result->testParameter->name ?? '-' }}</span>
                                    <span class="text-sm font-bold text-emerald-700">{{ $result->result_value ?? 'Menunggu' }} {{ $result->result_unit ?? '' }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if($testRequest->status === 'completed' && $testRequest->report_file)
                    <div class="bg-white rounded-3xl border border-green-200 shadow-xl p-8 text-center">
                        <div class="w-16 h-16 rounded-full bg-green-100 flex items-center justify-center mx-auto mb-4 text-3xl">📄</div>
                        <h3 class="text-lg font-bold text-green-800 mb-2">Laporan Tersedia</h3>
                        <p class="text-sm text-slate-500 mb-4">Laporan pengujian Anda sudah selesai dan tersedia untuk diunduh.</p>
                        <a href="{{ asset('storage/' . $testRequest->report_file) }}" target="_blank" class="inline-flex items-center px-6 py-3 text-sm font-semibold text-white bg-gradient-to-r from-green-600 to-emerald-600 rounded-xl shadow-lg">Download Laporan</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
