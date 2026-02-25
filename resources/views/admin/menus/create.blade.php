@extends('layouts.admin')

@section('content')
    <div class="space-y-6 animate-fade-in">
        <!-- Header & Breadcrumbs -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.menus.index') }}"
                    class="flex items-center justify-center w-10 h-10 rounded-xl bg-white border border-slate-200 text-slate-500 hover:text-indigo-600 hover:border-indigo-200 hover:bg-indigo-50 transition-all shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Tambah Menu Baru</h1>
                    <nav class="flex mt-1" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 md:space-x-2 text-xs text-slate-500 font-medium">
                            <li><a href="{{ route('admin.home') }}"
                                    class="hover:text-indigo-600 transition-colors">Dashboard</a></li>
                            <li><span class="mx-1 text-slate-300">/</span></li>
                            <li><a href="{{ route('admin.menus.index') }}"
                                    class="hover:text-indigo-600 transition-colors">Menu</a></li>
                            <li><span class="mx-1 text-slate-300">/</span></li>
                            <li class="text-indigo-600 font-semibold" aria-current="page">Tambah</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="flex justify-center flex-grow">
            <div class="w-full max-w-4xl">
                <!-- Main Form Card -->
                <div
                    class="bg-white border border-slate-100 rounded-3xl shadow-xl shadow-slate-200/40 overflow-hidden relative">
                    <div
                        class="absolute top-0 right-0 -mt-16 -mr-16 w-64 h-64 bg-gradient-to-br from-indigo-500/10 to-purple-500/10 rounded-full blur-3xl pointer-events-none">
                    </div>

                    <div class="px-8 py-6 border-b border-slate-100 flex items-center gap-4 bg-slate-50/50 relative z-10">
                        <div
                            class="w-12 h-12 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 shadow-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-slate-800">Detail Navigasi</h2>
                            <p class="text-sm text-slate-500">Susun tautan navigasi dengan memilih route dan mengatur akses
                                perannya.</p>
                        </div>
                    </div>

                    <div class="p-8 relative z-10">
                        <form action="{{ route('admin.menus.store') }}" method="POST" class="space-y-6">
                            @csrf

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Nama Menu -->
                                <div class="space-y-2 md:col-span-2">
                                    <label class="block text-sm font-bold text-slate-700">
                                        Nama Menu <span class="text-rose-500">*</span>
                                    </label>
                                    <input type="text" name="name" required
                                        class="block w-full px-4 py-3 bg-slate-50 border border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl text-sm transition-all focus:bg-white focus:outline-none"
                                        placeholder="Contoh: Pengaturan Pengguna">
                                </div>

                                <!-- Parent Menu -->
                                <div class="space-y-2">
                                    <label class="block text-sm font-bold text-slate-700">
                                        Parent Menu (Induk)
                                    </label>
                                    <div class="relative">
                                        <select name="parent_id"
                                            class="block w-full px-4 py-3 pr-10 bg-slate-50 border border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl text-sm transition-all focus:bg-white focus:outline-none appearance-none">
                                            <option value="">-- Tidak Ada (Jadikan Menu Utama) --</option>
                                            @foreach($menus as $parent)
                                                <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                                            @endforeach
                                        </select>
                                        <div
                                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-500">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <p class="text-xs text-slate-400">Pilih jika menu ini adalah sub-menu dari menu lain.
                                    </p>
                                </div>

                                <!-- Route Name -->
                                <div class="space-y-2">
                                    <label class="block text-sm font-bold text-slate-700">Route Name</label>
                                    <input type="text" name="route_name"
                                        class="block w-full px-4 py-3 bg-slate-50 border border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl text-sm transition-all focus:bg-white focus:outline-none font-mono"
                                        placeholder="contoh: admin.users.index">
                                </div>

                                <!-- Icon -->
                                <div class="space-y-2">
                                    <label class="block text-sm font-bold text-slate-700">Icon (Feather)</label>
                                    <input type="text" name="icon"
                                        class="block w-full px-4 py-3 bg-slate-50 border border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl text-sm transition-all focus:bg-white focus:outline-none font-mono"
                                        placeholder="contoh: users">
                                    <p class="text-xs text-slate-400">Lihat referensi ikon di <a
                                            href="https://feathericons.com/" target="_blank"
                                            class="text-indigo-500 hover:underline">feathericons.com</a>.</p>
                                </div>

                                <!-- Sort Order -->
                                <div class="space-y-2">
                                    <label class="block text-sm font-bold text-slate-700">Urutan (Sort Order)</label>
                                    <input type="number" name="sort_order" min="0" value="0"
                                        class="block w-full px-4 py-3 bg-slate-50 border border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl text-sm transition-all focus:bg-white focus:outline-none font-mono">
                                    <p class="text-xs text-slate-400">Angka yang lebih kecil akan tampil lebih atas pada
                                        sidebar.</p>
                                </div>
                            </div>

                            <!-- Roles Access Matrix -->
                            <div class="pt-6 border-t border-slate-100">
                                <label class="block text-sm font-bold text-slate-700 mb-4">
                                    Hak Akses Peran <span class="text-rose-500">*</span>
                                </label>
                                <div class="bg-indigo-50/50 border border-indigo-100 rounded-xl p-5">
                                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                                        @foreach($roles as $role)
                                            <div
                                                class="relative flex items-start p-3 border border-indigo-100 bg-white rounded-lg hover:border-indigo-300 transition-colors shadow-sm">
                                                <div class="flex h-6 items-center">
                                                    <input id="role-{{ $role->id }}" name="roles[]" value="{{ $role->id }}"
                                                        type="checkbox"
                                                        class="h-4 w-4 rounded border-indigo-300 text-indigo-600 focus:ring-indigo-600 transition-colors cursor-pointer">
                                                </div>
                                                <div class="ml-3 text-sm leading-6">
                                                    <label for="role-{{ $role->id }}"
                                                        class="font-semibold text-slate-800 cursor-pointer select-none">{{ $role->name }}</label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    @error('roles')
                                        <p class="text-sm text-rose-500 mt-3 flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            Minimal pilih satu role yang dapat mengakses menu ini.
                                        </p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Is Active Toggle -->
                            <div class="flex items-center gap-3 pt-2">
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="is_active" value="1" class="sr-only peer" checked>
                                    <div
                                        class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500 shadow-inner">
                                    </div>
                                </label>
                                <span class="text-sm font-bold text-slate-700 select-none">Tampilkan Menu (Aktif)</span>
                            </div>

                            <!-- Actions -->
                            <div
                                class="pt-6 mt-8 border-t border-slate-100 flex flex-col-reverse sm:flex-row justify-end gap-3">
                                <a href="{{ route('admin.menus.index') }}"
                                    class="inline-flex justify-center items-center px-5 py-2.5 text-sm font-semibold text-slate-700 bg-white border border-slate-300 rounded-xl hover:bg-slate-50 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 shadow-sm">
                                    Batal
                                </a>
                                <button type="submit"
                                    class="inline-flex justify-center items-center px-6 py-2.5 text-sm font-semibold text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 shadow-sm shadow-indigo-600/20">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4">
                                        </path>
                                    </svg>
                                    Simpan Menu
                                </button>
                            </div>
                        </form>
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