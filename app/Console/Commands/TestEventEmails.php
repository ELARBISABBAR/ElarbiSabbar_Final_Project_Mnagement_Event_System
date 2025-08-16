<?php

namespace App\Console\Commands;

use App\Mail\EventCreated;
use App\Mail\NewEventNotification;
use App\Models\Events;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestEventEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:event-emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test event creation emails';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Testing event creation emails...');

        // Get a sample event and organizer
        $event = Events::with(['user', 'category'])->first();
        $admin = User::role('admin')->first();

        if (!$event) {
            $this->error('No events found. Please create some test data first.');
            return;
        }

        if (!$admin) {
            $this->error('No admin user found. Please create an admin user first.');
            return;
        }

        try {
            // Test event creation confirmation email
            $this->info('Sending event creation confirmation email...');
            Mail::to($event->user->email)->send(new EventCreated($event));
            $this->info("✅ Event creation confirmation email sent to: {$event->user->email}");

            // Test admin notification email
            $this->info('Sending admin notification email...');
            Mail::to($admin->email)->send(new NewEventNotification($event));
            $this->info("✅ Admin notification email sent to: {$admin->email}");

            $this->info('🎉 All event emails sent successfully!');
            $this->info('Check MailHog at http://localhost:8025 to view the emails.');

        } catch (\Exception $e) {
            $this->error('❌ Failed to send emails: ' . $e->getMessage());
        }
    }
}
