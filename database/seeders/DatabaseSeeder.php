<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'name'=>'Ananymus',
            'email'=>'ananymus@gmail.com',
            'image'=>'images/default-person.png',
            'user_bio'=>'anonim user',
            'password'=>Hash::make('932840470'),
        ]);
        \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            RetseptSeeder::class,
            CommentSeeder::class,
        ]);
    }
}
