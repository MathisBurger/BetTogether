<?php

namespace App\Http\Controllers;

use App\Models\Community;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CommunityViewController
{


    public function exploreCommunitiesView(): View
    {
        $communities = Community::paginate(50);
        return view('community.exploreCommunities', ['communities' => $communities]);
    }
}