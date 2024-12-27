<?php

namespace App\Http\Controllers;

use App\Models\Bet;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class BetViewController
{

    public function viewBet(string $id): View
    {
        /** @var Bet $bet */
        $bet = Bet::find($id);
        Gate::authorize('read', $bet);
        $hasPlacedBet = $bet->placedBets()->where('user_id', auth()->id())->exists();
        return view('community.bets.viewBet', ['bet' => $bet, 'hasPlacedBet' => $hasPlacedBet]);
    }

    public function createBetView(string $id): View
    {
        return view('community.bets.createBet', ['communityId' => $id]);
    }

}