<?php

namespace App\Providers;

use App\Models\Bet;
use App\Models\Community;
use App\Models\Leaderboard;
use App\Policies\BetPolicy;
use App\Policies\CommunityPolicy;
use App\Policies\LeaderboardPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

/**
 * Provider for model policies
 */
class AuthPoliciesProvider extends ServiceProvider
{
    public function boot(): void
    {
        Gate::policy(Community::class, CommunityPolicy::class);
        Gate::policy(Bet::class, BetPolicy::class);
        Gate::policy(Leaderboard::class, LeaderboardPolicy::class);
    }
}
