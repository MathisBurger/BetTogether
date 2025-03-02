@php use App\Utility\BacklinkUtility; @endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('messages.updateCommunity') }}: {{$community->name}}
        </h2>
    </x-slot>
    <div class="py-12">
        <x-card>
            <x-backlink href="{{BacklinkUtility::generateCommunityViewBacklink($community->id)}}" />
            <x-validation-errors class="mb-4"/>
            <form method="POST" action="{{ route('update-community-action', $community->id) }}">
                @csrf

                <div class="mt-4">
                    <x-label value="{{ __('messages.joinPolicy') }}"/>
                    <x-select name="joinPolicy" value="{{$community->joinPolicy}}">
                        <option value="open " @selected($community->joinPolicy === 'open')>{{__('messages.open')}}</option>
                        <option value="closed" @selected($community->joinPolicy === 'closed')>{{__('messages.closed')}}</option>
                    </x-select>
                </div>

                <div class="mt-4">
                    <x-label value="{{ __('messages.betCreationPolicy') }}"/>
                    <x-select name="betCreationPolicy" value="{{$community->betCreationPolicy}}">
                        <option value="admin" @selected($community->betCreationPolicy === 'admin')>{{__('messages.creationPolicyAdminOnly')}}</option>
                        <option value="creators" @selected($community->betCreationPolicy === 'creators')>{{__('messages.creationPolicyCreatorsOnly')}}
                        </option>
                        <option value="everyone" @selected($community->betCreationPolicy === 'everyone')>{{__('messages.creationPolicyEveryone')}}
                        </option>
                    </x-select>
                </div>

                <div class="mt-4 row-auto">
                    <x-checkbox name="inviteLinks" :checkedValue="$community->inviteLinks" />
                    <x-label value="{{ __('messages.inviteLinksEnabled') }}" :block="false" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-button class="ms-4">
                        {{ __('messages.update') }}
                    </x-button>
                </div>
            </form>
        </x-card>
    </div>
</x-app-layout>