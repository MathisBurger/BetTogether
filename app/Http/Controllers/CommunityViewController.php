<?php

namespace App\Http\Controllers;

use App\Models\Bet;
use App\Models\Community;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class CommunityViewController
{


    public function exploreCommunitiesView(): View
    {
        $communities = Community::where('admin_id', '!=', Auth::id())
            ->whereDoesntHave('members', function ($query) {
                $query->where('member_id', Auth::id());
            })
            ->paginate(50);
        return view('community.exploreCommunities', ['communities' => $communities]);
    }

    public function communitiesView(): View
    {
        $communities = Community::where('admin_id', '=', Auth::id())
            ->whereHas('members', function ($query) {
                $query->orWhere('member_id', Auth::id());
            })
            ->paginate(50);
        return view('community.communitiesView', ['communities' => $communities]);
    }

    public function viewCommunity(string $id): View
    {
        $community = Community::where('id', $id)->first();

        Gate::authorize('read', $community);

        $members = User::join('community_members', 'community_members.member_id', '=', 'users.id')
            ->where('community_members.community_id', $id)->paginate(50);
        $activeBets = Bet::with('creator')->whereHas('community', function($query) use ($id) {
            $query->where('id', $id);
        })->where('endDateTime', '>', Carbon::now())->paginate(50);
        $pastBets = Bet::with('creator')->whereHas('community', function($query) use ($id) {
            $query->where('id', $id);
        })->where('endDateTime', '<=', Carbon::now())->paginate(50);
        return \view('community.viewCommunity', ['community' => $community, 'members' => $members, 'activeBets' => $activeBets, 'pastBets' => $pastBets]);
    }

    public function viewEditCommunity(string $id): View
    {
        $community = Community::where('id', $id)->first();
        Gate::authorize('update', $community);
        return \view('community.editCommunity', ['community' => $community]);
    }
}