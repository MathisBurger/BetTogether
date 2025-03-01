@php use Illuminate\Support\Facades\Gate;use Illuminate\Support\Str; @endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('messages.community') }}: {{$community->name}}
        </h2>
        @if (Gate::allows('update', $community))
            <x-link href="{{route('show-edit-community', $community->id)}}">{{__('messages.edit')}}</x-link>
        @endif
        @if(Gate::allows('createBet', $community))
            <x-link href="{{route('create-bet', $community->id)}}">{{__('messages.createBet')}}</x-link>
        @endif
    </x-slot>
    <x-main-content-card>

        <x-tabs :tabs="['dashboard', 'members', 'activeBets', 'pastBets']"/>

        @if(request()->get('tab') === 'dashboard')
            <x-leaderboard-table :community="$community" :leaderboards="$leaderboards" />
        @endif
        @if(request()->get('tab') === 'members')
            <x-members-table :members="$members" />
        @endif
        @if(request()->get('tab') === 'activeBets')
            <x-bet-table :bets="$activeBets" />

            @if(count($activeBets) === 0)
                <x-alert message="{{__('messages.noActiveBets')}}" />
            @endif
        @endif
        @if(request()->get('tab') === 'pastBets')
            <x-bet-table :bets="$pastBets" />

            @if(count($pastBets) === 0)
                <x-alert message="{{__('messages.noPastBets')}}" />
            @endif
        @endif


    </x-main-content-card>
</x-app-layout>