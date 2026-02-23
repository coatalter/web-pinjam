<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRoleId = Role::where('slug', 'admin')->value('id');
        $userRoleId = Role::where('slug', 'user')->value('id');

        User::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Admin',
                'password' => bcrypt('password'),
                'role_id' => $adminRoleId,
            ]
        );

        User::updateOrCreate(
            ['email' => 'user@user.com'],
            [
                'name' => 'User',
                'password' => bcrypt('password'),
                'role_id' => $userRoleId,
            ]
        );
    }
}
