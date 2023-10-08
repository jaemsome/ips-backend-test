<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class AchievementUnlockedEvent
{
    use Dispatchable, SerializesModels;

    public $user;
    public $achievement_name;

    /**
     * Create a new event instance.
     */
    public function __construct(User $user, string $achievement_name='')
    {
        Log::info('AchievementUnlockedEvent => User: '.json_encode($user).' | '.$achievement_name);

        $this->user = $user;
        $this->achievement_name = $achievement_name;
    }
}
