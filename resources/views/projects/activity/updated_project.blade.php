@if(count($activity->changes['after']) == 1)
    {{-- there was a single change --}}

    You updated the {{ key($activity->changes['after']) }} of the project
@else
    You updated the project
@endif
