<?php

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
});
