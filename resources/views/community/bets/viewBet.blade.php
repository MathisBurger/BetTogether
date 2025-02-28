@php use App\Utility\BacklinkUtility; @endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Bet details') }}
        </h2>
    </x-slot>
    <x-main-content-card>
        <div class="mt-2">
            <x-backlink href="{{BacklinkUtility::generateCommunityViewBacklink($bet->community_id)}}" />
        </div>
        <h1 class="font-bold mt-2" style="font-size: 2em;">{{$bet->betText}}</h1>
        <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium" style="color: #1e40af; background: #dbeafe">
            {{$bet->determinationStrategy}}
        </span>
        <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium text-teal-800" style="color: {{$bet->isDeterminated ? '#115e59' : ''}}; background: #dbeafe">
            @if($bet->isDeterminated)
                Determinated
            @else
                Open
            @endif
        </span>
        <span style="background: #fef9c3; color: #854d0e" class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium">{{$bet->totalPoints}} points</span>
        <br />
        @if ($bet->isDeterminated)
            <br />
            <b>Answer:</b>
            <x-answer-display :answer="$bet->answer" />
            <hr />
            <br />
        @endif
        @if($canPlaceBet)
            <div class="mt-1">
                <x-link href="{{route('view-place-bet', $bet->id)}}">
                    Place bet
                </x-link>
            </div>
        @endif
        @if($canDetermineBet)
            <div class="mt-1">
                <x-link href="{{route('view-determine-bet', $bet->id)}}">
                    Determine bet
                </x-link>
            </div>
        @endif
        <table class="table">
            <thead>
                <tr>
                    <th>Person</th>
                    <th>Bet</th>
                    <th>Placement</th>
                    <th>Points</th>
                </tr>
            </thead>
            <tbody>
                @foreach($placedBets as $placement => $placedBet)
                    <tr>
                        <td>{{$placedBet->user->name}}</td>
                        <td><x-answer-display :answer="$placedBet->answer" /></td>
                        <td>{{$placement+1}}</td>
                        <td>{{$placedBet->points}}</td>
                    </tr>
                @endforeach
            </tbody>
            {{ $placedBets->links() }}
        </table>
    </x-main-content-card>
</x-app-layout>