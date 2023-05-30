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
        // \App\Models\User::factory(10)->create();
        \App\Models\Album::factory(1)->has(\App\Models\Song::factory(4))->create();
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'password' => '123',
        // ]);

    }
}
