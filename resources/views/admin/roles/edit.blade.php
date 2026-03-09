@extends('layouts.admin')

@section('content')
    <div class="space-y-6 ">
        <!-- Header & Breadcrumbs -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.roles.index') }}" class="flex items-center justify-center w-10 h-10 rounded-xl bg-white border border-slate-200 text-slate-500 hover:text-amber-600 hover:border-amber-200 hover:bg-amber-50 transition-all shadow-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Edit Role</h1>
                    <nav class="flex mt-1" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 md:space-x-2 text-xs text-slate-500 font-medium">
                            <li><a href="{{ route('admin.home') }}" class="hover:text-amber-600 transition-colors">Dashboard</a></li>
                            <li><span class="mx-1 text-slate-300">/</span></li>
                            <li><a href="{{ route('admin.roles.index') }}" class="hover:text-amber-600 transition-colors">Role</a></li>
                            <li><span class="mx-1 text-slate-300">/</span></li>
                            <li class="text-amber-600 font-semibold truncate max-w-[150px] sm:max-w-xs" aria-current="page">Edit: {{ $role->name }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="flex justify-center">
            <div class="w-full max-w-4xl">
                <!-- Main Form Card -->
                <div class="bg-white border border-slate-100 rounded-3xl shadow-xl shadow-slate-200/40 overflow-hidden relative">
                    <!-- Decorative background element -->
                    <div class="absolute top-0 right-0 -mt-16 -mr-16 w-64 h-64 bg-gradient-to-br from-amber-500/10 to-orange-500/10 rounded-full blur-3xl pointer-events-none"></div>
                    
                        <!-- Header Container with x-data for Modal -->
                        <div class="px-8 py-6 border-b border-slate-100 flex items-center justify-between gap-4 bg-slate-50/50 relative z-10" x-data="{ showHelp: false }">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-2xl bg-amber-50 border border-amber-100 flex items-center justify-center text-amber-500 shadow-sm">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                                        Edit Role: {{ $role->name }}
                                        <button @click="showHelp = true" type="button" class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-blue-100 text-blue-600 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors" title="Bantuan & Penjelasan">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        </button>
                                    </h2>
                                    <p class="text-sm border border-slate-200 bg-white px-2 py-0.5 rounded text-slate-500 font-mono inline-block mt-1">slug: {{ $role->slug }}</p>
                                </div>
                            </div>

                            <!-- Help Modal -->
                            <div x-show="showHelp" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                                    <div x-show="showHelp" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity bg-slate-900/60 backdrop-blur-sm" aria-hidden="true" @click="showHelp = false"></div>

                                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                                    <div x-show="showHelp" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block w-full max-w-lg px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-2xl shadow-2xl border border-slate-100 sm:my-8 sm:align-middle sm:p-6">
                                        <div class="sm:flex sm:items-start">
                                            <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto bg-blue-50 rounded-full sm:mx-0 sm:h-10 sm:w-10">
                                                <svg class="w-6 h-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            </div>
                                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                                <h3 class="text-lg font-bold leading-6 text-slate-800" id="modal-title">Panduan: Apa itu Role?</h3>
                                                <div class="mt-4 space-y-4 text-sm text-slate-600">
                                                    <p>
                                                        <strong>Role (Peran)</strong> adalah status jabatan yang diberikan kepada pengguna aplikasi. Misalnya: <em>"Admin"</em>, <em>"Dosen"</em>, atau <em>"Mahasiswa"</em>.
                                                    </p>
                                                    <div class="bg-slate-50 p-3 rounded-lg border border-slate-100">
                                                        <h4 class="font-bold text-slate-700 mb-1">📝 Istilah Penting:</h4>
                                                        <ul class="list-disc pl-5 space-y-2">
                                                            <li><strong>Nama Role:</strong> Nama jabatan yang mudah dibaca oleh manusia (Contoh: <span class="text-blue-600 font-medium">Admin Perusahaan</span>).</li>
                                                            <li><strong>Slug Sistem:</strong> Kode panggil khusus untuk sistem komputer. Harus huruf kecil semua tanpa spasi (Contoh: <span class="font-mono text-rose-500 bg-rose-50 px-1 py-0.5 rounded">admin_perusahaan</span>). <strong>Sebaiknya tidak diubah jika sistem sudah berjalan.</strong></li>
                                                        </ul>
                                                    </div>
                                                    <p>
                                                        Dengan mengatur role yang tepat, Anda bisa mengontrol menu dan fitur apa saja yang boleh dilihat atau diklik oleh pengguna tersebut.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-6 sm:mt-8 sm:flex sm:flex-row-reverse">
                                            <button type="button" class="inline-flex justify-center w-full px-4 py-2 text-base font-semibold text-white bg-blue-600 border border-transparent rounded-xl shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm transition-colors" @click="showHelp = false">
                                                Saya Mengerti
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <div class="p-8 relative z-10">
                        <form action="{{ route('admin.roles.update', $role) }}" method="POST" class="space-y-6">
                            @csrf
                            @method('PUT')

                            <!-- Nama Role -->
                            <div class="space-y-2">
                                <label for="name" class="block text-sm font-bold text-slate-700">
                                    Nama Role <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" id="name" name="name" 
                                    class="block w-full px-4 py-3 bg-slate-50 border @error('name') border-rose-300 ring-rose-300 @else border-slate-200 focus:border-amber-500 focus:ring-amber-500 @enderror rounded-xl text-sm transition-all focus:bg-white focus:ring-2 focus:outline-none" 
                                    value="{{ old('name', $role->name) }}" autofocus>
                                @error('name')
                                    <p class="text-sm text-rose-500 mt-1 flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Slug -->
                            <div class="space-y-2">
                                <label for="slug" class="block text-sm font-bold text-slate-700">Slug Sistem</label>
                                <div class="flex rounded-xl shadow-sm focus-within:ring-2 focus-within:ring-amber-500 focus-within:border-amber-500 transition-all">
                                    <span class="inline-flex items-center px-4 rounded-l-xl border border-r-0 @error('slug') border-rose-300 bg-rose-50 text-rose-500 @else border-slate-200 bg-slate-100 text-slate-500 @enderror text-sm font-mono">
                                        #
                                    </span>
                                    <input type="text" id="slug" name="slug" 
                                        class="flex-1 block w-full min-w-0 px-4 py-3 rounded-none rounded-r-xl bg-slate-50 text-slate-700 font-mono text-sm border @error('slug') border-rose-300 focus:ring-rose-500 focus:border-rose-500 @else border-slate-200 focus:ring-amber-500 focus:border-amber-500 @enderror transition-all focus:bg-white focus:outline-none" 
                                        value="{{ old('slug', $role->slug) }}">
                                </div>
                                @error('slug')
                                    <p class="text-sm text-rose-500 mt-1 flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                                <div class="flex items-start gap-2 mt-2 p-3 bg-amber-50 border border-amber-100 rounded-lg">
                                    <svg class="w-4 h-4 text-amber-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                    <p class="text-xs font-semibold text-amber-700">Peringatan: Mengubah slug bisa mempengaruhi kontrol akses dan middleware untuk pengguna sistem yang sudah ada.</p>
                                </div>
                            </div>

                            <!-- Deskripsi -->
                            <div class="space-y-2">
                                <label for="description" class="block text-sm font-bold text-slate-700">Deskripsi/Keterangan</label>
                                <textarea id="description" name="description" rows="3" 
                                    class="block w-full px-4 py-3 bg-slate-50 border border-slate-200 @error('description') border-rose-300 ring-rose-300 @else hover:border-slate-300 focus:border-amber-500 focus:ring-amber-500 @enderror rounded-xl text-sm transition-all focus:bg-white focus:ring-2 focus:outline-none resize-y">{{ old('description', $role->description) }}</textarea>
                                @error('description')
                                    <p class="text-sm text-rose-500 mt-1 flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Info Pengguna -->
                            @php $userCount = $role->users()->count(); @endphp
                            @if($userCount > 0)
                                <div class="flex items-center gap-3 p-4 bg-navy-50 border border-navy-100 rounded-xl">
                                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-navy-100 flex items-center justify-center text-navy-600">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-bold text-navy-800">Role Terhubung dengan Pengguna</h4>
                                        <p class="text-xs text-navy-600 mt-0.5">Role ini saat ini digunakan oleh <strong class="font-extrabold">{{ $userCount }} pengguna</strong> di sistem.</p>
                                    </div>
                                </div>
                            @endif

                            <!-- Form Actions -->
                            <div class="pt-6 mt-8 border-t border-slate-100 flex flex-col sm:flex-row justify-between items-center gap-4">
                                <a href="{{ route('admin.roles.show', $role) }}" class="inline-flex justify-center items-center px-4 py-2.5 text-sm font-semibold text-cyan-700 bg-cyan-50 border border-cyan-100 rounded-xl hover:bg-cyan-100 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500 w-full sm:w-auto">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    Lihat Detail
                                </a>
                                
                                <div class="flex flex-col-reverse sm:flex-row gap-3 w-full sm:w-auto mt-4 sm:mt-0">
                                    <a href="{{ route('admin.roles.index') }}" class="inline-flex justify-center items-center px-5 py-2.5 text-sm font-semibold text-slate-700 bg-white border border-slate-300 rounded-xl hover:bg-slate-50 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 shadow-sm w-full sm:w-auto">
                                        Batal
                                    </a>
                                    <button type="submit" class="inline-flex justify-center items-center px-6 py-2.5 text-sm font-bold text-white bg-amber-500 rounded-xl hover:bg-amber-600 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 shadow-sm shadow-amber-500/20 w-full sm:w-auto">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                                        </svg>
                                        Update Role
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes fade-in {
            0% { opacity: 0; transform: translateY(10px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        . {
            animation: fade-in 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
    </style>
@endsection
