@extends('layouts.user')

@section('content')
    <div class="space-y-6 animate-fade-in">
        <div class="flex items-center gap-4">
            <a href="{{ route('bookings.index') }}" class="flex items-center justify-center w-10 h-10 rounded-xl bg-white border border-slate-200 text-slate-500 hover:text-cyan-600 hover:border-cyan-200 hover:bg-cyan-50 transition-all shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Ajukan Peminjaman Ruangan</h1>
                <p class="text-sm text-slate-500 mt-1">Isi form berikut untuk mengajukan peminjaman</p>
            </div>
        </div>

        @if(session('error'))
            <div class="p-4 text-sm text-rose-800 rounded-xl bg-rose-50 border border-rose-200 flex items-center shadow-sm">
                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
        @endif

        <div class="flex justify-center">
            <div class="w-full max-w-4xl">
                <div class="bg-white border border-slate-100 rounded-3xl shadow-xl shadow-slate-200/40 overflow-hidden relative">
                    <div class="absolute top-0 right-0 -mt-16 -mr-16 w-64 h-64 bg-gradient-to-br from-cyan-500/10 to-teal-500/10 rounded-full blur-3xl pointer-events-none"></div>
                    <div class="px-8 py-6 border-b border-slate-100 flex items-center gap-4 bg-slate-50/50 relative z-10">
                        <div class="w-12 h-12 rounded-2xl bg-cyan-50 border border-cyan-100 flex items-center justify-center text-cyan-600 shadow-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-slate-800">Form Peminjaman</h2>
                            <p class="text-sm text-slate-500">Pilih ruangan, tanggal, dan waktu yang diinginkan.</p>
                        </div>
                    </div>

                    <div class="p-8 relative z-10">
                        <form action="{{ route('bookings.store') }}" method="POST" class="space-y-6">
                            @csrf

                            <div class="space-y-2">
                                <label for="room_id" class="block text-sm font-bold text-slate-700">Pilih Ruangan <span class="text-rose-500">*</span></label>
                                <select id="room_id" name="room_id" class="block w-full px-4 py-3 bg-slate-50 border @error('room_id') border-rose-300 @else border-slate-200 @enderror rounded-xl text-sm focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 focus:bg-white focus:outline-none">
                                    <option value="">-- Pilih Ruangan --</option>
                                    @foreach($rooms as $room)
                                        <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>
                                            {{ $room->name }} ({{ $room->code }}) — {{ ucfirst($room->scope) }}{{ $room->faculty ? ', ' . $room->faculty : '' }} — Kapasitas: {{ $room->capacity }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('room_id')<p class="text-sm text-rose-500 mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div class="space-y-2">
                                    <label for="booking_date" class="block text-sm font-bold text-slate-700">Tanggal <span class="text-rose-500">*</span></label>
                                    <input type="date" id="booking_date" name="booking_date" min="{{ date('Y-m-d') }}" class="block w-full px-4 py-3 bg-slate-50 border @error('booking_date') border-rose-300 @else border-slate-200 @enderror rounded-xl text-sm focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 focus:bg-white focus:outline-none" value="{{ old('booking_date') }}">
                                    @error('booking_date')<p class="text-sm text-rose-500 mt-1">{{ $message }}</p>@enderror
                                </div>
                                <div class="space-y-2">
                                    <label for="start_time" class="block text-sm font-bold text-slate-700">Jam Mulai <span class="text-rose-500">*</span></label>
                                    <input type="time" id="start_time" name="start_time" class="block w-full px-4 py-3 bg-slate-50 border @error('start_time') border-rose-300 @else border-slate-200 @enderror rounded-xl text-sm focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 focus:bg-white focus:outline-none" value="{{ old('start_time') }}">
                                    @error('start_time')<p class="text-sm text-rose-500 mt-1">{{ $message }}</p>@enderror
                                </div>
                                <div class="space-y-2">
                                    <label for="end_time" class="block text-sm font-bold text-slate-700">Jam Selesai <span class="text-rose-500">*</span></label>
                                    <input type="time" id="end_time" name="end_time" class="block w-full px-4 py-3 bg-slate-50 border @error('end_time') border-rose-300 @else border-slate-200 @enderror rounded-xl text-sm focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 focus:bg-white focus:outline-none" value="{{ old('end_time') }}">
                                    @error('end_time')<p class="text-sm text-rose-500 mt-1">{{ $message }}</p>@enderror
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label for="purpose" class="block text-sm font-bold text-slate-700">Tujuan Penggunaan <span class="text-rose-500">*</span></label>
                                <input type="text" id="purpose" name="purpose" class="block w-full px-4 py-3 bg-slate-50 border @error('purpose') border-rose-300 @else border-slate-200 @enderror rounded-xl text-sm focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 focus:bg-white focus:outline-none" value="{{ old('purpose') }}" placeholder="Contoh: Praktikum Jaringan Komputer, Rapat BEM, Seminar Nasional">
                                @error('purpose')<p class="text-sm text-rose-500 mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div class="space-y-2">
                                <label for="notes" class="block text-sm font-bold text-slate-700">Catatan Tambahan</label>
                                <textarea id="notes" name="notes" rows="3" class="block w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 focus:bg-white focus:outline-none resize-y" placeholder="Informasi tambahan...">{{ old('notes') }}</textarea>
                            </div>

                            <div class="p-4 bg-amber-50 border border-amber-200 rounded-xl">
                                <div class="flex items-start gap-3">
                                    <svg class="w-5 h-5 text-amber-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                    <div>
                                        <h4 class="text-sm font-bold text-amber-800">Perhatian</h4>
                                        <p class="text-xs text-amber-700 mt-1">Peminjaman harus menunggu persetujuan admin. Anda akan menerima notifikasi saat peminjaman disetujui atau ditolak.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="pt-4 border-t border-slate-100 flex flex-col-reverse sm:flex-row justify-end gap-3">
                                <a href="{{ route('bookings.index') }}" class="inline-flex justify-center items-center px-5 py-2.5 text-sm font-semibold text-slate-700 bg-white border border-slate-300 rounded-xl hover:bg-slate-50 transition-colors shadow-sm">Batal</a>
                                <button type="submit" class="inline-flex justify-center items-center px-6 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-cyan-600 to-teal-600 rounded-xl hover:from-cyan-500 hover:to-teal-500 transition-all shadow-lg shadow-cyan-500/20">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                                    Ajukan Peminjaman
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>@keyframes fade-in { 0% { opacity:0; transform:translateY(10px); } 100% { opacity:1; transform:translateY(0); } } .animate-fade-in { animation: fade-in 0.5s cubic-bezier(0.16,1,0.3,1) forwards; }</style>
@endsection
