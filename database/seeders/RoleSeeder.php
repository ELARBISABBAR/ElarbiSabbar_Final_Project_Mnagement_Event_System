<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles using Spatie Permission
        Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'organizer', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'editor', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'attendee', 'guard_name' => 'web']);

        // Create admin user with specified credentials
        $admin = \App\Models\User::updateOrCreate(
            ['email' => 'larbisbbar1234@gmail.com'],
            [
                'name' => 'Admin User',
                'email' => 'larbisbbar1234@gmail.com',
                'password' => bcrypt('Lwalida1981@'),
                'phone' => '1234567890',
                'role' => 'admin'
            ]
        );

        // Assign admin role
        $admin->assignRole('admin');
    }
}
