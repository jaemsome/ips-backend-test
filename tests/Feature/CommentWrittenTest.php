<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Events\CommentWritten;
use App\Listeners\CommentWrittenListener;
use App\Models\Comment;

class CommentWrittenTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * 
     * @group comment_Written
     */
    public function comment_Written_listener(): void
    {
        $comment = Comment::factory()->create();
        
        // Create and Dispatch an event
        $event = new CommentWritten($comment);
        // event($event);

        $listener = new CommentWrittenListener();

        $this->assertTrue($listener->handle($event));
    }
}
