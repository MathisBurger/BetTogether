<?php

namespace App\Actions;

use App\Models\BetCreationPolicy;
use App\Models\Community;
use App\Models\CommunityJoinPolicy;
use App\Models\Leaderboard;
use App\Models\Standing;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\ValidationException;
use Symfony\Component\Finder\Exception\AccessDeniedException;

/**
 * All actions available for a community
 */
class CommunityActions
{
    /**
     * Creates a new community
     *
     * @param  array  $data  The input data
     * @return Community The created community
     *
     * @throws ValidationException If invalid data has been submitted
     */
    public function create(array $data): Community
    {

        Validator::make($data, [
            'name' => ['required', 'string', 'max:255', 'unique:communities'],
            'joinPolicy' => ['required', 'string', new Enum(CommunityJoinPolicy::class)],
            'betCreationPolicy' => ['required', 'string', new Enum(BetCreationPolicy::class)],
        ])->validate();

        $community = Community::create([
            'name' => $data['name'],
            'joinPolicy' => $data['joinPolicy'],
            'betCreationPolicy' => $data['betCreationPolicy'],
            'admin_id' => Auth::id(),
        ]);
        $community->members()->attach(Auth::id());
        $community->save();
        return $community;
    }

    /**
     * Updates a community
     *
     * @param  string  $id  The ID of the community
     * @param  array  $data  The data of the community that should be updated
     * @return Community The updated community
     *
     * @throws ValidationException
     */
    public function update(string $id, array $data): Community
    {
        $community = Community::where('id', $id)->firstOrFail();
        if ($community->admin_id !== Auth::id()) {
            throw new AccessDeniedException;
        }
        Validator::make($data, [
            'joinPolicy' => ['required', 'string', new Enum(CommunityJoinPolicy::class)],
            'betCreationPolicy' => ['required', 'string', new Enum(BetCreationPolicy::class)],
        ])->validate();
        $inviteLinks = ($data['inviteLinks'] ?? '') === 'on';
        $community->joinPolicy = $data['joinPolicy'];
        $community->betCreationPolicy = $data['betCreationPolicy'];
        $community->inviteLinks = $inviteLinks;

        Gate::authorize('update', $community);

        $community->save();

        return $community;
    }

    /**
     * Joins the current user into a community
     *
     * @param  string  $id  The community ID
     * @return Community The updated community
     *
     * @throws \Exception If user is already member
     */
    public function join(string $id): Community
    {
        /** @var Community $community */
        $community = Community::where('id', $id)->firstOrFail();
        Gate::authorize('join', $community);
        $community->members()->attach(Auth::id());
        $community->save();

        /** @var Leaderboard $leaderboard */
        foreach ($community->leaderboards as $leaderboard) {
            $rank = $leaderboard->standings()->count() + 1;
            Standing::create([
                'leaderboard_id' => $leaderboard->id,
                'user_id' => Auth::id(),
                'rank' => $rank,
                'points' => 0,
                'diffPointsToLastBet' => 0,
                'diffRanksToLastBet' => 0,
            ]);
        }

        return $community;
    }
}
