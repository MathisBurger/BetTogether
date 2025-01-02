<?php

namespace App\Service;

use App\Models\Community;
use App\Models\Leaderboard;
use Illuminate\Support\Facades\DB;

readonly class RankingService
{
    public function createRanking(Community $community, Leaderboard $leaderboard)
    {
        $rankings = DB::select('SELECT sum(placed_bets.points) AS point_sum, u.id FROM placed_bets
    JOIN public.users u on placed_bets.user_id = u.id
    JOIN public.bets on placed_bets.bet_id = bets.id
    JOIN public.communities c on c.id = bets.community_id
    WHERE community_id = ?
    GROUP BY u.id
    ORDER BY point_sum DESC', [$community->id]);
    }
}