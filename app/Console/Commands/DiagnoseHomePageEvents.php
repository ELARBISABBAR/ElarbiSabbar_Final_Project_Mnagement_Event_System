<?php

namespace App\Console\Commands;

use App\Models\Events;
use Illuminate\Console\Command;

class DiagnoseHomePageEvents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'diagnose:homepage';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Diagnose why events are missing from the home page';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 Home Page Event Display Diagnostic');
        $this->info('====================================');
        $this->newLine();

        // Get all events
        $allEvents = Events::with(['user', 'category'])->get();
        $this->info("📊 Total Events in Database: {$allEvents->count()}");
        $this->newLine();

        // Analyze by status
        $this->info('📋 Events by Status:');
        $statusCounts = $allEvents->groupBy('status')->map->count();
        foreach ($statusCounts as $status => $count) {
            $this->info("   {$status}: {$count} events");
        }
        $this->newLine();

        // Analyze by visibility
        $this->info('👁️  Events by Visibility:');
        $visibilityCounts = $allEvents->groupBy('visibility')->map->count();
        foreach ($visibilityCounts as $visibility => $count) {
            $this->info("   {$visibility}: {$count} events");
        }
        $this->newLine();

        // Check date filtering
        $this->info('📅 Date Analysis:');
        $now = now();
        $futureEvents = $allEvents->where('date_start', '>=', $now);
        $pastEvents = $allEvents->where('date_start', '<', $now);
        $this->info("   Future events (date_start >= now): {$futureEvents->count()}");
        $this->info("   Past events (date_start < now): {$pastEvents->count()}");
        $this->newLine();

        // Simulate HomeController query for guest users
        $this->info('🌐 Home Page Query Simulation (Guest User):');
        $guestQuery = Events::approved()
            ->where('visibility', 'public')
            ->where('date_start', '>=', $now)
            ->orderBy('date_start', 'asc');

        $guestEvents = $guestQuery->get();
        $this->info("   Events shown to guests: {$guestEvents->count()}");

        if ($guestEvents->count() > 0) {
            $this->info('   Guest-visible events:');
            foreach ($guestEvents as $event) {
                $this->info("     #{$event->id} - {$event->title} | {$event->date_start->format('M j, Y')} | {$event->visibility}");
            }
        }
        $this->newLine();

        // Simulate HomeController query for logged-in users (UPDATED)
        $this->info('👤 Home Page Query Simulation (Logged-in User - UPDATED):');
        $userQuery = Events::approved()
            ->whereIn('visibility', ['public', 'private', 'members_only']) // Updated to include members_only
            ->where('date_start', '>=', $now)
            ->orderBy('date_start', 'asc');

        $userEvents = $userQuery->get();
        $this->info("   Events shown to logged-in users: {$userEvents->count()}");

        if ($userEvents->count() > 0) {
            $this->info('   User-visible events:');
            foreach ($userEvents as $event) {
                $this->info("     #{$event->id} - {$event->title} | {$event->date_start->format('M j, Y')} | {$event->visibility}");
            }
        }
        $this->newLine();

        // Check what's being filtered out
        $this->info('❌ Events Filtered Out:');

        // Not approved
        $notApproved = $allEvents->where('status', '!=', 'approved');
        if ($notApproved->count() > 0) {
            $this->warn("   Not approved: {$notApproved->count()} events");
            foreach ($notApproved as $event) {
                $this->warn("     #{$event->id} - {$event->title} | Status: {$event->status}");
            }
        }

        // Past events
        if ($pastEvents->count() > 0) {
            $this->warn("   Past events (filtered by date): {$pastEvents->count()} events");
            foreach ($pastEvents as $event) {
                $this->warn("     #{$event->id} - {$event->title} | {$event->date_start->format('M j, Y')} (past)");
            }
        }

        // Members-only events
        $membersOnly = $allEvents->where('visibility', 'members_only');
        if ($membersOnly->count() > 0) {
            $this->warn("   Members-only events (not shown to regular users): {$membersOnly->count()} events");
            foreach ($membersOnly as $event) {
                $this->warn("     #{$event->id} - {$event->title} | Visibility: members_only");
            }
        }

        $this->newLine();

        // Recommendations
        $this->info('💡 Recommendations:');
        if ($pastEvents->count() > 0) {
            $this->info('   1. Past events are hidden by date filter - this is normal behavior');
        }
        if ($membersOnly->count() > 0) {
            $this->info('   2. Members-only events need special handling in visibleTo scope');
        }
        if ($notApproved->count() > 0) {
            $this->info('   3. Unapproved events need admin approval to appear on home page');
        }

        $this->info('   4. Check pagination - home page shows 12 events per page');
        $this->info('   5. Verify event creation workflow includes proper status setting');

        return 0;
    }
}
