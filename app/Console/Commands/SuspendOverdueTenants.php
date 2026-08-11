<?php

namespace App\Console\Commands;

use App\Models\Subscription;
use App\Models\Tenant;
use Illuminate\Console\Command;

class SuspendOverdueTenants extends Command
{
    protected $signature = 'saas:suspend-overdue {--days=7 : Grace period in days before suspension}';

    protected $description = 'Suspend tenants whose subscription is past due beyond the grace period';

    public function handle(): int
    {
        $graceDays = (int) $this->option('days');
        $threshold = now()->subDays($graceDays);

        $suspended = 0;

        Subscription::whereIn('stripe_status', ['past_due', 'unpaid', 'incomplete'])
            ->where('updated_at', '<', $threshold)
            ->each(function (Subscription $subscription) use (&$suspended) {
                $subscription->update([
                    'status' => 'canceled',
                    'stripe_status' => 'canceled',
                    'ends_at' => now(),
                ]);

                $tenant = Tenant::find($subscription->tenant_id);

                if ($tenant && ! in_array($tenant->status, ['canceled', 'suspended'], true)) {
                    $tenant->update([
                        'status' => 'suspended',
                        'suspended_at' => now(),
                    ]);
                }

                $suspended++;
            });

        // Expire tenants whose local trial has run out with no paid subscription.
        Tenant::where('status', 'trial')
            ->where('trial_ends_at', '<', $threshold)
            ->each(function (Tenant $tenant) use (&$suspended) {
                $tenant->update([
                    'status' => 'suspended',
                    'suspended_at' => now(),
                ]);

                $suspended++;
            });

        $this->info("Suspended {$suspended} tenant(s).");

        return self::SUCCESS;
    }
}
