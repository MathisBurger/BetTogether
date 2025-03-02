<?php

namespace App\Actions;

use App\Models\Community;
use App\Models\Leaderboard;
use App\Service\RankingService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

/**
 * All actions for leaderboards
 */
class LeaderboardActions
{
    public function __construct(
        private readonly RankingService $rankingService,
    ) {}

    /**
     * Creates a leaderboard on a community
     *
     * @param  string  $id  The ID of the community to create on
     * @param  array  $data  The submitted form data
     * @return Leaderboard The created leaderboard
     *
     * @throws ValidationException
     */
    public function create(string $id, array $data): Leaderboard
    {
        $community = Community::find($id);
        Gate::authorize('canCreateLeaderboard', $community);

        Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'periodStart' => ['nullable', 'date', 'required_unless:isAllTime,on'],
            'periodEnd' => ['nullable', 'date', 'required_unless:isAllTime,on'],
        ])->validate();

        $isAllTime = ($data['isAllTime'] ?? '') == 'on';
        $leaderboard = Leaderboard::create([
            'community_id' => $community->id,
            'name' => $data['name'],
            'periodStart' => ! $isAllTime ? $data['periodStart'] ?? null : null,
            'periodEnd' => ! $isAllTime ? $data['periodEnd'] ?? null : null,
            'isAllTime' => $isAllTime,
        ]);

        $this->rankingService->createRanking($leaderboard);

        return $leaderboard;
    }

    /**
     * Deletes a leaderboard
     *
     * @param  Leaderboard  $leaderboard  The leaderboard to delete
     */
    public function delete(Leaderboard $leaderboard): void
    {
        Gate::authorize('canDeleteLeaderboard', $leaderboard->community);
        $leaderboard->delete();
    }

    /**
     * Changes the favorite status of an leaderboard
     *
     * @param  Leaderboard  $leaderboard  The leaderboard that should be marked / unmarked as favorite
     */
    public function changeFavorite(Leaderboard $leaderboard): void
    {
        Gate::authorize('read', $leaderboard);
        if ($leaderboard->favoritesBy()->where('user_id', Auth::id())->exists()) {
            $leaderboard->favoritesBy()->detach(Auth::id());
        } else {
            $leaderboard->favoritesBy()->attach(Auth::id());
        }
        $leaderboard->save();
    }
}
