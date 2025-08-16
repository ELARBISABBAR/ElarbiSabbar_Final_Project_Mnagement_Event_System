<?php

namespace App\Console\Commands;

use App\Models\Events;
use App\Models\User;
use Illuminate\Console\Command;

class EventDataAnalysis extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'debug:events';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Analyze event data and display issues';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 Event Data Analysis');
        $this->info('=====================');
        $this->newLine();

        // Get all events
        $events = Events::with(['user', 'category'])->get();

        $this->info("📊 Total Events: {$events->count()}");
        $this->newLine();

        // Analyze by status
        $statusCounts = $events->groupBy('status')->map->count();
        $this->info('📋 Events by Status:');
        foreach ($statusCounts as $status => $count) {
            $this->info("   {$status}: {$count} events");
        }
        $this->newLine();

        // Analyze by organizer
        $this->info('👥 Events by Organizer:');
        $eventsByUser = $events->groupBy('user_id');
        foreach ($eventsByUser as $userId => $userEvents) {
            $user = $userEvents->first()->user;
            $approved = $userEvents->where('status', 'approved')->count();
            $pending = $userEvents->where('status', 'pending')->count();
            $rejected = $userEvents->where('status', 'rejected')->count();

            $this->info("   {$user->name} ({$user->role}):");
            $this->info("     Total: {$userEvents->count()} | Approved: {$approved} | Pending: {$pending} | Rejected: {$rejected}");
        }
        $this->newLine();

        // Show detailed event list
        $this->info('📅 Detailed Event List:');
        foreach ($events as $event) {
            $organizer = $event->user->name;
            $status = $event->status ?? 'no_status';
            $this->info("   #{$event->id} - {$event->title} | {$organizer} | Status: {$status}");
        }
        $this->newLine();

        // Check for organizers specifically
        $organizers = User::role('organizer')->get();
        $this->info('🎯 Organizer Analysis:');
        foreach ($organizers as $organizer) {
            $organizerEvents = Events::where('user_id', $organizer->id)->get();
            $approvedEvents = $organizerEvents->where('status', 'approved');

            $this->info("   {$organizer->name} (ID: {$organizer->id}):");
            $this->info("     Total events: {$organizerEvents->count()}");
            $this->info("     Approved events: {$approvedEvents->count()}");

            if ($organizerEvents->count() > 0) {
                $this->info("     All event IDs: " . $organizerEvents->pluck('id')->implode(', '));
                $this->info("     All event statuses: " . $organizerEvents->pluck('status')->implode(', '));
            }

            if ($approvedEvents->count() > 0) {
                $this->info("     Approved event IDs: " . $approvedEvents->pluck('id')->implode(', '));
            }
        }

        $this->newLine();
        $this->info('🔍 Potential Issues:');

        // Check if there are any events without status
        $eventsWithoutStatus = Events::whereNull('status')->orWhere('status', '')->get();
        if ($eventsWithoutStatus->count() > 0) {
            $this->warn("   ⚠️  Events without status: {$eventsWithoutStatus->count()}");
            $this->warn("     Event IDs: " . $eventsWithoutStatus->pluck('id')->implode(', '));
        }

        // Check if there are pagination issues
        $this->info("   📄 Checking for pagination in CreateEventsController...");
        $this->info("   Current query: Events::where('user_id', Auth::user()->id)->get()");
        $this->info("   This query fetches ALL events for the user, no pagination limit.");
    }
}
