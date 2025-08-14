<?php

namespace Database\Seeders;

use App\Models\Events;
use App\Models\Tickets;
use App\Models\User;
use Illuminate\Database\Seeder;

class TicketsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all events and attendees
        $events = Events::all();
        $attendees = User::where('role', 'attendee')->get();

        if ($events->isEmpty() || $attendees->isEmpty()) {
            $this->command->warn('No events or attendees found. Please run EventsSeeder and UserSeeder first.');
            return;
        }

        $ticketTypes = ['standard', 'vip', 'early_bird', 'student'];
        $ticketsCreated = 0;

        foreach ($events as $event) {
            // Create 3-8 random tickets for each event
            $ticketCount = rand(3, 8);

            for ($i = 0; $i < $ticketCount; $i++) {
                $attendee = $attendees->random();
                $ticketType = $ticketTypes[array_rand($ticketTypes)];
                $quantity = rand(1, 4);

                // Calculate price based on ticket type
                $basePrice = $event->price;
                $price = match($ticketType) {
                    'vip' => $basePrice * 1.5,
                    'early_bird' => $basePrice * 0.8,
                    'student' => $basePrice * 0.6,
                    default => $basePrice
                };

                Tickets::create([
                    'user_id' => $attendee->id,
                    'event_id' => $event->id,
                    'ticket_type' => $ticketType,
                    'price' => round($price, 2),
                    'quantity' => $quantity,
                    'pdf' => null, // Will be generated when payment is complete
                    'is_paid' => rand(0, 1) === 1, // Random paid/unpaid status
                ]);

                $ticketsCreated++;
            }
        }

        $this->command->info("Created {$ticketsCreated} tickets successfully!");
    }
}
