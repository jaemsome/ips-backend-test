<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\LessonWatched;
use App\Events\CommentWritten;
use App\Events\AchievementUnlockedEvent;
use App\Events\BadgeUnlockedEvent;
use App\Listeners\LessonWatchedListener;
use App\Listeners\CommentWrittenListener;
use App\Listeners\AchievementUnlockedListener;
use App\Listeners\BadgeUnlockedListener;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        LessonWatched::class => [
            LessonWatchedListener::class,
        ],
        CommentWritten::class => [
            CommentWrittenListener::class,
        ],
        AchievementUnlockedEvent::class => [
            AchievementUnlockedListener::class,
        ],
        BadgeUnlockedEvent::class => [
            BadgeUnlockedListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
