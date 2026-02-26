@extends('layouts.user')

@section('content')
    <div class="space-y-8 animate-fade-in">
        <!-- Welcome -->
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-navy-600 via-navy-500 to-navy-700 p-8 shadow-xl">
            <div class="absolute -top-20 -right-20 w-64 h-64 bg-gold-500/10 rounded-full blur-3xl"></div>
            <div class="relative z-10">
                <h1 class="text-3xl font-extrabold text-white tracking-tight">Selamat Datang, {{ Auth::user()->name }}! 👋</h1>
                <p class="text-navy-100 mt-2 max-w-xl">Ajukan peminjaman ruangan dengan mudah dan cepat.</p>
                <a href="{{ route('bookings.create') }}" class="inline-flex items-center mt-4 px-5 py-2.5 text-sm font-bold text-navy-900 bg-gold-500 rounded-xl hover:bg-gold-400 transition-all shadow-md">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Ajukan Peminjaman
                </a>
            </div>
        </div>

        <!-- Stats -->
        @php
            $myBookings = \App\Models\Booking::where('user_id', Auth::id());
            $stats = [
                ['label' => 'Total Peminjaman', 'value' => $myBookings->count(), 'bg' => 'bg-navy-50', 'text' => 'text-navy-600', 'border' => 'border-navy-100', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
                ['label' => 'Menunggu', 'value' => (clone $myBookings)->where('status','pending')->count(), 'bg' => 'bg-gold-50', 'text' => 'text-gold-700', 'border' => 'border-gold-100', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                ['label' => 'Disetujui', 'value' => (clone $myBookings)->where('status','approved')->count(), 'bg' => 'bg-success-50', 'text' => 'text-success-600', 'border' => 'border-success-100', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                ['label' => 'Ruangan Tersedia', 'value' => \App\Models\Room::where('is_active', true)->count(), 'bg' => 'bg-sky-50', 'text' => 'text-sky-600', 'border' => 'border-sky-100', 'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5'],
            ];
        @endphp
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach($stats as $stat)
                <div class="relative group rounded-2xl bg-white border border-slate-100 p-5 shadow-sm hover:shadow-lg transition-all transform hover:-translate-y-0.5">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl {{ $stat['bg'] }} {{ $stat['border'] }} border flex items-center justify-center {{ $stat['text'] }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $stat['icon'] }}"></path></svg>
                        </div>
                        <div>
                            <p class="text-2xl font-black text-slate-800">{{ $stat['value'] }}</p>
                            <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">{{ $stat['label'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- My Recent Bookings -->
        <div class="bg-white rounded-3xl border border-slate-100 shadow-xl shadow-slate-200/40 overflow-hidden">
            <div class="px-6 sm:px-8 py-5 sm:py-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <div>
                    <h3 class="text-lg font-bold text-slate-800">Peminjaman Terakhir</h3>
                    <p class="text-sm text-slate-500 hidden sm:block">Riwayat peminjaman Anda</p>
                </div>
                <a href="{{ route('bookings.index') }}" class="text-sm font-semibold text-navy-600 hover:text-navy-800 transition-colors">Lihat Semua →</a>
            </div>
            @php $myRecent = \App\Models\Booking::with('room')->where('user_id', Auth::id())->latest()->take(5)->get(); @endphp

            <!-- Desktop Table -->
            <div class="overflow-x-auto hidden md:block">
                <table class="w-full text-left min-w-max">
                    <thead><tr class="text-xs text-slate-500 font-bold uppercase tracking-widest border-b border-slate-100">
                        <th class="px-8 py-4">Ruangan</th>
                        <th class="px-6 py-4">Tanggal</th>
                        <th class="px-6 py-4">Waktu</th>
                        <th class="px-6 py-4 text-center">Status</th>
                    </tr></thead>
                    <tbody class="divide-y divide-slate-50 text-sm">
                        @forelse($myRecent as $booking)
                            <tr class="hover:bg-slate-50/80 transition-colors cursor-pointer" onclick="window.location='{{ route('bookings.show', $booking) }}'">
                                <td class="px-8 py-4 font-semibold text-slate-800">{{ $booking->room->name }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ $booking->booking_date->format('d M Y') }}</td>
                                <td class="px-6 py-4 text-slate-600 font-mono text-xs">{{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }}–{{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}</td>
                                <td class="px-6 py-4 text-center">
                                    @php $c = ['pending'=>'gold','approved'=>'success','rejected'=>'danger','finished'=>'sky'][$booking->status] ?? 'slate'; @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-{{ $c }}-100 text-{{ $c }}-700 border border-{{ $c }}-200">{{ $booking->status_label }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="px-8 py-12 text-center text-slate-400">
                                <p class="mb-2">Belum ada peminjaman.</p>
                                <a href="{{ route('bookings.create') }}" class="text-navy-600 font-semibold hover:underline">Ajukan Peminjaman →</a>
                            </td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile Card View -->
            <div class="md:hidden divide-y divide-slate-100">
                @forelse($myRecent as $booking)
                    @php $c = ['pending'=>'gold','approved'=>'success','rejected'=>'danger','finished'=>'sky'][$booking->status] ?? 'slate'; @endphp
                    <a href="{{ route('bookings.show', $booking) }}" class="block p-4 hover:bg-slate-50/80 transition-colors active:bg-slate-100">
                        <div class="flex items-center justify-between mb-1.5">
                            <p class="text-sm font-semibold text-slate-800">{{ $booking->room->name }}</p>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-{{ $c }}-100 text-{{ $c }}-700 border border-{{ $c }}-200">{{ $booking->status_label }}</span>
                        </div>
                        <div class="flex items-center gap-3 text-xs text-slate-500">
                            <span>📅 {{ $booking->booking_date->format('d M Y') }}</span>
                            <span class="font-mono">🕐 {{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }}–{{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}</span>
                        </div>
                    </a>
                @empty
                    <div class="p-8 text-center text-slate-400 text-sm">
                        <p class="mb-2">Belum ada peminjaman.</p>
                        <a href="{{ route('bookings.create') }}" class="text-navy-600 font-semibold hover:underline">Ajukan Peminjaman →</a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    <style>@keyframes fade-in{0%{opacity:0;transform:translateY(10px);}100%{opacity:1;transform:translateY(0);}}.animate-fade-in{animation:fade-in .5s cubic-bezier(.16,1,.3,1) forwards;}</style>
@endsection
