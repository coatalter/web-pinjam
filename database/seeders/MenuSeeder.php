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

        // --- Admin Menus ---
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

        // --- Booking & Approval ---
        $bookingParent = Menu::updateOrCreate(
            ['context' => 'admin', 'parent_id' => null, 'name' => 'Peminjaman'],
            ['route_name' => null, 'icon' => 'calendar', 'sort_order' => 40, 'is_active' => true]
        );

        Menu::updateOrCreate(
            ['context' => 'admin', 'parent_id' => $bookingParent->id, 'name' => 'Approval Peminjaman'],
            ['route_name' => 'admin.bookings.index', 'icon' => 'check-square', 'sort_order' => 0, 'is_active' => true]
        );

        // --- User Menus ---
        $userDashboard = Menu::updateOrCreate(
            ['context' => 'user', 'parent_id' => null, 'name' => 'User Dashboard'],
            ['route_name' => 'home', 'icon' => 'home', 'sort_order' => 0, 'is_active' => true]
        );

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

        // Assign menus ke admin roles
        $adminMenuIds = Menu::where('context', 'admin')->pluck('id')->all();
        if ($adminRole) {
            $adminRole->menus()->syncWithoutDetaching($adminMenuIds);
        }
        $adminFakultasRole = Role::where('slug', 'admin-fakultas')->first();
        if ($adminFakultasRole) {
            $adminFakultasRole->menus()->syncWithoutDetaching($adminMenuIds);
        }

        // Assign menus ke user roles (dosen & mahasiswa)
        $userMenuIds = Menu::where('context', 'user')->pluck('id')->all();
        $dosenRole = Role::where('slug', 'dosen')->first();
        $mahasiswaRole = Role::where('slug', 'mahasiswa')->first();
        if ($dosenRole) {
            $dosenRole->menus()->syncWithoutDetaching($userMenuIds);
        }
        if ($mahasiswaRole) {
            $mahasiswaRole->menus()->syncWithoutDetaching($userMenuIds);
        }
    }
}