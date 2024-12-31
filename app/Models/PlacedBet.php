<?php

namespace App\Models;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Placed bet model
 */
class PlacedBet extends Model
{
    use HasUuids;
    use HasTimestamps;

    protected $fillable = [
        'bet_id',
        'user_id',
        'points'
    ];

    public function answer(): HasOne
    {
        return $this->hasOne(BetAnswer::class);
    }

    public function bet(): BelongsTo
    {
        return $this->belongsTo(Bet::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}