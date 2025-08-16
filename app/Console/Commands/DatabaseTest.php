<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Events;
use App\Models\Tickets;
use App\Models\Category;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DatabaseTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:database';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test database integrity and relationships';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 Testing Database Integrity...');
        $this->newLine();

        // Test database connection
        try {
            DB::connection()->getPdo();
            $this->info('✅ Database connection: OK');
        } catch (\Exception $e) {
            $this->error('❌ Database connection failed: ' . $e->getMessage());
            return;
        }

        // Test model counts
        $userCount = User::count();
        $eventCount = Events::count();
        $ticketCount = Tickets::count();
        $categoryCount = Category::count();

        $this->info("📊 Model Counts:");
        $this->info("   Users: {$userCount}");
        $this->info("   Events: {$eventCount}");
        $this->info("   Tickets: {$ticketCount}");
        $this->info("   Categories: {$categoryCount}");
        $this->newLine();

        // Test relationships
        $this->info('🔗 Testing Model Relationships...');

        // Test Event relationships
        $event = Events::with(['user', 'category', 'tickets'])->first();
        if ($event) {
            $this->info("✅ Event-User relationship: {$event->user->name}");
            $this->info("✅ Event-Category relationship: " . ($event->category ? $event->category->name : 'No category'));
            $this->info("✅ Event-Tickets relationship: {$event->tickets->count()} tickets");
        } else {
            $this->warn('⚠️  No events found to test relationships');
        }

        // Test User roles
        $adminCount = User::role('admin')->count();
        $organizerCount = User::role('organizer')->count();
        $attendeeCount = User::role('attendee')->count();

        $this->info("👥 User Roles:");
        $this->info("   Admins: {$adminCount}");
        $this->info("   Organizers: {$organizerCount}");
        $this->info("   Attendees: {$attendeeCount}");
        $this->newLine();

        // Test Ticket relationships
        $ticket = Tickets::with(['user', 'event'])->first();
        if ($ticket) {
            $this->info("✅ Ticket-User relationship: {$ticket->user->name}");
            $this->info("✅ Ticket-Event relationship: {$ticket->event->title}");
        } else {
            $this->warn('⚠️  No tickets found to test relationships');
        }

        $this->newLine();
        $this->info('🎉 Database integrity check completed!');
    }
}
