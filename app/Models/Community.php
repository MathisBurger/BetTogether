<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Community model
 */
class Community extends Model
{
    use HasTimestamps;
    use HasUuids;

    protected $fillable = [
        'name',
        'joinPolicy',
        'betCreationPolicy',
        'admin_id',
        'inviteLinks',
    ];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'community_members', 'community_id', 'member_id');
    }

    public function betCreators(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'community_bet_creators', 'community_id', 'creator_id');
    }

    public function bets(): HasMany
    {
        return $this->hasMany(Bet::class);
    }

    public function leaderboards(): HasMany
    {
        return $this->hasMany(Leaderboard::class);
    }
}
