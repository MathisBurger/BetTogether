<?php

namespace App\Http\Controllers;

use App\Actions\Community\CommunityActions;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

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

}