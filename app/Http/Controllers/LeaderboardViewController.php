<?php

namespace App\Http\Controllers;

use App\Models\Community;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

readonly class LeaderboardViewController
{

    public function createLeaderboardView(string $id): View
    {
        $community = Community::find($id);
        Gate::authorize('canCreateLeaderboard', $community);
        return view('community.leaderboard.createLeaderboard', ['community' => $community]);
    }

}