@php use App\Models\ResultType; @endphp
@props(['answer' => new \App\Models\BetAnswer()])


@if($answer->type === ResultType::Integer->value)
    <p>{{$answer->integerValue}}</p>
@elseif($answer->type === ResultType::Float->value)
    <p>{{$answer->floatValue}}</p>
@elseif($answer->type === ResultType::String->value)
    <p>{{$answer->stringValue}}</p>
@endif