@extends('layouts.admin')

@section('content')
    <div class="space-y-8 animate-fade-in">
        <!-- Page Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white/5 backdrop-blur-md border border-white/10 rounded-2xl p-6 shadow-xl relative overflow-hidden">
            <div class="absolute -top-24 -right-24 w-64 h-64 bg-navy-500/20 rounded-full mix-blend-screen filter blur-[80px] animate-pulse-slow"></div>
            <div class="relative z-10">
                <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight mb-1">Manajemen Role</h1>
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3 text-sm text-slate-500 font-medium">
                        <li>
                            <a href="{{ route('admin.home') }}" class="hover:text-navy-600 transition-colors">Dashboard</a>
                        </li>
                        <li><span class="mx-2">/</span></li>
                        <li class="text-navy-600 font-semibold" aria-current="page">Role</li>
                    </ol>
                </nav>
            </div>
            <div class="relative z-10">
                <a href="{{ route('admin.roles.create') }}" class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-navy-600 to-navy-600 rounded-xl hover:from-navy-500 hover:to-navy-500 transition-all shadow-lg hover:shadow-navy-500/30 transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gold-500">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Role
                </a>
            </div>
        </div>

        <!-- Alert Messages -->
        @if(session('success'))
            <div class="p-4 mb-4 text-sm text-emerald-800 rounded-xl bg-emerald-50 border border-emerald-200 flex items-center justify-between shadow-sm animate-fade-in" role="alert" id="successAlert">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
                <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-emerald-50 text-emerald-500 rounded-lg focus:ring-2 focus:ring-emerald-400 p-1.5 hover:bg-emerald-200 inline-flex h-8 w-8 transition-colors" onclick="document.getElementById('successAlert').style.display = 'none'" aria-label="Close">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="p-4 mb-4 text-sm text-rose-800 rounded-xl bg-rose-50 border border-rose-200 flex items-center justify-between shadow-sm animate-fade-in" role="alert" id="errorAlert">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="font-medium">{{ session('error') }}</span>
                </div>
                <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-rose-50 text-rose-500 rounded-lg focus:ring-2 focus:ring-rose-400 p-1.5 hover:bg-rose-200 inline-flex h-8 w-8 transition-colors" onclick="document.getElementById('errorAlert').style.display = 'none'" aria-label="Close">
                     <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
            </div>
        @endif

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Total Roles -->
            <div class="relative group rounded-3xl bg-white border border-slate-100 p-6 shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden transform hover:-translate-y-1">
                <div class="absolute inset-x-0 bottom-0 h-1 bg-gradient-to-r from-navy-400 to-navy-500 transform scale-x-0 group-hover:scale-x-100 transition-transform origin-left duration-300"></div>
                <div class="flex flex-col mb-2">
                    <div class="w-14 h-14 rounded-2xl bg-navy-50 border border-navy-100 flex items-center justify-center text-navy-600 mb-4 group-hover:bg-navy-600 group-hover:text-white transition-colors duration-300 shadow-sm">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                </div>
                <div>
                    <h4 class="text-slate-500 text-sm font-semibold uppercase tracking-wider mb-1">Total Role Terdaftar</h4>
                    <h1 class="text-3xl font-black text-slate-800 tracking-tight">{{ number_format($roles->total()) }}</h1>
                </div>
            </div>

            <!-- Total Users -->
            <div class="relative group rounded-3xl bg-white border border-slate-100 p-6 shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden transform hover:-translate-y-1">
                <div class="absolute inset-x-0 bottom-0 h-1 bg-gradient-to-r from-emerald-400 to-teal-500 transform scale-x-0 group-hover:scale-x-100 transition-transform origin-left duration-300"></div>
                <div class="flex flex-col mb-2">
                    <div class="w-14 h-14 rounded-2xl bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-600 mb-4 group-hover:bg-emerald-600 group-hover:text-white transition-colors duration-300 shadow-sm">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                </div>
                <div>
                    <h4 class="text-slate-500 text-sm font-semibold uppercase tracking-wider mb-1">Total Pengguna Terkait</h4>
                    <h1 class="text-3xl font-black text-slate-800 tracking-tight">{{ number_format($roles->sum('users_count')) }}</h1>
                </div>
            </div>

            <!-- Empty Roles -->
            <div class="relative group rounded-3xl bg-white border border-slate-100 p-6 shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden transform hover:-translate-y-1">
                <div class="absolute inset-x-0 bottom-0 h-1 bg-gradient-to-r from-amber-400 to-orange-500 transform scale-x-0 group-hover:scale-x-100 transition-transform origin-left duration-300"></div>
                <div class="flex flex-col mb-2">
                    <div class="w-14 h-14 rounded-2xl bg-amber-50 border border-amber-100 flex items-center justify-center text-amber-600 mb-4 group-hover:bg-amber-600 group-hover:text-white transition-colors duration-300 shadow-sm">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div>
                    <h4 class="text-slate-500 text-sm font-semibold uppercase tracking-wider mb-1">Role Tanpa Pengguna</h4>
                    <h1 class="text-3xl font-black text-slate-800 tracking-tight">{{ number_format($roles->filter(fn($r) => $r->users_count == 0)->count()) }}</h1>
                </div>
            </div>
        </div>

        <!-- Table Card -->
        <div class="bg-white rounded-3xl border border-slate-100 shadow-xl shadow-slate-200/40 overflow-hidden">
            <div class="px-8 py-6 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-slate-50/50">
                <div>
                    <h4 class="text-xl font-bold text-slate-800 mb-1">Daftar Role</h4>
                    <p class="text-sm text-slate-500">Kelola peran akses level sistem anda</p>
                </div>
                <form method="GET" action="{{ route('admin.roles.index') }}" class="w-full sm:w-auto flex gap-2">
                    <div class="relative w-full sm:w-64">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" class="block w-full pl-10 pr-3 py-2 border border-slate-200 rounded-xl leading-5 bg-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-gold-500 focus:border-gold-500 sm:text-sm transition-colors" placeholder="Cari role...">
                    </div>
                    @if(request('search'))
                        <a href="{{ route('admin.roles.index') }}" class="inline-flex items-center px-4 py-2 border border-slate-200 shadow-sm text-sm font-medium rounded-xl text-slate-700 bg-white hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gold-500 transition-colors">
                            Reset
                        </a>
                    @endif
                    <button type="submit" class="hidden sm:inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-xl text-white bg-navy-600 hover:bg-navy-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gold-500 transition-colors">
                        Cari
                    </button>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-max">
                    <thead>
                        <tr class="bg-white border-b border-slate-100 text-slate-500 text-xs font-bold uppercase tracking-widest">
                            <th class="px-8 py-5 w-16 text-center">#</th>
                            <th class="px-8 py-5">Nama Role</th>
                            <th class="px-8 py-5">Slug</th>
                            <th class="px-8 py-5">Deskripsi</th>
                            <th class="px-8 py-5 text-center">Pengguna</th>
                            <th class="px-8 py-5 text-center">Dibuat</th>
                            <th class="px-8 py-5 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 text-sm">
                        @forelse($roles as $index => $role)
                            <tr class="hover:bg-slate-50/80 transition-colors group">
                                <td class="px-8 py-4 text-center text-slate-400 font-medium">
                                    {{ $roles->firstItem() + $index }}
                                </td>
                                <td class="px-8 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-navy-50 border border-navy-100 flex items-center justify-center text-navy-500 shadow-sm group-hover:bg-navy-500 group-hover:text-white transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                            </svg>
                                        </div>
                                        <span class="text-slate-800 font-bold text-sm">{{ $role->name }}</span>
                                    </div>
                                </td>
                                <td class="px-8 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium font-mono bg-slate-100 text-slate-600 border border-slate-200">
                                        {{ $role->slug }}
                                    </span>
                                </td>
                                <td class="px-8 py-4 text-slate-500 font-medium truncate max-w-sm">
                                    {{ $role->description ?? '-' }}
                                </td>
                                <td class="px-8 py-4 text-center whitespace-nowrap">
                                    @if($role->users_count > 0)
                                        <a href="{{ route('admin.roles.show', $role) }}" class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700 border border-emerald-200 hover:bg-emerald-200 transition-colors">
                                            {{ $role->users_count }}
                                        </a>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-500 border border-slate-200">
                                            0
                                        </span>
                                    @endif
                                </td>
                                <td class="px-8 py-4 text-slate-500 whitespace-nowrap text-center font-medium">
                                    {{ $role->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-8 py-4 whitespace-nowrap text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('admin.roles.show', $role) }}" class="p-1.5 rounded-lg text-cyan-600 hover:bg-cyan-50 hover:text-cyan-700 transition-colors focus:ring-2 focus:ring-cyan-500" title="Detail">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </a>
                                        <a href="{{ route('admin.roles.edit', $role) }}" class="p-1.5 rounded-lg text-amber-500 hover:bg-amber-50 hover:text-amber-600 transition-colors focus:ring-2 focus:ring-amber-400" title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </a>
                                        <button type="button" class="p-1.5 rounded-lg text-rose-500 hover:bg-rose-50 hover:text-rose-600 transition-colors focus:ring-2 focus:ring-rose-400" title="Hapus" onclick="confirmDelete('{{ $role->name }}', '{{ route('admin.roles.destroy', $role) }}')">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-8 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-16 h-16 rounded-full bg-slate-50 border border-slate-100 flex items-center justify-center text-slate-400 mb-4">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                            </svg>
                                        </div>
                                        <h5 class="text-slate-800 font-bold mb-1">Tidak ada role ditemukan</h5>
                                        <p class="text-sm text-slate-500">
                                            @if(request('search'))
                                                Pencarian untuk "{{ request('search') }}" tidak menghasilkan kecocokan.
                                            @else
                                                Belum ada role yang diregistrasikan di sistem.
                                            @endif
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($roles->hasPages())
                <div class="px-8 py-4 border-t border-slate-100 bg-slate-50/50">
                    {{ $roles->links('pagination::tailwind') }}
                </div>
            @endif
        </div>
    </div>

    <!-- Delete Confirmation Modal (Tailwind Modal) -->
    <div id="deleteModal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <!-- Background backdrop -->
        <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm transition-opacity" aria-hidden="true"></div>

        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-md border border-slate-100">
                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-rose-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-rose-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                <h3 class="text-base font-semibold leading-6 text-slate-900" id="modal-title">Konfirmasi Hapus Role</h3>
                                <div class="mt-2">
                                    <p class="text-sm text-slate-500">Apakah Anda yakin ingin menghapus role <span id="deleteRoleName" class="font-bold text-slate-800"></span>? Aksi ini tidak dapat dibatalkan.</p>
                                    <p class="text-xs text-rose-500 mt-2 font-medium bg-rose-50 p-2 rounded border border-rose-100">Catatan: Role yang masih memiliki pengguna aktif tidak dapat dihapus.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-slate-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 border-t border-slate-100">
                        <form id="deleteForm" method="POST" class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-3">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex w-full justify-center rounded-xl bg-rose-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-rose-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-rose-600 sm:w-auto transition-colors">Ya, Hapus Role</button>
                        </form>
                        <button type="button" onclick="closeModal()" class="mt-3 inline-flex w-full justify-center rounded-xl bg-white px-4 py-2 text-sm font-semibold text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50 sm:mt-0 sm:w-auto transition-colors">Batal</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Styles to support keyframes as fallback if not in tailwind config -->
    <style>
        @keyframes fade-in {
            0% { opacity: 0; transform: translateY(10px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fade-in 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        @keyframes pulse-slow {
            0%, 100% { opacity: 0.2; transform: scale(1); }
            50% { opacity: 0.3; transform: scale(1.05); }
        }
        .animate-pulse-slow {
            animation: pulse-slow 8s ease-in-out infinite;
        }
    </style>

    <script>
        function confirmDelete(name, url) {
            document.getElementById('deleteRoleName').textContent = name;
            document.getElementById('deleteForm').action = url;
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }
    </script>
@endsection
