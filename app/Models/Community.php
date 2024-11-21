<?php

namespace App\Models;

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

    use HasUuids;

    protected $fillable = [
        'name',
        'joinPolicy',
        'betCreationPolicy'
    ];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'community_members');
    }

    public function betCreators(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'community_bet_creators');
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