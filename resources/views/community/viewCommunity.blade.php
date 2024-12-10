<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Community:') }} {{$community->name}}
        </h2>
        @if ($community->admin->id === auth()->user()->getAuthIdentifier())
            <x-button>Edit (not implemented yet)</x-button>
        @endif
    </x-slot>
</x-app-layout>