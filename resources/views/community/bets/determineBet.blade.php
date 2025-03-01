@php use App\Models\BetDeterminationStrategy; @endphp
@php use App\Utility\BacklinkUtility; @endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('messages.determineBet') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <x-card>
            <x-backlink href="{{BacklinkUtility::generateBetViewBacklink($bet)}}"/>
            <x-validation-errors class="mb-4"/>
            <form method="POST" action="{{ route('determine-bet-action', $bet->id) }}">
                @csrf
                <p>{{$bet->betText}}</p>
                @if($bet->determinationStrategy === BetDeterminationStrategy::Manual->value)
                    <table class="table">
                        <thead>
                        <tr>
                            <th>{{__('messages.answer')}}</th>
                            <th>{{__('messages.points')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($placedBets as $index => $placedBet)
                            <tr>
                                <td>
                                    <x-answer-display :answer="$placedBet->answer"/>
                                </td>
                                <td>
                                    <input style="display: none" name="{{'bets[' . $index . '][placed_bet_id]'}}"
                                           value="{{$placedBet->id}}"/>
                                    <x-input type="number" name="{{'bets[' . $index . '][points]'}}"
                                             max="{{$bet->totalPoints}}"/>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @foreach($placedBets as $placedBet)

                    @endforeach
                @else
                    <x-answer-type-input :type="$bet->answer->type" />
                @endif
                <div class="flex items-center justify-end mt-4">
                    <x-button class="ms-4">
                        {{ __('messages.determineBet') }}
                    </x-button>
                </div>
            </form>
        </x-card>
    </div>
</x-app-layout>