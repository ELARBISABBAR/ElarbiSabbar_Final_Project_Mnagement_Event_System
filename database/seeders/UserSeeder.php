<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user with specified credentials
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'larbisbbar1234@gmail.com',
            'password' => Hash::make('Lwalida1981@'),
            'phone' => '+1-555-0101',
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Create organizers
        $organizers = [
            [
                'name' => 'Sarah Johnson',
                'email' => 'sarah@evenext.com',
                'password' => Hash::make('password'),
                'phone' => '+1-555-0102',
                'role' => 'organizer',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Michael Chen',
                'email' => 'michael@evenext.com',
                'password' => Hash::make('password'),
                'phone' => '+1-555-0103',
                'role' => 'organizer',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Emily Rodriguez',
                'email' => 'emily@evenext.com',
                'password' => Hash::make('password'),
                'phone' => '+1-555-0104',
                'role' => 'organizer',
                'email_verified_at' => now(),
            ],
        ];

        foreach ($organizers as $organizer) {
            User::create($organizer);
        }

        // Create attendees
        $attendees = [
            [
                'name' => 'John Smith',
                'email' => 'john@example.com',
                'password' => Hash::make('password'),
                'phone' => '+1-555-0201',
                'role' => 'attendee',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Lisa Wang',
                'email' => 'lisa@example.com',
                'password' => Hash::make('password'),
                'phone' => '+1-555-0202',
                'role' => 'attendee',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'David Brown',
                'email' => 'david@example.com',
                'password' => Hash::make('password'),
                'phone' => '+1-555-0203',
                'role' => 'attendee',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Maria Garcia',
                'email' => 'maria@example.com',
                'password' => Hash::make('password'),
                'phone' => '+1-555-0204',
                'role' => 'attendee',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'James Wilson',
                'email' => 'james@example.com',
                'password' => Hash::make('password'),
                'phone' => '+1-555-0205',
                'role' => 'attendee',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Anna Thompson',
                'email' => 'anna@example.com',
                'password' => Hash::make('password'),
                'phone' => '+1-555-0206',
                'role' => 'attendee',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Robert Lee',
                'email' => 'robert@example.com',
                'password' => Hash::make('password'),
                'phone' => '+1-555-0207',
                'role' => 'attendee',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Jennifer Davis',
                'email' => 'jennifer@example.com',
                'password' => Hash::make('password'),
                'phone' => '+1-555-0208',
                'role' => 'attendee',
                'email_verified_at' => now(),
            ],
        ];

        foreach ($attendees as $attendee) {
            User::create($attendee);
        }
    }
}
