<?php

namespace Database\Seeders;

use App\Models\Events;
use App\Models\User;
use App\Models\Category;
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

        // Get categories
        $categories = Category::all();

        if ($organizers->isEmpty()) {
            $this->command->warn('No organizers found. Please run UserSeeder first.');
            return;
        }

        if ($categories->isEmpty()) {
            $this->command->warn('No categories found. Please run CategorySeeder first.');
            return;
        }

        $events = [
            [
                'title' => 'AI & Machine Learning Summit 2024',
                'description' => 'Join industry leaders and AI experts for a comprehensive summit covering the latest trends in artificial intelligence, machine learning, and deep learning technologies. Featuring keynote speakers from Google, Microsoft, and OpenAI.',
                'date_start' => Carbon::now()->addDays(15)->setTime(9, 0),
                'date_end' => Carbon::now()->addDays(15)->setTime(17, 30),
                'location' => 'San Francisco Convention Center, CA',
                'price' => 299.00,
                'image' => 'ai_summit_2024.jpg',
                'category_name' => 'Technology & Innovation',
                'visibility' => 'public',
                'status' => 'approved',
                'approved_at' => Carbon::now()->subDays(5),
            ],
            [
                'title' => 'Digital Marketing Masterclass',
                'description' => 'Master the art of digital marketing with hands-on workshops covering SEO, social media marketing, content strategy, and paid advertising. Learn from industry experts who have managed campaigns for Fortune 500 companies.',
                'date_start' => Carbon::now()->addDays(8)->setTime(10, 0),
                'date_end' => Carbon::now()->addDays(8)->setTime(16, 0),
                'location' => 'New York Business Center, NY',
                'price' => 149.00,
                'image' => 'digital_marketing_masterclass.jpg',
                'category_name' => 'Business & Professional',
                'visibility' => 'private',
                'status' => 'approved',
                'approved_at' => Carbon::now()->subDays(3),
            ],
            [
                'title' => 'Jazz Under the Stars Festival',
                'description' => 'Experience an enchanting evening of smooth jazz under the open sky. Featuring renowned jazz musicians from around the world, food trucks with gourmet cuisine, and a relaxed outdoor atmosphere.',
                'date_start' => Carbon::now()->addDays(22)->setTime(19, 0),
                'date_end' => Carbon::now()->addDays(22)->setTime(23, 30),
                'location' => 'Central Park Amphitheater, NY',
                'price' => 75.00,
                'image' => 'jazz_festival_2024.jpg',
                'category_name' => 'Arts & Entertainment',
                'visibility' => 'public',
                'status' => 'pending',
                'approved_at' => null,
            ],
            [
                'title' => 'Marathon Training Workshop',
                'description' => 'Comprehensive marathon training program designed for runners of all levels. Learn proper running techniques, nutrition strategies, injury prevention, and mental preparation from certified trainers.',
                'date_start' => Carbon::now()->addDays(5)->setTime(7, 0),
                'date_end' => Carbon::now()->addDays(5)->setTime(12, 0),
                'location' => 'City Sports Complex, Los Angeles',
                'price' => 89.00,
                'image' => 'marathon_training_2024.jpg',
                'category_name' => 'Sports & Fitness',
                'visibility' => 'members_only',
                'status' => 'approved',
                'approved_at' => Carbon::now()->subDays(7),
            ],
            [
                'title' => 'Startup Pitch Competition',
                'description' => 'Witness the next generation of entrepreneurs pitch their innovative ideas to a panel of venture capitalists and industry experts. Open to all attendees, with networking sessions and mentorship opportunities.',
                'date_start' => Carbon::now()->addDays(30)->setTime(14, 0),
                'date_end' => Carbon::now()->addDays(30)->setTime(20, 0),
                'location' => 'Innovation Hub, Austin, TX',
                'price' => 0.00, // Free event
                'image' => 'startup_pitch_competition.jpg',
                'category_name' => 'Business & Professional',
                'visibility' => 'public',
                'status' => 'pending',
                'approved_at' => null,
            ],
            [
                'title' => 'Gourmet Food & Wine Tasting',
                'description' => 'Indulge in an exquisite culinary experience featuring award-winning chefs and premium wines from renowned vineyards. Sample artisanal dishes and learn about wine pairing techniques.',
                'date_start' => Carbon::now()->addDays(12)->setTime(18, 30),
                'date_end' => Carbon::now()->addDays(12)->setTime(22, 0),
                'location' => 'Grand Hotel Ballroom, Chicago',
                'price' => 185.00,
                'image' => 'food_wine_tasting.jpg',
                'category_name' => 'Food & Beverage',
                'visibility' => 'private',
                'status' => 'approved',
                'approved_at' => Carbon::now()->subDays(2),
            ],
            [
                'title' => 'Cybersecurity Conference 2024',
                'description' => 'Stay ahead of cyber threats with insights from leading cybersecurity experts. Topics include threat intelligence, incident response, cloud security, and emerging attack vectors.',
                'date_start' => Carbon::now()->addDays(45)->setTime(8, 30),
                'date_end' => Carbon::now()->addDays(46)->setTime(17, 0), // 2-day event
                'location' => 'Washington DC Convention Center',
                'price' => 450.00,
                'image' => 'cybersecurity_conference.jpg',
                'category_name' => 'Technology & Innovation',
                'visibility' => 'public',
                'status' => 'approved',
                'approved_at' => Carbon::now()->subDays(10),
            ],
            [
                'title' => 'Photography Workshop: Portrait Mastery',
                'description' => 'Elevate your portrait photography skills with professional techniques for lighting, composition, and post-processing. Hands-on workshop with live models and professional equipment.',
                'date_start' => Carbon::now()->addDays(18)->setTime(13, 0),
                'date_end' => Carbon::now()->addDays(18)->setTime(18, 0),
                'location' => 'Creative Arts Studio, Portland, OR',
                'price' => 125.00,
                'image' => 'photography_workshop.jpg',
                'category_name' => 'Arts & Entertainment',
                'visibility' => 'members_only',
                'status' => 'pending',
                'approved_at' => null,
            ],
        ];

        foreach ($events as $index => $eventData) {
            // Assign events to organizers in round-robin fashion
            $organizer = $organizers[$index % $organizers->count()];

            // Find or create category
            $category = null;
            if (isset($eventData['category_name'])) {
                $category = $categories->where('name', $eventData['category_name'])->first();
                if (!$category) {
                    // Use the first available category as fallback
                    $category = $categories->first();
                }
            } else {
                // Use the first available category as fallback
                $category = $categories->first();
            }

            Events::create([
                'title' => $eventData['title'],
                'user_id' => $organizer->id,
                'description' => $eventData['description'],
                'date_start' => $eventData['date_start'],
                'date_end' => $eventData['date_end'],
                'location' => $eventData['location'],
                'price' => $eventData['price'],
                'image' => $eventData['image'],
                'category_id' => $category->id,
                'visibility' => $eventData['visibility'] ?? 'public',
                'status' => $eventData['status'] ?? 'pending',
                'approved_at' => $eventData['approved_at'] ?? null,
                'approved_by' => ($eventData['status'] ?? 'pending') === 'approved' ? 1 : null, // Assuming admin user ID is 1
            ]);
        }

        $this->command->info('Created ' . count($events) . ' events successfully!');
    }
}
