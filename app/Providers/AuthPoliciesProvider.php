<?php

namespace App\Providers;

use App\Models\Bet;
use App\Models\Community;
use App\Policies\BetPolicy;
use App\Policies\CommunityPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthPoliciesProvider extends ServiceProvider
{
    public function boot(): void
    {
        Gate::policy(Community::class, CommunityPolicy::class);
        Gate::policy(Bet::class, BetPolicy::class);
    }
}