<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Leaderboard model
 */
class Leaderboard extends Model
{
    use HasTimestamps;
    use HasUuids;

    protected $fillable = [
        'name',
        'periodStart',
        'periodEnd',
        'isAllTime',
        'community_id',
    ];

    public function community(): BelongsTo
    {
        return $this->belongsTo(Community::class);
    }

    public function standings(): HasMany
    {
        return $this->hasMany(Standing::class);
    }

    public function favoritesBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'favorite_leaderboards', 'leaderboard_id', 'user_id');
    }
}
