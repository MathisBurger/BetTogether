<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    <x-application-logo class="block h-12 w-auto" />
                    <div class="row mt-8">
                        <div class="col col-md-6">
                            <h1 class="text-2xl font-medium text-gray-900">
                                {{__('messages.dashboard.openBets')}}
                            </h1>
                            <x-bet-table :bets="$openBets" />
                            @if(count($openBets) === 0)
                                <x-alert message="{{__('messages.dashboard.noOpenBets')}}" />
                            @endif
                        </div>
                        <div class="col col-md-6">
                            <h1 class="text-2xl font-medium text-gray-900">
                                {{__('messages.dashboard.leaderboards')}}
                            </h1>
                            <x-leaderboard-table :leaderboards="$leaderboards" :showDelete="false" :community="null" colWidth="col-md-12" />
                            @if(count($leaderboards) === 0)
                                <x-alert message="{{__('messages.dashboard.noFavoriteLeaderboards')}}" />
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
