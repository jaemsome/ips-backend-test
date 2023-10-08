<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use App\Models\Badge;
use App\Models\User;

class BadgeUnlockedEvent
{
    use Dispatchable, SerializesModels;

    public $user;
    public $badge_name;

    /**
     * Create a new event instance.
     */
    public function __construct(User $user, string $badge_name='')
    {
        Log::info('BadgeUnlockedEvent => User: '.json_encode($user).' | '.$badge_name);
        $this->user = $user;
        $this->badge_name = $badge_name;
    }
}
