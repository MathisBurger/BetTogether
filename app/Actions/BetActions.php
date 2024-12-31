<?php

namespace App\Actions;

use App\Models\Bet;
use App\Models\BetAnswer;
use App\Models\BetCreationPolicy;
use App\Models\BetDeterminationStrategy;
use App\Models\Community;
use App\Models\PlacedBet;
use App\Models\ResultType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Enum;
use Symfony\Component\Finder\Exception\AccessDeniedException;

/**
 * All actions on a bet used within this platform
 */
class BetActions {

    public function createBet(string $id, array $data): Bet
    {
        $community = Community::where('id', $id)->firstOrFail();
        Gate::authorize('createBet', $community);

        Validator::make($data, [
            'answerType' => ['required', 'string', new Enum(ResultType::class)],
            'determinationStrategy' => ['required', 'string', new Enum(BetDeterminationStrategy::class)],
            'endDateTime' => ['required', 'date'],
        ])->validate();

        $bet = Bet::create([
            'community_id' => $community->id,
            'creator_id' => Auth::id(),
            'betText' => $data['betText'],
            'totalPoints' => $data['totalPoints'],
            'determinationStrategy' => $data['determinationStrategy'],
            'endDateTime' => $data['endDateTime'],
            'isDeterminated' => false,
        ]);

        BetAnswer::create([
            'bet_id' => $bet->id,
            'type' => $data['answerType'],
        ]);
        return $bet;
    }

    public function placeBet(string $id, array $data): PlacedBet
    {
        $bet = Bet::with('answer')->where('id', $id)->firstOrFail();
        Gate::authorize('canPlaceBet', $bet);
        Validator::make($data, [
            'stringValue' => ['string'],
            'integerValue' => ['integer'],
            'floatValue' => ['float'],
        ])->validate();

        $placedBet = PlacedBet::create([
            'bet_id' => $bet->id,
            'user_id' => Auth::id(),
        ]);
        BetAnswer::create([
           'placed_bet_id' => $placedBet->id,
           'type' => $bet->answer->type,
        ]);
        return $placedBet;
    }
}
