<?php

namespace App\Http\Controllers;

use App\Models\Bet;
use Illuminate\View\View;

class BetViewController
{

    public function viewBet(string $id): View
    {
        $bet = Bet::find($id);
        return view('community.bets.viewBet');
    }

    public function createBetView(string $id): View
    {
        return view('community.bets.createBet', ['communityId' => $id]);
    }

}