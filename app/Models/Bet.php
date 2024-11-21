<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Bet model.
 */
class Bet extends Model
{
    use HasUuids;

    protected $fillable = [
        'betText',
        'totalPoints',
        'determinationStrategy',
        'endDateTime',
        'isDeterminated'
    ];

    public function creator(): HasOne
    {
        return $this->hasOne(User::class, 'creator_id');
    }

    public function community(): BelongsTo
    {
        return $this->belongsTo(Community::class);
    }

    public function answer(): HasOne
    {
        return $this->hasOne(BetAnswer::class);
    }

    public function placedBets(): HasMany
    {
        return $this->hasMany(PlacedBet::class);
    }

}