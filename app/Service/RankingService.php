<?php

namespace App\Service;

use App\Models\Community;
use App\Models\Leaderboard;
use App\Models\Standing;
use App\Models\User;
use Illuminate\Support\Str;

/**
 * This service handles leaderboard rankings
 */
readonly class RankingService
{
    /**
     * Creates a ranking or a leaderboard
     *
     * @param  Leaderboard  $leaderboard  The leaderboard that the ranking should be created for
     */
    public function createRanking(Leaderboard $leaderboard): void
    {
        $standings = $this->getStandings($leaderboard);
        $inserts = array_map(function ($standing, $rank) use ($leaderboard) {
            return ['id' => Str::uuid(), 'rank' => $rank + 1, 'points' => $standing['total_points'] ?? 0, 'user_id' => $standing['id'], 'leaderboard_id' => $leaderboard->id, 'diffPointsToLastBet' => 0, 'diffRanksToLastBet' => 0];
        }, $standings, array_keys($standings));

        Standing::insert($inserts);
    }

    /**
     * Updates all rankings for a community
     *
     * @param  Community  $community  The community that contains the leaderboards
     */
    public function updateRankingsForCommunity(Community $community): void
    {
        $leaderboards = Leaderboard::where('community_id', $community->id)
            ->where(function ($query) {
                $query->where('isAllTime', true)
                    ->orWhere(function ($query) {
                        $query->where('periodStart', '<=', now())
                            ->where('periodEnd', '>=', now());
                    });
            })
            ->get();
        foreach ($leaderboards as $leaderboard) {
            $this->updateRanking($leaderboard);
        }
    }

    /**
     * Updates the ranking of a leaderboard
     *
     * @param  Leaderboard  $leaderboard  The leaderboard that should be re-ranked
     */
    public function updateRanking(Leaderboard $leaderboard): void
    {
        $calculatedStandings = $this->getStandings($leaderboard);
        $leaderboardStandings = Standing::where('leaderboard_id', $leaderboard->id)->orderBy('rank')->get();
        if (count($leaderboardStandings) !== count($calculatedStandings)) {
            return;
        }
        $userChangeMap = [];
        foreach ($leaderboardStandings as $leaderboardStanding) {
            $userChangeMap[$leaderboardStanding->user_id] = ['rank' => $leaderboardStanding->rank, 'points' => $leaderboardStanding->points];
        }
        for ($i = 0; $i < count($calculatedStandings); $i++) {
            $points = $calculatedStandings[$i]['total_points'];
            $userId = $calculatedStandings[$i]['id'];
            $leaderboardStandings[$i]->update([
                'points' => $points,
                'user_id' => $userId,
                'diffPointsToLastBet' => $points - $userChangeMap[$userId]['points'],
                'diffRanksToLastBet' => $userChangeMap[$userId]['rank'] - $leaderboardStandings[$i]->rank,
            ]);
        }
    }

    /**
     * Gets the current standings of a leaderboard
     *
     * @param  Leaderboard  $leaderboard  The leaderboard to get current standings from
     * @return array The current standings
     */
    private function getStandings(Leaderboard $leaderboard): array
    {
        $baseQuery = User::selectRaw('users.id, SUM(placed_bets.points) as total_points')
            ->join('placed_bets', 'placed_bets.user_id', '=', 'users.id')
            ->join('bets', 'placed_bets.bet_id', '=', 'bets.id')
            ->where('bets.community_id', $leaderboard->community_id);
        if (! $leaderboard->isAllTime) {
            $baseQuery = $baseQuery->whereBetween('placed_bets.created_at', [$leaderboard->periodStart, $leaderboard->periodEnd]);
        }

        return $baseQuery
            ->groupBy('users.id')
            ->orderByDesc('total_points')
            ->get()->toArray();
    }
}
