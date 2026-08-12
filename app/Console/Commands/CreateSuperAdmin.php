<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CreateSuperAdmin extends Command
{
    protected $signature = 'central:create-superadmin {name} {email} {password}';

    protected $description = 'Create a central (superadmin) user with tenant_id = null';

    public function handle(): int
    {
        $exists = User::where('email', $this->argument('email'))->whereNull('tenant_id')->exists();

        if ($exists) {
            $this->error('A superadmin with this email already exists.');

            return self::FAILURE;
        }

        User::create([
            'name' => $this->argument('name'),
            'email' => $this->argument('email'),
            'password' => bcrypt($this->argument('password')),
            'tenant_id' => null,
        ]);

        $this->info('Superadmin created. Login at /admin/login on the central domain.');

        return self::SUCCESS;
    }
}
