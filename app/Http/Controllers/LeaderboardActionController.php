<?php

namespace App\Http\Controllers;

use App\Actions\LeaderboardActions;
use App\Models\Leaderboard;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * Controller for leaderboard actions
 */
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
        /** @var Leaderboard $leaderboard */
        $leaderboard = Leaderboard::find($id);
        $this->actions->delete($leaderboard);

        return redirect(route('show-community', $leaderboard->community));
    }

    public function changeLeaderboardFavorite(string $id): RedirectResponse
    {
        /** @var Leaderboard $leaderboard */
        $leaderboard = Leaderboard::find($id);
        $this->actions->changeFavorite($leaderboard);

        return redirect()->back();
    }
}
