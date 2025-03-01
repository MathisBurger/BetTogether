<?php

namespace App\Service;

use App\Models\Bet;
use App\Models\BetAnswer;
use App\Models\BetDeterminationStrategy;
use App\Models\ResultType;
use Illuminate\Support\Facades\DB;

/**
 * This service handles the bet determination with native SQL queries.
 * NOTE: I know this is kinda ugly and hard to read. I kind of had to do it to keep up performance on large datasets.
 * I know, I could have solved this in a more elegant way. But come on: This is a fuckin side project.
 */
class BetService
{

    /**
     * Determines an bet using native SQL queries
     *
     * @param Bet $bet The bet that should be determinated
     * @param array $data The form data that has been submitted
     * @return void
     */
    public function determineBet(Bet $bet, array $data): void
    {
        /** @var BetAnswer $betAnswer */
        $betAnswer = $bet->answer;
        if ($bet->determinationStrategy === BetDeterminationStrategy::ExactMatch->value) {

            $this->determineExactMatch($bet, $betAnswer, $data);

        } elseif ($bet->determinationStrategy === BetDeterminationStrategy::DiffGradient->value) {

            if ($betAnswer->type === ResultType::String->value) {
                $this->determineGradientString($bet, $betAnswer, $data);
            } else {
                $this->determineGradientNumber($bet, $betAnswer, $data);
            }

        } else {
            // Manual updates
            foreach ($data['bets'] as $singleBetData) {
                DB::update('UPDATE placed_bets SET points = ? WHERE id = ?', [$singleBetData['points'], $singleBetData['placed_bet_id']]);
            }
        }
    }

    /**
     * Determine an exact match bet.
     *
     * @param Bet $bet The bet to determine
     * @param BetAnswer $betAnswer The given bet answer
     * @param array $data The form data that has been submitted
     * @return void
     */
    private function determineExactMatch(Bet $bet, BetAnswer $betAnswer, array $data): void
    {
        DB::update('UPDATE placed_bets SET points = ? WHERE id IN (SELECT placed_bets.id FROM placed_bets
                   JOIN public.bet_answers ba on placed_bets.id = ba.placed_bet_id
                   WHERE placed_bets.bet_id = ? AND ba."'.$betAnswer->type.'Value" = ?)', [$bet->totalPoints, $bet->id, $data['value']]);
        DB::update('UPDATE placed_bets SET points = 0 WHERE id NOT IN (SELECT placed_bets.id FROM placed_bets
                   JOIN public.bet_answers ba on placed_bets.id = ba.placed_bet_id
                   WHERE placed_bets.bet_id = ? AND ba."'.$betAnswer->type.'Value" = ?) AND placed_bets.bet_id = ?', [$bet->id, $data['value'], $bet->id]);
    }

    /**
     * Determines an gradient bet that has string as answer type
     *
     * @param Bet $bet The bet that should be determined
     * @param BetAnswer $betAnswer The answer of the bet
     * @param array $data The form data that has been submitted
     * @return void
     */
    private function determineGradientString(Bet $bet, BetAnswer $betAnswer, array $data): void
    {
        $maxDiff = DB::select('SELECT MAX(levenshtein(?,  ans1."stringValue")) AS max_diff FROM placed_bets AS pb_1 JOIN bet_answers ans1 ON pb_1.id = ans1.placed_bet_id JOIN bets ON pb_1.bet_id = bets.id WHERE bets.id = ?', [$data['value'], $bet->id])[0]->max_diff;
        DB::update('UPDATE placed_bets SET points = (? - ? * (CAST(levenshtein((SELECT "'.$betAnswer->type.'Value" FROM bet_answers WHERE placed_bet_id = placed_bets.id), ?) AS FLOAT) / CAST(? AS FLOAT))) WHERE placed_bets.bet_id = ?', [$bet->totalPoints, $bet->totalPoints, $data['value'], $maxDiff, $bet->id]);
    }

    /**
     * Determines a gradient bet that has a number type as answer type
     *
     * @param Bet $bet The bet that should be determinated
     * @param BetAnswer $betAnswer The answer
     * @param array $data The form data that has been submitted
     * @return void
     */
    private function determineGradientNumber(Bet $bet, BetAnswer $betAnswer, array $data): void
    {
        $maxDiff = DB::select('SELECT MAX(ABS(? - ans1."'.$betAnswer->type.'Value")) AS max_diff FROM placed_bets AS pb_1 JOIN bet_answers ans1 ON pb_1.id = ans1.placed_bet_id JOIN bets ON pb_1.bet_id = bets.id WHERE bets.id = ?', [$data['value'], $bet->id])[0]->max_diff;
        DB::update('UPDATE placed_bets SET points = (? - ? * (CAST(ABS((SELECT "'.$betAnswer->type.'Value" FROM bet_answers WHERE placed_bet_id = placed_bets.id) - ?) AS FLOAT) / CAST(? AS FLOAT))) WHERE placed_bets.bet_id = ?', [$bet->totalPoints, $bet->totalPoints, $data['value'], $maxDiff, $bet->id]);
    }
}