<?php

namespace App\Utility;

use App\Models\Bet;

class BacklinkUtility
{

    public static function generateCommunityViewBacklink(string $communityId): string
    {
        return route('show-community', $communityId);
    }

    public static function generateBetViewBacklink(Bet $bet): string
    {
        return route('view-bet', $bet->id);
    }

}