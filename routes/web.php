<?php

use App\Http\Controllers\BetActionController;
use App\Http\Controllers\BetViewController;
use App\Http\Controllers\CommunityActionController;
use App\Http\Controllers\CommunityViewController;
use App\Http\Controllers\DashboardViewController;
use App\Http\Controllers\LeaderboardActionController;
use App\Http\Controllers\LeaderboardViewController;
use App\Http\Controllers\LegalController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [DashboardViewController::class, 'dashboardView'])->name('dashboard');

    // Community
    Route::get('/explore-communities', [CommunityViewController::class, 'exploreCommunitiesView'])->name('explore-communities');
    Route::view('/create-community', 'community.createCommunity')->name('create-community');
    Route::post('/create-community', [CommunityActionController::class, 'create'])->name('create-community-action');
    Route::get('/communities', [CommunityViewController::class, 'communitiesView'])->name('communities-view');
    Route::get('/communities/{community}', [CommunityViewController::class, 'viewCommunity'])->name('show-community');
    Route::get('/communities/{community}/edit', [CommunityViewController::class, 'viewEditCommunity'])->name('show-edit-community');
    Route::post('/communities/{community}/edit', [CommunityActionController::class, 'update'])->name('update-community-action');
    Route::post('/communities/{community}/join', [CommunityActionController::class, 'joinCommunity'])->name('join-community-action');
    Route::get('/communities/{community}/invite', [CommunityViewController::class, 'communityInvite'])->name('view-invite-community');

    // Bet
    Route::get('/communities/{community}/create-bet', [BetViewController::class, 'createBetView'])->name('create-bet');
    Route::post('/communities/{community}/create-bet', [BetActionController::class, 'create'])->name('create-bet-action');
    Route::get('/bets/{bet}', [BetViewController::class, 'viewBet'])->name('view-bet');
    Route::get('/bets/{bet}/place', [BetViewController::class, 'placeBetView'])->name('view-place-bet');
    Route::post('/bets/{bet}/place', [BetActionController::class, 'place'])->name('place-bet-action');
    Route::get('/bets/{bet}/determine', [BetViewController::class, 'determineBetView'])->name('view-determine-bet');
    Route::post('/bets/{bet}/determine', [BetActionController::class, 'determine'])->name('determine-bet-action');

    // Leaderboard
    Route::post('/communities/{community}/leaderboards', [LeaderboardActionController::class, 'createLeaderboard'])->name('create-leaderboard-action');
    Route::get('/communities/{community}/createLeaderboard', [LeaderboardViewController::class, 'createLeaderboardView'])->name('create-leaderboard-view');
    Route::get('/leaderboards/{leaderboard}/delete', [LeaderboardActionController::class, 'deleteLeaderboard'])->name('delete-leaderboard-action');
});

// Legal
Route::get('/impress', [LegalController::class, 'impress'])->name('impress');
