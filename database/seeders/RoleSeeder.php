<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            // Sistem
            ['name' => 'Admin',             'slug' => 'admin',             'description' => 'Administrator sistem'],
            ['name' => 'User',              'slug' => 'user',              'description' => 'Pengguna umum'],

            // Mahasiswa & Akademik
            ['name' => 'Mahasiswa',         'slug' => 'mahasiswa',         'description' => 'Mahasiswa aktif'],
            ['name' => 'Dosen',             'slug' => 'dosen',             'description' => 'Dosen pengampu mata kuliah'],
            ['name' => 'Dosen Pembimbing',  'slug' => 'dosen-pembimbing',  'description' => 'Dosen pembimbing tugas akhir/PKL'],

            // Laboratorium
            ['name' => 'Kepala Lab',        'slug' => 'kepala-lab',        'description' => 'Kepala laboratorium yang bertanggung jawab atas lab'],
            ['name' => 'Asisten Lab',       'slug' => 'asisten-lab',       'description' => 'Asisten praktikum laboratorium'],
            ['name' => 'Teknisi Lab',       'slug' => 'teknisi-lab',       'description' => 'Teknisi yang mengelola peralatan laboratorium'],

            // Program Studi
            ['name' => 'Kaprodi',           'slug' => 'kaprodi',           'description' => 'Ketua Program Studi'],
            ['name' => 'Sekretaris Prodi',  'slug' => 'sekretaris-prodi',  'description' => 'Sekretaris Program Studi'],
            ['name' => 'Staff Prodi',       'slug' => 'staff-prodi',       'description' => 'Staff administrasi Program Studi'],

            // Fakultas
            ['name' => 'Dekan',             'slug' => 'dekan',             'description' => 'Dekan Fakultas'],
            ['name' => 'Wakil Dekan',       'slug' => 'wakil-dekan',       'description' => 'Wakil Dekan Fakultas'],
            ['name' => 'Staff Fakultas',    'slug' => 'staff-fakultas',    'description' => 'Staff administrasi Fakultas'],

            // Universitas
            ['name' => 'Rektor',            'slug' => 'rektor',            'description' => 'Rektor Universitas'],
            ['name' => 'Staff Universitas', 'slug' => 'staff-universitas', 'description' => 'Staff administrasi Universitas'],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(
                ['slug' => $role['slug']],
                ['name' => $role['name'], 'description' => $role['description']]
            );
        }
    }
}