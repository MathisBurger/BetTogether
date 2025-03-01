<?php

namespace App\Http\Controllers;

use App\Actions\LeaderboardActions;
use App\Models\Leaderboard;
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

    public function deleteLeaderboard(string $id): RedirectResponse
    {
        var_dump($id);
        /** @var Leaderboard $leaderboard */
        $leaderboard = Leaderboard::find($id);
        $this->actions->delete($leaderboard);
        return redirect(route('show-community', $leaderboard->community));
    }
}