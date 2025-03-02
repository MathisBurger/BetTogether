@php use App\Models\CommunityJoinPolicy; @endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('messages.exploreCommunities') }}
        </h2>
        <x-link href="{{route('create-community')}}">{{__('messages.createCommunity')}}</x-link>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4">
                <form class="mt-3 row-auto">
                    <x-input placeholder="{{__('messages.search')}}" name="search" value="{{$search}}" />
                    <x-button type="submit"><i class="fas fa-search p-2"></i></x-button>
                </form>
                <table class="table">
                    <thead>
                    <tr>
                        <th>{{__('messages.name')}}</th>
                        <th>{{__('messages.admin')}}</th>
                        <th>{{__('messages.actions')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($communities as $community)
                        <tr>
                            <td>{{ $community->name }}</td>
                            <td>{{ $community->admin->name }}</td>
                            <td>
                                @if ($community->joinPolicy == CommunityJoinPolicy::Open->value)
                                    <x-form-action-button href="{{route('join-community-action', $community->id)}}">{{__('messages.join')}}</x-form-action-button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                @if(count($communities) === 0)
                    <x-alert message="{{__('messages.noCommunitiesFound')}}" />
                @endif


                {{ $communities->links() }}
            </div>
        </div>
    </div>

</x-app-layout>