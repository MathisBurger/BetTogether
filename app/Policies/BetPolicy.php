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
        if (!$object instanceof Bet) {
            return false;
        }
        return Gate::allows('read', $object->community);
    }

    public function create(User $authUser, $object): bool
    {
        throw new NotImplementedException();
    }

    public function update(User $authUser, $object): bool
    {
        throw new NotImplementedException();
    }

    public function delete(User $authUser, $object): bool
    {
        throw new NotImplementedException();
    }

    public static function registerOther(): void
    {
        // TODO: Implement registerOther() method.
    }
}
