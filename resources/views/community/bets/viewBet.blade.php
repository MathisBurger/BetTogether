<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Bet details') }}
        </h2>
    </x-slot>
    <x-main-content-card>
        <h1 class="font-bold" style="font-size: 2em;">{{$bet->betText}}</h1>
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
        @if(!$hasPlacedBet)
            <div class="mt-1">
                <x-link href="">
                    Place bet
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
        </table>
    </x-main-content-card>
</x-app-layout>