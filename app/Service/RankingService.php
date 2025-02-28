<?php

namespace App\Service;

use App\Models\Community;
use App\Models\Leaderboard;
use App\Models\Standing;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

readonly class RankingService
{
    public function createRanking(Community $community, Leaderboard $leaderboard, ?Carbon $periodStart = null, ?Carbon $periodEnd = null)
    {
        $baseQuery = User::selectRaw('users.id, SUM(placed_bets.points) as total_points')
            ->join('placed_bets', 'placed_bets.user_id', '=', 'users.id')
            ->join('bets', 'placed_bets.bet_id', '=', 'bets.id')
            ->where('bets.community_id', $community->id);
        if (!$leaderboard->isAllTime) {
            $baseQuery = $baseQuery->whereBetween('placed_bets.created_at', [$periodStart, $periodEnd]);
        }
        $standings = $baseQuery
            ->groupBy('users.id')
            ->orderByDesc('total_points')
            ->get();


        $inserts = array_map(function ($standing, $rank) use ($leaderboard) {
            return ['id' => Str::uuid() , 'rank' => $rank+1, 'points' => $standing['total_points'] ?? 0, 'user_id' => $standing['id'], 'leaderboard_id' => $leaderboard->id, 'diffPointsToLastBet' => 0, 'diffRanksToLastBet' => 0];
        }, $standings->toArray(), array_keys($standings->toArray()));

        Standing::insert($inserts);
    }
}