@extends('layouts.admin')

@section('content')
    <div class="space-y-8 ">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white/5 backdrop-blur-md border border-white/10 rounded-2xl p-6 shadow-xl relative overflow-hidden">
            <div class="absolute -top-24 -right-24 w-64 h-64 bg-indigo-500/20 rounded-full mix-blend-screen filter blur-[80px] animate-pulse-slow"></div>
            <div class="relative z-10">
                <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight mb-1">Manajemen Alat</h1>
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3 text-sm text-slate-500 font-medium">
                        <li><a href="{{ route('admin.home') }}" class="hover:text-indigo-600 transition-colors">Dashboard</a></li>
                        <li><span class="mx-2">/</span></li>
                        <li class="text-indigo-600 font-semibold" aria-current="page">Alat</li>
                    </ol>
                </nav>
            </div>
            <div class="relative z-10">
                <a href="{{ route('admin.equipment.create') }}" class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-indigo-600 to-violet-600 rounded-xl hover:from-indigo-500 hover:to-violet-500 transition-all shadow-lg hover:shadow-indigo-500/30 transform hover:-translate-y-0.5">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Tambah Alat
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

        <!-- Filter & Table -->
        <div id="table-container" class="bg-white rounded-3xl border border-slate-100 shadow-xl shadow-slate-200/40 overflow-hidden table-transition">
            <div class="px-8 py-6 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-slate-50/50">
                <div>
                    <h4 class="text-xl font-bold text-slate-800 mb-1">Daftar Alat Laboratorium</h4>
                    <p class="text-sm text-slate-500">Kelola data alat dan peralatan Lab Terpadu</p>
                </div>
                <form method="GET" action="{{ route('admin.equipment.index') }}" class="w-full sm:w-auto flex gap-2 flex-wrap" hx-target="#table-container" hx-select="#table-container" hx-swap="outerHTML swap:200ms settle:200ms" hx-push-url="true">
                    <select name="category" class="block px-3 py-2 border border-slate-200 rounded-xl text-sm bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" onchange="this.form.submit()">
                        <option value="">Semua Kategori</option>
                        <option value="general" {{ request('category') === 'general' ? 'selected' : '' }}>Umum</option>
                        <option value="soil" {{ request('category') === 'soil' ? 'selected' : '' }}>Tanah</option>
                        <option value="water" {{ request('category') === 'water' ? 'selected' : '' }}>Air</option>
                        <option value="plant_tissue" {{ request('category') === 'plant_tissue' ? 'selected' : '' }}>Jaringan Tanaman</option>
                    </select>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" class="block w-full pl-10 pr-3 py-2 border border-slate-200 rounded-xl text-sm bg-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Cari alat...">
                    </div>
                    @if(request('search') || request('category'))
                        <a href="{{ route('admin.equipment.index') }}" class="inline-flex items-center px-4 py-2 border border-slate-200 text-sm font-medium rounded-xl text-slate-700 bg-white hover:bg-slate-50 transition-colors">Reset</a>
                    @endif
                </form>
            </div>

            <div class="overflow-x-auto hidden md:block">
                <table class="w-full text-left border-collapse min-w-max">
                    <thead>
                        <tr class="bg-white border-b border-slate-100 text-slate-500 text-xs font-bold uppercase tracking-widest">
                            <th class="px-8 py-5 w-16 text-center">#</th>
                            <th class="px-8 py-5">Nama Alat</th>
                            <th class="px-8 py-5">Kode</th>
                            <th class="px-8 py-5">Kategori</th>
                            <th class="px-8 py-5">Ruangan</th>
                            <th class="px-8 py-5 text-center">Kondisi</th>
                            <th class="px-8 py-5 text-center">Status</th>
                            <th class="px-8 py-5 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 text-sm">
                        @forelse($equipment as $index => $item)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="px-8 py-4 text-center text-slate-400 font-medium">{{ $equipment->firstItem() + $index }}</td>
                                <td class="px-8 py-4 font-bold text-slate-800">{{ $item->name }}</td>
                                <td class="px-8 py-4"><span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium font-mono bg-slate-100 text-slate-600 border border-slate-200">{{ $item->code }}</span></td>
                                <td class="px-8 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold
                                        {{ $item->category === 'soil' ? 'bg-amber-100 text-amber-700 border border-amber-200' : '' }}
                                        {{ $item->category === 'water' ? 'bg-cyan-100 text-cyan-700 border border-cyan-200' : '' }}
                                        {{ $item->category === 'plant_tissue' ? 'bg-green-100 text-green-700 border border-green-200' : '' }}
                                        {{ $item->category === 'general' ? 'bg-slate-100 text-slate-600 border border-slate-200' : '' }}
                                    ">{{ $item->category_label }}</span>
                                </td>
                                <td class="px-8 py-4 text-slate-500">{{ $item->room?->name ?? '-' }}</td>
                                <td class="px-8 py-4 text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold
                                        {{ $item->condition === 'baik' ? 'bg-emerald-100 text-emerald-700' : '' }}
                                        {{ $item->condition === 'rusak_ringan' ? 'bg-amber-100 text-amber-700' : '' }}
                                        {{ $item->condition === 'rusak_berat' ? 'bg-rose-100 text-rose-700' : '' }}
                                    ">{{ $item->condition_label }}</span>
                                </td>
                                <td class="px-8 py-4 text-center">
                                    @if($item->is_available)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700 border border-emerald-200"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span>Tersedia</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-500 border border-slate-200">Tidak Tersedia</span>
                                    @endif
                                </td>
                                <td class="px-8 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('admin.equipment.edit', $item) }}" class="p-1.5 rounded-lg text-amber-500 hover:bg-amber-50 transition-colors" title="Edit"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg></a>
                                        <form method="POST" action="{{ route('admin.equipment.destroy', $item) }}" class="inline" onsubmit="return confirm('Hapus alat ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-1.5 rounded-lg text-rose-500 hover:bg-rose-50 transition-colors" title="Hapus"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-8 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-16 h-16 rounded-full bg-slate-50 border border-slate-100 flex items-center justify-center text-slate-400 mb-4">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                                        </div>
                                        <h5 class="text-slate-800 font-bold mb-1">Tidak ada alat ditemukan</h5>
                                        <p class="text-sm text-slate-500">Belum ada alat yang terdaftar di sistem.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Mobile Card View -->
            <div class="md:hidden divide-y divide-slate-100">
                @forelse($equipment as $item)
                    <div class="p-4">
                        <div class="flex items-start justify-between mb-2 gap-2">
                            <div class="flex-1 min-w-0">
                                <h5 class="text-sm font-bold text-slate-800 truncate">{{ $item->name }}</h5>
                                <p class="text-xs font-mono text-slate-500 mt-0.5">{{ $item->code }}</p>
                            </div>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold shrink-0
                                {{ $item->category === 'soil' ? 'bg-amber-100 text-amber-700 border border-amber-200' : '' }}
                                {{ $item->category === 'water' ? 'bg-cyan-100 text-cyan-700 border border-cyan-200' : '' }}
                                {{ $item->category === 'plant_tissue' ? 'bg-green-100 text-green-700 border border-green-200' : '' }}
                                {{ $item->category === 'general' ? 'bg-slate-100 text-slate-600 border border-slate-200' : '' }}
                            ">{{ $item->category_label }}</span>
                        </div>
                        <div class="text-xs text-slate-500 mb-3 space-y-1">
                            <p><strong>Ruangan:</strong> {{ $item->room?->name ?? '-' }}</p>
                            <p class="flex items-center gap-1">
                                <strong>Status:</strong> 
                                @if($item->is_available)
                                    <span class="text-emerald-600 font-medium">Tersedia</span>
                                @else
                                    <span class="text-slate-400 font-medium">Tidak Tersedia</span>
                                @endif
                                <span class="mx-1">•</span>
                                <span class="{{ $item->condition === 'baik' ? 'text-emerald-600' : ($item->condition === 'rusak_ringan' ? 'text-amber-600' : 'text-rose-600') }}">{{ $item->condition_label }}</span>
                            </p>
                        </div>
                        <div class="flex justify-end gap-1 pt-2 border-t border-slate-50">
                            <a href="{{ route('admin.equipment.edit', $item) }}" class="inline-flex items-center px-4 py-1.5 text-xs font-semibold text-amber-700 bg-amber-50 rounded-lg hover:bg-amber-100">Edit</a>
                            <form method="POST" action="{{ route('admin.equipment.destroy', $item) }}" onsubmit="return confirm('Hapus alat ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="inline-flex items-center px-4 py-1.5 text-xs font-semibold text-rose-700 bg-rose-50 rounded-lg hover:bg-rose-100">Hapus</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-slate-400 text-sm">Belum ada alat terdaftar.</div>
                @endforelse
            </div>

            @if($equipment->hasPages())
                <div class="px-6 sm:px-8 py-4 border-t border-slate-100 bg-slate-50/50">
                    {{ $equipment->links('pagination::tailwind') }}
                </div>
            @endif
        </div>
    </div>

    <style>
        @keyframes fade-in { 0% { opacity:0; transform:translateY(10px); } 100% { opacity:1; transform:translateY(0); } }
        . { animation: fade-in 0.5s cubic-bezier(0.16,1,0.3,1) forwards; }
        @keyframes pulse-slow { 0%,100% { opacity:0.2; } 50% { opacity:0.3; } }
        .animate-pulse-slow { animation: pulse-slow 8s ease-in-out infinite; }
    </style>
@endsection
