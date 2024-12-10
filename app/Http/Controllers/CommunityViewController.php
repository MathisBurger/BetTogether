<?php

namespace App\Http\Controllers;

use App\Models\Community;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class CommunityViewController
{


    public function exploreCommunitiesView(): View
    {
        $communities = Community::paginate(50);
        return view('community.exploreCommunities', ['communities' => $communities]);
    }

    public function viewCommunity(string $id): View
    {
        return \view('community.viewCommunity', ['community' => Community::where('id', $id)->first()]);
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