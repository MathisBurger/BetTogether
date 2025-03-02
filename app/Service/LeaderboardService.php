<?php

namespace App\Service;

use App\Models\Leaderboard;
use App\Models\Standing;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

readonly class LeaderboardService
{
    /**
     * Gets all leaderboards for a community
     *
     * @param  string  $id  The ID of the community
     * @return Collection The leaderboards as table maps
     */
    public function getCommunityLeaderboards(string $id): Collection
    {
        /** @var Collection<(int|string), Leaderboard> $leaderboardObjects */
        $leaderboardObjects = Leaderboard::where('community_id', $id)->get();

        return $this->convertToLeaderboardMaps($leaderboardObjects);
    }

    /**
     * Gets the leaderboards the user marked as favorite
     *
     * @return Collection The user favorite leaderboards
     */
    public function getUserFavoriteLeaderboards(): Collection
    {
        /** @var Collection<(int|string), Leaderboard> $leaderboardObjects */
        $leaderboardObjects = Leaderboard::whereHas('favoritesBy', function ($query) {
            $query->where('id', Auth::id());
        })->get();

        return $this->convertToLeaderboardMaps($leaderboardObjects);
    }

    /**
     * Converts each leaderboard to a map that can be used to display the data in a leaderboard table
     *
     * @param  Collection  $leaderboardObjects  All leaderboard objects
     * @return Collection The objects as maps
     */
    private function convertToLeaderboardMaps(Collection $leaderboardObjects): Collection
    {
        return $leaderboardObjects->map(function (Leaderboard $leaderboardObject) {
            $standings = Standing::with('user')->where('leaderboard_id', $leaderboardObject->id)->orderBy('rank')->paginate(50, pageName: ''.$leaderboardObject->id);
            $standings->appends(request()->except($leaderboardObject->id));

            return [
                'id' => $leaderboardObject->id,
                'isFavorite' => $leaderboardObject->favoritesBy()->where('user_id', Auth::id())->exists(),
                'name' => $leaderboardObject->name,
                'standings' => $standings,
            ];
        });
    }
}
