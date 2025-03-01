<?php

namespace App\Policies;

use App\Models\Bet;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use Nette\NotImplementedException;

/**
 * Policy definitions for bets
 */
class BetPolicy implements PolicyInterface
{
    public function read(User $authUser, $object): bool
    {
        if (! $object instanceof Bet) {
            return false;
        }

        return Gate::allows('read', $object->community);
    }

    public function create(User $authUser, $object): bool
    {
        throw new NotImplementedException;
    }

    public function update(User $authUser, $object): bool
    {
        throw new NotImplementedException;
    }

    public function delete(User $authUser, $object): bool
    {
        throw new NotImplementedException;
    }

    /**
     * Checks if a bet can be placed
     *
     * @param User $user The user that wants to perform the action
     * @param Bet $bet The bet that should be placed on
     * @return bool The result
     */
    public function canPlaceBet(User $user, Bet $bet): bool
    {
        /** @var Carbon $endDateTime */
        $endDateTime = $bet->endDateTime;

        return Gate::allows('read', $bet)
            && ! $bet->placedBets()->where('user_id', auth()->id())->exists()
            && $endDateTime->isAfter(now());
    }

    /**
     * Checks if the current user can determine a bet
     *
     * @param User $user The user that wants to perform the action
     * @param Bet $bet The bet that should be determinated
     * @return bool The result
     */
    public function canDetermineBet(User $user, Bet $bet): bool
    {
        return Gate::allows('read', $bet)
            && Gate::allows('createBet', $bet->community) && ! $bet->isDeterminated;
    }

    public static function registerOther(): void {}
}
