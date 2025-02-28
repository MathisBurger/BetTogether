<?php

namespace App\Actions;

use App\Models\Community;
use App\Models\Leaderboard;
use App\Models\Standing;
use App\Models\User;
use App\Service\RankingService;
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

    public function __construct(
        private readonly RankingService $rankingService,
    )
    {}

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

        $this->rankingService->createRanking(
            $community,
            $leaderboard,
            $data['periodStart'] ? Carbon::parse($data['periodStart']) : null,
            $data['periodEnd'] ? Carbon::parse($data['periodEnd']) : null,
        );

        return $leaderboard;
    }
}