<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Helper;
use App\Models\Achievement;
use App\Models\Badge;
use Illuminate\Http\Request;

class AchievementsController extends Controller
{
    public function index(User $user)
    {
        $achievement_ids = Helper::getCollectionColumnValues($user->achievements, 'id');
        $achievement_names = Helper::getCollectionColumnValues($user->achievements, 'name');
        $next_achievements = Achievement::whereNotIn('id', $achievement_ids)
            ->groupBy('type')->orderBy('value', 'asc')->get();
        $next_achievements = Helper::getCollectionColumnValues($next_achievements, 'name');
        if( $user->badge ) {
            $current_badge = $user->badge->name;
            $next_badge = Badge::where('value', '>', (int)$user->badge->value)
                ->orderBy('value', 'asc')->first();
            $next_badge_name = $next_badge->name;
            $remaining_next_badge = $next_badge->value - count($achievement_names);
        } else {
            $current_badge = '';
            $next_badge_name = '';
            $remaining_next_badge = -1;
        }
        

        return response()->json([
            'unlocked_achievements' => $achievement_names,
            'next_available_achievements' => $next_achievements,
            'current_badge' => $current_badge,
            'next_badge' => $next_badge_name,
            'remaing_to_unlock_next_badge' => $remaining_next_badge,
        ]);
    }
}
