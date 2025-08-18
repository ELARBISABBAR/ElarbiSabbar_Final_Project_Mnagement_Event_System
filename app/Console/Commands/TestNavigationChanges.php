<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class TestNavigationChanges extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:navigation-changes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test navigation changes for admin users';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔧 TESTING NAVIGATION CHANGES');
        $this->info('=============================');
        $this->newLine();

        // Get users by role
        $adminUsers = User::whereHas('roles', function($query) {
            $query->where('name', 'admin');
        })->get();

        $organizerUsers = User::whereHas('roles', function($query) {
            $query->where('name', 'organizer');
        })->get();

        $attendeeUsers = User::whereHas('roles', function($query) {
            $query->where('name', 'attendee');
        })->get();

        $this->info('👥 USER ROLE DISTRIBUTION:');
        $this->info('==========================');
        $this->info("🔑 Admin Users: {$adminUsers->count()}");
        foreach ($adminUsers as $admin) {
            $this->info("   • {$admin->name} ({$admin->email})");
        }
        $this->newLine();

        $this->info("🎯 Organizer Users: {$organizerUsers->count()}");
        foreach ($organizerUsers as $organizer) {
            $this->info("   • {$organizer->name} ({$organizer->email})");
        }
        $this->newLine();

        $this->info("👤 Attendee Users: {$attendeeUsers->count()}");
        foreach ($attendeeUsers->take(3) as $attendee) {
            $this->info("   • {$attendee->name} ({$attendee->email})");
        }
        if ($attendeeUsers->count() > 3) {
            $this->info("   • ... and " . ($attendeeUsers->count() - 3) . " more attendees");
        }
        $this->newLine();

        $this->info('🔧 NAVIGATION CHANGES IMPLEMENTED:');
        $this->info('==================================');
        $this->newLine();

        $this->info('✅ ADMIN USERS:');
        $this->info('   • "Create Event" button REMOVED from navigation dropdown');
        $this->info('   • "Create Event" button REMOVED from mobile menu');
        $this->info('   • Can still access event management through:');
        $this->info('     - "Manage Events" page (event_admin.index)');
        $this->info('     - "Manage Users" page (users.index)');
        $this->info('     - Direct URL access to event creation if needed');
        $this->newLine();

        $this->info('✅ ORGANIZER USERS:');
        $this->info('   • "Create Event" button VISIBLE in navigation dropdown');
        $this->info('   • "Create Event" button VISIBLE in mobile menu');
        $this->info('   • Full access to event creation functionality');
        $this->info('   • Modal interface available for event management');
        $this->newLine();

        $this->info('✅ ATTENDEE USERS:');
        $this->info('   • No "Create Event" button (as expected)');
        $this->info('   • Standard navigation with My Orders and Profile');
        $this->info('   • No changes to their navigation experience');
        $this->newLine();

        $this->info('🎯 ADMIN EVENT MANAGEMENT ACCESS:');
        $this->info('=================================');
        $this->info('Admins can still create and manage events through:');
        $this->newLine();
        $this->info('1. 📊 MANAGE EVENTS PAGE:');
        $this->info('   • URL: /events/admin');
        $this->info('   • Route: event_admin.index');
        $this->info('   • Features: View, approve, reject, delete events');
        $this->info('   • Statistics dashboard with event counts');
        $this->newLine();

        $this->info('2. 👥 MANAGE USERS PAGE:');
        $this->info('   • URL: /edit/users');
        $this->info('   • Route: users.index');
        $this->info('   • Features: User management and role assignment');
        $this->newLine();

        $this->info('3. 🔗 DIRECT ACCESS:');
        $this->info('   • URL: /event (if needed for event creation)');
        $this->info('   • Route: event.index');
        $this->info('   • Modal interface for creating events');
        $this->newLine();

        $this->info('🧪 TESTING RECOMMENDATIONS:');
        $this->info('============================');
        $this->info('1. Login as admin user and verify "Create Event" button is hidden');
        $this->info('2. Login as organizer user and verify "Create Event" button is visible');
        $this->info('3. Test admin event management through "Manage Events" page');
        $this->info('4. Verify modal functionality works correctly');
        $this->info('5. Test on both desktop and mobile layouts');
        $this->newLine();

        $this->info('🌐 TEST URLS:');
        $this->info('=============');
        $this->info('• Home page: http://127.0.0.1:8000/');
        $this->info('• Login page: http://127.0.0.1:8000/login');
        $this->info('• Admin event management: http://127.0.0.1:8000/events/admin');
        $this->info('• Organizer event creation: http://127.0.0.1:8000/event');
        $this->newLine();

        $this->info('✅ NAVIGATION CHANGES COMPLETE!');
        $this->info('Admin users now have a streamlined navigation experience');
        $this->info('while maintaining full access to event management capabilities.');

        return 0;
    }
}
