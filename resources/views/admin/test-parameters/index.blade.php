@extends('layouts.admin')

@section('content')
    <div class="space-y-8 ">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white/5 backdrop-blur-md border border-white/10 rounded-2xl p-6 shadow-xl relative overflow-hidden">
            <div class="absolute -top-24 -right-24 w-64 h-64 bg-purple-500/20 rounded-full mix-blend-screen filter blur-[80px]"></div>
            <div class="relative z-10">
                <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight mb-1">Parameter Pengujian</h1>
                <nav class="flex"><ol class="inline-flex items-center space-x-1 text-sm text-slate-500 font-medium"><li><a href="{{ route('admin.home') }}" class="hover:text-purple-600">Dashboard</a></li><li><span class="mx-2">/</span></li><li class="text-purple-600 font-semibold">Parameter</li></ol></nav>
            </div>
            <div class="relative z-10">
                <a href="{{ route('admin.test-parameters.create') }}" class="inline-flex items-center px-5 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-purple-600 to-fuchsia-600 rounded-xl hover:from-purple-500 hover:to-fuchsia-500 transition-all shadow-lg hover:shadow-purple-500/30 transform hover:-translate-y-0.5">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Tambah Parameter
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="p-4 text-sm text-emerald-800 rounded-xl bg-emerald-50 border border-emerald-200 flex items-center justify-between shadow-sm" role="alert" id="successAlert">
                <div class="flex items-center"><svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg><span class="font-medium">{{ session('success') }}</span></div>
                <button type="button" class="ml-auto text-emerald-500 rounded-lg p-1.5 hover:bg-emerald-200 h-8 w-8" onclick="document.getElementById('successAlert').style.display='none'">✕</button>
            </div>
        @endif

        <div class="bg-white rounded-3xl border border-slate-100 shadow-xl shadow-slate-200/40 overflow-hidden">
            <div class="px-8 py-6 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-slate-50/50">
                <div>
                    <h4 class="text-xl font-bold text-slate-800 mb-1">Daftar Parameter</h4>
                    <p class="text-sm text-slate-500">Master data parameter pengujian (tanah, air, jaringan tanaman)</p>
                </div>
                <form method="GET" action="{{ route('admin.test-parameters.index') }}" class="w-full sm:w-auto flex gap-2 flex-wrap">
                    <select name="category" class="block px-3 py-2 border border-slate-200 rounded-xl text-sm bg-white" onchange="this.form.submit()">
                        <option value="">Semua Kategori</option>
                        <option value="soil" {{ request('category') === 'soil' ? 'selected' : '' }}>Tanah</option>
                        <option value="water" {{ request('category') === 'water' ? 'selected' : '' }}>Air</option>
                        <option value="plant_tissue" {{ request('category') === 'plant_tissue' ? 'selected' : '' }}>Jaringan Tanaman</option>
                    </select>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"><svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg></div>
                        <input type="text" name="search" value="{{ request('search') }}" class="block w-full pl-10 pr-3 py-2 border border-slate-200 rounded-xl text-sm bg-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-purple-500" placeholder="Cari parameter...">
                    </div>
                </form>
            </div>

            <!-- Desktop Table -->
            <div class="overflow-x-auto hidden md:block">
                <table class="w-full text-left border-collapse min-w-max">
                    <thead>
                        <tr class="bg-white border-b border-slate-100 text-slate-500 text-xs font-bold uppercase tracking-widest">
                            <th class="px-8 py-5 w-16 text-center">#</th>
                            <th class="px-8 py-5">Nama Parameter</th>
                            <th class="px-8 py-5">Kategori</th>
                            <th class="px-8 py-5">Satuan</th>
                            <th class="px-8 py-5">Metode</th>
                            <th class="px-8 py-5 text-right">Harga (Rp)</th>
                            <th class="px-8 py-5 text-center">Status</th>
                            <th class="px-8 py-5 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 text-sm">
                        @forelse($parameters as $index => $param)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="px-8 py-4 text-center text-slate-400">{{ $parameters->firstItem() + $index }}</td>
                                <td class="px-8 py-4 font-bold text-slate-800">{{ $param->name }}</td>
                                <td class="px-8 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold
                                        {{ $param->category === 'soil' ? 'bg-amber-100 text-amber-700' : '' }}
                                        {{ $param->category === 'water' ? 'bg-cyan-100 text-cyan-700' : '' }}
                                        {{ $param->category === 'plant_tissue' ? 'bg-green-100 text-green-700' : '' }}
                                    ">{{ $param->category_label }}</span>
                                </td>
                                <td class="px-8 py-4 text-slate-500">{{ $param->unit ?? '-' }}</td>
                                <td class="px-8 py-4 text-slate-500 truncate max-w-[200px]">{{ $param->method ?? '-' }}</td>
                                <td class="px-8 py-4 text-right font-semibold text-slate-700">{{ number_format($param->price, 0, ',', '.') }}</td>
                                <td class="px-8 py-4 text-center">
                                    @if($param->is_active)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span>Aktif</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-500">Nonaktif</span>
                                    @endif
                                </td>
                                <td class="px-8 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('admin.test-parameters.edit', $param) }}" class="p-1.5 rounded-lg text-amber-500 hover:bg-amber-50 transition-colors" title="Edit"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg></a>
                                        <form method="POST" action="{{ route('admin.test-parameters.destroy', $param) }}" class="inline" onsubmit="return confirm('Hapus parameter ini?')">@csrf @method('DELETE')
                                            <button class="p-1.5 rounded-lg text-rose-500 hover:bg-rose-50 transition-colors"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="8" class="px-8 py-12 text-center"><div class="flex flex-col items-center"><div class="w-16 h-16 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 mb-4"><svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg></div><h5 class="text-slate-800 font-bold mb-1">Belum ada parameter</h5></div></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile Card View -->
            <div class="md:hidden divide-y divide-slate-100">
                @forelse($parameters as $param)
                    <div class="p-4 block hover:bg-slate-50 transition-colors">
                        <div class="flex items-start justify-between mb-2 gap-2">
                            <h5 class="text-sm font-bold text-slate-800 truncate flex-1">{{ $param->name }}</h5>
                            <span class="inline-flex items-center justify-center px-2 py-0.5 rounded-full text-[10px] font-semibold shrink-0 text-center
                                {{ $param->category === 'soil' ? 'bg-amber-100 text-amber-700' : '' }}
                                {{ $param->category === 'water' ? 'bg-cyan-100 text-cyan-700' : '' }}
                                {{ $param->category === 'plant_tissue' ? 'bg-green-100 text-green-700' : '' }}
                            ">{{ $param->category_label }}</span>
                        </div>
                        <div class="text-xs text-slate-500 mb-3 space-y-1">
                            <p class="truncate"><strong>Metode:</strong> {{ $param->method ?? '-' }}</p>
                            <p><strong>Satuan:</strong> {{ $param->unit ?? '-' }}</p>
                            <div class="flex justify-between items-center mt-2">
                                <span class="font-mono font-bold text-slate-700">Rp {{ number_format($param->price, 0, ',', '.') }}</span>
                                @if($param->is_active)
                                    <span class="text-emerald-600 font-semibold px-2 py-0.5 bg-emerald-50 rounded">Aktif</span>
                                @else
                                    <span class="text-slate-400 font-semibold px-2 py-0.5 bg-slate-50 rounded">Nonaktif</span>
                                @endif
                            </div>
                        </div>
                        <div class="flex justify-end gap-1 pt-2 border-t border-slate-50">
                            <a href="{{ route('admin.test-parameters.edit', $param) }}" class="inline-flex items-center px-4 py-1.5 text-xs font-semibold text-amber-700 bg-amber-50 rounded-lg hover:bg-amber-100">Edit</a>
                            <form method="POST" action="{{ route('admin.test-parameters.destroy', $param) }}" onsubmit="return confirm('Hapus parameter ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="inline-flex items-center px-4 py-1.5 text-xs font-semibold text-rose-700 bg-rose-50 rounded-lg hover:bg-rose-100">Hapus</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-slate-400 text-sm">Belum ada parameter.</div>
                @endforelse
            </div>

            @if($parameters->hasPages())
                <div class="px-6 sm:px-8 py-4 border-t border-slate-100 bg-slate-50/50">{{ $parameters->links('pagination::tailwind') }}</div>
            @endif
        </div>
    </div>
@endsection
