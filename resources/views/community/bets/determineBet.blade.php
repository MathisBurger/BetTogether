@php use App\Models\ResultType; @endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Determine bet') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <x-card>
            <x-validation-errors class="mb-4"/>
            <form method="POST" action="{{ route('determine-bet-action', $bet->id) }}">
                @csrf
                <p>{{$bet->betText}}</p>
                @if ($bet->answer->type === ResultType::Integer->value)
                    <x-label value="{{ __('Answer (Number)') }}" />
                    <x-input type="number" name="value" />
                @elseif($bet->answer->type === ResultType::Float->value)
                    <x-label value="{{ __('Answer (Number)') }}" />
                    <x-input type="number" name="value" step="0.01" />
                @elseif($bet->answer->type === ResultType::String->value)
                    <x-label value="{{ __('Answer (String)') }}" />
                    <x-input type="text" name="value" />
                @endif
                <div class="flex items-center justify-end mt-4">
                    <x-button class="ms-4">
                        {{ __('Determine bet') }}
                    </x-button>
                </div>
            </form>
        </x-card>
    </div>
</x-app-layout>