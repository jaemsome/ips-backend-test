<?php

namespace App\Listeners;

use App\Events\LessonWatched;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use App\Models\Helper;

class LessonWatchedListener
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
    public function handle(LessonWatched $event): bool
    {
        try {
            // Access event data and perform actions
            $user   = $event->user;
            $lesson = $event->lesson;

            Log::info('LessonWatched => user: '.$user->id.' | lesson: '.$lesson->id);

            $user_watched = Helper::getCollectionColumnValues($user->watched, 'id');

            // Make sure to only add new lessons
            if( !in_array($lesson->id, $user_watched) ) {
                $user_watched[] = $lesson->id;
                $user->watched()->syncWithPivotValues($user_watched, ['watched' => TRUE]);
                
                // Check achievement
                $user->newAchievementUnlocked($event::EVENT_NAME, count($user_watched));

                return TRUE;
            }
        } catch(Exception $e) {
            Log::error('LessonWatched =>Exception: '.$e->getMessage());
        }

        return FALSE;
    }
}
