<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Super Admin',
                'email' => 'admin@admin.com',
                'role' => 'admin',
            ],
            [
                'name' => 'Admin Fakultas Teknik',
                'email' => 'admin.teknik@upr.ac.id',
                'role' => 'admin-fakultas',
            ],
            [
                'name' => 'Dr. Budi Santoso',
                'email' => 'budi.santoso@upr.ac.id',
                'role' => 'dosen',
            ],
            [
                'name' => 'Andi Mahasiswa',
                'email' => 'andi@student.upr.ac.id',
                'role' => 'mahasiswa',
            ],
        ];

        foreach ($users as $data) {
            $roleId = Role::where('slug', $data['role'])->value('id');
            User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => bcrypt('password'),
                    'role_id' => $roleId,
                ]
            );
        }
    }
}
