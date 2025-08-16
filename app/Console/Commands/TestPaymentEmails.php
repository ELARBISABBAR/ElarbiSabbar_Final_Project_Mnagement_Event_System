<?php

namespace App\Console\Commands;

use App\Mail\TicketConfirmation;
use App\Mail\SalesNotification;
use App\Models\Events;
use App\Models\Tickets;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestPaymentEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:payment-emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test payment confirmation emails';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Testing payment confirmation emails...');

        // Get a sample event and user
        $event = Events::first();
        $user = User::where('role', 'attendee')->first();

        if (!$event || !$user) {
            $this->error('No event or attendee user found. Please create some test data first.');
            return;
        }

        // Create a real test ticket in the database
        $ticket = Tickets::create([
            'user_id' => $user->id,
            'event_id' => $event->id,
            'ticket_type' => 'standard',
            'quantity' => 2,
            'price' => $event->price,
            'total_amount' => $event->price * 2,
            'is_paid' => true,
            'payment_method' => 'stripe',
            'stripe_session_id' => 'test_session_' . time(),
            'purchased_at' => now(),
        ]);

        $transactionId = 'pi_test_' . time();

        try {
            // Test ticket confirmation email (send synchronously)
            $this->info('Sending ticket confirmation email...');
            $ticketMail = new TicketConfirmation($ticket, $transactionId);
            Mail::to($user->email)->send($ticketMail);
            $this->info("✅ Ticket confirmation email sent to: {$user->email}");

            // Test sales notification email (send synchronously)
            $this->info('Sending sales notification email...');
            $salesMail = new SalesNotification($ticket, $transactionId);
            Mail::to($event->user->email)->send($salesMail);
            $this->info("✅ Sales notification email sent to: {$event->user->email}");

            $this->info('🎉 All payment emails sent successfully!');
            $this->info('Check MailHog at http://localhost:8025 to view the emails.');

            // Clean up test ticket
            $ticket->delete();
            $this->info('Test ticket cleaned up.');

        } catch (\Exception $e) {
            $this->error('❌ Failed to send emails: ' . $e->getMessage());
            // Clean up test ticket even if email fails
            if (isset($ticket) && $ticket->exists) {
                $ticket->delete();
            }
        }
    }
}
