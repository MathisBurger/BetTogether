@props(['tabs' => []])

<div class="text-sm font-medium text-center text-gray-500 border-gray-200 dark:text-gray-400 dark:border-gray-700 mb-2">
    <ul class="flex flex-wrap -mb-px">
        @foreach($tabs as $tab)
            <li class="me-2">
                <a href="?tab={{$tab}}" class="inline-block p-4 text-blue-600 {{request()->get('tab') === $tab ? 'border-b-2' : ''}} border-blue-600 rounded-t-lg active dark:text-blue-500 dark:border-blue-500">{{__('messages.tabs.' . $tab)}}</a>
            </li>
        @endforeach
    </ul>
</div>