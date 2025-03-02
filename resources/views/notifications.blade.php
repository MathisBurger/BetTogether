<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('messages.notifications') }}
        </h2>
    </x-slot>
    <x-main-content-card>
        @if(count($notifications) > 0)
            <div class="mt-3">
                <x-link href="{{route('notifications-all-mark-read')}}">{{__('messages.clearAll')}}</x-link>
            </div>
        @endif
        <table class="table">
            <thead>
                <tr>
                    <td>{{__('messages.message')}}</td>
                    <td>{{__('messages.actions')}}</td>
                </tr>
            </thead>
            <tbody>
                @foreach($notifications as $notification)
                    <tr>
                        <td>{{$notification->data['message']}}</td>
                        <td>
                            <div class="row">
                                <div class="col col-md-6">
                                    <x-link href="{{$notification->data['link']}}">{{__('messages.open')}}</x-link>
                                </div>
                                <div class="col col-md-6">
                                    <a href="{{route('notifications-mark-read', $notification->id)}}">
                                        <i class="fas fa-window-close text-red-500 mt-2"></i>
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if(count($notifications) === 0)
            <x-alert message="{{__('messages.noNotifications')}}" />
        @endif
    </x-main-content-card>
</x-app-layout>