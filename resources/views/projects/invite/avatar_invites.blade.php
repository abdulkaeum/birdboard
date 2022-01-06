<div class="card mt-3">
    @forelse($project->members as $members)
        <img src="https://i.pravatar.cc/60?u={{ $members->email }}"
             width="35"
             height="35"
             alt="{{ $members->name }}'s avatar"
             title="{{ $members->name }}'s avatar"
             class="rounded-full"
        >
    @empty
        No project members.
    @endforelse
</div>
