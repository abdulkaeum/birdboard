<a href="/{{ $project->path() }}">
    <div class="card flex flex-col {{ $project->user_id === auth()->user()->id ? 'bg-indigo-50' : '' }}"
         style="height: 200px">
        <h3 class="text-xl mb-6 py-4 -ml-5 border-l-4 border-cyan-400 pl-4">{{ $project->title }}</h3>
        <div
            class="text-sm text-gray-500 flex-1">{{ Str::limit($project->description, 100) }}
        </div>
        @if($project->user_id !== auth()->user()->id)
            <img src="https://i.pravatar.cc/40?u={{ $project->user_id.'&'.$project->user->email }}"
                 width="35"
                 height="35"
                 alt="{{ $project->user->email }}'s avatar"
                 title="{{ $project->user->email }}'s avatar"
                 class="rounded-full sm:text-right"
            >
        @else
            <footer>
                <form action="{{ $project->path() }}" method="POST" class="sm:text-right">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-xs">Delete</button>
                </form>
            </footer>
        @endif
    </div>
</a>
