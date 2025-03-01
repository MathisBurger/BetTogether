<?php

namespace App\Policies;

use App\Models\Bet;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Nette\NotImplementedException;

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

    public function canPlaceBet(User $user, Bet $bet): bool
    {
        return Gate::allows('read', $bet)
            && ! $bet->placedBets()->where('user_id', auth()->id())->exists()
            && $bet->endDateTime->isAfter(now());
    }

    public function canDetermineBet(User $user, Bet $bet): bool
    {
        return Gate::allows('read', $bet)
            && Gate::allows('createBet', $bet->community) && ! $bet->isDeterminated;
    }

    public static function registerOther(): void {}
}
