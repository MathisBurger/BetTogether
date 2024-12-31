<?php

namespace App\Http\Controllers;

use App\Actions\BetActions;
use App\Models\Bet;
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

    public function place(string $id, Request $request): RedirectResponse
    {
        $this->actions->placeBet($id, $request->all());
        $bet = Bet::find($id);
        return redirect(route('view-bet', $bet));
    }

}