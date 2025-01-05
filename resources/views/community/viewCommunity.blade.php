@php use Illuminate\Support\Facades\Gate;use Illuminate\Support\Str; @endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Community:') }} {{$community->name}}
        </h2>
        @if (Gate::allows('update', $community))
            <x-link href="{{route('show-edit-community', $community->id)}}">Edit</x-link>
        @endif
        @if(Gate::allows('createBet', $community))
            <x-link href="{{route('create-bet', $community->id)}}">Create bet</x-link>
        @endif
    </x-slot>
    <x-main-content-card>

        <x-tabs :tabs="['Dashboard', 'Members', 'Active bets', 'Past bets']"/>

        @if(request()->get('tab') === 'Dashboard')
            @if(Gate::allows('canCreateLeaderboard', $community))
                <x-link href="{{route('create-leaderboard-view', $community->id)}}">Create Leaderboard</x-link>
            @endif
                <div class="row mt-3 mb-3">
                    @foreach($leaderboards as $leaderboard)
                        <div class="col col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5>{{$leaderboard['name']}}</h5>
                                    <hr />
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>Rank</th>
                                            <th>Name</th>
                                            <th>Points</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($leaderboard['standings'] as $standing)
                                            <tr>
                                                <td>{{ $standing->rank }}</td>
                                                <td>{{ $standing->user->name }}</td>
                                                <td>{{$standing->points}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    {{$leaderboard['standings']->links()}}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
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

        @if(request()->get('tab') === 'Active bets')
            <table class="table">
                <thead>
                <tr>
                    <th>Text</th>
                    <th>Total points</th>
                    <th>End date time</th>
                    <th>Creator</th>
                    <th>Actions</th>

                </tr>
                </thead>
                <tbody>
                @foreach ($activeBets as $bet)
                    <tr>
                        <td>{{ Str::limit($bet->betText, 50) }}</td>
                        <td>{{$bet->totalPoints}}</td>
                        <td>{{ $bet->endDateTime->format('Y-m-d H:i:s') }}</td>
                        <td>{{$bet->creator->name}}</td>
                        <td>
                            <x-link href="{{route('view-bet', $bet->id)}}">
                                Open
                            </x-link>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            {{ $activeBets->links() }}
        @endif

        @if(request()->get('tab') === 'Past bets')
            <table class="table">
                <thead>
                <tr>
                    <th>Text</th>
                    <th>Total points</th>
                    <th>End date time</th>
                    <th>Creator</th>
                    <th>Actions</th>

                </tr>
                </thead>
                <tbody>
                @foreach ($pastBets as $bet)
                    <tr>
                        <td>{{ Str::limit($bet->betText, 50) }}</td>
                        <td>{{$bet->totalPoints}}</td>
                        <td>{{ $bet->endDateTime->format('Y-m-d H:i:s') }}</td>
                        <td>{{$bet->creator->name}}</td>
                        <td>
                            <x-link href="{{route('view-bet', $bet->id)}}">
                                Open
                            </x-link>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            {{ $pastBets->links() }}
        @endif


    </x-main-content-card>
</x-app-layout>