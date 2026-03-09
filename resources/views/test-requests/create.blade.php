@extends('layouts.admin')

@section('content')
    <div class="space-y-8 ">
        <div class="bg-white/5 backdrop-blur-md border border-white/10 rounded-2xl p-6 shadow-xl">
            <h1 class="text-3xl font-extrabold text-slate-800 mb-1">Ajukan Pengujian Baru</h1>
            <nav class="flex">
                <ol class="inline-flex items-center text-sm text-slate-500">
                    <li><a href="{{ route('home') }}">Dashboard</a></li>
                    <li><span class="mx-2">/</span></li>
                    <li><a href="{{ route('test-requests.index') }}">Pengujian</a></li>
                    <li><span class="mx-2">/</span></li>
                    <li class="text-rose-600 font-semibold">Ajukan</li>
                </ol>
            </nav>
        </div>

        @if($errors->any())
            <div class="p-4 text-sm text-rose-800 rounded-xl bg-rose-50 border border-rose-200">
                <ul class="list-disc list-inside">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif

        <form method="POST" action="{{ route('test-requests.store') }}" class="space-y-8">
            @csrf

            <div class="bg-white rounded-3xl border border-slate-100 shadow-xl p-8">
                <h3 class="text-lg font-bold text-slate-800 mb-6">Informasi Sampel</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="sample_type" class="block text-sm font-semibold text-slate-700 mb-2">Jenis Sampel <span
                                class="text-rose-500">*</span></label>
                        <select id="sample_type" name="sample_type"
                            class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-rose-500"
                            required onchange="filterParameters()">
                            <option value="">— Pilih Jenis Sampel —</option>
                            <option value="tanah" {{ old('sample_type') === 'tanah' ? 'selected' : '' }}>Tanah</option>
                            <option value="air" {{ old('sample_type') === 'air' ? 'selected' : '' }}>Air</option>
                            <option value="jaringan_tanaman" {{ old('sample_type') === 'jaringan_tanaman' ? 'selected' : '' }}>Jaringan Tanaman</option>
                        </select>
                    </div>
                    <div>
                        <label for="num_samples" class="block text-sm font-semibold text-slate-700 mb-2">Jumlah Sampel <span
                                class="text-rose-500">*</span></label>
                        <input type="number" id="num_samples" name="num_samples" value="{{ old('num_samples', 1) }}" min="1"
                            max="100"
                            class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-rose-500"
                            required>
                    </div>
                    <div class="md:col-span-2">
                        <label for="sample_description" class="block text-sm font-semibold text-slate-700 mb-2">Deskripsi
                            Sampel</label>
                        <textarea id="sample_description" name="sample_description" rows="3"
                            class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-rose-500"
                            placeholder="Contoh: Sampel tanah dari area persawahan desa X, kedalaman 0-30cm">{{ old('sample_description') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Parameter Selection -->
            <div class="bg-white rounded-3xl border border-slate-100 shadow-xl p-8">
                <h3 class="text-lg font-bold text-slate-800 mb-2">Pilih Parameter Pengujian <span
                        class="text-rose-500">*</span></h3>
                <p class="text-sm text-slate-500 mb-6">Pilih parameter yang ingin diuji. Harga akan dihitung otomatis.</p>

                @foreach($parameters as $category => $params)
                    @php
                        $catMap = ['soil' => 'tanah', 'water' => 'air', 'plant_tissue' => 'jaringan_tanaman'];
                        $catLabel = ['soil' => 'Tanah', 'water' => 'Air', 'plant_tissue' => 'Jaringan Tanaman'];
                    @endphp
                    <div class="parameter-group mb-6" data-category="{{ $catMap[$category] ?? $category }}">
                        <h4 class="text-sm font-bold text-slate-600 uppercase tracking-wider mb-3 flex items-center gap-2">
                            <span
                                class="w-3 h-3 rounded-full {{ $category === 'soil' ? 'bg-amber-400' : ($category === 'water' ? 'bg-cyan-400' : 'bg-green-400') }}"></span>
                            {{ $catLabel[$category] ?? $category }}
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                            @foreach($params as $param)
                                <label
                                    class="flex items-start gap-3 p-4 bg-slate-50 rounded-xl border border-slate-100 hover:border-rose-200 hover:bg-rose-50/50 cursor-pointer transition-colors param-item"
                                    data-price="{{ $param->price }}">
                                    <input type="checkbox" name="parameters[]" value="{{ $param->id }}"
                                        class="mt-1 h-4 w-4 text-rose-600 border-slate-300 rounded focus:ring-rose-500 param-checkbox"
                                        {{ in_array($param->id, old('parameters', [])) ? 'checked' : '' }} onchange="updateTotal()">
                                    <div class="flex-1">
                                        <p class="text-sm font-semibold text-slate-800">{{ $param->name }}</p>
                                        <p class="text-xs text-slate-500">{{ $param->method ?? '-' }} • {{ $param->unit ?? '-' }}
                                        </p>
                                        <p class="text-xs font-bold text-rose-600 mt-1">Rp
                                            {{ number_format($param->price, 0, ',', '.') }}</p>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endforeach

                <!-- Total Price -->
                <div class="mt-6 p-4 bg-slate-800 rounded-2xl text-white flex justify-between items-center">
                    <span class="text-sm font-semibold">Estimasi Total</span>
                    <span class="text-2xl font-black" id="totalPrice">Rp 0</span>
                </div>
            </div>

            <div class="bg-white rounded-3xl border border-slate-100 shadow-xl p-8">
                <label for="notes" class="block text-sm font-semibold text-slate-700 mb-2">Catatan Tambahan</label>
                <textarea id="notes" name="notes" rows="3"
                    class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-rose-500">{{ old('notes') }}</textarea>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('test-requests.index') }}"
                    class="px-5 py-2.5 text-sm font-semibold text-slate-700 bg-white border border-slate-300 rounded-xl hover:bg-slate-50">Batal</a>
                <button type="submit"
                    class="px-8 py-3 text-sm font-semibold text-white bg-gradient-to-r from-rose-600 to-pink-600 rounded-xl shadow-lg hover:from-rose-500 hover:to-pink-500 transform hover:-translate-y-0.5 transition-all">Ajukan
                    Permohonan</button>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            function filterParameters() {
                const type = document.getElementById('sample_type').value;
                const typeMap = { tanah: 'tanah', air: 'air', jaringan_tanaman: 'jaringan_tanaman' };
                document.querySelectorAll('.parameter-group').forEach(g => {
                    g.style.display = (!type || g.dataset.category === type) ? '' : 'none';
                });
                updateTotal();
            }
            function updateTotal() {
                let total = 0;
                const numSamples = parseInt(document.getElementById('num_samples').value) || 1;
                document.querySelectorAll('.param-checkbox:checked').forEach(cb => {
                    const item = cb.closest('.param-item');
                    total += parseFloat(item.dataset.price) || 0;
                });
                total *= numSamples;
                document.getElementById('totalPrice').textContent = 'Rp ' + total.toLocaleString('id-ID');
            }
            document.getElementById('num_samples')?.addEventListener('input', updateTotal);
            filterParameters();
        </script>
    @endpush
@endsection
