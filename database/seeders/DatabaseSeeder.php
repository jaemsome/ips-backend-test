<?php

namespace Database\Seeders;

use App\Models\Lesson;
use App\Models\Comment;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $lessons = Lesson::factory()
            ->count(20)
            ->create();

        $comments = Comment::factory()
            ->count(50)
            ->create();

        $this->call([
            AchievementsTableSeeder::class,
            BadgesTableSeeder::class,
        ]);
    }
}
