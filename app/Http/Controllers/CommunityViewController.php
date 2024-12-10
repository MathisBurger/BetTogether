<?php

namespace App\Http\Controllers;

use App\Models\Community;
use Illuminate\View\View;

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
}