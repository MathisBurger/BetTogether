<?php

namespace App\Providers;

use App\Actions\Community\CommunityActions;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class CommunityServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        $this->app->singleton('create-community', CommunityActions::class);
    }

    public function boot(): void
    {
        Paginator::useBootstrapFive();
    }

}