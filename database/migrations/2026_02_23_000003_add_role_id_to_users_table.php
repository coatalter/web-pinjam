<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'role_id')) {
                $table->foreignId('role_id')->nullable()->after('password')->constrained('roles')->nullOnDelete();
            }
        });

        if (!Schema::hasTable('roles') || !Schema::hasColumn('users', 'role')) {
            return;
        }

        $adminRoleId = DB::table('roles')->where('slug', 'admin')->value('id');
        $userRoleId = DB::table('roles')->where('slug', 'user')->value('id');

        if (!$adminRoleId) {
            $adminRoleId = DB::table('roles')->insertGetId([
                'name' => 'Admin',
                'slug' => 'admin',
                'description' => 'Administrator',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        if (!$userRoleId) {
            $userRoleId = DB::table('roles')->insertGetId([
                'name' => 'User',
                'slug' => 'user',
                'description' => 'Regular user',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        DB::table('users')
            ->whereNull('role_id')
            ->where('role', '1')
            ->update(['role_id' => $adminRoleId]);

        DB::table('users')
            ->whereNull('role_id')
            ->where('role', '0')
            ->update(['role_id' => $userRoleId]);
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'role_id')) {
                $table->dropConstrainedForeignId('role_id');
            }
        });
    }
};
