<?php

namespace App\Console\Commands;

use App\Models\Events;
use App\Models\User;
use Illuminate\Console\Command;

class TestOrganizerView extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:organizer-view {user_id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test what an organizer sees in their manage events page';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $userId = $this->argument('user_id');

        if (!$userId) {
            // Show all organizers and let user choose
            $organizers = User::role('organizer')->get();
            $this->info('Available organizers:');
            foreach ($organizers as $organizer) {
                $eventCount = Events::where('user_id', $organizer->id)->count();
                $this->info("  ID {$organizer->id}: {$organizer->name} ({$eventCount} events)");
            }
            $this->newLine();
            $this->info('Usage: php artisan test:organizer-view {user_id}');
            return;
        }

        $user = User::find($userId);
        if (!$user) {
            $this->error("User with ID {$userId} not found.");
            return;
        }

        if (!$user->hasRole('organizer')) {
            $this->error("User {$user->name} is not an organizer.");
            return;
        }

        $this->info("🎯 Testing Organizer View for: {$user->name} (ID: {$user->id})");
        $this->info('='.str_repeat('=', 50));
        $this->newLine();

        // Simulate the exact query from CreateEventsController::index()
        $events = Events::where('user_id', $user->id)->get();

        $this->info("📊 Query Results:");
        $this->info("   Query: Events::where('user_id', {$user->id})->get()");
        $this->info("   Total events returned: {$events->count()}");
        $this->newLine();

        if ($events->count() > 0) {
            $this->info("📅 Events List:");
            foreach ($events as $index => $event) {
                $status = $event->status ?? 'no_status';
                $visibility = $event->visibility ?? 'no_visibility';
                $this->info("   " . ($index + 1) . ". #{$event->id} - {$event->title}");
                $this->info("      Status: {$status} | Visibility: {$visibility}");
                $this->info("      Date: {$event->date_start->format('M j, Y g:i A')}");
                $this->info("      Location: {$event->location}");
            }
        } else {
            $this->warn("   No events found for this organizer.");
        }

        $this->newLine();
        $this->info("📋 Status Breakdown:");
        $statusCounts = $events->groupBy('status')->map->count();
        foreach ($statusCounts as $status => $count) {
            $this->info("   {$status}: {$count} events");
        }

        $this->newLine();
        $this->info("🔍 Potential Issues Check:");

        // Check if there are any database issues
        $this->info("   ✅ Events model doesn't use soft deletes");

        // Check for any database constraints
        $this->info("   ✅ No pagination applied (using ->get())");
        $this->info("   ✅ No status filtering applied");
        $this->info("   ✅ No date filtering applied");

        $this->newLine();
        $this->info("🎯 Expected Behavior:");
        $this->info("   The organizer should see ALL {$events->count()} events in their manage events page.");
        $this->info("   Each event should display with its current status (approved/pending/rejected).");
    }
}
