@props(['community', 'leaderboards'])

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