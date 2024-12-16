<?php

namespace App\Http\Controllers;

use App\Models\Bet;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class BetViewController
{

    public function viewBet(string $id): View
    {
        $bet = Bet::find($id);
        Gate::authorize('read', $bet);
        return view('community.bets.viewBet');
    }

    public function createBetView(string $id): View
    {
        return view('community.bets.createBet', ['communityId' => $id]);
    }

}