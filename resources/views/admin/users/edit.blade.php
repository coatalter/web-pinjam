@extends('layouts.admin')

@section('content')
    <div class="space-y-6 animate-fade-in">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.users.index') }}" class="flex items-center justify-center w-10 h-10 rounded-xl bg-slate-100 text-slate-500 hover:bg-slate-200 hover:text-slate-700 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <div>
                <h1 class="text-2xl font-extrabold text-slate-800">Edit User: {{ $user->name }}</h1>
                <p class="text-sm text-slate-500 mt-0.5">Perbarui data pengguna dan role</p>
            </div>
        </div>

        @if(session('success'))
            <div class="p-4 text-sm text-success-800 bg-success-50 border border-success-200 rounded-xl flex items-center gap-2">
                <svg class="w-5 h-5 text-success-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Update Profile -->
            <div class="bg-white rounded-3xl border border-slate-100 shadow-xl shadow-slate-200/40 p-8">
                <h2 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-navy-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Data User
                </h2>
                <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-5">
                    @csrf @method('PUT')
                    <div class="space-y-2">
                        <label for="name" class="block text-sm font-semibold text-slate-700">Nama Lengkap</label>
                        <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required
                            class="block w-full px-4 py-3 text-sm border @error('name') border-danger-400 @else border-slate-200 @enderror rounded-xl bg-slate-50 focus:bg-white focus:ring-2 focus:ring-gold-400 focus:border-gold-400 focus:outline-none transition-all">
                        @error('name')<p class="text-sm text-danger-500">{{ $message }}</p>@enderror
                    </div>
                    <div class="space-y-2">
                        <label for="email" class="block text-sm font-semibold text-slate-700">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required
                            class="block w-full px-4 py-3 text-sm border @error('email') border-danger-400 @else border-slate-200 @enderror rounded-xl bg-slate-50 focus:bg-white focus:ring-2 focus:ring-gold-400 focus:border-gold-400 focus:outline-none transition-all">
                        @error('email')<p class="text-sm text-danger-500">{{ $message }}</p>@enderror
                    </div>
                    <div class="space-y-2">
                        <label for="role_id" class="block text-sm font-semibold text-slate-700">Role</label>
                        <select id="role_id" name="role_id" required
                            class="block w-full px-4 py-3 text-sm border @error('role_id') border-danger-400 @else border-slate-200 @enderror rounded-xl bg-slate-50 focus:bg-white focus:ring-2 focus:ring-gold-400 focus:border-gold-400 focus:outline-none transition-all">
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                            @endforeach
                        </select>
                        @error('role_id')<p class="text-sm text-danger-500">{{ $message }}</p>@enderror
                    </div>
                    <button type="submit" class="px-6 py-3 text-sm font-bold text-navy-900 bg-gold-500 rounded-xl hover:bg-gold-400 transition-all shadow-md">
                        Simpan Perubahan
                    </button>
                </form>
            </div>

            <!-- Reset Password -->
            <div class="bg-white rounded-3xl border border-slate-100 shadow-xl shadow-slate-200/40 p-8">
                <h2 class="text-lg font-bold text-slate-800 mb-2 flex items-center gap-2">
                    <svg class="w-5 h-5 text-danger-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                    Reset Password
                </h2>
                <p class="text-sm text-slate-500 mb-6">Reset password user ini ke password baru.</p>

                <form method="POST" action="{{ route('admin.users.reset-password', $user) }}" class="space-y-5">
                    @csrf @method('PATCH')
                    <div class="space-y-2">
                        <label for="password" class="block text-sm font-semibold text-slate-700">Password Baru</label>
                        <input id="password" type="password" name="password" required
                            class="block w-full px-4 py-3 text-sm border @error('password') border-danger-400 @else border-slate-200 @enderror rounded-xl bg-slate-50 focus:bg-white focus:ring-2 focus:ring-gold-400 focus:border-gold-400 focus:outline-none transition-all"
                            placeholder="Minimal 6 karakter">
                        @error('password')<p class="text-sm text-danger-500">{{ $message }}</p>@enderror
                    </div>
                    <div class="space-y-2">
                        <label for="password_confirmation" class="block text-sm font-semibold text-slate-700">Konfirmasi Password</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required
                            class="block w-full px-4 py-3 text-sm border border-slate-200 rounded-xl bg-slate-50 focus:bg-white focus:ring-2 focus:ring-gold-400 focus:border-gold-400 focus:outline-none transition-all"
                            placeholder="Ulangi password baru">
                    </div>
                    <button type="submit" class="px-6 py-3 text-sm font-bold text-white bg-danger-500 rounded-xl hover:bg-danger-600 transition-all shadow-md"
                            onclick="return confirm('Yakin reset password user ini?')">
                        Reset Password
                    </button>
                </form>

                <!-- User Info -->
                <div class="mt-8 pt-6 border-t border-slate-100">
                    <h3 class="text-sm font-semibold text-slate-600 mb-3">Info User</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between"><span class="text-slate-400">Terdaftar</span><span class="text-slate-700">{{ $user->created_at->format('d M Y, H:i') }}</span></div>
                        <div class="flex justify-between"><span class="text-slate-400">Update Terakhir</span><span class="text-slate-700">{{ $user->updated_at->format('d M Y, H:i') }}</span></div>
                        <div class="flex justify-between"><span class="text-slate-400">Total Peminjaman</span><span class="text-slate-700 font-semibold">{{ $user->bookings()->count() }}</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>@keyframes fade-in{0%{opacity:0;transform:translateY(10px);}100%{opacity:1;transform:translateY(0);}}.animate-fade-in{animation:fade-in .5s cubic-bezier(.16,1,.3,1) forwards;}</style>
@endsection
