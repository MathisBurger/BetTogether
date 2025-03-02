<?php

namespace App\Http\Controllers;

use App\Models\Bet;
use App\Service\LeaderboardService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

readonly class DashboardViewController
{

    public function __construct(private LeaderboardService $leaderboardService)
    {

    }

    public function dashboardView(): View
    {
        $openBets = Bet::whereHas('community', function ($query) {
            $query->whereHas('members', function ($userQuery) {
                $userQuery->where('id', Auth::id());
            });
        })
            // This logic is not needed. Just comment it back in if the wished behaviour is to not display bets that you have already placed a bet on
            /*->where(function ($query) {
                $query->whereHas('placedBets', function ($betsQuery) {
                    $betsQuery->whereHas('user', function ($userQuery) {
                        $userQuery->whereNot('id', Auth::id());
                    });
                })->orWhereDoesntHave('placedBets');
            })*/
            ->where('isDeterminated', false)
            ->where('endDateTime', '>', Carbon::now())
            ->limit(10)->get();

        $leaderboards = $this->leaderboardService->getUserFavoriteLeaderboards();

        return \view('dashboard', ['openBets' => $openBets, 'leaderboards' => $leaderboards]);
    }

}