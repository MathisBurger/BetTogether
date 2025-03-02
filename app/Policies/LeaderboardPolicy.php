<?php

namespace App\Policies;

use App\Models\Leaderboard;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Nette\NotImplementedException;

/**
 * Policy definitions for leaderboards
 */
class LeaderboardPolicy implements PolicyInterface
{

    public function read(User $authUser, $object): bool
    {
        if ($object instanceof Leaderboard) {
            return Gate::allows('read', $object->community);
        }
        return false;
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