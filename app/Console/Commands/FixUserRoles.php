<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class FixUserRoles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:user-roles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix users without assigned roles';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔧 Fixing User Role Assignments...');

        // Get users without roles
        $usersWithoutRoles = User::doesntHave('roles')->get();

        $this->info("Found {$usersWithoutRoles->count()} users without roles:");

        foreach ($usersWithoutRoles as $user) {
            $this->info("  - {$user->name} ({$user->email})");

            // Assign attendee role by default
            $user->assignRole('attendee');
            $this->info("    ✅ Assigned 'attendee' role");
        }

        if ($usersWithoutRoles->count() > 0) {
            $this->info("\n✅ Fixed {$usersWithoutRoles->count()} user role assignments");
        } else {
            $this->info("✅ All users already have roles assigned");
        }

        return 0;
    }
}
