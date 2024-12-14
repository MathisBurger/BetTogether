<?php

namespace App\Actions;

use App\Models\Bet;
use App\Models\BetAnswer;
use App\Models\BetCreationPolicy;
use App\Models\BetDeterminationStrategy;
use App\Models\Community;
use App\Models\ResultType;
use Illuminate\Support\Facades\Auth;
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
        $canCreateBet = match ($community->betCreationPolicy) {
            BetCreationPolicy::AdminOnly->value => $community->admin->id === Auth::id(),
            BetCreationPolicy::Creators->value => $community->betCreators->filter(fn ($user) => $user->id === Auth::id()),
            BetCreationPolicy::Everyone->value => $community->members->filter(fn ($user) => $user->id === Auth::id()),
            default => false,
        };
        if (!$canCreateBet) {
            throw new AccessDeniedException("Cannot create bet");
        }

        Validator::make($data, [
            'answerType' => ['required', 'string', new Enum(ResultType::class)],
            'determinationStrategy' => ['required', 'string', new Enum(BetDeterminationStrategy::class)],
            'endDateTime' => ['required', 'date'],
        ])->validate();

        $bet = Bet::create([
            'community_id' => $id,
            'creator_id' => Auth::id(),
            'betText' => $data['betText'],
            'totalPoints' => $data['totalPoints'],
            'determinationStrategy' => $data['determinationStrategy'],
            'endDateTime' => $data['endDateTime'],
            'isDeterminated' => $data['isDeterminated'],
        ]);

        BetAnswer::create([
            'bet_id' => $bet->id,
            'type' => $data['answerType'],
        ]);
        return $bet;
    }

}
