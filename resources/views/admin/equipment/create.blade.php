@extends('layouts.admin')

@section('content')
    <div class="space-y-8 animate-fade-in">
        <div
            class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white/5 backdrop-blur-md border border-white/10 rounded-2xl p-6 shadow-xl relative overflow-hidden">
            <div class="relative z-10">
                <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight mb-1">
                    {{ isset($equipment) ? 'Edit Alat' : 'Tambah Alat' }}</h1>
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3 text-sm text-slate-500 font-medium">
                        <li><a href="{{ route('admin.home') }}"
                                class="hover:text-indigo-600 transition-colors">Dashboard</a></li>
                        <li><span class="mx-2">/</span></li>
                        <li><a href="{{ route('admin.equipment.index') }}"
                                class="hover:text-indigo-600 transition-colors">Alat</a></li>
                        <li><span class="mx-2">/</span></li>
                        <li class="text-indigo-600 font-semibold" aria-current="page">
                            {{ isset($equipment) ? 'Edit' : 'Tambah' }}</li>
                    </ol>
                </nav>
            </div>
        </div>

        @if($errors->any())
            <div class="p-4 text-sm text-rose-800 rounded-xl bg-rose-50 border border-rose-200">
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-3xl border border-slate-100 shadow-xl shadow-slate-200/40 overflow-hidden">
            <form method="POST"
                action="{{ isset($equipment) ? route('admin.equipment.update', $equipment) : route('admin.equipment.store') }}"
                class="p-8 space-y-6">
                @csrf
                @if(isset($equipment)) @method('PUT') @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">Nama Alat <span
                                class="text-rose-500">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name', $equipment->name ?? '') }}"
                            class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            required>
                    </div>
                    <div>
                        <label for="code" class="block text-sm font-semibold text-slate-700 mb-2">Kode Alat <span
                                class="text-rose-500">*</span></label>
                        <input type="text" id="code" name="code" value="{{ old('code', $equipment->code ?? '') }}"
                            class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            required>
                    </div>
                    <div>
                        <label for="category" class="block text-sm font-semibold text-slate-700 mb-2">Kategori <span
                                class="text-rose-500">*</span></label>
                        <select id="category" name="category"
                            class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            required>
                            <option value="general" {{ old('category', $equipment->category ?? '') === 'general' ? 'selected' : '' }}>Umum</option>
                            <option value="soil" {{ old('category', $equipment->category ?? '') === 'soil' ? 'selected' : '' }}>Tanah</option>
                            <option value="water" {{ old('category', $equipment->category ?? '') === 'water' ? 'selected' : '' }}>Air</option>
                            <option value="plant_tissue" {{ old('category', $equipment->category ?? '') === 'plant_tissue' ? 'selected' : '' }}>Jaringan Tanaman</option>
                        </select>
                    </div>
                    <div>
                        <label for="room_id" class="block text-sm font-semibold text-slate-700 mb-2">Ruangan</label>
                        <select id="room_id" name="room_id"
                            class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">— Tidak ditentukan —</option>
                            @foreach($rooms as $room)
                                <option value="{{ $room->id }}" {{ old('room_id', $equipment->room_id ?? '') == $room->id ? 'selected' : '' }}>{{ $room->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="condition" class="block text-sm font-semibold text-slate-700 mb-2">Kondisi <span
                                class="text-rose-500">*</span></label>
                        <select id="condition" name="condition"
                            class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            required>
                            <option value="baik" {{ old('condition', $equipment->condition ?? '') === 'baik' ? 'selected' : '' }}>Baik</option>
                            <option value="rusak_ringan" {{ old('condition', $equipment->condition ?? '') === 'rusak_ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                            <option value="rusak_berat" {{ old('condition', $equipment->condition ?? '') === 'rusak_berat' ? 'selected' : '' }}>Rusak Berat</option>
                        </select>
                    </div>
                    <div class="flex items-center pt-8">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_available" class="sr-only peer" {{ old('is_available', $equipment->is_available ?? true) ? 'checked' : '' }}>
                            <div
                                class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600">
                            </div>
                            <span class="ml-3 text-sm font-semibold text-slate-700">Tersedia</span>
                        </label>
                    </div>
                </div>

                <div>
                    <label for="description" class="block text-sm font-semibold text-slate-700 mb-2">Deskripsi</label>
                    <textarea id="description" name="description" rows="3"
                        class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">{{ old('description', $equipment->description ?? '') }}</textarea>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                    <a href="{{ route('admin.equipment.index') }}"
                        class="inline-flex items-center px-5 py-2.5 text-sm font-semibold text-slate-700 bg-white border border-slate-300 rounded-xl hover:bg-slate-50 transition-colors">Batal</a>
                    <button type="submit"
                        class="inline-flex items-center px-5 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-indigo-600 to-violet-600 rounded-xl hover:from-indigo-500 hover:to-violet-500 transition-all shadow-lg hover:shadow-indigo-500/30">
                        {{ isset($equipment) ? 'Simpan Perubahan' : 'Tambah Alat' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection