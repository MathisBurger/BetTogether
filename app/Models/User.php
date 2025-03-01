<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

/**
 * User model
 */
class User extends Authenticatable
{
    use HasApiTokens;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;

    use HasProfilePhoto;
    use HasTimestamps;
    use Notifiable;
    use TwoFactorAuthenticatable;

    protected $fillable = [
        'name',
        'password',
        'roles',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'roles' => 'array',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function adminShips(): HasMany
    {
        return $this->hasMany(Community::class, 'admin_id');
    }

    public function communities(): BelongsToMany
    {
        return $this->belongsToMany(Community::class, 'community_members', 'community_id', 'member_id');
    }

    public function betCreatorIn(): BelongsToMany
    {
        return $this->belongsToMany(Community::class, 'community_bet_creators');
    }

    public function standings(): HasMany
    {
        return $this->hasMany(Standing::class);
    }

    public function placedBets(): HasMany
    {
        return $this->hasMany(PlacedBet::class);
    }
}
