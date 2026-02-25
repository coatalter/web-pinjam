@extends('layouts.admin')

@section('content')
    <div class="space-y-6 animate-fade-in">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.users.index') }}" class="flex items-center justify-center w-10 h-10 rounded-xl bg-slate-100 text-slate-500 hover:bg-slate-200 hover:text-slate-700 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <div>
                <h1 class="text-2xl font-extrabold text-slate-800">Tambah User Baru</h1>
                <p class="text-sm text-slate-500 mt-0.5">Buat akun pengguna baru dengan role yang sesuai</p>
            </div>
        </div>

        <div class="bg-white rounded-3xl border border-slate-100 shadow-xl shadow-slate-200/40 p-8 max-w-2xl">
            <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-6">
                @csrf
                <div class="space-y-2">
                    <label for="name" class="block text-sm font-semibold text-slate-700">Nama Lengkap</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required
                        class="block w-full px-4 py-3 text-sm border @error('name') border-danger-400 @else border-slate-200 @enderror rounded-xl bg-slate-50 focus:bg-white focus:ring-2 focus:ring-gold-400 focus:border-gold-400 focus:outline-none transition-all"
                        placeholder="Nama lengkap pengguna">
                    @error('name')<p class="text-sm text-danger-500">{{ $message }}</p>@enderror
                </div>

                <div class="space-y-2">
                    <label for="email" class="block text-sm font-semibold text-slate-700">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
                        class="block w-full px-4 py-3 text-sm border @error('email') border-danger-400 @else border-slate-200 @enderror rounded-xl bg-slate-50 focus:bg-white focus:ring-2 focus:ring-gold-400 focus:border-gold-400 focus:outline-none transition-all"
                        placeholder="email@upr.ac.id">
                    @error('email')<p class="text-sm text-danger-500">{{ $message }}</p>@enderror
                </div>

                <div class="space-y-2">
                    <label for="role_id" class="block text-sm font-semibold text-slate-700">Role</label>
                    <select id="role_id" name="role_id" required
                        class="block w-full px-4 py-3 text-sm border @error('role_id') border-danger-400 @else border-slate-200 @enderror rounded-xl bg-slate-50 focus:bg-white focus:ring-2 focus:ring-gold-400 focus:border-gold-400 focus:outline-none transition-all">
                        <option value="">— Pilih Role —</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                        @endforeach
                    </select>
                    @error('role_id')<p class="text-sm text-danger-500">{{ $message }}</p>@enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label for="password" class="block text-sm font-semibold text-slate-700">Password</label>
                        <input id="password" type="password" name="password" required
                            class="block w-full px-4 py-3 text-sm border @error('password') border-danger-400 @else border-slate-200 @enderror rounded-xl bg-slate-50 focus:bg-white focus:ring-2 focus:ring-gold-400 focus:border-gold-400 focus:outline-none transition-all"
                            placeholder="Minimal 6 karakter">
                        @error('password')<p class="text-sm text-danger-500">{{ $message }}</p>@enderror
                    </div>
                    <div class="space-y-2">
                        <label for="password_confirmation" class="block text-sm font-semibold text-slate-700">Konfirmasi Password</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required
                            class="block w-full px-4 py-3 text-sm border border-slate-200 rounded-xl bg-slate-50 focus:bg-white focus:ring-2 focus:ring-gold-400 focus:border-gold-400 focus:outline-none transition-all"
                            placeholder="Ulangi password">
                    </div>
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <button type="submit" class="px-6 py-3 text-sm font-bold text-navy-900 bg-gold-500 rounded-xl hover:bg-gold-400 transition-all shadow-md">
                        Simpan User
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="px-6 py-3 text-sm font-medium text-slate-500 bg-slate-100 rounded-xl hover:bg-slate-200 transition-colors">Batal</a>
                </div>
            </form>
        </div>
    </div>
    <style>@keyframes fade-in{0%{opacity:0;transform:translateY(10px);}100%{opacity:1;transform:translateY(0);}}.animate-fade-in{animation:fade-in .5s cubic-bezier(.16,1,.3,1) forwards;}</style>
@endsection
