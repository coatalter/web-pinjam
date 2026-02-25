@extends('layouts.admin')

@section('content')
    <div class="space-y-6 animate-fade-in">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.rooms.index') }}"
                    class="flex items-center justify-center w-10 h-10 rounded-xl bg-white border border-slate-200 text-slate-500 hover:text-teal-600 hover:border-teal-200 hover:bg-teal-50 transition-all shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-slate-800">Detail Ruangan</h1>
                    <nav class="flex mt-1">
                        <ol class="inline-flex items-center space-x-2 text-xs text-slate-500 font-medium">
                            <li><a href="{{ route('admin.home') }}" class="hover:text-teal-600">Dashboard</a></li>
                            <li><span class="mx-1 text-slate-300">/</span></li>
                            <li><a href="{{ route('admin.rooms.index') }}" class="hover:text-teal-600">Ruangan</a></li>
                            <li><span class="mx-1 text-slate-300">/</span></li>
                            <li class="text-teal-600 font-semibold truncate max-w-[150px]">{{ $room->name }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.rooms.edit', $room) }}"
                    class="inline-flex items-center px-4 py-2 text-sm font-semibold text-amber-600 bg-amber-50 border border-amber-200 rounded-xl hover:bg-amber-100 transition-all shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                        </path>
                    </svg>
                    Edit
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Room Info -->
            <div class="space-y-6 lg:col-span-1">
                <div
                    class="bg-white rounded-3xl border border-slate-100 shadow-xl shadow-slate-200/40 relative overflow-hidden">
                    <div class="absolute inset-x-0 bottom-0 h-1 bg-gradient-to-r from-teal-400 to-emerald-400"></div>
                    <div class="p-8 text-center relative z-10">
                        <div
                            class="w-20 h-20 mx-auto rounded-full {{ $room->scope === 'universitas' ? 'bg-navy-50 border-navy-100 text-navy-500' : 'bg-amber-50 border-amber-100 text-amber-500' }} border flex items-center justify-center shadow-sm mb-4">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                </path>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-black text-slate-800 mb-1">{{ $room->name }}</h2>
                        <span
                            class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold font-mono bg-slate-100 text-slate-600 border border-slate-200 mb-2">{{ $room->code }}</span>
                        <div class="mt-2">
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $room->scope === 'universitas' ? 'bg-navy-100 text-navy-700 border border-navy-200' : 'bg-amber-100 text-amber-700 border border-amber-200' }}">{{ ucfirst($room->scope) }}</span>
                            @if($room->faculty)<span
                            class="block text-sm text-slate-500 mt-1">{{ $room->faculty }}</span>@endif
                        </div>

                        <div class="pt-6 mt-6 border-t border-slate-100 grid grid-cols-2 gap-4">
                            <div class="text-center p-3 rounded-2xl bg-slate-50 border border-slate-100">
                                <h3 class="text-2xl font-bold text-teal-600">{{ $room->capacity }}</h3>
                                <p class="text-xs uppercase tracking-wider font-semibold text-slate-500 mt-1">Kapasitas</p>
                            </div>
                            <div class="text-center p-3 rounded-2xl bg-slate-50 border border-slate-100">
                                <h3 class="text-2xl font-bold text-navy-600">{{ $room->bookings_count }}</h3>
                                <p class="text-xs uppercase tracking-wider font-semibold text-slate-500 mt-1">Booking</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-3xl border border-slate-100 shadow-xl shadow-slate-200/40 p-6">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-4">Detail Info</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center py-2 border-b border-slate-50">
                            <span class="text-sm font-medium text-slate-500">Lokasi</span>
                            <span class="text-sm font-semibold text-slate-800">{{ $room->location ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-slate-50">
                            <span class="text-sm font-medium text-slate-500">Status</span>
                            @if($room->is_active)
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700 border border-emerald-200"><span
                                        class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span>Aktif</span>
                            @else
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-500 border border-slate-200">Nonaktif</span>
                            @endif
                        </div>
                        <div class="py-2">
                            <span class="text-sm font-medium text-slate-500 block mb-2">Fasilitas</span>
                            <p class="text-sm text-slate-700 bg-slate-50 p-3 rounded-xl border border-slate-100">
                                {{ $room->facilities ?? 'Tidak ada informasi fasilitas.' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Upcoming Bookings -->
            <div class="lg:col-span-2">
                <div
                    class="bg-white rounded-3xl border border-slate-100 shadow-xl shadow-slate-200/40 overflow-hidden h-full flex flex-col">
                    <div class="px-8 py-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                        <div>
                            <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                                <svg class="w-5 h-5 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                                Jadwal Mendatang
                            </h3>
                            <p class="text-sm text-slate-500 mt-1">Peminjaman aktif & pending untuk ruangan ini.</p>
                        </div>
                    </div>

                    <div class="flex-1 overflow-x-auto">
                        @if($upcomingBookings->count() > 0)
                            <table class="w-full text-left border-collapse min-w-max">
                                <thead>
                                    <tr
                                        class="bg-white border-b border-slate-100 text-slate-500 text-xs font-bold uppercase tracking-widest">
                                        <th class="px-8 py-4">Tanggal</th>
                                        <th class="px-8 py-4">Waktu</th>
                                        <th class="px-8 py-4">Peminjam</th>
                                        <th class="px-8 py-4">Tujuan</th>
                                        <th class="px-8 py-4 text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-50 text-sm">
                                    @foreach($upcomingBookings as $booking)
                                        <tr class="hover:bg-slate-50/80 transition-colors">
                                            <td class="px-8 py-4 font-semibold text-slate-800">
                                                {{ $booking->booking_date->format('d M Y') }}</td>
                                            <td class="px-8 py-4 text-slate-600 font-mono text-xs">
                                                {{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }} –
                                                {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}</td>
                                            <td class="px-8 py-4">
                                                <div class="flex items-center gap-2">
                                                    <div
                                                        class="w-8 h-8 rounded-full bg-gradient-to-br from-teal-500 to-emerald-500 text-white flex items-center justify-center font-bold text-xs">
                                                        {{ strtoupper(substr($booking->user->name, 0, 1)) }}</div>
                                                    <span class="font-medium text-slate-800">{{ $booking->user->name }}</span>
                                                </div>
                                            </td>
                                            <td class="px-8 py-4 text-slate-500 truncate max-w-[200px]">{{ $booking->purpose }}</td>
                                            <td class="px-8 py-4 text-center">
                                                @php $colors = ['pending' => 'amber', 'approved' => 'emerald', 'rejected' => 'rose', 'finished' => 'sky'];
                                                $c = $colors[$booking->status] ?? 'slate'; @endphp
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-{{ $c }}-100 text-{{ $c }}-700 border border-{{ $c }}-200">{{ $booking->status_label }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="flex flex-col items-center justify-center p-12 h-full text-center">
                                <div
                                    class="w-20 h-20 rounded-full bg-slate-50 border border-slate-100 flex items-center justify-center text-slate-300 mb-4">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-bold text-slate-800 mb-1">Belum Ada Jadwal</h3>
                                <p class="text-sm text-slate-500 max-w-sm mx-auto">Ruangan ini belum memiliki peminjaman aktif
                                    untuk hari mendatang.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        @keyframes fade-in {
            0% {
                opacity: 0;
                transform: translateY(10px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fade-in 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
    </style>
@endsection