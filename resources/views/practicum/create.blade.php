@extends('layouts.admin')

@section('content')
    <div class="space-y-8 animate-fade-in">
        <div class="bg-white/5 backdrop-blur-md border border-white/10 rounded-2xl p-6 shadow-xl">
            <h1 class="text-3xl font-extrabold text-slate-800 mb-1">Daftar Praktikum</h1>
            <nav class="flex">
                <ol class="inline-flex items-center text-sm text-slate-500">
                    <li><a href="{{ route('home') }}">Dashboard</a></li>
                    <li><span class="mx-2">/</span></li>
                    <li><a href="{{ route('practicum.index') }}">Praktikum</a></li>
                    <li><span class="mx-2">/</span></li>
                    <li class="text-sky-600 font-semibold">Daftar</li>
                </ol>
            </nav>
        </div>

        @if($errors->any())
            <div class="p-4 text-sm text-rose-800 rounded-xl bg-rose-50 border border-rose-200">
                <ul class="list-disc list-inside">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif

        <form method="POST" action="{{ route('practicum.store') }}" class="space-y-8">
            @csrf

            <div class="bg-white rounded-3xl border border-slate-100 shadow-xl p-8">
                <h3 class="text-lg font-bold text-slate-800 mb-6">Informasi Praktikum</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="course_name" class="block text-sm font-semibold text-slate-700 mb-2">Mata Kuliah <span
                                class="text-rose-500">*</span></label>
                        <input type="text" id="course_name" name="course_name" value="{{ old('course_name') }}"
                            class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-sky-500"
                            required>
                    </div>
                    <div>
                        <label for="class_name" class="block text-sm font-semibold text-slate-700 mb-2">Kelas <span
                                class="text-rose-500">*</span></label>
                        <input type="text" id="class_name" name="class_name" value="{{ old('class_name') }}"
                            class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-sky-500"
                            required placeholder="Contoh: A1, B2">
                    </div>
                    <div>
                        <label for="lecturer_name" class="block text-sm font-semibold text-slate-700 mb-2">Dosen Pengampu
                            <span class="text-rose-500">*</span></label>
                        <input type="text" id="lecturer_name" name="lecturer_name" value="{{ old('lecturer_name') }}"
                            class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-sky-500"
                            required>
                    </div>
                    <div>
                        <label for="num_students" class="block text-sm font-semibold text-slate-700 mb-2">Jumlah Mahasiswa
                            <span class="text-rose-500">*</span></label>
                        <input type="number" id="num_students" name="num_students" value="{{ old('num_students') }}" min="1"
                            class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-sky-500"
                            required>
                    </div>
                    <div>
                        <label for="semester" class="block text-sm font-semibold text-slate-700 mb-2">Semester <span
                                class="text-rose-500">*</span></label>
                        <select id="semester" name="semester"
                            class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-sky-500"
                            required>
                            <option value="">— Pilih —</option>
                            <option value="Ganjil" {{ old('semester') === 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                            <option value="Genap" {{ old('semester') === 'Genap' ? 'selected' : '' }}>Genap</option>
                        </select>
                    </div>
                    <div>
                        <label for="academic_year" class="block text-sm font-semibold text-slate-700 mb-2">Tahun Akademik
                            <span class="text-rose-500">*</span></label>
                        <input type="text" id="academic_year" name="academic_year"
                            value="{{ old('academic_year', date('Y') . '/' . (date('Y') + 1)) }}"
                            class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-sky-500"
                            required placeholder="2026/2027">
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-3xl border border-slate-100 shadow-xl p-8">
                <h3 class="text-lg font-bold text-slate-800 mb-6">Jadwal & Ruangan</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="room_id" class="block text-sm font-semibold text-slate-700 mb-2">Ruangan <span
                                class="text-rose-500">*</span></label>
                        <select id="room_id" name="room_id"
                            class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-sky-500"
                            required>
                            <option value="">— Pilih Ruangan —</option>
                            @foreach($rooms as $room)
                                <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>
                                    {{ $room->name }} (Kap. {{ $room->capacity }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="schedule_date" class="block text-sm font-semibold text-slate-700 mb-2">Tanggal <span
                                class="text-rose-500">*</span></label>
                        <input type="date" id="schedule_date" name="schedule_date" value="{{ old('schedule_date') }}"
                            class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-sky-500"
                            required>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label for="start_time" class="block text-sm font-semibold text-slate-700 mb-2">Mulai <span
                                    class="text-rose-500">*</span></label>
                            <input type="time" id="start_time" name="start_time" value="{{ old('start_time') }}"
                                class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-sky-500"
                                required>
                        </div>
                        <div>
                            <label for="end_time" class="block text-sm font-semibold text-slate-700 mb-2">Selesai <span
                                    class="text-rose-500">*</span></label>
                            <input type="time" id="end_time" name="end_time" value="{{ old('end_time') }}"
                                class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-sky-500"
                                required>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Equipment Selection -->
            <div class="bg-white rounded-3xl border border-slate-100 shadow-xl p-8">
                <h3 class="text-lg font-bold text-slate-800 mb-2">Alat yang Dibutuhkan</h3>
                <p class="text-sm text-slate-500 mb-6">Opsional — pilih alat yang akan digunakan selama praktikum.</p>
                <div id="equipment-list" class="space-y-3">
                    <div class="flex items-center gap-3 equipment-row">
                        <select name="equipment[0][id]"
                            class="flex-1 px-4 py-3 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-sky-500">
                            <option value="">— Pilih Alat —</option>
                            @foreach($equipment as $eq)
                                <option value="{{ $eq->id }}">{{ $eq->name }} ({{ $eq->code }})</option>
                            @endforeach
                        </select>
                        <input type="number" name="equipment[0][quantity]" min="1" value="1"
                            class="w-24 px-4 py-3 border border-slate-200 rounded-xl text-sm" placeholder="Qty">
                    </div>
                </div>
                <button type="button" onclick="addEquipmentRow()"
                    class="mt-3 inline-flex items-center text-sm text-sky-600 hover:text-sky-800 font-semibold">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Alat
                </button>
            </div>

            <div class="bg-white rounded-3xl border border-slate-100 shadow-xl p-8">
                <label for="notes" class="block text-sm font-semibold text-slate-700 mb-2">Catatan</label>
                <textarea id="notes" name="notes" rows="3"
                    class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-sky-500">{{ old('notes') }}</textarea>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('practicum.index') }}"
                    class="px-5 py-2.5 text-sm font-semibold text-slate-700 bg-white border border-slate-300 rounded-xl hover:bg-slate-50">Batal</a>
                <button type="submit"
                    class="px-8 py-3 text-sm font-semibold text-white bg-gradient-to-r from-sky-600 to-blue-600 rounded-xl shadow-lg hover:from-sky-500 hover:to-blue-500 transform hover:-translate-y-0.5 transition-all">Daftarkan
                    Praktikum</button>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            let eqIndex = 1;
            function addEquipmentRow() {
                const list = document.getElementById('equipment-list');
                const row = document.createElement('div');
                row.className = 'flex items-center gap-3 equipment-row';
                row.innerHTML = `
                        <select name="equipment[${eqIndex}][id]" class="flex-1 px-4 py-3 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-sky-500">
                            <option value="">— Pilih Alat —</option>
                            @foreach($equipment as $eq)
                                <option value="{{ $eq->id }}">{{ $eq->name }} ({{ $eq->code }})</option>
                            @endforeach
                        </select>
                        <input type="number" name="equipment[${eqIndex}][quantity]" min="1" value="1" class="w-24 px-4 py-3 border border-slate-200 rounded-xl text-sm" placeholder="Qty">
                        <button type="button" onclick="this.closest('.equipment-row').remove()" class="p-2 text-rose-500 hover:bg-rose-50 rounded-lg"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                    `;
                list.appendChild(row);
                eqIndex++;
            }
        </script>
    @endpush
@endsection