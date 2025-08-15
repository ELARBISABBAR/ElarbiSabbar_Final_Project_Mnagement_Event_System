<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class AdditionalCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Business & Professional',
                'slug' => 'business-professional',
                'description' => 'Business conferences, networking events, professional development workshops, and corporate training sessions',
                'icon' => 'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V8a2 2 0 012-2V6',
                'color' => '#059669',
                'is_active' => true,
            ],
            [
                'name' => 'Arts & Entertainment',
                'slug' => 'arts-entertainment',
                'description' => 'Art exhibitions, music concerts, theater performances, cultural festivals, and creative workshops',
                'icon' => 'M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2h3a1 1 0 011 1v14a1 1 0 01-1 1H4a1 1 0 01-1-1V5a1 1 0 011-1h3zM9 3v1h6V3H9zm-4 3v12h14V6H5z',
                'color' => '#7C3AED',
                'is_active' => true,
            ],
            [
                'name' => 'Sports & Fitness',
                'slug' => 'sports-fitness',
                'description' => 'Sports competitions, fitness workshops, training sessions, marathons, and wellness events',
                'icon' => 'M13 10V3L4 14h7v7l9-11h-7z',
                'color' => '#DC2626',
                'is_active' => true,
            ],
            [
                'name' => 'Food & Beverage',
                'slug' => 'food-beverage',
                'description' => 'Culinary events, wine tastings, cooking classes, food festivals, and restaurant experiences',
                'icon' => 'M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z',
                'color' => '#EA580C',
                'is_active' => true,
            ],
            [
                'name' => 'Education & Learning',
                'slug' => 'education-learning',
                'description' => 'Educational workshops, seminars, training programs, academic conferences, and skill development sessions',
                'icon' => 'M12 14l9-5-9-5-9 5 9 5z M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z',
                'color' => '#0891B2',
                'is_active' => true,
            ],
            [
                'name' => 'Health & Wellness',
                'slug' => 'health-wellness',
                'description' => 'Health seminars, wellness workshops, medical conferences, fitness events, and mental health awareness programs',
                'icon' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z',
                'color' => '#16A34A',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $categoryData) {
            // Check if category already exists
            $existingCategory = Category::where('slug', $categoryData['slug'])->first();
            
            if (!$existingCategory) {
                Category::create($categoryData);
                $this->command->info("Created category: {$categoryData['name']}");
            } else {
                $this->command->info("Category already exists: {$categoryData['name']}");
            }
        }

        $this->command->info('Additional categories seeded successfully!');
    }
}
