<x-app-layout>
    <x-slot name="header">
        <div class="lg:flex justify-between w-full items-end">
            <p>
                <a href="/projects">My Projects</a> / {{ $project->title }}
            </p>

            <a href="" class="btn-primary">Back</a>
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
                                    <div class="card mb-2">
                                        <form action="/{{ $project->path() . '/tasks/' . $task->id }}" method="POST">
                                            @method('PATCH')
                                            @csrf

                                            <div class="flex ">
                                                <label for="body"></label>
                                                <input type="text"
                                                       name="body"
                                                       id="body"
                                                       value="{{ $task->body }}"
                                                       class="{{ $task->completed ? 'text-gray-400' : '' }} w-full mr-2 border-transparent focus:ring-opacity-50 focus:border-transparent focus:ring-indigo-50"
                                                >

                                                <label for="completed"></label>
                                                <input type="checkbox"
                                                       id="completed"
                                                       name="completed"
                                                       {{ $task->completed ? 'checked' : '' }}
                                                       onchange="this.form.submit()"
                                                >
                                            </div>
                                        </form>
                                    </div>
                                @endforeach

                                <div class="card mb-2">
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

                                <label>
                                    <textarea
                                        class="card w-full max-h-fit overflow-hidden">{{ $project->title }}</textarea>
                                </label>
                            </div>
                        </div>
                        <div class="lg:w-1/3 px-3">
                            @include('projects._card')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
