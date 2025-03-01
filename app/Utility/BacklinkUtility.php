<?php

namespace App\Utility;

use App\Models\Bet;

/**
 * Utility to generate backlinks
 */
class BacklinkUtility
{
    /**
     * Generates backlink to a community
     *
     * @param string $communityId The ID of the community
     * @return string The backlink
     */
    public static function generateCommunityViewBacklink(string $communityId): string
    {
        return route('show-community', $communityId);
    }

    /**
     * Generates backlink to a bet
     *
     * @param Bet $bet The bet
     * @return string The backlink
     */
    public static function generateBetViewBacklink(Bet $bet): string
    {
        return route('view-bet', $bet->id);
    }
}
