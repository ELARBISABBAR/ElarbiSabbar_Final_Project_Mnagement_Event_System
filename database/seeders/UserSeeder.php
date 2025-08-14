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
        //

        User::insert([
            [
                'name'=>"achraf",
                'email'=>"achraf@gmail.com",
                'password'=>Hash::make("achraf@gmail.com"),
                'phone'=>"0689226137",
                'role'=>"admin",
            ],
            [
                'name'=>"userO1",
                'email'=>"o1@gmail.com",
                'password'=>Hash::make("o1@gmail.com"),
                'phone'=>"0666666666",
                'role'=>"organizer",
            ],
            [
                'name'=>"userA1",
                'email'=>"a1@gmail.com",
                'password'=>Hash::make("a1@gmail.com"),
                'phone'=>"0666666666",
                'role'=>"attendee",
            ],
            [
                'name'=>"userA2",
                'email'=>"a2@gmail.com",
                'password'=>Hash::make("a2@gmail.com"),
                'phone'=>"0666666666",
                'role'=>"attendee",
            ],
            [
                'name'=>"userA3",
                'email'=>"a3@gmail.com",
                'password'=>Hash::make("a3@gmail.com"),
                'phone'=>"0666666666",
                'role'=>"attendee",
            ],
            ]

        );
    
    }
}
