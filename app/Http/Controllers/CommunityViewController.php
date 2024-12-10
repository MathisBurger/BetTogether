<?php

namespace App\Http\Controllers;

use App\Models\Community;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class CommunityViewController
{


    public function exploreCommunitiesView(): View
    {
        $communities = Community::leftJoin('community_members', 'community_members.community_id', '=', 'communities.id')
            ->whereNot('community_members.member_id', Auth::id())->whereNot('admin_id', Auth::id())->paginate(50);
        return view('community.exploreCommunities', ['communities' => $communities]);
    }

    public function communitiesView(): View
    {
        $communities = Community::leftJoin('community_members', 'community_members.community_id', '=', 'communities.id')
            ->where('community_members.member_id', Auth::id())->orWhere('admin_id', Auth::id())->paginate(50);
        return view('community.communitiesView', ['communities' => $communities]);
    }

    public function viewCommunity(string $id): View
    {
        $community = Community::where('id', $id)->first();
        if ($community->members->filter(fn ($user) => $user->id === Auth::id())->isEmpty() && $community->admin->id !== Auth::id()) {
            throw new AccessDeniedHttpException('You do not have permission to view this community.');
        }
        $members = User::join('community_members', 'community_members.member_id', '=', 'users.id')
            ->where('community_members.community_id', $id)->paginate(50);

        return \view('community.viewCommunity', ['community' => $community, 'members' => $members]);
    }

    public function viewEditCommunity(string $id): View
    {
        $community = Community::where('id', $id)->first();
        if (empty($community) || $community->admin->id !== auth()->user()->getAuthIdentifier()) {
            throw new AccessDeniedHttpException();
        }
        return \view('community.editCommunity', ['community' => $community]);
    }
}