<?php

namespace App\Actions;

use App\Models\Community;
use App\Models\Leaderboard;
use App\Models\Standing;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

/**
 * All actions for leaderboards
 */
class LeaderboardActions
{
    public function create(string $id, array $data): Leaderboard
    {
        $community = Community::find($id);
        Gate::authorize('canCreateLeaderboard', $community);

        Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'periodStart' => ['nullable', 'date', 'required_unless:isAllTime,on'],
            'periodEnd' => ['nullable', 'date', 'required_unless:isAllTime,on'],
        ])->validate();

        $isAllTime = ($data['isAllTime'] ?? '') == 'on';
        $leaderboard = Leaderboard::create([
            'community_id' => $community->id,
            'name' => $data['name'],
            'periodStart' => !$isAllTime ? $data['periodStart'] ?? null : null,
            'periodEnd' => !$isAllTime ? $data['periodEnd'] ?? null : null,
            'isAllTime' => $isAllTime,
        ]);

        $baseQuery = User::selectRaw('users.id, SUM(placed_bets.points) as total_points')
            ->join('placed_bets', 'placed_bets.user_id', '=', 'users.id')
            ->join('bets', 'placed_bets.bet_id', '=', 'bets.id')
            ->where('bets.community_id', $community->id);
        if (!$leaderboard->isAllTime) {
            $baseQuery = $baseQuery->whereBetween('placed_bets.created_at', [Carbon::parse($data['periodStart']), Carbon::parse($data['periodEnd'])]);
        }
        $standings = $baseQuery
            ->groupBy('users.id')
            ->orderByDesc('total_points')
            ->get();


        $inserts = array_map(function ($standing, $rank) use ($leaderboard) {
            return ['id' => Str::uuid() , 'rank' => $rank+1, 'points' => $standing['total_points'], 'user_id' => $standing['id'], 'leaderboard_id' => $leaderboard->id, 'diffPointsToLastBet' => 0, 'diffRanksToLastBet' => 0];
        }, $standings->toArray(), array_keys($standings->toArray()));

        Standing::insert($inserts);

        return $leaderboard;
    }
}