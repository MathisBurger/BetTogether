@php use App\Utility\BacklinkUtility; @endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Bet') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <x-card>
            <x-backlink href="{{BacklinkUtility::generateCommunityViewBacklink($communityId)}}" />
            <x-validation-errors class="mb-4" />
            <form method="POST" action="{{ route('create-bet-action', $communityId) }}">
                @csrf

                <div>
                    <x-label for="betText" value="{{ __('messages.text') }}" />
                    <x-input id="betBext" class="block mt-1 w-full" type="text" name="betText" required autofocus autocomplete="name" />
                </div>

                <div class="mt-4">
                    <x-label value="{{ __('messages.totalPoints') }}" />
                    <x-input class="block mt-1 w-full" type="number" name="totalPoints" required autofocus autocomplete="totalPoints" />
                </div>

                <div class="mt-4">
                    <x-label value="{{ __('messages.determinationStrategy') }}" />
                    <x-select name="determinationStrategy">
                        <option value="diff_gradient">{{__('messages.gradient')}}</option>
                        <option value="exact_match">{{__('messages.exactMatch')}}</option>
                        <option value="manual">{{__('messages.manual')}}</option>
                    </x-select>
                </div>

                <div class="mt-4 mb-4">
                    <x-label value="{{ __('messages.endDateTime') }}" />
                    <x-datepicker name="endDateTime" />
                </div>

                <p class="font-bold">{{__('messages.answer')}}</p>

                <div class="mt-4">
                    <x-label value="{{ __('messages.answerType') }}" />
                    <x-select name="answerType">
                        <option value="string">{{__('messages.string')}}</option>
                        <option value="integer">{{__('messages.integer')}}</option>
                        <option value="float">{{__('messages.float')}}</option>
                    </x-select>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-button class="ms-4">
                        {{ __('messages.createBet') }}
                    </x-button>
                </div>
            </form>
        </x-card>
    </div>
</x-app-layout>