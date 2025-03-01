@props(['members'])
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