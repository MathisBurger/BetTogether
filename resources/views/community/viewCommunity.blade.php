@php use Illuminate\Support\Facades\Gate;use Illuminate\Support\Str; @endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('messages.community') }}: {{$community->name}}
        </h2>
        @if (Gate::allows('update', $community))
            <x-link href="{{route('show-edit-community', $community->id)}}">{{__('messages.edit')}}</x-link>
        @endif
        @if(Gate::allows('createBet', $community))
            <x-link href="{{route('create-bet', $community->id)}}">{{__('messages.createBet')}}</x-link>
        @endif
    </x-slot>
    <x-main-content-card>

        <x-tabs :tabs="['dashboard', 'members', 'activeBets', 'pastBets']"/>

        @if(request()->get('tab') === 'dashboard')
            @if(Gate::allows('canCreateLeaderboard', $community))
                <x-link href="{{route('create-leaderboard-view', $community->id)}}">{{__('messages.createLeaderboard')}}</x-link>
            @endif
                <div class="row mt-3 mb-3">
                    @foreach($leaderboards as $leaderboard)
                        <div class="col col-md-6 mt-2">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col col-md-11">
                                            <h5>{{$leaderboard['name']}}</h5>
                                        </div>
                                        <div class="col col-md-1">
                                            @if(Gate::allows('canDeleteLeaderboard', $community))
                                                <a href="{{route('delete-leaderboard-action',  $leaderboard['id'])}}">
                                                    <i class="fas fa-trash-alt text-red-500"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                    <hr />
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>{{__('messages.rank')}}</th>
                                            <th>{{__('messages.name')}}</th>
                                            <th>{{__('messages.points')}}</th>
                                            <th>{{__('messages.pointsDiff')}}</th>
                                            <th>{{__('messages.rankDiff')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($leaderboard['standings'] as $standing)
                                            <tr>
                                                <td>{{ $standing->rank }}</td>
                                                <td>{{ $standing->user->name }}</td>
                                                <td>{{$standing->points}}</td>
                                                <td>{{$standing->diffPointsToLastBet}}</td>
                                                <td>{{$standing->diffRanksToLastBet}}</td>
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
        @if(request()->get('tab') === 'members')
            <table class="table">
                <thead>
                <tr>
                    <th>{{__('messages.name')}}</th>
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

        @if(request()->get('tab') === 'activeBets')
            <table class="table">
                <thead>
                <tr>
                    <th>{{__('messages.text')}}</th>
                    <th>{{__('messages.totalPoints')}}</th>
                    <th>{{__('messages.endDateTime')}}</th>
                    <th>{{__('messages.creator')}}</th>
                    <th>{{__('messages.actions')}}</th>

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
                                {{__('messages.open')}}
                            </x-link>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            @if(count($activeBets) === 0)
                <x-alert message="{{__('messages.noActiveBets')}}" />
            @endif

            {{ $activeBets->links() }}
        @endif

        @if(request()->get('tab') === 'pastBets')
            <table class="table">
                <thead>
                <tr>
                    <th>{{__('messages.text')}}</th>
                    <th>{{__('messages.totalPoints')}}</th>
                    <th>{{__('messages.endDateTime')}}</th>
                    <th>{{__('messages.creator')}}</th>
                    <th>{{__('messages.actions')}}</th>
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
                                {{__('messages.open')}}
                            </x-link>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            @if(count($pastBets) === 0)
                <x-alert message="{{__('messages.noPastBets')}}" />
            @endif

            {{ $pastBets->links() }}
        @endif


    </x-main-content-card>
</x-app-layout>