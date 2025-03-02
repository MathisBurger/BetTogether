@props(['bets'])
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
    @foreach ($bets as $bet)
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