<?php

namespace App\Providers;

use App\Service\BetService;
use App\Service\CommunityService;
use App\Service\LeaderboardService;
use App\Service\RankingService;
use Illuminate\Support\ServiceProvider;

/**
 * Provider for all services that are in service namespace
 */
class SimpleServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton('rankingService', RankingService::class);
        $this->app->singleton('betService', BetService::class);
        $this->app->singleton('leaderboardService', LeaderboardService::class);
        $this->app->singleton('communityService', CommunityService::class);
    }
}
