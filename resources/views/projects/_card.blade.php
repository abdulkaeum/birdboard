<a href="/{{ $project->path() }}">
    <div class="card flex flex-col" style="height: 200px">
        <h3 class="text-xl mb-6 py-4 -ml-5 border-l-4 border-cyan-400 pl-4">{{ $project->title }}</h3>
        <div
            class="text-sm text-gray-500 flex-1">{{ Str::limit($project->description, 100) }}
        </div>
        <footer>
            <form action="{{ $project->path() }}" method="POST" class="sm:text-right">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-xs">Delete</button>
            </form>
        </footer>
    </div>
</a>
