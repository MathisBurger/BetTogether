<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Bet') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <x-card>
            <x-validation-errors class="mb-4" />
            <form method="POST" action="{{ route('create-bet-action', $communityId) }}">
                @csrf

                <div>
                    <x-label for="betText" value="{{ __('Text') }}" />
                    <x-input id="betBext" class="block mt-1 w-full" type="text" name="betText" required autofocus autocomplete="name" />
                </div>

                <div class="mt-4">
                    <x-label value="{{ __('Total points') }}" />
                    <x-input class="block mt-1 w-full" type="number" name="totalPoints" required autofocus autocomplete="totalPoints" />
                </div>

                <div class="mt-4">
                    <x-label value="{{ __('Determination strategy') }}" />
                    <x-select name="determinationStrategy">
                        <option value="diff_order">Order</option>
                        <option value="diff_gradient">Gradient</option>
                        <option value="exact_match">Exact match</option>
                        <option value="manual">Manual</option>
                    </x-select>
                </div>

                <div class="mt-4 mb-4">
                    <x-label value="{{ __('End date time') }}" />
                    <x-datepicker name="endDateTime" />
                </div>

                <p class="font-bold">Answer</p>

                <div class="mt-4">
                    <x-label value="{{ __('Answer type') }}" />
                    <x-select name="answerType">
                        <option value="string">String</option>
                        <option value="integer">Integer</option>
                        <option value="float">Float</option>
                    </x-select>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-button class="ms-4">
                        {{ __('Create bet') }}
                    </x-button>
                </div>
            </form>
        </x-card>
    </div>
</x-app-layout>