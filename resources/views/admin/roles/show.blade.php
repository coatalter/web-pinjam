@extends('layouts.admin')

@section('content')
    <div class="space-y-6 animate-fade-in">
        <!-- Header & Breadcrumbs -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.roles.index') }}"
                    class="flex items-center justify-center w-10 h-10 rounded-xl bg-white border border-slate-200 text-slate-500 hover:text-navy-600 hover:border-navy-200 hover:bg-navy-50 transition-all shadow-sm focus:outline-none focus:ring-2 focus:ring-gold-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Detail Role</h1>
                    <nav class="flex mt-1" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 md:space-x-2 text-xs text-slate-500 font-medium">
                            <li><a href="{{ route('admin.home') }}"
                                    class="hover:text-navy-600 transition-colors">Dashboard</a></li>
                            <li><span class="mx-1 text-slate-300">/</span></li>
                            <li><a href="{{ route('admin.roles.index') }}"
                                    class="hover:text-navy-600 transition-colors">Role</a></li>
                            <li><span class="mx-1 text-slate-300">/</span></li>
                            <li class="text-navy-600 font-semibold truncate max-w-[150px] sm:max-w-xs"
                                aria-current="page">{{ $role->name }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.roles.edit', $role) }}"
                    class="inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-amber-600 bg-amber-50 border border-amber-200 rounded-xl hover:bg-amber-100 hover:border-amber-300 transition-all shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                        </path>
                    </svg>
                    Edit Role
                </a>
                <button type="button"
                    onclick="confirmDelete('{{ $role->name }}', '{{ route('admin.roles.destroy', $role) }}')"
                    class="inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-rose-600 bg-rose-50 border border-rose-200 rounded-xl hover:bg-rose-100 hover:border-rose-300 transition-all shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                        </path>
                    </svg>
                    Hapus
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column: Role Details & Timestamps -->
            <div class="space-y-6 lg:col-span-1">
                <!-- Role Info Card -->
                <div
                    class="bg-white rounded-3xl border border-slate-100 shadow-xl shadow-slate-200/40 relative overflow-hidden group hover:-translate-y-1 transition-transform duration-300">
                    <div class="absolute inset-x-0 bottom-0 h-1 bg-gradient-to-r from-navy-400 to-cyan-400"></div>
                    <!-- Decorative BG -->
                    <div class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 bg-navy-50 rounded-full blur-2xl opacity-60">
                    </div>

                    <div class="p-8 text-center relative z-10">
                        <div
                            class="w-20 h-20 mx-auto rounded-full bg-navy-50 border border-navy-100 flex items-center justify-center text-navy-500 shadow-sm mb-4">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                </path>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-black text-slate-800 mb-1">{{ $role->name }}</h2>
                        <span
                            class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold font-mono bg-slate-100 text-slate-600 border border-slate-200 mb-4">
                            #{{ $role->slug }}
                        </span>
                        <p class="text-sm text-slate-500 mb-6 leading-relaxed">
                            {{ $role->description ?? 'Tidak ada deskripsi rinci untuk role ini.' }}</p>

                        <div class="pt-6 border-t border-slate-100 grid grid-cols-2 gap-4">
                            <div class="text-center p-3 rounded-2xl bg-slate-50 border border-slate-100">
                                <h3 class="text-2xl font-bold text-navy-600">{{ $role->users_count }}</h3>
                                <p class="text-xs uppercase tracking-wider font-semibold text-slate-500 mt-1">Pengguna</p>
                            </div>
                            <!-- Jika model menu dan relationship tidak ada, tampilkan 0 atau hapus -->
                            <div class="text-center p-3 rounded-2xl bg-slate-50 border border-slate-100">
                                <h3 class="text-2xl font-bold text-emerald-600">
                                    {{ method_exists($role, 'menus') ? $role->menus->count() : '-' }}</h3>
                                <p class="text-xs uppercase tracking-wider font-semibold text-slate-500 mt-1">Menu Akses</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Timestamps Card -->
                <div class="bg-white rounded-3xl border border-slate-100 shadow-xl shadow-slate-200/40 p-6">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-4 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Informasi Sistem
                    </h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center py-2 border-b border-slate-50">
                            <span class="text-sm font-medium text-slate-500">ID Role</span>
                            <span
                                class="text-sm font-mono font-semibold text-slate-800">{{ str_pad($role->id, 4, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:justify-between py-2 border-b border-slate-50 gap-1">
                            <span class="text-sm font-medium text-slate-500">Dibuat</span>
                            <span
                                class="text-sm font-semibold text-slate-800">{{ $role->created_at->format('d M Y, H:i') }}</span>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:justify-between py-2 gap-1">
                            <span class="text-sm font-medium text-slate-500">Terakhir Update</span>
                            <span
                                class="text-sm font-semibold text-slate-800">{{ $role->updated_at->format('d M Y, H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: User List -->
            <div class="lg:col-span-2">
                <div
                    class="bg-white rounded-3xl border border-slate-100 shadow-xl shadow-slate-200/40 overflow-hidden h-full flex flex-col">
                    <div class="px-8 py-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                        <div>
                            <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                                <svg class="w-5 h-5 text-navy-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                    </path>
                                </svg>
                                Pengguna Terhubung
                            </h3>
                            <p class="text-sm text-slate-500 mt-1">Daftar pengguna yang ditugaskan dengan role ini.</p>
                        </div>
                        <span
                            class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-navy-100 text-navy-700 font-bold text-sm">
                            {{ $role->users_count }}
                        </span>
                    </div>

                    <div class="flex-1 overflow-x-auto">
                        @if($role->users->count() > 0)
                            <table class="w-full text-left border-collapse min-w-max">
                                <thead>
                                    <tr
                                        class="bg-white border-b border-slate-100 text-slate-500 text-xs font-bold uppercase tracking-widest">
                                        <th class="px-8 py-4 w-16 text-center">#</th>
                                        <th class="px-8 py-4">Data Pengguna</th>
                                        <th class="px-8 py-4 text-center">Status</th>
                                        <th class="px-8 py-4 text-right">Bergabung</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-50 text-sm">
                                    @foreach($role->users as $i => $user)
                                        <tr class="hover:bg-slate-50/80 transition-colors group">
                                            <td class="px-8 py-4 text-center text-slate-400 font-medium">
                                                {{ $i + 1 }}
                                            </td>
                                            <td class="px-8 py-4 whitespace-nowrap">
                                                <div class="flex items-center gap-3">
                                                    <div
                                                        class="w-10 h-10 rounded-full bg-gradient-to-br from-navy-500 to-navy-500 text-white flex items-center justify-center font-bold shadow-sm ring-2 ring-white">
                                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                                    </div>
                                                    <div>
                                                        <p class="font-bold text-slate-800">{{ $user->name }}</p>
                                                        <p class="text-xs text-slate-500 font-medium">{{ $user->email }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-8 py-4 text-center whitespace-nowrap">
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700 border border-emerald-200">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span>
                                                    Aktif
                                                </span>
                                            </td>
                                            <td class="px-8 py-4 text-slate-500 whitespace-nowrap text-right font-medium">
                                                {{ $user->created_at->format('M d, Y') }}
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
                                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                        </path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-bold text-slate-800 mb-1">Belum Ada Pengguna</h3>
                                <p class="text-sm text-slate-500 max-w-sm mx-auto">Tidak ada satupun pengguna di sistem yang
                                    saat ini diberikan hak akses dari role ini.</p>

                                <a href="#"
                                    class="mt-6 inline-flex items-center px-4 py-2 text-sm font-semibold text-navy-600 bg-navy-50 rounded-xl hover:bg-navy-100 transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                                        </path>
                                    </svg>
                                    Tugaskan Pengguna Baru
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal (Tailwind Modal) -->
    <div id="deleteModal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <!-- Background backdrop -->
        <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm transition-opacity" aria-hidden="true"></div>

        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div
                    class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-md border border-slate-100">
                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div
                                class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-rose-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-rose-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                <h3 class="text-base font-semibold leading-6 text-slate-900" id="modal-title">Konfirmasi
                                    Hapus Role</h3>
                                <div class="mt-2">
                                    <p class="text-sm text-slate-500">Apakah Anda yakin ingin menghapus role <span
                                            id="deleteRoleName" class="font-bold text-slate-800"></span>? Aksi ini tidak
                                        dapat dibatalkan.</p>
                                    <p
                                        class="text-xs text-rose-500 mt-2 font-medium bg-rose-50 p-2 rounded border border-rose-100">
                                        Catatan: Role yang masih memiliki pengguna aktif tidak dapat dihapus.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-slate-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 border-t border-slate-100">
                        <form id="deleteForm" method="POST" class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-3">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="inline-flex w-full justify-center rounded-xl bg-rose-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-rose-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-rose-600 sm:w-auto transition-colors">Ya,
                                Hapus</button>
                        </form>
                        <button type="button" onclick="closeModal()"
                            class="mt-3 inline-flex w-full justify-center rounded-xl bg-white px-4 py-2 text-sm font-semibold text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50 sm:mt-0 sm:w-auto transition-colors">Batal</button>
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