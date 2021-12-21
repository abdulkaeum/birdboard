<a href="{{ $project->path() }}">
    <div class="card" style="height: 200px">
        <h3 class="text-xl mb-6 py-4 -ml-5 border-l-4 border-cyan-400 pl-4">{{ $project->title }}</h3>
        <div
            class="text-sm text-gray-500">{{ Str::limit($project->description, 100) }}
        </div>
    </div>
</a>
