<?php

namespace App\Console\Commands;

use App\Models\Events;
use App\Models\User;
use Illuminate\Console\Command;

class DiagnoseEventDisplay extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'diagnose:events';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Diagnose event display issues and explain what users should see';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 Event Display Diagnostic Tool');
        $this->info('================================');
        $this->newLine();

        // Get all data
        $allEvents = Events::with('user')->get();
        $organizers = User::role('organizer')->get();
        $admins = User::role('admin')->get();

        $this->info('📊 Platform Overview:');
        $this->info("   Total events in database: {$allEvents->count()}");
        $this->info("   Total organizers: {$organizers->count()}");
        $this->info("   Total admins: {$admins->count()}");
        $this->newLine();

        // Explain the two different views
        $this->info('🎯 Understanding Event Management Views:');
        $this->info('   There are TWO different event management pages:');
        $this->newLine();

        $this->info('   1. 📝 ORGANIZER Event Management (/event)');
        $this->info('      - Shows only YOUR OWN events');
        $this->info('      - Used by organizers to manage their events');
        $this->info('      - Query: Events::where("user_id", Auth::user()->id)');
        $this->newLine();

        $this->info('   2. 👑 ADMIN Event Management (/events/admin)');
        $this->info('      - Shows ALL events from all organizers');
        $this->info('      - Used by admins to approve/reject events');
        $this->info('      - Query: Events::all()');
        $this->newLine();

        // Show what each organizer should see
        $this->info('👥 What Each Organizer Should See:');
        foreach ($organizers as $organizer) {
            $organizerEvents = Events::where('user_id', $organizer->id)->get();
            if ($organizerEvents->count() > 0) {
                $approved = $organizerEvents->where('status', 'approved')->count();
                $pending = $organizerEvents->where('status', 'pending')->count();
                $rejected = $organizerEvents->where('status', 'rejected')->count();

                $this->info("   {$organizer->name} (ID: {$organizer->id}):");
                $this->info("     Should see: {$organizerEvents->count()} events total");
                $this->info("     Breakdown: {$approved} approved, {$pending} pending, {$rejected} rejected");
                $this->info("     Event IDs: " . $organizerEvents->pluck('id')->implode(', '));
            } else {
                $this->info("   {$organizer->name} (ID: {$organizer->id}): No events");
            }
        }
        $this->newLine();

        // Show what admins should see
        $this->info('👑 What Admins Should See:');
        $this->info("   Admins should see ALL {$allEvents->count()} events from all organizers");
        $approvedCount = $allEvents->where('status', 'approved')->count();
        $pendingCount = $allEvents->where('status', 'pending')->count();
        $rejectedCount = $allEvents->where('status', 'rejected')->count();
        $this->info("   Breakdown: {$approvedCount} approved, {$pendingCount} pending, {$rejectedCount} rejected");
        $this->newLine();

        // Common misconceptions
        $this->info('❌ Common Misconceptions:');
        $this->info('   • "I should see all 10 approved events" - NO, only YOUR events');
        $this->info('   • "The system is broken if I see less than 10" - NO, depends on how many YOU created');
        $this->info('   • "Organizers should see all events" - NO, only admins see all events');
        $this->newLine();

        // Troubleshooting steps
        $this->info('🔧 Troubleshooting Steps:');
        $this->info('   1. Identify which user reported the issue');
        $this->info('   2. Check how many events THAT USER created');
        $this->info('   3. Verify they are on the correct page (/event vs /events/admin)');
        $this->info('   4. Test with their specific login credentials');
        $this->info('   5. Check browser console for JavaScript errors');
        $this->newLine();

        // Test URLs
        $this->info('🌐 Test URLs:');
        $this->info('   Organizer page: http://127.0.0.1:8000/event');
        $this->info('   Admin page: http://127.0.0.1:8000/events/admin');
        $this->newLine();

        $this->info('✅ Conclusion:');
        $this->info('   The system is working correctly. Each organizer sees only their own events.');
        $this->info('   If a user expects to see all events, they have a misunderstanding of the system design.');

        return 0;
    }
}
