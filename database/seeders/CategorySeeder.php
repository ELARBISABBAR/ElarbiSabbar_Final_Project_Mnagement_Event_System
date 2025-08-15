<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Technology & Innovation',
                'slug' => 'technology-innovation',
                'description' => 'Tech conferences, workshops, product launches, and innovation summits',
                'icon' => 'M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z',
                'color' => '#3b82f6',
            ],
            [
                'name' => 'Music & Entertainment',
                'slug' => 'music-entertainment',
                'description' => 'Concerts, music festivals, live performances, and entertainment shows',
                'icon' => 'M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3',
                'color' => '#ec4899',
            ],
            [
                'name' => 'Business & Networking',
                'slug' => 'business-networking',
                'description' => 'Business conferences, networking events, startup pitches, and professional meetups',
                'icon' => 'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V8a2 2 0 012-2V6',
                'color' => '#059669',
            ],
            [
                'name' => 'Arts & Culture',
                'slug' => 'arts-culture',
                'description' => 'Art exhibitions, cultural festivals, theater performances, and creative workshops',
                'icon' => 'M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM21 5a2 2 0 00-2-2h-4a2 2 0 00-2 2v12a4 4 0 004 4 4 4 0 004-4V5z',
                'color' => '#8b5cf6',
            ],
            [
                'name' => 'Sports & Fitness',
                'slug' => 'sports-fitness',
                'description' => 'Sports events, fitness competitions, marathons, and wellness workshops',
                'icon' => 'M13 10V3L4 14h7v7l9-11h-7z',
                'color' => '#f59e0b',
            ],
            [
                'name' => 'Education & Learning',
                'slug' => 'education-learning',
                'description' => 'Educational seminars, workshops, training sessions, and academic conferences',
                'icon' => 'M12 14l9-5-9-5-9 5 9 5z M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z',
                'color' => '#dc2626',
            ],
            [
                'name' => 'Food & Dining',
                'slug' => 'food-dining',
                'description' => 'Food festivals, cooking classes, wine tastings, and culinary events',
                'icon' => 'M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z',
                'color' => '#ea580c',
            ],
            [
                'name' => 'Health & Wellness',
                'slug' => 'health-wellness',
                'description' => 'Health seminars, wellness retreats, medical conferences, and fitness events',
                'icon' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z',
                'color' => '#10b981',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
