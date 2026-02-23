<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('users')) {
            return;
        }

        $hasRole = Schema::hasColumn('users', 'role');
        $hasLegacy = Schema::hasColumn('users', 'role_legacy');

        if ($hasRole && !$hasLegacy) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('role_legacy')->nullable()->after('role_id');
            });

            DB::table('users')->update([
                'role_legacy' => DB::raw('`role`'),
            ]);
        }

        if ($hasRole) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('role');
            });
        }
    }

    public function down(): void
    {
        if (!Schema::hasTable('users')) {
            return;
        }

        $hasRole = Schema::hasColumn('users', 'role');
        $hasLegacy = Schema::hasColumn('users', 'role_legacy');

        if (!$hasRole) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('role')->default('0')->after('password');
            });
        }

        if ($hasLegacy) {
            DB::table('users')->update([
                'role' => DB::raw('`role_legacy`'),
            ]);

            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('role_legacy');
            });
        }
    }
};
