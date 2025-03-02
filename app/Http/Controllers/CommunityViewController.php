<?php

namespace App\Http\Controllers;

use App\Models\Community;
use App\Service\CommunityService;
use App\Service\LeaderboardService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

/**
 * Controller for community views
 */
readonly class CommunityViewController
{
    public function __construct(private LeaderboardService $leaderboardService, private CommunityService $communityService) {}

    public function exploreCommunitiesView(): View
    {
        $query = Community::where('admin_id', '!=', Auth::id())
            ->whereDoesntHave('members', function ($query) {
                $query->where('member_id', Auth::id());
            });
        if (request()->has('search')) {
            $query->where(function ($query) {
                $query->where('name', 'like', '%'.request('search').'%');
            });
        }

        $communities = $query->paginate(50);

        return view('community.exploreCommunities', ['communities' => $communities, 'search' => request('search')]);
    }

    public function communitiesView(): View
    {
        $communities = Community::where('admin_id', '=', Auth::id())
            ->orWhereHas('members', function ($query) {
                $query->where('member_id', Auth::id());
            })
            ->paginate(50);

        return view('community.communitiesView', ['communities' => $communities]);
    }

    public function viewCommunity(string $id): View
    {
        if (request()->get('tab') === null) {
            request()->merge(['tab' => 'dashboard']);
        }

        $community = Community::where('id', $id)->first();

        Gate::authorize('read', $community);

        $members = $this->communityService->getCommunityMembers($id);
        $activeBets = $this->communityService->getCommunityActiveBets($id);
        $pastBets = $this->communityService->getCommunityPastBets($id);
        $leaderboards = $this->leaderboardService->getCommunityLeaderboards($id);

        return \view('community.viewCommunity', ['community' => $community, 'members' => $members, 'activeBets' => $activeBets, 'pastBets' => $pastBets, 'leaderboards' => $leaderboards->toArray()]);
    }

    public function viewEditCommunity(string $id): View
    {
        $community = Community::where('id', $id)->first();
        Gate::authorize('update', $community);

        return \view('community.editCommunity', ['community' => $community]);
    }

    public function communityInvite(string $id): View
    {
        $community = Community::where('id', $id)->first();
        $joinAllowed = Gate::allows('join', $community);

        return \view('community.communityInvite', ['community' => $community, 'joinAllowed' => $joinAllowed]);
    }
}
