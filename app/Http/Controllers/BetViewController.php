<?php

namespace App\Http\Controllers;

use App\Models\Bet;
use App\Models\BetDeterminationStrategy;
use App\Models\PlacedBet;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

/**
 * Controller for bet views
 */
readonly class BetViewController
{
    public function viewBet(string $id): View
    {
        /** @var Bet $bet */
        $bet = Bet::find($id);
        Gate::authorize('read', $bet);
        $placedBets = PlacedBet::with('answer')
            ->with('user')
            ->where('bet_id', $id)
            ->orderByDesc('points')
            ->paginate(50);
        $canPlaceBet = Gate::allows('canPlaceBet', $bet);
        $canDetermineBet = Gate::allows('canDetermineBet', $bet);

        return view('community.bets.viewBet', ['bet' => $bet, 'canPlaceBet' => $canPlaceBet, 'placedBets' => $placedBets, 'canDetermineBet' => $canDetermineBet]);
    }

    public function createBetView(string $id): View
    {
        return view('community.bets.createBet', ['communityId' => $id]);
    }

    public function placeBetView(string $id): View
    {
        $bet = Bet::with('answer')->find($id);
        Gate::authorize('read', $bet);

        return view('community.bets.placeBet', ['bet' => $bet]);
    }

    public function determineBetView(string $id): View
    {
        $bet = Bet::with('answer')->find($id);
        Gate::authorize('canDetermineBet', $bet);

        $placedBets = [];
        if ($bet->determinationStrategy === BetDeterminationStrategy::Manual->value) {
            $placedBets = PlacedBet::with('answer')->where('bet_id', $bet->id)->get();
        }

        return view('community.bets.determineBet', ['bet' => $bet, 'placedBets' => $placedBets]);
    }
}
