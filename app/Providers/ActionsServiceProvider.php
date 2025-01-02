<?php

namespace App\Providers;

use App\Actions\BetActions;
use App\Actions\CommunityActions;
use App\Actions\LeaderboardActions;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class ActionsServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        $this->app->singleton('communityActions', CommunityActions::class);
        $this->app->singleton('betActions', BetActions::class);
        $this->app->singleton('leaderboardActions', LeaderboardActions::class);
    }

    public function boot(): void
    {
        Paginator::useBootstrapFive();
    }

}