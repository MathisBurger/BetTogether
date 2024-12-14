<?php

namespace App\Http\Controllers;

use App\Actions\BetActions;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BetActionController
{

    public function __construct(private BetActions $actions) {}

    public function create(string $id, Request $request): RedirectResponse
    {
        $bet = $this->actions->createBet($id, $request->all());
        return redirect()
    }

}