<?php

namespace App\Http\Controllers;

use App\Actions\CommunityActions;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

/**
 * Controller for community actions
 */
readonly class CommunityActionController
{
    public function __construct(private CommunityActions $actions) {}

    /**
     * @throws ValidationException On invalid input data
     */
    public function create(Request $request): RedirectResponse
    {
        $community = $this->actions->create($request->all());

        return redirect(route('show-community', $community));
    }

    /**
     * @throws ValidationException On invalid input data
     */
    public function update(string $id, Request $request): RedirectResponse
    {
        $community = $this->actions->update($id, $request->all());

        return redirect(route('show-community', $community));
    }

    /**
     * @throws \Exception If user is already member of the group
     */
    public function joinCommunity(string $id): RedirectResponse
    {
        $community = $this->actions->join($id);

        return redirect(route('show-community', $community));
    }
}
