<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        
        DB::table('roles')->insert([
            'id' => 1,
            'value' => 'user'
        ]);
        DB::table('roles')->insert([
            'id' => 2,
            'value' => 'worker'
        ]);
        DB::table('roles')->insert([
            'id' => 3,
            'value' => 'admin'
        ]);

        \App\Models\User::factory()->create([
            'name' => 'AdminTest User',
            'email' => 'kazaev@vk.com',
        ]);

        DB::table('role_user')->insert([
            'user_id' => 1,
            'role_id' => 3,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('role_user')->insert([
            'user_id' => 1,
            'role_id' => 2,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        DB::table('role_user')->insert([
            'user_id' => 2,
            'role_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // $users = \App\Models\User::factory(50)->create();
        // for($i=6; $i<=count($users); $i++){DB::table('role_user')->insert(['user_id' => $i, 'role_id' => rand(1, 2), 'created_at' => now(), 'updated_at' => now()]);}
        
        // \App\Models\Task::factory(20)->create();
        
    }
}
