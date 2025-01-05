<?php

namespace App\Policies;

use App\Models\User;
use Nette\NotImplementedException;

class LeaderboardPolicy implements PolicyInterface
{

    public function read(User $authUser, $object): bool
    {
        throw new NotImplementedException();
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

    }
}