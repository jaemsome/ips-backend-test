<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Badge;
use Database\Seeders\BadgesTableSeeder;
use App\Events\BadgeUnlockedEvent;
use App\Listeners\BadgeUnlockedListener;

class BadgeUnlockedTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        // $this->seed(AchievementsTableSeeder::class);
        $this->seed(BadgesTableSeeder::class);
    }

    /**
     * @test
     * 
     * @group badge_unlocked
     */
    public function badge_unlocked_listener(): void
    {
        $user = User::factory()->create();

        $name = 'Beginner';
        $this->assertDatabaseHas('badges', ['name' => $name]);
        $badge = Badge::where('name', $name)->first();
        
        // Create and Dispatch an event
        $event = new BadgeUnlockedEvent($user, $badge->name);

        $listener = new BadgeUnlockedListener();

        $this->assertTrue($listener->handle($event));
    }
}
