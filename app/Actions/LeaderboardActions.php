<?php

namespace App\Actions;

use App\Models\Community;
use App\Models\Leaderboard;
use App\Models\Standing;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

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
            'periodStart' => ['date'],
            'periodEnd' => ['date'],
            'isAllTime' => ['boolean'],
        ])->validate();

        $leaderboard = Leaderboard::create([
            'community_id' => $community->id,
            'name' => $data['name'],
            'periodStart' => $data['periodStart'] ?? null,
            'periodEnd' => $data['periodEnd'] ?? null,
            'isAllTime' => $data['isAllTime'] ?? true,
        ]);

        // TODO: Add standings after leaderboard creation

        return $leaderboard;
    }
}