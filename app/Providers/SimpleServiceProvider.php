<?php

namespace App\Providers;

use App\Service\RankingService;
use Illuminate\Support\ServiceProvider;

class SimpleServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        $this->app->singleton('rankingService', RankingService::class);
    }

}