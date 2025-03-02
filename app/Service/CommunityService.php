<?php

namespace App\Service;

use App\Models\Bet;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;

readonly class CommunityService
{
    /**
     * Gets all members of a community paginated
     *
     * @param  string  $id  The ID of the community
     * @return LengthAwarePaginator The paginator
     */
    public function getCommunityMembers(string $id): LengthAwarePaginator
    {
        $members = User::join('community_members', 'community_members.member_id', '=', 'users.id')
            ->where('community_members.community_id', $id)->paginate(50);
        $members->appends(request()->except('page'));

        return $members;
    }

    /**
     * Gets all active bets of a community
     *
     * @param  string  $id  The ID of the community
     * @return LengthAwarePaginator The paginator
     */
    public function getCommunityActiveBets(string $id): LengthAwarePaginator
    {
        $activeBets = Bet::with('creator')->whereHas('community', function ($query) use ($id) {
            $query->where('id', $id);
        })->where('endDateTime', '>', Carbon::now())->where('isDeterminated', false)->paginate(50);
        $activeBets->appends(request()->except('page'));

        return $activeBets;
    }

    /**
     * Gets all past bets of a community
     *
     * @param  string  $id  The ID of the community
     * @return LengthAwarePaginator The paginator
     */
    public function getCommunityPastBets(string $id): LengthAwarePaginator
    {
        $pastBets = Bet::with('creator')->whereHas('community', function ($query) use ($id) {
            $query->where('id', $id);
        })->where('isDeterminated', true)->paginate(50);
        $pastBets->appends(request()->except('page'));

        return $pastBets;
    }
}
