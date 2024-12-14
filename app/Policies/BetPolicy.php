<?php

namespace App\Policies;

use App\Models\Bet;
use App\Models\User;

class BetPolicy
{
    public function get(User $user, Bet $bet): bool
    {
        return $bet->
    }
}
