<?php

namespace App\Console\Commands;

use App\Mail\WelcomeAttendee;
use App\Mail\WelcomeOrganizer;
use App\Mail\NewOrganizerNotification;
use App\Mail\EventCreated;
use App\Mail\NewEventNotification;
use App\Mail\TicketConfirmation;
use App\Mail\SalesNotification;
use App\Models\Events;
use App\Models\Tickets;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestAllEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:all-emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test all email notifications in the system';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 Testing all email notifications...');
        $this->newLine();

        // Get test data
        $attendee = User::where('role', 'attendee')->first();
        $organizer = User::where('role', 'organizer')->first();
        $admin = User::role('admin')->first();
        $event = Events::with(['user', 'category'])->first();

        if (!$attendee || !$organizer || !$admin || !$event) {
            $this->error('❌ Missing test data. Please ensure you have attendee, organizer, admin users and at least one event.');
            return;
        }

        $this->info("📧 Test emails will be sent to:");
        $this->info("   Attendee: {$attendee->email}");
        $this->info("   Organizer: {$organizer->email}");
        $this->info("   Admin: {$admin->email}");
        $this->newLine();

        $emailsSent = 0;
        $emailsFailed = 0;

        // Test 1: Welcome Attendee Email
        $this->testEmail('Welcome Attendee', function() use ($attendee) {
            Mail::to($attendee->email)->send(new WelcomeAttendee($attendee));
        }, $emailsSent, $emailsFailed);

        // Test 2: Welcome Organizer Email
        $this->testEmail('Welcome Organizer', function() use ($organizer) {
            Mail::to($organizer->email)->send(new WelcomeOrganizer($organizer));
        }, $emailsSent, $emailsFailed);

        // Test 3: New Organizer Notification (to Admin)
        $this->testEmail('New Organizer Notification', function() use ($admin, $organizer) {
            Mail::to($admin->email)->send(new NewOrganizerNotification($organizer));
        }, $emailsSent, $emailsFailed);

        // Test 4: Event Created Confirmation
        $this->testEmail('Event Created Confirmation', function() use ($event) {
            Mail::to($event->user->email)->send(new EventCreated($event));
        }, $emailsSent, $emailsFailed);

        // Test 5: New Event Notification (to Admin)
        $this->testEmail('New Event Notification', function() use ($admin, $event) {
            Mail::to($admin->email)->send(new NewEventNotification($event));
        }, $emailsSent, $emailsFailed);

        // Test 6: Ticket Confirmation & Sales Notification
        $ticket = $this->createTestTicket($attendee, $event);
        $transactionId = 'pi_test_' . time();

        $this->testEmail('Ticket Confirmation', function() use ($attendee, $ticket, $transactionId) {
            Mail::to($attendee->email)->send(new TicketConfirmation($ticket, $transactionId));
        }, $emailsSent, $emailsFailed);

        $this->testEmail('Sales Notification', function() use ($event, $ticket, $transactionId) {
            Mail::to($event->user->email)->send(new SalesNotification($ticket, $transactionId));
        }, $emailsSent, $emailsFailed);

        // Clean up test ticket
        $ticket->delete();

        // Summary
        $this->newLine();
        $this->info("📊 Email Testing Summary:");
        $this->info("   ✅ Emails sent successfully: {$emailsSent}");
        if ($emailsFailed > 0) {
            $this->error("   ❌ Emails failed: {$emailsFailed}");
        }
        $this->info("   📧 Check MailHog at http://localhost:8025 to view all emails");
        $this->newLine();

        if ($emailsFailed === 0) {
            $this->info('🎉 All email notifications are working perfectly!');
        } else {
            $this->warn('⚠️  Some emails failed. Check the logs for details.');
        }
    }

    private function testEmail($emailType, $callback, &$emailsSent, &$emailsFailed)
    {
        try {
            $this->info("📤 Sending {$emailType}...");
            $callback();
            $this->info("   ✅ {$emailType} sent successfully");
            $emailsSent++;
        } catch (\Exception $e) {
            $this->error("   ❌ {$emailType} failed: " . $e->getMessage());
            $emailsFailed++;
        }
    }

    private function createTestTicket($attendee, $event)
    {
        return Tickets::create([
            'user_id' => $attendee->id,
            'event_id' => $event->id,
            'ticket_type' => 'standard',
            'quantity' => 1,
            'price' => $event->price,
            'total_amount' => $event->price,
            'is_paid' => true,
            'payment_method' => 'stripe',
            'stripe_session_id' => 'test_session_' . time(),
            'purchased_at' => now(),
        ]);
    }
}
