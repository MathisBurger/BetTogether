<?php

namespace App\Http\Controllers;

use App\Actions\BetActions;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

readonly class BetActionController
{

    public function __construct(private readonly BetActions $actions) {}

    public function create(string $id, Request $request): RedirectResponse
    {
        $bet = $this->actions->createBet($id, $request->all());
        return redirect(route('view-bet', $bet));
    }

}