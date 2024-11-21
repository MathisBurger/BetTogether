@props(['name' => ''])

<select class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full" name="{{$name}}">
    {{$slot}}
</select>