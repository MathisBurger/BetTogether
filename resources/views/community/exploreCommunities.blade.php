@php use App\Models\CommunityJoinPolicy; @endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Explore communities') }}
        </h2>
        <x-link href="{{route('create-community')}}">Create Community</x-link>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Admin</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($communities as $community)
                        <tr>
                            <td>{{ $community->name }}</td>
                            <td>{{ $community->admin->name }}</td>
                            <td>
                                @if ($community->joinPolicy == CommunityJoinPolicy::Open->value)
                                    <x-link href="{{route('show-community', $community->id)}}">Open</x-link>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                {{ $communities->links() }}
            </div>
        </div>
    </div>

</x-app-layout>