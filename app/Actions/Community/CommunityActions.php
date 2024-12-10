<?php

namespace App\Actions\Community;

use App\Models\BetCreationPolicy;
use App\Models\Community;
use App\Models\CommunityJoinPolicy;
use Illuminate\Support\Facades\Auth;
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
     * @param array $data The input data
     * @return Community The created community
     * @throws ValidationException If invalid data has been submitted
     */
    public function create(array $data): Community
    {

        Validator::make($data, [
            'name' => ['required', 'string', 'max:255', 'unique:communities'],
            'joinPolicy' => ['required', 'string', new Enum(CommunityJoinPolicy::class)],
            'betCreationPolicy' => ['required', 'string', new Enum(BetCreationPolicy::class)],
        ])->validate();

        return Community::create([
            'name' => $data['name'],
            'joinPolicy' => $data['joinPolicy'],
            'betCreationPolicy' => $data['betCreationPolicy'],
            'admin_id' => Auth::id(),
        ]);
    }

    /**
     * Updates a community
     *
     * @param string $id The ID of the community
     * @param array $data The data of the community that should be updated
     * @return Community The updated community
     * @throws ValidationException
     */
    public function update(string $id, array $data): Community
    {
        $community = Community::where('id', $id)->firstOrFail();
        if ($community->admin_id !== Auth::id()) {
            throw new AccessDeniedException();
        }
        Validator::make($data, [
            'joinPolicy' => ['required', 'string', new Enum(CommunityJoinPolicy::class)],
            'betCreationPolicy' => ['required', 'string', new Enum(BetCreationPolicy::class)],
        ])->validate();
        $community->joinPolicy = $data['joinPolicy'];
        $community->betCreationPolicy = $data['betCreationPolicy'];
        $community->save();
        return $community;
    }

    /**
     * Joins the current user into a community
     *
     * @param string $id The community ID
     * @return Community The updated community
     * @throws \Exception If user is already member
     */
    public function join(string $id): Community
    {
        var_dump("123");
        $community = Community::where('id', $id)->firstOrFail();
        if ($community->members()->where('member_id', Auth::id())->exists()) {
            throw new \Exception("You are already an member");
        }
        var_dump("sfdfsfds");
        var_dump("lol");
        $community->members()->attach(Auth::id());
        $community->save();
        return $community;
    }

}