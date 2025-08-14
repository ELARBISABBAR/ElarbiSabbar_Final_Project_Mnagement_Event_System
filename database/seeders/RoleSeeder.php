<?php

namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        DB::table('roles')->insert([
            [
                "name" => "admin",
                "guard_name" => "web"
            ],
            [
                "name" => "organizer",
                "guard_name" => "web"
            ],
        ]);

        DB::table('model_has_roles')->insert([
            [
                'role_id' => 1,
                'model_type' => "App\Models\User",
                'model_id'=> 1
            ],
            [
                'role_id' => 2,
                'model_type' => "App\Models\User",
                'model_id'=> 2
            ],
        ]);
    }
}
