@props(['community', 'leaderboards', 'showDelete' => true, 'colWidth' => 'col-md-6'])

@if(Gate::allows('canCreateLeaderboard', $community))
    <x-link href="{{route('create-leaderboard-view', $community->id)}}">{{__('messages.createLeaderboard')}}</x-link>
@endif
<div class="row mt-3 mb-3">
    @foreach($leaderboards as $leaderboard)
        <div class="{{'col ' . $colWidth . ' mt-2'}}">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col col-md-10">
                            <h5>{{$leaderboard['name']}}</h5>
                        </div>
                        <div class="col col-md-1">
                            <a href="{{route('change-leaderboard-favorite-action',  $leaderboard['id'])}}">
                                @if($leaderboard['isFavorite'])
                                    <i class="fas fa-star text-yellow-300"></i>
                                @else
                                    <i class="fas fa-star text-gray-400"></i>
                                @endif
                            </a>
                        </div>
                        <div class="col col-md-1">
                            @if(Gate::allows('canDeleteLeaderboard', $community) && $showDelete)
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
                                <td>
                                    @if($standing->diffPointsToLastBet < 0)
                                        <p class="text-red-500">
                                            <i class="fas fa-arrow-down"></i>
                                            {{$standing->diffPointsToLastBet}}
                                        </p>

                                    @elseif($standing->diffPointsToLastBet > 0)
                                        <p class="text-green-600">
                                            <i class="fas fa-arrow-up"></i>
                                            {{$standing->diffPointsToLastBet}}
                                        </p>
                                    @else
                                        <p>{{$standing->diffPointsToLastBet}}</p>
                                    @endif
                                </td>
                                <td>
                                    @if($standing->diffRanksToLastBet < 0)
                                        <p class="text-red-500">
                                            <i class="fas fa-arrow-down"></i>
                                            {{$standing->diffRanksToLastBet}}
                                        </p>

                                    @elseif($standing->diffRanksToLastBet > 0)
                                        <p class="text-green-600">
                                            <i class="fas fa-arrow-up"></i>
                                            {{$standing->diffRanksToLastBet}}
                                        </p>
                                    @else
                                        <p>{{$standing->diffRanksToLastBet}}</p>
                                    @endif
                                </td>
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