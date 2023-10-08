<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Achievement;
use App\Events\CommentWritten;
use App\Events\LessonWatched;

class AchievementsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $achievements = [
            // Achievement
            ['name' => 'First Lesson Watched', 'value'   => 1, 'type'  => LessonWatched::EVENT_NAME, 'created_at'  => now(), 'updated_at' => now()],
            ['name' => '5 Lessons Watched', 'value'  => 5, 'type'  => LessonWatched::EVENT_NAME, 'created_at'  => now(), 'updated_at' => now()],
            ['name' => '10 Lessons Watched', 'value' => 10, 'type' => LessonWatched::EVENT_NAME, 'created_at' => now(), 'updated_at' => now()],
            ['name' => '25 Lessons Watched', 'value' => 25, 'type' => LessonWatched::EVENT_NAME, 'created_at' => now(), 'updated_at' => now()],
            ['name' => '50 Lessons Watched', 'value' => 50, 'type' => LessonWatched::EVENT_NAME, 'created_at' => now(), 'updated_at' => now()],
            // Comment
            ['name' => 'First Comment Written', 'value'   => 1, 'type'  => CommentWritten::EVENT_NAME, 'created_at'  => now(), 'updated_at' => now()],
            ['name' => '3 Comments Written', 'value'  => 3, 'type'  => CommentWritten::EVENT_NAME, 'created_at'  => now(), 'updated_at' => now()],
            ['name' => '5 Comments Written', 'value'  => 5, 'type'  => CommentWritten::EVENT_NAME, 'created_at' => now(), 'updated_at' => now()],
            ['name' => '10 Comments Written', 'value' => 10, 'type' => CommentWritten::EVENT_NAME, 'created_at' => now(), 'updated_at' => now()],
            ['name' => '20 Comments Written', 'value' => 20, 'type' => CommentWritten::EVENT_NAME, 'created_at' => now(), 'updated_at' => now()],
        ];

        // Insert the achievement data into the 'achievements' table
        Achievement::insert($achievements);
    }
}
