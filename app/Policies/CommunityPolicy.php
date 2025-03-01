<?php

namespace App\Policies;

use App\Models\BetCreationPolicy;
use App\Models\Community;
use App\Models\CommunityJoinPolicy;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Nette\NotImplementedException;

class CommunityPolicy implements PolicyInterface
{

    public function read(User $authUser, $object): bool
    {
        if (!$object instanceof Community) {
            return false;
        }
        return  !$object->members->filter(fn ($user) => $user->id === $authUser->id)->isEmpty() || $object->admin->id === $authUser->id;
    }

    public function update(User $authUser, $object): bool
    {
        if (!$object instanceof Community) {
            return false;
        }
        return $object->admin->id === $authUser->id;
    }

    public function createBet(User $authUser, Community $community): bool
    {
        return match ($community->betCreationPolicy) {
            BetCreationPolicy::AdminOnly->value => $community->admin->id === $authUser->id,
            BetCreationPolicy::Creators->value => $community->betCreators->filter(fn ($user) => $user->id === $authUser->id),
            BetCreationPolicy::Everyone->value => $community->members->filter(fn ($user) => $user->id === $authUser->id),
            default => false,
        };
    }

    public function canCreateLeaderboard(User $authUser, Community $community): bool
    {
        return $this->update($authUser, $community);
    }

    public function canDeleteLeaderboard(User $authUser, Community $community): bool
    {
        return $this->update($authUser, $community);
    }

    public function join(User $authUser, Community $community): bool
    {
        if ($community->members()->where('member_id', $authUser->id)->exists()) {
            return false;
        }
        return $community->joinPolicy === CommunityJoinPolicy::Open->value;
    }

    public function create(User $authUser, $object): bool
    {
        throw new NotImplementedException();
    }

    public function delete(User $authUser, $object): bool
    {
        throw new NotImplementedException();
    }

    public static function registerOther(): void
    {
    }
}