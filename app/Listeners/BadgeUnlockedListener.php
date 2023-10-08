<?php

namespace App\Listeners;

use App\Events\BadgeUnlockedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use App\Models\Badge;

class BadgeUnlockedListener
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
    public function handle(BadgeUnlockedEvent $event): bool
    {
        try {
            Log::info('BadgeUnlockedListener => '.json_encode($event));

            $user = $event->user;
            // Make sure user exists
            if( !empty($user->id) ) {
                $badge_name = $event->badge_name;
                // Check for new badge reached
                $new_badge = Badge::where([
                    'name'  => $badge_name,
                ])->first();
                // If badge found
                if( $new_badge ) {
                    $user->badge_id = $new_badge->id;
                    if( $user->save() ) {
                        Log::info('BadgeUnlockedListener => New Badge: User = '.$user->id.' | Badge = '.$new_badge->name);
                        return TRUE;
                    }
                    else
                        Log::error('BadgeUnlockedListener => Failed to set new Badge: User = '.$user->id.' | Badge = '.$new_badge->name);
                } else Log::error('BadgeUnlockedListener => Badge not found: '.json_encode($new_badge));
            } else Log::error('BadgeUnlockedListener => User not found: '.json_encode($user));
        } catch(Exception $e) {
            Log::error('BadgeUnlockedListener => Exception: '.$e->getMessage());
        }

        return FALSE;
    }
}
