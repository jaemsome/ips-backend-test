<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Events\AchievementUnlockedEvent;
use App\Listeners\AchievementUnlockedListener;
use App\Models\Achievement;
use App\Models\User;
use App\Models\Lesson;
use App\Models\Comment;
use App\Events\LessonWatched;
use App\Events\CommentWritten;
use Database\Seeders\AchievementsTableSeeder;
use Database\Seeders\BadgesTableSeeder;
use Database\Seeders\CommentsTableSeeder;

class AchievementUnlockedTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(AchievementsTableSeeder::class);
        $this->seed(BadgesTableSeeder::class);
    }

    /**
     * @test
     * 
     * @group achievement_unlocked
     */
    public function lesson_watched_achievement_unlocked_listener(): void
    {
        $user = User::factory()->create();
        $lesson = Lesson::factory()->create();

        $name = 'First Lesson Watched';
        $this->assertDatabaseHas('achievements', ['name' => $name]);
        $achievement = Achievement::where('name', $name)->first();

        // Add lesson to being watched
        $user->watched()->save($lesson);
        
        // Create and Dispatch an event
        $event = new AchievementUnlockedEvent($user, $achievement->name);

        $listener = new AchievementUnlockedListener();

        $this->assertTrue($listener->handle($event));
    }

    /**
     * @test
     * 
     * @group achievement_unlocked
     */
    public function comment_written_achievement_unlocked_listener(): void
    {
        $this->seed(CommentsTableSeeder::class);

        $comment = Comment::find(1);
        $this->assertNotNull($comment);

        $user = $comment->user;
        $this->assertNotNull($user);

        $name = 'First Comment Written';
        $this->assertDatabaseHas('achievements', ['name' => $name]);
        $achievement = Achievement::where('name', $name)->first();
        
        // Create and Dispatch an event
        $event = new AchievementUnlockedEvent($user, $achievement->name);

        $listener = new AchievementUnlockedListener();

        $this->assertTrue($listener->handle($event));
    }
}
