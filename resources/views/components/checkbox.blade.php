@props(['name', 'checkedValue' => false])
<input type="checkbox" name="{{$name}}" @checked($checkedValue) {!! $attributes->merge(['class' => 'rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500']) !!}>
