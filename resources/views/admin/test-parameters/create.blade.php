@extends('layouts.admin')

@section('content')
    <div class="space-y-8 ">
        <div class="bg-white/5 backdrop-blur-md border border-white/10 rounded-2xl p-6 shadow-xl">
            <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight mb-1">
                {{ isset($testParameter) ? 'Edit Parameter' : 'Tambah Parameter' }}</h1>
            <nav class="flex">
                <ol class="inline-flex items-center text-sm text-slate-500 font-medium">
                    <li><a href="{{ route('admin.home') }}" class="hover:text-purple-600">Dashboard</a></li>
                    <li><span class="mx-2">/</span></li>
                    <li><a href="{{ route('admin.test-parameters.index') }}" class="hover:text-purple-600">Parameter</a>
                    </li>
                    <li><span class="mx-2">/</span></li>
                    <li class="text-purple-600 font-semibold">{{ isset($testParameter) ? 'Edit' : 'Tambah' }}</li>
                </ol>
            </nav>
        </div>

        @if($errors->any())
            <div class="p-4 text-sm text-rose-800 rounded-xl bg-rose-50 border border-rose-200">
                <ul class="list-disc list-inside">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif

        <div class="bg-white rounded-3xl border border-slate-100 shadow-xl overflow-hidden">
            <form method="POST"
                action="{{ isset($testParameter) ? route('admin.test-parameters.update', $testParameter) : route('admin.test-parameters.store') }}"
                class="p-8 space-y-6">
                @csrf
                @if(isset($testParameter)) @method('PUT') @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">Nama Parameter <span
                                class="text-rose-500">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name', $testParameter->name ?? '') }}"
                            class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-purple-500"
                            required>
                    </div>
                    <div>
                        <label for="category" class="block text-sm font-semibold text-slate-700 mb-2">Kategori <span
                                class="text-rose-500">*</span></label>
                        <select id="category" name="category"
                            class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-purple-500"
                            required>
                            <option value="soil" {{ old('category', $testParameter->category ?? '') === 'soil' ? 'selected' : '' }}>Tanah</option>
                            <option value="water" {{ old('category', $testParameter->category ?? '') === 'water' ? 'selected' : '' }}>Air</option>
                            <option value="plant_tissue" {{ old('category', $testParameter->category ?? '') === 'plant_tissue' ? 'selected' : '' }}>Jaringan Tanaman</option>
                        </select>
                    </div>
                    <div>
                        <label for="unit" class="block text-sm font-semibold text-slate-700 mb-2">Satuan</label>
                        <input type="text" id="unit" name="unit" value="{{ old('unit', $testParameter->unit ?? '') }}"
                            class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-purple-500"
                            placeholder="contoh: mg/L, ppm, %">
                    </div>
                    <div>
                        <label for="method" class="block text-sm font-semibold text-slate-700 mb-2">Metode Pengujian</label>
                        <input type="text" id="method" name="method"
                            value="{{ old('method', $testParameter->method ?? '') }}"
                            class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-purple-500"
                            placeholder="contoh: SNI 06-6989.11-2004">
                    </div>
                    <div>
                        <label for="price" class="block text-sm font-semibold text-slate-700 mb-2">Harga (Rp) <span
                                class="text-rose-500">*</span></label>
                        <input type="number" id="price" name="price" value="{{ old('price', $testParameter->price ?? 0) }}"
                            class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-purple-500"
                            min="0" step="1000" required>
                    </div>
                    <div class="flex items-center pt-8">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_active" class="sr-only peer" {{ old('is_active', $testParameter->is_active ?? true) ? 'checked' : '' }}>
                            <div
                                class="w-11 h-6 bg-slate-200 peer-focus:ring-4 peer-focus:ring-purple-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-600">
                            </div>
                            <span class="ml-3 text-sm font-semibold text-slate-700">Aktif</span>
                        </label>
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                    <a href="{{ route('admin.test-parameters.index') }}"
                        class="px-5 py-2.5 text-sm font-semibold text-slate-700 bg-white border border-slate-300 rounded-xl hover:bg-slate-50">Batal</a>
                    <button type="submit"
                        class="px-5 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-purple-600 to-fuchsia-600 rounded-xl hover:from-purple-500 hover:to-fuchsia-500 shadow-lg">{{ isset($testParameter) ? 'Simpan Perubahan' : 'Tambah Parameter' }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection
