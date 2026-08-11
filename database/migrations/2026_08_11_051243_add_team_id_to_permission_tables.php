<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected function primaryIncludes(string $table, string $column): bool
    {
        return collect(Schema::getIndexes($table))
            ->contains(fn ($index) => ($index['primary'] ?? false) && in_array($column, $index['columns'] ?? [], true));
    }

    public function up(): void
    {
        $tableNames = config('permission.table_names');
        $teamForeignKey = config('permission.column_names.team_foreign_key') ?? 'team_id';

        // ---------------- roles ----------------
        if (! Schema::hasColumn($tableNames['roles'], $teamForeignKey)) {
            Schema::table($tableNames['roles'], function (Blueprint $table) use ($teamForeignKey) {
                $table->unsignedBigInteger($teamForeignKey)->nullable()->after('id');
            });
        }

        if (Schema::hasIndex($tableNames['roles'], $tableNames['roles'].'_name_guard_name_unique')) {
            Schema::table($tableNames['roles'], function (Blueprint $table) use ($tableNames) {
                $table->dropUnique($tableNames['roles'].'_name_guard_name_unique');
            });
        }

        if (! Schema::hasIndex($tableNames['roles'], $tableNames['roles'].'_team_name_guard_unique')) {
            Schema::table($tableNames['roles'], function (Blueprint $table) use ($tableNames, $teamForeignKey) {
                $table->unique([$teamForeignKey, 'name', 'guard_name'], $tableNames['roles'].'_team_name_guard_unique');
            });
        }

        // ---------------- model_has_roles ----------------
        if (! Schema::hasColumn($tableNames['model_has_roles'], $teamForeignKey)) {
            Schema::table($tableNames['model_has_roles'], function (Blueprint $table) use ($teamForeignKey) {
                $table->unsignedBigInteger($teamForeignKey)->default(0)->after('role_id');
            });
        }

        if (! $this->primaryIncludes($tableNames['model_has_roles'], $teamForeignKey)) {
            // role_id is referenced by a foreign key and must stay indexed while the primary key is rebuilt
            if (! Schema::hasIndex($tableNames['model_has_roles'], $tableNames['model_has_roles'].'_role_id_index')) {
                Schema::table($tableNames['model_has_roles'], function (Blueprint $table) use ($tableNames) {
                    $table->index('role_id', $tableNames['model_has_roles'].'_role_id_index');
                });
            }
            Schema::table($tableNames['model_has_roles'], function (Blueprint $table) {
                $table->dropPrimary();
            });
            Schema::table($tableNames['model_has_roles'], function (Blueprint $table) use ($teamForeignKey) {
                $table->primary([$teamForeignKey, 'role_id', 'model_id', 'model_type']);
            });
        }

        // ---------------- model_has_permissions ----------------
        if (! Schema::hasColumn($tableNames['model_has_permissions'], $teamForeignKey)) {
            Schema::table($tableNames['model_has_permissions'], function (Blueprint $table) use ($teamForeignKey) {
                $table->unsignedBigInteger($teamForeignKey)->default(0)->after('permission_id');
            });
        }

        if (! $this->primaryIncludes($tableNames['model_has_permissions'], $teamForeignKey)) {
            // permission_id is referenced by a foreign key and must stay indexed while the primary key is rebuilt
            if (! Schema::hasIndex($tableNames['model_has_permissions'], $tableNames['model_has_permissions'].'_permission_id_index')) {
                Schema::table($tableNames['model_has_permissions'], function (Blueprint $table) use ($tableNames) {
                    $table->index('permission_id', $tableNames['model_has_permissions'].'_permission_id_index');
                });
            }
            Schema::table($tableNames['model_has_permissions'], function (Blueprint $table) {
                $table->dropPrimary();
            });
            Schema::table($tableNames['model_has_permissions'], function (Blueprint $table) use ($teamForeignKey) {
                $table->primary([$teamForeignKey, 'permission_id', 'model_id', 'model_type']);
            });
        }
    }

    public function down(): void
    {
        $tableNames = config('permission.table_names');
        $teamForeignKey = config('permission.column_names.team_foreign_key') ?? 'team_id';

        if ($this->primaryIncludes($tableNames['model_has_permissions'], $teamForeignKey)) {
            Schema::table($tableNames['model_has_permissions'], function (Blueprint $table) {
                $table->dropPrimary();
            });
            Schema::table($tableNames['model_has_permissions'], function (Blueprint $table) {
                $table->primary(['permission_id', 'model_id', 'model_type']);
            });
        }

        if (Schema::hasIndex($tableNames['model_has_permissions'], $tableNames['model_has_permissions'].'_permission_id_index')) {
            Schema::table($tableNames['model_has_permissions'], function (Blueprint $table) use ($tableNames) {
                $table->dropIndex($tableNames['model_has_permissions'].'_permission_id_index');
            });
        }

        if (Schema::hasColumn($tableNames['model_has_permissions'], $teamForeignKey)) {
            Schema::table($tableNames['model_has_permissions'], function (Blueprint $table) use ($teamForeignKey) {
                $table->dropColumn($teamForeignKey);
            });
        }

        if ($this->primaryIncludes($tableNames['model_has_roles'], $teamForeignKey)) {
            Schema::table($tableNames['model_has_roles'], function (Blueprint $table) {
                $table->dropPrimary();
            });
            Schema::table($tableNames['model_has_roles'], function (Blueprint $table) {
                $table->primary(['role_id', 'model_id', 'model_type']);
            });
        }

        if (Schema::hasIndex($tableNames['model_has_roles'], $tableNames['model_has_roles'].'_role_id_index')) {
            Schema::table($tableNames['model_has_roles'], function (Blueprint $table) use ($tableNames) {
                $table->dropIndex($tableNames['model_has_roles'].'_role_id_index');
            });
        }

        if (Schema::hasColumn($tableNames['model_has_roles'], $teamForeignKey)) {
            Schema::table($tableNames['model_has_roles'], function (Blueprint $table) use ($teamForeignKey) {
                $table->dropColumn($teamForeignKey);
            });
        }

        if (Schema::hasIndex($tableNames['roles'], $tableNames['roles'].'_team_name_guard_unique')) {
            Schema::table($tableNames['roles'], function (Blueprint $table) use ($tableNames) {
                $table->dropUnique($tableNames['roles'].'_team_name_guard_unique');
            });
        }
        if (! Schema::hasIndex($tableNames['roles'], $tableNames['roles'].'_name_guard_name_unique')) {
            Schema::table($tableNames['roles'], function (Blueprint $table) {
                $table->unique(['name', 'guard_name']);
            });
        }

        if (Schema::hasColumn($tableNames['roles'], $teamForeignKey)) {
            Schema::table($tableNames['roles'], function (Blueprint $table) use ($teamForeignKey) {
                $table->dropColumn($teamForeignKey);
            });
        }
    }
};
