<?php

namespace App\Http\Controllers;

use App\Actions\LeaderboardActions;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

readonly class LeaderboardActionController
{

    public function __construct(private LeaderboardActions $actions) {}

    public function createLeaderboard(string $id, Request $request): RedirectResponse
    {
        $leaderboard = $this->actions->create($id, $request->all());
        return redirect(route('show-community', $leaderboard->community));
    }
}