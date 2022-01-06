<div class="card mt-3">
    @foreach($project->members as $members)
        <img src="https://i.pravatar.cc/60?u={{ $members->user_id }}"
             width="35"
             height="35"
             alt="{{ $members->name }}'s avatar"
             class="rounded-full"
        >
    @endforeach
</div>
