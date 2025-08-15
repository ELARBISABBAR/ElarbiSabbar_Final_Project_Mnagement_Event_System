<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('Starting database seeding...');

        $this->call([
            UserSeeder::class,
            RoleSeeder::class,
            CategorySeeder::class,
            AdditionalCategoriesSeeder::class,
            EventsSeeder::class,
            TicketsSeeder::class,
        ]);

        $this->command->info('Database seeding completed successfully!');
    }
}
