<?php

use App\Http\Controllers\BetViewController;
use App\Http\Controllers\CommunityActionController;
use App\Http\Controllers\CommunityViewController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/explore-communities', [CommunityViewController::class, 'exploreCommunitiesView'])->name('explore-communities');
    Route::view('/create-community', 'community.createCommunity')->name('create-community');
    Route::post('/create-community', [CommunityActionController::class, 'create'])->name('create-community-action');
    Route::get('/communities', [CommunityViewController::class, 'communitiesView'])->name('communities-view');
    Route::get('/communities/{community}', [CommunityViewController::class, 'viewCommunity'])->name('show-community');
    Route::get('/communities/{community}/edit', [CommunityViewController::class, 'viewEditCommunity'])->name('show-edit-community');
    Route::post('/communities/{community}/edit', [CommunityActionController::class, 'update'])->name('update-community-action');
    Route::post('/communities/{community}/join', [CommunityActionController::class, 'joinCommunity'])->name('join-community-action');
    Route::get('/communities/{community}/create-bet', [BetViewController::class, 'createBetView'])->name('create-bet');
});
