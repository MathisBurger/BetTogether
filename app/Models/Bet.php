<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
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
    use HasTimestamps;

    protected $fillable = [
        'betText',
        'totalPoints',
        'determinationStrategy',
        'endDateTime',
        'isDeterminated',
        'community_id',
        'creator_id'
    ];

    protected function casts(): array
    {
        return [
            'endDateTime' => 'datetime'
        ];
    }

    public function creator(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'creator_id');
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