<x-app-layout>
    <x-slot name="header">
        <div class="lg:flex justify-between w-full items-end">
            <p>
                <a href="/projects">My Projects</a> / {{ $project->title }}
            </p>

            <div>
                <a href="{{ URL::previous() }}" class="btn-primary">Back</a>
                <a href="/{{ $project->path().'/edit' }}" class="btn-primary">Edit</a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden">
                <div class="p-6">
                    <div class="lg:flex -mx-6">
                        <div class="lg:w-2/3 px-3 pb-3">
                            <div class="mb-6">

                                <h2 class="text-gray text-lg mb-3">Tasks</h2>
                                @foreach($project->tasks as $task)
                                    <div class="card">
                                        <form action="{{ $task->path()}}" method="POST">
                                            @method('PATCH')
                                            @csrf

                                            <div class="flex">
                                                <label for="body"></label>
                                                <input type="text"
                                                       name="body"
                                                       id="body"
                                                       value="{{ $task->body }}"
                                                       class="{{ $task->completed ? 'text-gray-400' : '' }} w-full mr-2 inputCSS"
                                                >

                                                <label for="completed"></label>
                                                <input type="checkbox"
                                                       id="completed"
                                                       name="completed"
                                                       {{ $task->completed ? 'checked' : '' }}
                                                       onchange="this.form.submit()"
                                                       class="rounded p-4 border-cyan-400 focus:border-transparent focus:ring-indigo-50"
                                                >
                                            </div>
                                        </form>
                                    </div>
                                @endforeach

                                <div class="card">
                                    <form method="POST" action="/{{ $project->path() . '/tasks' }}">
                                        @csrf
                                        <label>
                                            <input class="focus:outline-none p-2 rounded w-full"
                                                   placeholder="Add a new task"
                                                   id="body"
                                                   name="body"
                                            />
                                        </label>
                                    </form>
                                </div>
                            </div>

                            <div>
                                <h2 class="text-gray text-lg mb-3">Notes</h2>
                                {{-- Notes --}}
                                <form action="/{{ $project->path() }}" method="POST">
                                    @csrf
                                    @method('PATCH')

                                    <label for="notes"></label>
                                    <textarea
                                        name="notes"
                                        id="notes"
                                        class="card w-full max-h-fit overflow-hidden inputCSS"
                                        placeholder="Add any notes here"
                                    >{{ $project->notes }}</textarea>


                                    <button type="submit" class="btn-primary">Save</button>
                                </form>
                            </div>
                        </div>
                        <div class="lg:w-1/3 px-3">
                            @include('projects._card')
                            @include('projects.activity.card')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
