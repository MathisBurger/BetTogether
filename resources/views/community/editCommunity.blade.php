@php use App\Utility\BacklinkUtility; @endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Update community:') }} {{$community->name}}
        </h2>
    </x-slot>
    <div class="py-12">
        <x-card>
            <x-backlink href="{{BacklinkUtility::generateCommunityViewBacklink($community->id)}}" />
            <x-validation-errors class="mb-4"/>
            <form method="POST" action="{{ route('update-community-action', $community->id) }}">
                @csrf

                <div class="mt-4">
                    <x-label value="{{ __('Join policy') }}"/>
                    <x-select name="joinPolicy" value="{{$community->joinPolicy}}">
                        <option value="open " @selected($community->joinPolicy === 'open')>Open</option>
                        <option value="closed" @selected($community->joinPolicy === 'closed')>Closed</option>
                    </x-select>
                </div>

                <div class="mt-4">
                    <x-label value="{{ __('Bet creation policy') }}"/>
                    <x-select name="betCreationPolicy" value="{{$community->betCreationPolicy}}">
                        <option value="admin" @selected($community->betCreationPolicy === 'admin')>Admin only</option>
                        <option value="creators" @selected($community->betCreationPolicy === 'creators')>Creators only
                        </option>
                        <option value="everyone" @selected($community->betCreationPolicy === 'everyone')>Everyone
                        </option>
                    </x-select>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-button class="ms-4">
                        {{ __('Update') }}
                    </x-button>
                </div>
            </form>
        </x-card>
    </div>
</x-app-layout>