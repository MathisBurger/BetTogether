<?php

namespace App\Providers;

use App\Models\Community;
use App\Policies\CommunityPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthPoliciesProvider extends ServiceProvider
{
    public function boot(): void
    {
        Gate::policy(Community::class, CommunityPolicy::class);
    }
}