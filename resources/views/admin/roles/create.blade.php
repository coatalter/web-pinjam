@extends('layouts.admin')

@section('content')
    <div class="space-y-6 animate-fade-in">
        <!-- Header & Breadcrumbs -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.roles.index') }}" class="flex items-center justify-center w-10 h-10 rounded-xl bg-white border border-slate-200 text-slate-500 hover:text-navy-600 hover:border-navy-200 hover:bg-navy-50 transition-all shadow-sm focus:outline-none focus:ring-2 focus:ring-gold-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Tambah Role Baru</h1>
                    <nav class="flex mt-1" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 md:space-x-2 text-xs text-slate-500 font-medium">
                            <li><a href="{{ route('admin.home') }}" class="hover:text-navy-600 transition-colors">Dashboard</a></li>
                            <li><span class="mx-1 text-slate-300">/</span></li>
                            <li><a href="{{ route('admin.roles.index') }}" class="hover:text-navy-600 transition-colors">Role</a></li>
                            <li><span class="mx-1 text-slate-300">/</span></li>
                            <li class="text-navy-600 font-semibold" aria-current="page">Tambah</li>
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
                    <div class="absolute top-0 right-0 -mt-16 -mr-16 w-64 h-64 bg-gradient-to-br from-navy-500/10 to-navy-500/10 rounded-full blur-3xl pointer-events-none"></div>
                    
                    <div class="px-8 py-6 border-b border-slate-100 flex items-center gap-4 bg-slate-50/50 relative z-10">
                        <div class="w-12 h-12 rounded-2xl bg-navy-50 border border-navy-100 flex items-center justify-center text-navy-600 shadow-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-slate-800">Informasi Role</h2>
                            <p class="text-sm text-slate-500">Lengkapi data di bawah ini untuk membuat hak akses baru.</p>
                        </div>
                    </div>

                    <div class="p-8 relative z-10">
                        <form action="{{ route('admin.roles.store') }}" method="POST" class="space-y-6">
                            @csrf

                            <!-- Nama Role -->
                            <div class="space-y-2">
                                <label for="name" class="block text-sm font-bold text-slate-700">
                                    Nama Role <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" id="name" name="name" 
                                    class="block w-full px-4 py-3 bg-slate-50 border @error('name') border-rose-300 ring-rose-300 @else border-slate-200 focus:border-gold-500 focus:ring-gold-500 @enderror rounded-xl text-sm transition-all focus:bg-white focus:ring-2 focus:outline-none" 
                                    placeholder="Contoh: Mahasiswa, Dosen, Kepala Lab" 
                                    value="{{ old('name') }}" autofocus>
                                @error('name')
                                    <p class="text-sm text-rose-500 mt-1 flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                                <p class="text-xs text-slate-400">Nama role yang akan ditampilkan kepada pengguna di seluruh sistem.</p>
                            </div>

                            <!-- Slug -->
                            <div class="space-y-2">
                                <label for="slug" class="block text-sm font-bold text-slate-700">Slug Sistem</label>
                                <div class="flex rounded-xl shadow-sm focus-within:ring-2 focus-within:ring-gold-500 focus-within:border-navy-500 transition-all">
                                    <span class="inline-flex items-center px-4 rounded-l-xl border border-r-0 @error('slug') border-rose-300 bg-rose-50 text-rose-500 @else border-slate-200 bg-slate-100 text-slate-500 @enderror text-sm font-mono">
                                        #
                                    </span>
                                    <input type="text" id="slug" name="slug" 
                                        class="flex-1 block w-full min-w-0 px-4 py-3 rounded-none rounded-r-xl bg-slate-50 text-slate-700 font-mono text-sm border @error('slug') border-rose-300 focus:ring-rose-500 focus:border-rose-500 @else border-slate-200 focus:ring-gold-500 focus:border-gold-500 @enderror transition-all focus:bg-white focus:outline-none" 
                                        placeholder="contoh: mahasiswa (otomatis)" 
                                        value="{{ old('slug') }}">
                                </div>
                                @error('slug')
                                    <p class="text-sm text-rose-500 mt-1 flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                                <p class="text-xs text-slate-400">Identifikasi unik untuk program. Kosongkan untuk dibuat secara otomatis dari nama.</p>
                            </div>

                            <!-- Deskripsi -->
                            <div class="space-y-2">
                                <label for="description" class="block text-sm font-bold text-slate-700">Deskripsi/Keterangan</label>
                                <textarea id="description" name="description" rows="3" 
                                    class="block w-full px-4 py-3 bg-slate-50 border border-slate-200 @error('description') border-rose-300 ring-rose-300 @else hover:border-slate-300 focus:border-gold-500 focus:ring-gold-500 @enderror rounded-xl text-sm transition-all focus:bg-white focus:ring-2 focus:outline-none resize-y" 
                                    placeholder="Jelaskan secara singkat kegunaan dan batasan akses role ini...">{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="text-sm text-rose-500 mt-1 flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Preset Role Universitas -->
                            <div class="pt-4 mt-6 border-t border-slate-100">
                                <label class="block text-sm font-bold text-slate-700 mb-3">Saran Preset Role Kampus</label>
                                <div class="bg-navy-50/50 border border-navy-100 rounded-2xl p-5">
                                    <p class="text-xs font-semibold text-navy-800 mb-4 flex items-center gap-2 uppercase tracking-wide">
                                        <svg class="w-4 h-4 text-navy-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                        Klik untuk mengisi formulir secara otomatis
                                    </p>
                                    <div class="flex flex-wrap gap-2.5">
                                        @foreach([
                                            ['Mahasiswa', 'Mahasiswa aktif yang dapat meminjam alat/lab'],
                                            ['Dosen', 'Dosen pengampu yang dapat meminjam dan menyetujui peminjaman'],
                                            ['Kepala Lab', 'Bertanggung jawab atas pengelolaan laboratorium'],
                                            ['Teknisi Lab', 'Teknisi yang mengelola peralatan dan jadwal lab'],
                                            ['Dekan', 'Dekan Fakultas'],
                                            ['Wakil Dekan', 'Wakil Dekan bidang akademik/kemahasiswaan'],
                                            ['Kaprodi', 'Ketua Program Studi'],
                                            ['Sekretaris Prodi', 'Sekretaris Program Studi'],
                                            ['Staff Fakultas', 'Staff administrasi tingkat fakultas'],
                                            ['Staff Universitas', 'Staff administrasi tingkat universitas'],
                                        ] as [$preset, $desc])
                                            <button type="button" 
                                                class="preset-btn inline-flex items-center px-3.5 py-1.5 rounded-full text-xs font-semibold bg-white border border-navy-200 text-navy-700 hover:bg-navy-600 hover:text-white hover:border-navy-600 transition-all shadow-sm transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-gold-500 focus:ring-offset-1"
                                                data-name="{{ $preset }}" 
                                                data-desc="{{ $desc }}">
                                                {{ $preset }}
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="pt-6 mt-8 border-t border-slate-100 flex flex-col-reverse sm:flex-row justify-end gap-3">
                                <a href="{{ route('admin.roles.index') }}" class="inline-flex justify-center items-center px-5 py-2.5 text-sm font-semibold text-slate-700 bg-white border border-slate-300 rounded-xl hover:bg-slate-50 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gold-500 shadow-sm">
                                    Batal
                                </a>
                                <button type="submit" class="inline-flex justify-center items-center px-6 py-2.5 text-sm font-semibold text-white bg-navy-600 rounded-xl hover:bg-navy-700 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gold-500 shadow-sm shadow-navy-600/20">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                                    </svg>
                                    Simpan Role Sistem
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script for form automation -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nameInput = document.getElementById('name');
            const slugInput = document.getElementById('slug');
            const descriptionInput = document.getElementById('description');
            
            // Auto-generate slug from name
            nameInput.addEventListener('input', function () {
                if (!slugInput.dataset.manual) {
                    slugInput.value = this.value
                        .toLowerCase()
                        .trim()
                        .replace(/[^a-z0-9\s-]/g, '')
                        .replace(/\s+/g, '-')
                        .replace(/-+/g, '-');
                }
            });

            // Mark slug as manually typed so it doesn't get overridden
            slugInput.addEventListener('input', function () {
                this.dataset.manual = this.value ? 'true' : '';
            });

            // Handle preset buttons
            document.querySelectorAll('.preset-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    const name = this.dataset.name;
                    const desc = this.dataset.desc;
                    
                    nameInput.value = name;
                    descriptionInput.value = desc;
                    
                    // Add subtle highlight animation
                    [nameInput, descriptionInput].forEach(el => {
                        el.classList.add('ring-2', 'ring-gold-300', 'bg-navy-50');
                        setTimeout(() => {
                            el.classList.remove('ring-2', 'ring-gold-300', 'bg-navy-50');
                        }, 500);
                    });

                    // Trigger slug generation
                    nameInput.dispatchEvent(new Event('input'));
                    slugInput.dataset.manual = '';
                    
                    // Scroll to top of form smoothly
                    nameInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
                });
            });
        });
    </script>

    <style>
        @keyframes fade-in {
            0% { opacity: 0; transform: translateY(10px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fade-in 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
    </style>
@endsection
