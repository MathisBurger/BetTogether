<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Community:') }} {{$community->name}}
        </h2>
        @if ($community->admin->id === auth()->user()->getAuthIdentifier())
            <x-link href="{{route('show-edit-community', $community->id)}}">Edit</x-link>
        @endif
    </x-slot>
    <x-main-content-card>

        <x-tabs :tabs="['Dashboard', 'Members', 'Active bets', 'Past bets']" />

        @if(request()->get('tab') === 'Dashboard')
            Hier kommt ein Dashboard hin
        @endif
        @if(request()->get('tab') === 'Members')
            <table class="table">
                <thead>
                <tr>
                    <th>Name</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($members as $member)
                    <tr>
                        <td>{{ $member->name }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            {{ $members->links() }}
        @endif


    </x-main-content-card>
</x-app-layout>