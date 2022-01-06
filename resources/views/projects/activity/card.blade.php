<div class="card mt-3">
    @if(count($project->activity) == 0)
        Project activity
    @else
        <ul class="text-xs">
            @foreach($project->activity as $activity)
                <li class="{{ $loop->last ? '' : 'mb-1' }}">
                    @include("projects.activity.{$activity->description}")
                    {{ $activity->created_at->diffForHumans(null, null, true) }}
                </li>
            @endforeach
        </ul>
    @endif
</div>
