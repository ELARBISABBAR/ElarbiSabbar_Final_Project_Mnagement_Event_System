<?php

namespace Database\Seeders;

use App\Models\Events;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class EventsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get organizers (users with role 'organizer')
        $organizers = User::where('role', 'organizer')->get();

        if ($organizers->isEmpty()) {
            $this->command->warn('No organizers found. Please run UserSeeder first.');
            return;
        }

        $events = [
            [
                'title' => 'Tech Conference 2025',
                'description' => 'Join us for the biggest technology conference of the year featuring keynotes from industry leaders, hands-on workshops, and networking opportunities.',
                'date_start' => Carbon::now()->addDays(30)->setTime(9, 0),
                'date_end' => Carbon::now()->addDays(30)->setTime(17, 0),
                'location' => 'San Francisco Convention Center, CA',
                'price' => 299.99,
                'image' => 'tech-conference.jpg',
            ],
            [
                'title' => 'Summer Music Festival',
                'description' => 'Experience three days of amazing music with top artists from around the world. Food trucks, art installations, and camping available.',
                'date_start' => Carbon::now()->addDays(45)->setTime(14, 0),
                'date_end' => Carbon::now()->addDays(47)->setTime(23, 0),
                'location' => 'Golden Gate Park, San Francisco, CA',
                'price' => 149.50,
                'image' => 'music-festival.jpg',
            ],
            [
                'title' => 'Business Leadership Summit',
                'description' => 'Learn from successful entrepreneurs and business leaders. Includes workshops on leadership, strategy, and innovation.',
                'date_start' => Carbon::now()->addDays(20)->setTime(8, 30),
                'date_end' => Carbon::now()->addDays(20)->setTime(18, 0),
                'location' => 'Marriott Hotel, New York, NY',
                'price' => 450.00,
                'image' => 'business-summit.jpg',
            ],
            [
                'title' => 'Art & Design Workshop',
                'description' => 'Hands-on workshop for artists and designers. Learn new techniques, get inspired, and connect with fellow creatives.',
                'date_start' => Carbon::now()->addDays(15)->setTime(10, 0),
                'date_end' => Carbon::now()->addDays(15)->setTime(16, 0),
                'location' => 'Creative Arts Center, Los Angeles, CA',
                'price' => 89.99,
                'image' => 'art-workshop.jpg',
            ],
            [
                'title' => 'Food & Wine Tasting',
                'description' => 'Discover exquisite wines paired with gourmet cuisine from renowned chefs. An evening of culinary excellence.',
                'date_start' => Carbon::now()->addDays(25)->setTime(18, 0),
                'date_end' => Carbon::now()->addDays(25)->setTime(22, 0),
                'location' => 'Napa Valley Winery, CA',
                'price' => 125.00,
                'image' => 'wine-tasting.jpg',
            ],
            [
                'title' => 'Startup Pitch Competition',
                'description' => 'Watch innovative startups pitch their ideas to investors. Network with entrepreneurs and learn about the latest trends.',
                'date_start' => Carbon::now()->addDays(35)->setTime(13, 0),
                'date_end' => Carbon::now()->addDays(35)->setTime(19, 0),
                'location' => 'Silicon Valley Innovation Hub, CA',
                'price' => 75.00,
                'image' => 'startup-pitch.jpg',
            ],
            [
                'title' => 'Photography Masterclass',
                'description' => 'Learn advanced photography techniques from professional photographers. Includes outdoor shooting session.',
                'date_start' => Carbon::now()->addDays(40)->setTime(9, 0),
                'date_end' => Carbon::now()->addDays(40)->setTime(15, 0),
                'location' => 'Photography Studio, Seattle, WA',
                'price' => 199.00,
                'image' => 'photography-class.jpg',
            ],
            [
                'title' => 'Health & Wellness Expo',
                'description' => 'Explore the latest in health and wellness. Features fitness demonstrations, healthy cooking classes, and wellness vendors.',
                'date_start' => Carbon::now()->addDays(50)->setTime(10, 0),
                'date_end' => Carbon::now()->addDays(50)->setTime(18, 0),
                'location' => 'Convention Center, Austin, TX',
                'price' => 35.00,
                'image' => 'wellness-expo.jpg',
            ],
        ];

        foreach ($events as $index => $eventData) {
            // Assign events to organizers in round-robin fashion
            $organizer = $organizers[$index % $organizers->count()];

            Events::create([
                'title' => $eventData['title'],
                'user_id' => $organizer->id,
                'description' => $eventData['description'],
                'date_start' => $eventData['date_start'],
                'date_end' => $eventData['date_end'],
                'location' => $eventData['location'],
                'price' => $eventData['price'],
                'image' => $eventData['image'],
            ]);
        }

        $this->command->info('Created ' . count($events) . ' events successfully!');
    }
}
