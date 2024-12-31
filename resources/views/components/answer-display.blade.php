@props(['answer' => new \App\Models\BetAnswer()])


@if($answer->type === \App\Models\ResultType::Integer->value)
    <p>{{$answer->integerValue}}</p>
@elseif($answer->type === \App\Models\ResultType::Float->value)
    <p>{{$answer->floatValue}}</p>
@elseif($answer->type === \App\Models\ResultType::String->value)
    <p>{{$answer->stringValue}}</p>
@endif