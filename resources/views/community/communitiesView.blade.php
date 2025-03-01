<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('messages.yourCommunities') }}
        </h2>
        <x-link href="{{route('create-community')}}">{{__('messages.createCommunity')}}</x-link>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4">
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
                                <x-link href="{{route('show-community', $community->id)}}">{{__('messages.open')}}</x-link>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                @if(count($communities) === 0)
                    <x-alert message="{{__('messages.notAMemberOfCommunity')}}" />
                @endif

                {{ $communities->links() }}
            </div>
        </div>
    </div>

</x-app-layout>