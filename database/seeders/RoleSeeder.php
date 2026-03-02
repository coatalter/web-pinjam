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
            ['name' => 'Admin Lab Terpadu', 'slug' => 'admin-lab', 'description' => 'Administrator Lab Terpadu — mengelola layanan pengujian, praktikum & peminjaman lab'],
            ['name' => 'Penguji', 'slug' => 'penguji', 'description' => 'Analis Lab / Penguji — melakukan pengujian sampel'],
            ['name' => 'Reviewer', 'slug' => 'reviewer', 'description' => 'Reviewer — melakukan blind review hasil pengujian'],
            ['name' => 'Pemohon', 'slug' => 'pemohon', 'description' => 'Pemohon — mendaftar layanan pengujian dan praktikum'],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(
                ['slug' => $role['slug']],
                ['name' => $role['name'], 'description' => $role['description']]
            );
        }
    }
}