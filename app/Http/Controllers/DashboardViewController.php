<?php

namespace App\Http\Controllers;

use App\Service\BetService;
use App\Service\LeaderboardService;
use Illuminate\View\View;

readonly class DashboardViewController
{
    public function __construct(private LeaderboardService $leaderboardService, private BetService $betService) {}

    public function dashboardView(): View
    {
        $openBets = $this->betService->getCurrentUsersOpenBets();
        $leaderboards = $this->leaderboardService->getUserFavoriteLeaderboards();

        return \view('dashboard', ['openBets' => $openBets, 'leaderboards' => $leaderboards]);
    }
}
