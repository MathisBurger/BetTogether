@php use App\Models\ResultType; @endphp
@props(['type'])

@if ($type === ResultType::Integer->value)
    <x-label value="{{ __('messages.answerNumber') }}"/>
    <x-input type="number" name="value"/>
@elseif($type === ResultType::Float->value)
    <x-label value="{{ __('messages.answerNumber') }}"/>
    <x-input type="number" name="value" step="0.01"/>
@elseif($type === ResultType::String->value)
    <x-label value="{{ __('messages.answerString') }}"/>
    <x-input type="text" name="value"/>
@endif