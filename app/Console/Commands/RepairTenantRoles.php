<?php

namespace App\Console\Commands;

use App\Models\Role;
use App\Models\Tenant;
use App\Models\User;
use App\Services\TenantPermissionSeeder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\PermissionRegistrar;

class RepairTenantRoles extends Command
{
    protected $signature = 'tenants:repair-roles';

    protected $description = 'Re-seed roles/permissions and ensure every tenant admin user is linked to the tenant-scoped Admin role';

    public function handle(): int
    {
        $tenants = Tenant::all();

        if ($tenants->isEmpty()) {
            $this->info('No tenants found.');

            return self::SUCCESS;
        }

        foreach ($tenants as $tenant) {
            tenancy()->initialize($tenant);

            try {
                (new TenantPermissionSeeder)->run();

                $key = tenant()->getTenantKey();
                $adminRole = Role::where('name', 'Admin')->first();
                $validRoleIds = Role::pluck('id');

                foreach (User::where('tenant_id', $key)->get() as $user) {
                    $stale = DB::table('model_has_roles')
                        ->where('model_type', $user->getMorphClass())
                        ->where('model_id', $user->getKey())
                        ->whereNotIn('role_id', $validRoleIds)
                        ->delete();

                    $roleCount = DB::table('model_has_roles')
                        ->where('model_type', $user->getMorphClass())
                        ->where('model_id', $user->getKey())
                        ->count();

                    if ($roleCount === 0 && $adminRole) {
                        $user->roles()->syncWithoutDetaching([
                            $adminRole->id => ['tenant_id' => $key],
                        ]);

                        $this->info("[{$tenant->id}] Assigned 'Admin' role to {$user->email}");
                    } elseif ($stale > 0) {
                        $this->info("[{$tenant->id}] Removed {$stale} stale role link(s) for {$user->email}");
                    }
                }

                app()[PermissionRegistrar::class]->forgetCachedPermissions();
            } catch (\Throwable $e) {
                $this->error("[{$tenant->id}] " . $e->getMessage());
                report($e);
            } finally {
                tenancy()->end();
            }
        }

        $this->info('Tenant roles repaired.');

        return self::SUCCESS;
    }
}
