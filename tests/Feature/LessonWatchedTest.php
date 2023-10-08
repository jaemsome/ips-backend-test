<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Events\LessonWatched;
use App\Listeners\LessonWatchedListener;
use App\Models\User;
use App\Models\Lesson;

class LessonWatchedTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * 
     * @group lesson_watched
     */
    public function lesson_watched_listener(): void
    {
        $user = User::factory()->create();
        $lesson = Lesson::factory()->create();
        
        // Create and Dispatch an event
        $event = new LessonWatched($lesson, $user);
        // event($event);

        $listener = new LessonWatchedListener();

        $this->assertTrue($listener->handle($event));
    }
}
