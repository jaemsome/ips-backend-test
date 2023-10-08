<?php

namespace App\Listeners;

use App\Events\CommentWritten;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use App\Models\Helper;

class CommentWrittenListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(CommentWritten $event): void
    {
        try {
            // Access event data and perform actions
            $comment = $event->comment;

            Log::info('CommentWrittenListener => comment: '.json_encode($comment));

            if( !empty($comment->id) ) {
                $user = $comment->user;

                if( !empty($user->id) ) {
                    $user_comments = Helper::getCollectionColumnValues($user->comments, 'id');
    
                    // Check achievement
                    $user->newAchievementUnlocked($event::EVENT_NAME, count($user_comments));
                } else Log::error('CommentWrittenListener => User not found: '.json_encode($user));
            } else Log::error('CommentWrittenListener => Comment not found: '.json_encode($comment));
        } catch(Exception $e) {
            Log::error('CommentWrittenListener =>Exception: '.$e->getMessage());
        }
    }
}
