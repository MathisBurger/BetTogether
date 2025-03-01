@php use App\Utility\BacklinkUtility; @endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('messages.placeBet') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <x-card>
            <x-backlink href="{{BacklinkUtility::generateBetViewBacklink($bet)}}" />
            <x-validation-errors class="mb-4"/>
            <form method="POST" action="{{ route('place-bet-action', $bet->id) }}">
                @csrf
                <p>{{$bet->betText}}</p>
                <x-answer-type-input :type="$bet->answer->type" />
                <div class="flex items-center justify-end mt-4">
                    <x-button class="ms-4">
                        {{ __('messages.placeBet') }}
                    </x-button>
                </div>
            </form>
        </x-card>
    </div>
</x-app-layout>