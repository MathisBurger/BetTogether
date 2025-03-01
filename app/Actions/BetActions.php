<?php

namespace App\Actions;

use App\Models\Bet;
use App\Models\BetAnswer;
use App\Models\BetDeterminationStrategy;
use App\Models\Community;
use App\Models\PlacedBet;
use App\Models\ResultType;
use App\Service\BetService;
use App\Service\RankingService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\ValidationException;

/**
 * All actions on a bet used within this platform
 */
class BetActions
{
    public function __construct(
        private readonly RankingService $rankingService,
        private readonly BetService $betService,
    ) {}

    /**
     * Creates a new bet on a community
     * 
     * @param string $id The ID of the community to create the bet on
     * @param array $data The form data that is submitted
     * @return Bet The created bet
     * @throws ValidationException Fails on form data validation
     */
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

    /**
     * Places a bet on a defined bet.
     *
     * @param string $id The ID of the bet to bet on
     * @param array $data The form data that has been submitted
     * @return PlacedBet The placed bet
     * @throws ValidationException Fails on invalid form data
     */
    public function placeBet(string $id, array $data): PlacedBet
    {
        $bet = Bet::with('answer')->where('id', $id)->firstOrFail();
        Gate::authorize('canPlaceBet', $bet);
        Validator::make($data, [
            'stringValue' => ['string'],
            'integerValue' => ['integer'],
            'floatValue' => ['numeric'],
        ])->validate();

        $placedBet = PlacedBet::create([
            'bet_id' => $bet->id,
            'user_id' => Auth::id(),
        ]);
        /** @var BetAnswer $betAnswer */
        $betAnswer = $bet->answer;
        BetAnswer::create([
            'placed_bet_id' => $placedBet->id,
            'type' => $betAnswer->type,
            'stringValue' => $data['stringValue'] ?? null,
            'integerValue' => $data['integerValue'] ?? null,
            'floatValue' => $data['floatValue'] ?? null,
        ]);

        return $placedBet;
    }

    /**
     * Determines a bet.
     *
     * @param string $id The ID of the bet to determine
     * @param array $data The submitted form data
     * @return Bet The determined bet
     * @throws ValidationException Validates the form data
     */
    public function determineBet(string $id, array $data): Bet
    {
        $bet = Bet::with('answer')->where('id', $id)->firstOrFail();
        Gate::authorize('canDetermineBet', $bet);
        if ($bet->determinationStrategy === BetDeterminationStrategy::Manual->value) {
            Validator::make($data, [
                'bets.*.placed_bet_id' => ['string', 'exists:placed_bets,id'],
                'bets.*.points' => ['integer', 'min:0', 'max:'.$bet->totalPoints],
            ])->validate();
        } else {
            Validator::make($data, [
                'value' => ['required'],
            ])->validate();
        }

        $this->betService->determineBet($bet, $data);

        /** @var BetAnswer $betAnswer */
        $betAnswer = $bet->answer;

        /** @var Community $community */
        $community = $bet->community;
        $this->rankingService->updateRankingsForCommunity($community);

        $bet->isDeterminated = true;
        $bet->save();

        // Create the correct answer on bet if exists
        if ($bet->determinationStrategy !== BetDeterminationStrategy::Manual->value) {
            $betAnswer->update([
                'stringValue' => $betAnswer->type === ResultType::String->value ? $data['value'] : null,
                'integerValue' => $betAnswer->type === ResultType::Integer->value ? $data['value'] : null,
                'floatValue' => $betAnswer->type === ResultType::Float->value ? $data['value'] : null,
            ]);
        }

        return $bet;
    }
}
