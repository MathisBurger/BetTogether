<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Bet answer model
 */
class BetAnswer extends Model
{

    use HasUuids;
    use HasTimestamps;


    protected $fillable = [
        'type',
        'stringValue',
        'integerValue',
        'floatValue'
    ];

    public function bet(): BelongsTo
    {
        return $this->belongsTo(Bet::class);
    }

    public function placedBet(): BelongsTo
    {
        return $this->belongsTo(PlacedBet::class);
    }
}