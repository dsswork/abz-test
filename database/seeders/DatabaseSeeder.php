<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Position;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\Position::factory(5)->hasUsers(9)->create();

        \App\Models\User::insert([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'phone' => '+380678390757',
            'photo' => '',
            'position_id' => Position::first()->id,
            'is_admin' => 1
        ]);

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
