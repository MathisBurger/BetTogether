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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Enum;

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
            'floatValue' => ['numeric'],
        ])->validate();

        $placedBet = PlacedBet::create([
            'bet_id' => $bet->id,
            'user_id' => Auth::id(),
        ]);
        BetAnswer::create([
           'placed_bet_id' => $placedBet->id,
           'type' => $bet->answer->type,
            'stringValue' => $data['stringValue'] ?? null,
            'integerValue' => $data['integerValue'] ?? null,
            'floatValue' => $data['floatValue'] ?? null,
        ]);
        return $placedBet;
    }

    public function determineBet(string $id, array $data): Bet
    {
        $bet = Bet::with('answer')->where('id', $id)->firstOrFail();
        Gate::authorize('canDetermineBet', $bet);
        if ($bet->determinationStrategy === BetDeterminationStrategy::Manual->value) {
            Validator::make($data, [
                '*.placed_bet_id' => ['string', 'exists:placed_bets,id'],
                '*.points' => ['integer', 'min:0'],
            ])->validate();
        } else {
            Validator::make($data, [
                'value' => ['required']
            ])->validate();
        }

        if ($bet->determinationStrategy === BetDeterminationStrategy::ExactMatch->value) {
            DB::update('UPDATE placed_bets SET points = ? WHERE id IN (SELECT placed_bets.id FROM placed_bets
                   JOIN public.bet_answers ba on placed_bets.id = ba.placed_bet_id
                   WHERE placed_bets.bet_id = ? AND ba."' . $bet->answer->type .'Value" = ?)'
                    , [$bet->totalPoints, $bet->id, $data['value']]);
            DB::update('UPDATE placed_bets SET points = 0 WHERE id NOT IN (SELECT placed_bets.id FROM placed_bets
                   JOIN public.bet_answers ba on placed_bets.id = ba.placed_bet_id
                   WHERE placed_bets.bet_id = ? AND ba."' . $bet->answer->type .'Value" = ?) AND placed_bets.bet_id = ?'
                , [$bet->id, $data['value'], $bet->id]);
        } elseif ($bet->determinationStrategy === BetDeterminationStrategy::DiffGradient->value) {
            if ($bet->answer->type === ResultType::String->value) {
                $maxDiff = DB::select('SELECT MAX(levenshtein(?,  ans1."stringValue")) AS max_diff FROM placed_bets AS pb_1 JOIN bet_answers ans1 ON pb_1.id = ans1.placed_bet_id JOIN bets ON pb_1.bet_id = bets.id WHERE bets.id = ?', [$data['value'], $bet->id])[0]->max_diff;
                DB::update('UPDATE placed_bets SET points = (
    ? - ? * (CAST(levenshtein((SELECT "' . $bet->answer->type . 'Value" FROM bet_answers WHERE placed_bet_id = placed_bets.id), ?) AS FLOAT) / CAST(? AS FLOAT))
    )
WHERE placed_bets.bet_id = ?', [$bet->totalPoints, $bet->totalPoints, $data['value'], $maxDiff, $bet->id]);
            } else {
                $maxDiff = DB::select('SELECT MAX(ABS(? - ans1."' . $bet->answer->type . 'Value")) AS max_diff FROM placed_bets AS pb_1 JOIN bet_answers ans1 ON pb_1.id = ans1.placed_bet_id JOIN bets ON pb_1.bet_id = bets.id WHERE bets.id = ?', [$data['value'], $bet->id])[0]->max_diff;
                DB::update('UPDATE placed_bets SET points = (
    ? - ? * (CAST(ABS((SELECT "' . $bet->answer->type . 'Value" FROM bet_answers WHERE placed_bet_id = placed_bets.id) - ?) AS FLOAT) / CAST(? AS FLOAT))
    )
WHERE placed_bets.bet_id = ?', [$bet->totalPoints, $bet->totalPoints, $data['value'], $maxDiff, $bet->id]);
            }
        } else {
            foreach ($data as $singleBetData) {
                DB::update('UPDATE placed_bets SET points = ? WHERE id = ?', [$singleBetData->points, $singleBetData->placed_bet_id]);
            }
        }

        // TODO: Rerank in leaderboards

        // TODO: Set answer
        $bet->isDeterminated = true;
        $bet->save();
        return $bet;
    }
}
