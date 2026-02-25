@extends('layouts.admin')

@section('content')
    <div class="space-y-8 animate-fade-in">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white/5 backdrop-blur-md border border-white/10 rounded-2xl p-6 shadow-xl relative overflow-hidden">
            <div class="absolute -top-24 -right-24 w-64 h-64 bg-teal-500/20 rounded-full mix-blend-screen filter blur-[80px] animate-pulse-slow"></div>
            <div class="relative z-10">
                <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight mb-1">Manajemen Ruangan</h1>
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3 text-sm text-slate-500 font-medium">
                        <li><a href="{{ route('admin.home') }}" class="hover:text-teal-600 transition-colors">Dashboard</a></li>
                        <li><span class="mx-2">/</span></li>
                        <li class="text-teal-600 font-semibold" aria-current="page">Ruangan</li>
                    </ol>
                </nav>
            </div>
            <div class="relative z-10">
                <a href="{{ route('admin.rooms.create') }}" class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-teal-600 to-emerald-600 rounded-xl hover:from-teal-500 hover:to-emerald-500 transition-all shadow-lg hover:shadow-teal-500/30 transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Tambah Ruangan
                </a>
            </div>
        </div>

        <!-- Alerts -->
        @if(session('success'))
            <div class="p-4 text-sm text-emerald-800 rounded-xl bg-emerald-50 border border-emerald-200 flex items-center justify-between shadow-sm" role="alert" id="successAlert">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
                <button type="button" class="ml-auto bg-emerald-50 text-emerald-500 rounded-lg p-1.5 hover:bg-emerald-200 inline-flex h-8 w-8 transition-colors" onclick="document.getElementById('successAlert').style.display='none'"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg></button>
            </div>
        @endif
        @if(session('error'))
            <div class="p-4 text-sm text-rose-800 rounded-xl bg-rose-50 border border-rose-200 flex items-center justify-between shadow-sm" role="alert" id="errorAlert">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                    <span class="font-medium">{{ session('error') }}</span>
                </div>
                <button type="button" class="ml-auto bg-rose-50 text-rose-500 rounded-lg p-1.5 hover:bg-rose-200 inline-flex h-8 w-8 transition-colors" onclick="document.getElementById('errorAlert').style.display='none'"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg></button>
            </div>
        @endif

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="relative group rounded-3xl bg-white border border-slate-100 p-6 shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden transform hover:-translate-y-1">
                <div class="absolute inset-x-0 bottom-0 h-1 bg-gradient-to-r from-teal-400 to-emerald-500 transform scale-x-0 group-hover:scale-x-100 transition-transform origin-left duration-300"></div>
                <div class="w-14 h-14 rounded-2xl bg-teal-50 border border-teal-100 flex items-center justify-center text-teal-600 mb-4 group-hover:bg-teal-600 group-hover:text-white transition-colors duration-300 shadow-sm">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
                <h4 class="text-slate-500 text-sm font-semibold uppercase tracking-wider mb-1">Total Ruangan</h4>
                <h1 class="text-3xl font-black text-slate-800">{{ $rooms->total() }}</h1>
            </div>
            <div class="relative group rounded-3xl bg-white border border-slate-100 p-6 shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden transform hover:-translate-y-1">
                <div class="absolute inset-x-0 bottom-0 h-1 bg-gradient-to-r from-navy-400 to-navy-500 transform scale-x-0 group-hover:scale-x-100 transition-transform origin-left duration-300"></div>
                <div class="w-14 h-14 rounded-2xl bg-navy-50 border border-navy-100 flex items-center justify-center text-navy-600 mb-4 group-hover:bg-navy-600 group-hover:text-white transition-colors duration-300 shadow-sm">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"></path></svg>
                </div>
                <h4 class="text-slate-500 text-sm font-semibold uppercase tracking-wider mb-1">Ruangan Universitas</h4>
                <h1 class="text-3xl font-black text-slate-800">{{ $rooms->filter(fn($r) => $r->scope === 'universitas')->count() }}</h1>
            </div>
            <div class="relative group rounded-3xl bg-white border border-slate-100 p-6 shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden transform hover:-translate-y-1">
                <div class="absolute inset-x-0 bottom-0 h-1 bg-gradient-to-r from-amber-400 to-orange-500 transform scale-x-0 group-hover:scale-x-100 transition-transform origin-left duration-300"></div>
                <div class="w-14 h-14 rounded-2xl bg-amber-50 border border-amber-100 flex items-center justify-center text-amber-600 mb-4 group-hover:bg-amber-600 group-hover:text-white transition-colors duration-300 shadow-sm">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path></svg>
                </div>
                <h4 class="text-slate-500 text-sm font-semibold uppercase tracking-wider mb-1">Ruangan Fakultas</h4>
                <h1 class="text-3xl font-black text-slate-800">{{ $rooms->filter(fn($r) => $r->scope === 'fakultas')->count() }}</h1>
            </div>
        </div>

        <!-- Table Card -->
        <div class="bg-white rounded-3xl border border-slate-100 shadow-xl shadow-slate-200/40 overflow-hidden">
            <div class="px-8 py-6 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-slate-50/50">
                <div>
                    <h4 class="text-xl font-bold text-slate-800 mb-1">Daftar Ruangan</h4>
                    <p class="text-sm text-slate-500">Kelola data ruangan universitas dan fakultas</p>
                </div>
                <form method="GET" action="{{ route('admin.rooms.index') }}" class="w-full sm:w-auto flex gap-2 flex-wrap">
                    <select name="scope" class="block px-3 py-2 border border-slate-200 rounded-xl text-sm bg-white focus:ring-2 focus:ring-teal-500 focus:border-teal-500" onchange="this.form.submit()">
                        <option value="">Semua Scope</option>
                        <option value="universitas" {{ request('scope') === 'universitas' ? 'selected' : '' }}>Universitas</option>
                        <option value="fakultas" {{ request('scope') === 'fakultas' ? 'selected' : '' }}>Fakultas</option>
                    </select>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" class="block w-full pl-10 pr-3 py-2 border border-slate-200 rounded-xl text-sm bg-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500" placeholder="Cari ruangan...">
                    </div>
                    @if(request('search') || request('scope'))
                        <a href="{{ route('admin.rooms.index') }}" class="inline-flex items-center px-4 py-2 border border-slate-200 text-sm font-medium rounded-xl text-slate-700 bg-white hover:bg-slate-50 transition-colors">Reset</a>
                    @endif
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-max">
                    <thead>
                        <tr class="bg-white border-b border-slate-100 text-slate-500 text-xs font-bold uppercase tracking-widest">
                            <th class="px-8 py-5 w-16 text-center">#</th>
                            <th class="px-8 py-5">Ruangan</th>
                            <th class="px-8 py-5">Kode</th>
                            <th class="px-8 py-5">Scope</th>
                            <th class="px-8 py-5 text-center">Kapasitas</th>
                            <th class="px-8 py-5">Lokasi</th>
                            <th class="px-8 py-5 text-center">Status</th>
                            <th class="px-8 py-5 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 text-sm">
                        @forelse($rooms as $index => $room)
                            <tr class="hover:bg-slate-50/80 transition-colors group">
                                <td class="px-8 py-4 text-center text-slate-400 font-medium">{{ $rooms->firstItem() + $index }}</td>
                                <td class="px-8 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full {{ $room->scope === 'universitas' ? 'bg-navy-50 border-navy-100 text-navy-500' : 'bg-amber-50 border-amber-100 text-amber-500' }} border flex items-center justify-center shadow-sm">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                        </div>
                                        <span class="text-slate-800 font-bold text-sm">{{ $room->name }}</span>
                                    </div>
                                </td>
                                <td class="px-8 py-4"><span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium font-mono bg-slate-100 text-slate-600 border border-slate-200">{{ $room->code }}</span></td>
                                <td class="px-8 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $room->scope === 'universitas' ? 'bg-navy-100 text-navy-700 border border-navy-200' : 'bg-amber-100 text-amber-700 border border-amber-200' }}">
                                        {{ ucfirst($room->scope) }}
                                    </span>
                                    @if($room->faculty)
                                        <span class="block text-xs text-slate-500 mt-1">{{ $room->faculty }}</span>
                                    @endif
                                </td>
                                <td class="px-8 py-4 text-center font-semibold text-slate-700">{{ $room->capacity }}</td>
                                <td class="px-8 py-4 text-slate-500 truncate max-w-[200px]">{{ $room->location ?? '-' }}</td>
                                <td class="px-8 py-4 text-center">
                                    @if($room->is_active)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700 border border-emerald-200"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span>Aktif</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-500 border border-slate-200">Nonaktif</span>
                                    @endif
                                </td>
                                <td class="px-8 py-4 whitespace-nowrap text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('admin.rooms.show', $room) }}" class="p-1.5 rounded-lg text-cyan-600 hover:bg-cyan-50 transition-colors" title="Detail"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg></a>
                                        <a href="{{ route('admin.rooms.edit', $room) }}" class="p-1.5 rounded-lg text-amber-500 hover:bg-amber-50 transition-colors" title="Edit"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg></a>
                                        <button type="button" class="p-1.5 rounded-lg text-rose-500 hover:bg-rose-50 transition-colors" title="Hapus" onclick="confirmDelete('{{ $room->name }}', '{{ route('admin.rooms.destroy', $room) }}')"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-8 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-16 h-16 rounded-full bg-slate-50 border border-slate-100 flex items-center justify-center text-slate-400 mb-4">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                        </div>
                                        <h5 class="text-slate-800 font-bold mb-1">Tidak ada ruangan ditemukan</h5>
                                        <p class="text-sm text-slate-500">
                                            @if(request('search'))
                                                Pencarian untuk "{{ request('search') }}" tidak menghasilkan kecocokan.
                                            @else
                                                Belum ada ruangan yang terdaftar di sistem.
                                            @endif
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($rooms->hasPages())
                <div class="px-8 py-4 border-t border-slate-100 bg-slate-50/50">
                    {{ $rooms->links('pagination::tailwind') }}
                </div>
            @endif
        </div>
    </div>

    <!-- Delete Modal -->
    <div id="deleteModal" class="fixed inset-0 z-50 hidden" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm"></div>
        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4">
                <div class="relative transform overflow-hidden rounded-2xl bg-white shadow-2xl sm:w-full sm:max-w-md border border-slate-100">
                    <div class="bg-white px-6 pb-4 pt-5">
                        <div class="flex items-start gap-4">
                            <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-rose-100">
                                <svg class="h-6 w-6 text-rose-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            </div>
                            <div>
                                <h3 class="text-base font-semibold text-slate-900">Konfirmasi Hapus Ruangan</h3>
                                <p class="text-sm text-slate-500 mt-2">Apakah Anda yakin ingin menghapus ruangan <span id="deleteRoomName" class="font-bold text-slate-800"></span>?</p>
                                <p class="text-xs text-rose-500 mt-2 font-medium bg-rose-50 p-2 rounded border border-rose-100">Ruangan dengan peminjaman aktif tidak dapat dihapus.</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-slate-50 px-6 py-3 flex flex-row-reverse gap-3 border-t border-slate-100">
                        <form id="deleteForm" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit" class="inline-flex justify-center rounded-xl bg-rose-600 px-4 py-2 text-sm font-semibold text-white hover:bg-rose-500 transition-colors">Ya, Hapus</button>
                        </form>
                        <button type="button" onclick="closeModal()" class="inline-flex justify-center rounded-xl bg-white px-4 py-2 text-sm font-semibold text-slate-900 ring-1 ring-inset ring-slate-300 hover:bg-slate-50 transition-colors">Batal</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes fade-in { 0% { opacity:0; transform:translateY(10px); } 100% { opacity:1; transform:translateY(0); } }
        .animate-fade-in { animation: fade-in 0.5s cubic-bezier(0.16,1,0.3,1) forwards; }
        @keyframes pulse-slow { 0%,100% { opacity:0.2; } 50% { opacity:0.3; } }
        .animate-pulse-slow { animation: pulse-slow 8s ease-in-out infinite; }
    </style>

    <script>
        function confirmDelete(name, url) {
            document.getElementById('deleteRoomName').textContent = "'" + name + "'";
            document.getElementById('deleteForm').action = url;
            document.getElementById('deleteModal').classList.remove('hidden');
        }
        function closeModal() { document.getElementById('deleteModal').classList.add('hidden'); }
    </script>
@endsection
