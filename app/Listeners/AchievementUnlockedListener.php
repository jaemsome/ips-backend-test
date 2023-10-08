<?php

namespace App\Listeners;

use App\Events\AchievementUnlockedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use App\Models\Achievement;
use App\Models\Helper;
use App\Models\Badge;

class AchievementUnlockedListener
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
    public function handle(AchievementUnlockedEvent $event): bool
    {
        try {
            Log::info('AchievementUnlockedListener => '.json_encode($event));

            $user = $event->user;
            // Make sure user exists
            if( !empty($user->id) ) {
                $achievement_name = $event->achievement_name;
                // Check for new achievement reached
                $new_achievement = Achievement::where([
                    'name'  => $achievement_name,
                ])->first();
                // If an achievement found
                if( $new_achievement ) {
                    // Make sure new achievement is not added yet
                    $achievements = Helper::getCollectionColumnValues($user->achievements, 'id');
                    if( !in_array($new_achievement->id, $achievements) ) {
                        $achievements[] = $new_achievement->id;
                        $user->achievements()->sync($achievements);
                        $user->achievements()->updateExistingPivot($new_achievement, [
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);

                        $total_achievements = count($achievements);

                        Log::info('AchievementUnlockedListener => New Reached: User = '.$user->id.' | Achievements ['.$total_achievements.'] = '.json_encode($achievements));

                        // Check new badge
                        $user->newBadgeUnlocked($total_achievements);

                        return TRUE;
                    }
                }
            } else Log::error('AchievementUnlockedListener => User not found: '.json_encode($user));
        } catch(Exception $e) {
            Log::error('AchievementUnlockedListener => Exception: '.$e->getMessage());
        }

        return FALSE;
    }
}
