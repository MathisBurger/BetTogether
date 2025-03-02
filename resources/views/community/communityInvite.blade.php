<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('messages.joinCommunity') }}: {{$community->name}}
        </h2>
    </x-slot>
    <div class="py-12">
        <x-card>
            <x-validation-errors class="mb-4"/>
            @if($community->inviteLinks && $joinAllowed)
                <form method="POST" action="{{route('join-community-action', $community->id)}}">
                    @csrf

                    {{__('messages.joinCommunityViaLink')}}
                    <div class="flex items-center justify-end mt-4">
                        <x-form-action-button>
                            {{__('messages.join')}}
                        </x-form-action-button>
                    </div>
                </form>
            @elseif($community->inviteLinks && !$joinAllowed)
                <x-alert message="{{__('messages.alreadyMemberOfCommunity')}}" />
            @else
                <x-alert message="{{__('messages.invitesNotEnabled')}}" />
            @endif
        </x-card>
    </div>
</x-app-layout>