<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['name' => 'Super Admin Univ', 'slug' => 'admin', 'description' => 'Super Administrator tingkat Universitas — akses penuh'],
            ['name' => 'Admin Fakultas Teknik', 'slug' => 'admin-fakultas', 'description' => 'Administrator Fakultas Teknik — mengelola ruangan & peminjaman fakultas'],
            ['name' => 'Dosen', 'slug' => 'dosen', 'description' => 'Dosen — dapat mengajukan peminjaman ruangan'],
            ['name' => 'Mahasiswa', 'slug' => 'mahasiswa', 'description' => 'Mahasiswa — dapat mengajukan peminjaman ruangan'],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(
                ['slug' => $role['slug']],
                ['name' => $role['name'], 'description' => $role['description']]
            );
        }
    }
}