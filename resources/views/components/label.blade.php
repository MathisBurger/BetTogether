@props(['value', 'block' => true])

@if($block)
    <label {{ $attributes->merge(['class' => 'block font-medium text-sm text-gray-700']) }}>
        {{ $value ?? $slot }}
    </label>
@else
    <label {{ $attributes->merge(['class' => 'font-medium text-sm text-gray-700']) }}>
        {{ $value ?? $slot }}
    </label>
@endif
