@php use App\Utility\BacklinkUtility; @endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('messages.createLeaderboard') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <x-card>
            <x-backlink href="{{BacklinkUtility::generateCommunityViewBacklink($community->id)}}" />
            <x-validation-errors class="mb-4"/>
            <form method="POST" action="{{ route('create-leaderboard-action', $community->id) }}">
                @csrf
                <div>
                    <x-label value="{{ __('messages.name') }}" />
                    <x-input class="block mt-1 w-full" type="text" name="name" required autofocus autocomplete="name" />
                </div>
                <div class="mt-1">
                    <x-label value="{{ __('messages.isAllTime') }}" />
                    <x-checkbox name="isAllTime" id="isAllTime" />
                </div>

                <div id="periodStart" class="mt-1">
                    <x-label value="{{ __('messages.periodStart') }}" />
                    <x-datepicker name="periodStart" />
                </div>

                <div id="periodEnd" class="mt-1">
                    <x-label value="{{ __('messages.periodEnd') }}" />
                    <x-datepicker name="periodEnd" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-button class="ms-4">
                        {{ __('messages.create') }}
                    </x-button>
                </div>
            </form>
        </x-card>
    </div>
</x-app-layout>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const isAllTime = document.getElementById('isAllTime');
        const periodStart = document.getElementById('periodStart');
        const periodEnd = document.getElementById('periodEnd');


        isAllTime.addEventListener('change', (e) => {
            console.log(periodStart);
            periodStart.style.display = e.target.checked ? 'none' : 'block';
            periodEnd.style.display = e.target.checked ? 'none' : 'block';
        });
    });
</script>