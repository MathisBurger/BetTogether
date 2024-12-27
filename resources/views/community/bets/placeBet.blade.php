<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Place bet') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <x-card>
            <x-validation-errors class="mb-4" />
            <form method="POST" action="{{ route('create-bet-action', $betId) }}">
                @csrf

                <div class="flex items-center justify-end mt-4">
                    <x-button class="ms-4">
                        {{ __('Place bet') }}
                    </x-button>
                </div>
            </form>
        </x-card>
    </div>
</x-app-layout>