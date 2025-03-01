<div class="p-6 lg:p-8 bg-white border-b border-gray-200">
    <x-application-logo class="block h-12 w-auto" />

    <h1 class="mt-8 text-2xl font-medium text-gray-900">
        {{__('messages.dashboard.title')}}
    </h1>

    <div class="max-w-3xl mx-auto bg-white p-8 rounded-lg shadow-md">
        <p class="text-lg mb-4">{{__('messages.dashboard.intro')}}</p>

        <h2 class="text-2xl font-semibold text-gray-800 mt-6 mb-2">{{__('messages.dashboard.possibilities')}}:</h2>
        <ul class="list-none space-y-2">
            <li class="flex items-center"><span class="mr-2">✅</span> <strong>{{__('messages.dashboard.simpleBetPlacing')}}</strong> – {{__('messages.dashboard.simpleBetPlacingText')}}</li>
            <li class="flex items-center"><span class="mr-2">✅</span> <strong>{{__('messages.dashboard.communities')}}</strong> – {{__('messages.dashboard.communitiesText')}}</li>
            <li class="flex items-center"><span class="mr-2">✅</span> <strong>{{__('messages.dashboard.secure')}}</strong> – {{__('messages.dashboard.secureText')}}</li>
        </ul>

        <h2 class="text-2xl font-semibold text-gray-800 mt-6 mb-2">{{__('messages.dashboard.uxNewDefined')}}</h2>
        <p class="text-lg mb-4">{{__('messages.dashboard.whatWeStandFor')}}</p>

        <p class="text-lg font-semibold text-blue-600">{{__('messages.dashboard.startNow')}}</p>
    </div>
</div>
