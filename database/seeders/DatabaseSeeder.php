<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\User;
use Database\Factories\ArticleFactory;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // User::factory(5)->create();
        User::create([
            'name' => "User Test",
            'email' => "usertest@email.com",
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);

        User::create([
            'name' => "User Test2",
            'email' => "usertest2@email.com",
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);

        Category::create([
            'name' => 'Front End Developer',
            'user_id' => 1,
        ]);

        Category::create([
            'name' => 'Back End Developer',
            'user_id' => 2,
        ]);

        Category::create([
            'name' => 'Fullstack Developer',
            'user_id' => 1,
        ]);
        

        Article::factory(20)->create();
        
    }
}
