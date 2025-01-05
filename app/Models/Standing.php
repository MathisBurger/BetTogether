<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Leaderboard standings model
 */
class Standing extends Model
{
    use HasUuids;

    protected $fillable = [
        'rank',
        'points',
        'diffPointsToLastBet',
        'diffRanksToLastBet',
        'leaderboard_id',
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function leaderboard(): BelongsTo
    {
        return $this->belongsTo(Leaderboard::class);
    }
}