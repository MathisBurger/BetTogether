<?php

namespace App\Policies;

use App\Models\BetCreationPolicy;
use App\Models\Community;
use App\Models\CommunityJoinPolicy;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Nette\NotImplementedException;

class CommunityPolicy implements PolicyInterface
{
    public function read(User $authUser, $object): bool
    {
        if (! $object instanceof Community) {
            return false;
        }

        /** @var User $admin */
        $admin = $object->admin;
        /** @var Collection<(int|string), User> $members */
        $members = $object->members;

        return ! $members->filter(fn (User $user) => $user->id === $authUser->id)->isEmpty() || $admin->id === $authUser->id;
    }

    public function update(User $authUser, $object): bool
    {
        if (! $object instanceof Community) {
            return false;
        }

        /** @var User $admin */
        $admin = $object->admin;

        return $admin->id === $authUser->id;
    }

    public function create(User $authUser, $object): bool
    {
        throw new NotImplementedException;
    }

    public function delete(User $authUser, $object): bool
    {
        throw new NotImplementedException;
    }

    /**
     * Checks if a user can create a bet on a community
     *
     * @param  User  $authUser  The user that wants to perform the action
     * @param  Community  $community  The community that the bet should be created on
     */
    public function createBet(User $authUser, Community $community): bool
    {
        /** @var User $admin */
        $admin = $community->admin;
        /** @var Collection<int|string, User> $betCreators */
        $betCreators = $community->betCreators;
        /** @var Collection<int|string, User> $members */
        $members = $community->members;

        return match ($community->betCreationPolicy) {
            BetCreationPolicy::AdminOnly->value => $admin->id === $authUser->id,
            BetCreationPolicy::Creators->value => $betCreators->filter(fn (User $user) => $user->id === $authUser->id),
            BetCreationPolicy::Everyone->value => $members->filter(fn (User $user) => $user->id === $authUser->id),
            default => false,
        };
    }

    /**
     * Checks if a user can create a leaderboard on a community
     *
     * @param  User  $authUser  The user that wants to perform the action
     * @param  Community  $community  The community that the leaderboard should be created on
     */
    public function canCreateLeaderboard(User $authUser, Community $community): bool
    {
        return $this->update($authUser, $community);
    }

    /**
     * Checks if a user can delete a leaderboard
     *
     * @param  User  $authUser  The user that wants to perform the action
     * @param  Community  $community  The community that the leaderboard should be deleted from
     */
    public function canDeleteLeaderboard(User $authUser, Community $community): bool
    {
        return $this->update($authUser, $community);
    }

    /**
     * Checks if a user can join a community
     *
     * @param  User  $authUser  The user that wants to join
     * @param  Community  $community  The community that the user wants to join
     */
    public function join(User $authUser, Community $community): bool
    {
        if ($community->members()->where('member_id', $authUser->id)->exists()) {
            return false;
        }

        return $community->joinPolicy === CommunityJoinPolicy::Open->value || $community->inviteLinks;
    }

    public static function registerOther(): void {}
}
