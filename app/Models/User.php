<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Events\CommentWritten;
use App\Events\LessonWatched;
use App\Events\AchievementUnlockedEvent;
use App\Events\BadgeUnlockedEvent;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * The comments that belong to the user.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * The lessons that a user has access to.
     */
    public function lessons()
    {
        return $this->belongsToMany(Lesson::class);
    }

    /**
     * The lessons that a user has watched.
     */
    public function watched()
    {
        return $this->belongsToMany(Lesson::class)->wherePivot('watched', true);
    }

    /**
     * The milesone that a user already achieved.
     */
    public function achievements()
    {
        return $this->belongsToMany(Achievement::class);
    }

    /**
     * The user's current badge
     */
    public function badge()
    {
        return $this->belongsTo(Badge::class);
    }

    /**
     * Checks for new achievement
     */
    public function newAchievementUnlocked(string $achievement_type='', int $value=0)
    {
        if( !empty($achievement_type) ) {
            // In case, 2nd parameter wasn't set
            if( $value < 1 ) {
                if( $achievement_type == CommentWritten::EVENT_NAME )
                    $value = $this->comments->count();
                else if( $achievement_type == LessonWatched::EVENT_NAME )
                    $value = $this->watched->count();
            }

            // Check for new achievement reached
            $new_achievement = Achievement::where([
                'type'  => $achievement_type,
                'value' => $value,
            ])->first();
            if( $new_achievement ) {
                // Fire unlock achievement
                event(new AchievementUnlockedEvent($this, $new_achievement->name));
                return TRUE;
            }
        }

        return FALSE;
    }

    /**
     * Checks for new badge reached.
     */
    public function newBadgeUnlocked(int $value=0)
    {
        // In case, 2nd parameter wasn't set
        if( $value < 1 ) {
            $value = $this->achievements->count();
        }
        // Check for new badge reached
        $new_badge = Badge::where('value', '<=', $value)
            ->orderBy('value', 'desc')->first();

        if( !$this->badge || $this->badge->value < $new_badge->value ) {
            // Fire unlock achievement
            event(new BadgeUnlockedEvent($this, $new_badge->name));
            return TRUE;
        }

        return FALSE;
    }
}

