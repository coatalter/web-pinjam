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
            ['route_name' => null, 'icon' => null, 'sort_order' => 0, 'is_active' => true]
        );

        $users = Menu::updateOrCreate(
            ['context' => 'admin', 'parent_id' => null, 'name' => 'Manage Users'],
            ['route_name' => null, 'icon' => 'users', 'sort_order' => 20, 'is_active' => true]
        );

        Menu::updateOrCreate(
            ['context' => 'admin', 'parent_id' => $users->id, 'name' => 'Profile'],
            ['route_name' => null, 'icon' => null, 'sort_order' => 0, 'is_active' => true]
        );

        $userDashboard = Menu::updateOrCreate(
            ['context' => 'user', 'parent_id' => null, 'name' => 'User Dashboard'],
            ['route_name' => 'home', 'icon' => 'home', 'sort_order' => 0, 'is_active' => true]
        );

        if ($adminRole) {
            $adminRole->menus()->syncWithoutDetaching([
                $adminDashboard->id,
                $front->id,
                $users->id,
            ]);

            $adminRole->menus()->syncWithoutDetaching(
                Menu::where('context', 'admin')->pluck('id')->all()
            );
        }

        if ($userRole) {
            $userRole->menus()->syncWithoutDetaching([$userDashboard->id]);
        }
    }
}
