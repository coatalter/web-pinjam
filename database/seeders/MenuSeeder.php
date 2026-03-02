<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\Role;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::where('slug', 'admin')->first();
        $userRole = Role::where('slug', 'user')->first();

        // ──────────────────────────────────────────────
        //  ADMIN MENUS
        // ──────────────────────────────────────────────

        $adminDashboard = Menu::updateOrCreate(
            ['context' => 'admin', 'parent_id' => null, 'name' => 'Admin Dashboard'],
            ['route_name' => 'admin.home', 'icon' => 'home', 'sort_order' => 0, 'is_active' => true]
        );

        $front = Menu::updateOrCreate(
            ['context' => 'admin', 'parent_id' => null, 'name' => 'Manage Front End'],
            ['route_name' => null, 'icon' => 'layers', 'sort_order' => 10, 'is_active' => true]
        );

        Menu::updateOrCreate(
            ['context' => 'admin', 'parent_id' => $front->id, 'name' => 'Menu'],
            ['route_name' => 'admin.menus.index', 'icon' => null, 'sort_order' => 0, 'is_active' => true]
        );

        $users = Menu::updateOrCreate(
            ['context' => 'admin', 'parent_id' => null, 'name' => 'Manage Users'],
            ['route_name' => null, 'icon' => 'users', 'sort_order' => 20, 'is_active' => true]
        );

        Menu::updateOrCreate(
            ['context' => 'admin', 'parent_id' => $users->id, 'name' => 'Profile'],
            ['route_name' => 'admin.profile.edit', 'icon' => null, 'sort_order' => 0, 'is_active' => true]
        );

        Menu::updateOrCreate(
            ['context' => 'admin', 'parent_id' => $users->id, 'name' => 'Kelola User'],
            ['route_name' => 'admin.users.index', 'icon' => 'user-plus', 'sort_order' => 1, 'is_active' => true]
        );

        Menu::updateOrCreate(
            ['context' => 'admin', 'parent_id' => $users->id, 'name' => 'Role Management'],
            ['route_name' => 'admin.roles.index', 'icon' => 'shield', 'sort_order' => 2, 'is_active' => true]
        );

        // --- Master Data ---
        $masterData = Menu::updateOrCreate(
            ['context' => 'admin', 'parent_id' => null, 'name' => 'Master Data'],
            ['route_name' => null, 'icon' => 'database', 'sort_order' => 30, 'is_active' => true]
        );

        Menu::updateOrCreate(
            ['context' => 'admin', 'parent_id' => $masterData->id, 'name' => 'Manajemen Ruangan'],
            ['route_name' => 'admin.rooms.index', 'icon' => 'map-pin', 'sort_order' => 0, 'is_active' => true]
        );

        Menu::updateOrCreate(
            ['context' => 'admin', 'parent_id' => $masterData->id, 'name' => 'Manajemen Alat'],
            ['route_name' => 'admin.equipment.index', 'icon' => 'tool', 'sort_order' => 1, 'is_active' => true]
        );

        Menu::updateOrCreate(
            ['context' => 'admin', 'parent_id' => $masterData->id, 'name' => 'Parameter Pengujian'],
            ['route_name' => 'admin.test-parameters.index', 'icon' => 'clipboard', 'sort_order' => 2, 'is_active' => true]
        );

        // --- Booking & Approval (Peminjaman Ruang) ---
        $bookingParent = Menu::updateOrCreate(
            ['context' => 'admin', 'parent_id' => null, 'name' => 'Peminjaman'],
            ['route_name' => null, 'icon' => 'calendar', 'sort_order' => 40, 'is_active' => true]
        );

        Menu::updateOrCreate(
            ['context' => 'admin', 'parent_id' => $bookingParent->id, 'name' => 'Approval Peminjaman'],
            ['route_name' => 'admin.bookings.index', 'icon' => 'check-square', 'sort_order' => 0, 'is_active' => true]
        );

        // --- Layanan Pengujian ---
        $pengujian = Menu::updateOrCreate(
            ['context' => 'admin', 'parent_id' => null, 'name' => 'Layanan Pengujian'],
            ['route_name' => null, 'icon' => 'activity', 'sort_order' => 50, 'is_active' => true]
        );

        Menu::updateOrCreate(
            ['context' => 'admin', 'parent_id' => $pengujian->id, 'name' => 'Permohonan Pengujian'],
            ['route_name' => 'admin.test-requests.index', 'icon' => 'file-text', 'sort_order' => 0, 'is_active' => true]
        );

        Menu::updateOrCreate(
            ['context' => 'admin', 'parent_id' => $pengujian->id, 'name' => 'Verifikasi Pembayaran'],
            ['route_name' => 'admin.test-requests.payments', 'icon' => 'credit-card', 'sort_order' => 1, 'is_active' => true]
        );

        // --- Layanan Praktikum ---
        $praktikum = Menu::updateOrCreate(
            ['context' => 'admin', 'parent_id' => null, 'name' => 'Layanan Praktikum'],
            ['route_name' => null, 'icon' => 'book-open', 'sort_order' => 60, 'is_active' => true]
        );

        Menu::updateOrCreate(
            ['context' => 'admin', 'parent_id' => $praktikum->id, 'name' => 'Registrasi Praktikum'],
            ['route_name' => 'admin.practicum.index', 'icon' => 'list', 'sort_order' => 0, 'is_active' => true]
        );

        Menu::updateOrCreate(
            ['context' => 'admin', 'parent_id' => $praktikum->id, 'name' => 'Laporan Praktikum'],
            ['route_name' => 'admin.practicum.reports', 'icon' => 'file', 'sort_order' => 1, 'is_active' => true]
        );

        // ──────────────────────────────────────────────
        //  USER MENUS
        // ──────────────────────────────────────────────

        $userDashboard = Menu::updateOrCreate(
            ['context' => 'user', 'parent_id' => null, 'name' => 'User Dashboard'],
            ['route_name' => 'home', 'icon' => 'home', 'sort_order' => 0, 'is_active' => true]
        );

        // --- Peminjaman Ruangan ---
        $userBooking = Menu::updateOrCreate(
            ['context' => 'user', 'parent_id' => null, 'name' => 'Peminjaman Ruangan'],
            ['route_name' => null, 'icon' => 'calendar', 'sort_order' => 10, 'is_active' => true]
        );

        Menu::updateOrCreate(
            ['context' => 'user', 'parent_id' => $userBooking->id, 'name' => 'Ajukan Peminjaman'],
            ['route_name' => 'bookings.create', 'icon' => 'plus-circle', 'sort_order' => 0, 'is_active' => true]
        );

        Menu::updateOrCreate(
            ['context' => 'user', 'parent_id' => $userBooking->id, 'name' => 'Riwayat Peminjaman'],
            ['route_name' => 'bookings.index', 'icon' => 'list', 'sort_order' => 1, 'is_active' => true]
        );

        // --- Layanan Pengujian (User) ---
        $userPengujian = Menu::updateOrCreate(
            ['context' => 'user', 'parent_id' => null, 'name' => 'Pengujian'],
            ['route_name' => null, 'icon' => 'activity', 'sort_order' => 20, 'is_active' => true]
        );

        Menu::updateOrCreate(
            ['context' => 'user', 'parent_id' => $userPengujian->id, 'name' => 'Ajukan Pengujian'],
            ['route_name' => 'test-requests.create', 'icon' => 'plus-circle', 'sort_order' => 0, 'is_active' => true]
        );

        Menu::updateOrCreate(
            ['context' => 'user', 'parent_id' => $userPengujian->id, 'name' => 'Tracking Pengujian'],
            ['route_name' => 'test-requests.index', 'icon' => 'search', 'sort_order' => 1, 'is_active' => true]
        );

        // --- Layanan Praktikum (User) ---
        $userPraktikum = Menu::updateOrCreate(
            ['context' => 'user', 'parent_id' => null, 'name' => 'Praktikum'],
            ['route_name' => null, 'icon' => 'book-open', 'sort_order' => 30, 'is_active' => true]
        );

        Menu::updateOrCreate(
            ['context' => 'user', 'parent_id' => $userPraktikum->id, 'name' => 'Daftar Praktikum'],
            ['route_name' => 'practicum.create', 'icon' => 'plus-circle', 'sort_order' => 0, 'is_active' => true]
        );

        Menu::updateOrCreate(
            ['context' => 'user', 'parent_id' => $userPraktikum->id, 'name' => 'Riwayat Praktikum'],
            ['route_name' => 'practicum.index', 'icon' => 'list', 'sort_order' => 1, 'is_active' => true]
        );

        // ──────────────────────────────────────────────
        //  ROLE ASSIGNMENTS
        // ──────────────────────────────────────────────

        $adminMenuIds = Menu::where('context', 'admin')->pluck('id')->all();
        $userMenuIds = Menu::where('context', 'user')->pluck('id')->all();

        // 1. Super Admin: Semua menu admin
        $adminRole?->menus()->sync($adminMenuIds);

        // 2. Admin Fakultas: Dashboard, Users (Profile), Master Data (Ruangan), Peminjaman
        $adminFakultasMenus = Menu::whereIn('name', [
            'Admin Dashboard',
            'Manage Users',
            'Profile',
            'Master Data',
            'Manajemen Ruangan',
            'Peminjaman',
            'Approval Peminjaman'
        ])->pluck('id')->all();
        Role::where('slug', 'admin-fakultas')->first()?->menus()->sync($adminFakultasMenus);

        // 3. Admin Lab: Dashboard, Profile, Master (Ruang, Alat, Param), Pengujian, Praktikum
        $adminLabMenus = Menu::whereIn('name', [
            'Admin Dashboard',
            'Manage Users',
            'Profile',
            'Master Data',
            'Manajemen Ruangan',
            'Manajemen Alat',
            'Parameter Pengujian',
            'Layanan Pengujian',
            'Permohonan Pengujian',
            'Verifikasi Pembayaran',
            'Layanan Praktikum',
            'Registrasi Praktikum',
            'Laporan Praktikum'
        ])->pluck('id')->all();
        Role::where('slug', 'admin-lab')->first()?->menus()->sync($adminLabMenus);

        // 4. Penguji & Reviewer: Dashboard, Profile, Pengujian (tanpa Verifikasi Pembayaran)
        $pengujiMenus = Menu::whereIn('name', [
            'Admin Dashboard',
            'Manage Users',
            'Profile',
            'Layanan Pengujian',
            'Permohonan Pengujian'
        ])->pluck('id')->all();
        Role::where('slug', 'penguji')->first()?->menus()->sync($pengujiMenus);
        Role::where('slug', 'reviewer')->first()?->menus()->sync($pengujiMenus);

        // 5. Dosen & Mahasiswa: User Dashboard, Peminjaman Ruang
        $dosenMhsMenus = Menu::whereIn('name', [
            'User Dashboard',
            'Peminjaman Ruangan',
            'Ajukan Peminjaman',
            'Riwayat Peminjaman'
        ])->pluck('id')->all();
        Role::where('slug', 'dosen')->first()?->menus()->sync($dosenMhsMenus);
        Role::where('slug', 'mahasiswa')->first()?->menus()->sync($dosenMhsMenus);

        // 6. Pemohon: User Dashboard, Pengujian, Praktikum
        $pemohonMenus = Menu::whereIn('name', [
            'User Dashboard',
            'Pengujian',
            'Ajukan Pengujian',
            'Tracking Pengujian',
            'Praktikum',
            'Daftar Praktikum',
            'Riwayat Praktikum'
        ])->pluck('id')->all();
        Role::where('slug', 'pemohon')->first()?->menus()->sync($pemohonMenus);
    }
}