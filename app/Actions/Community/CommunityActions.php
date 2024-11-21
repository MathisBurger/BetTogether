<?php

namespace App\Actions\Community;

use App\Models\BetCreationPolicy;
use App\Models\Community;
use App\Models\CommunityJoinPolicy;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\ValidationException;

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
        ]);
    }

}