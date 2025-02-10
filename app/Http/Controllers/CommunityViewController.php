<?php

namespace App\Http\Controllers;

use App\Models\Bet;
use App\Models\Community;
use App\Models\Leaderboard;
use App\Models\Standing;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
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
            ->orWhereHas('members', function ($query) {
                $query->where('member_id', Auth::id());
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
        $members->appends(request()->except('page'));

        $activeBets = Bet::with('creator')->whereHas('community', function($query) use ($id) {
            $query->where('id', $id);
        })->where('endDateTime', '>', Carbon::now())->where('isDeterminated', false)->paginate(50);
        $activeBets->appends(request()->except('page'));

        $pastBets = Bet::with('creator')->whereHas('community', function($query) use ($id) {
            $query->where('id', $id);
        })->where('endDateTime', '<=', Carbon::now())->orWhere('isDeterminated', true)->paginate(50);
        $pastBets->appends(request()->except('page'));

        /** @var Collection $leaderboardObjects */
        $leaderboardObjects = Leaderboard::where('community_id', $id)->get();
        $leaderboards = $leaderboardObjects->map(function ($leaderboardObject) {
            $standings = Standing::with('user')->where('leaderboard_id', $leaderboardObject->id)->paginate(50, pageName: $leaderboardObject->id);
            $standings->appends(request()->except($leaderboardObject->id));
            return [
                'name' => $leaderboardObject->name,
                'standings' => $standings
            ];
        });

        return \view('community.viewCommunity', ['community' => $community, 'members' => $members, 'activeBets' => $activeBets, 'pastBets' => $pastBets, 'leaderboards' => $leaderboards->toArray()]);
    }

    public function viewEditCommunity(string $id): View
    {
        $community = Community::where('id', $id)->first();
        Gate::authorize('update', $community);
        return \view('community.editCommunity', ['community' => $community]);
    }
}