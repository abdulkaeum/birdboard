<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between w-full items-end">
            <h2 class="font-semibold text-lg text-gray-800 leading-tight">
                {{ __('Project Dashboard') }}
            </h2>

            <a href="" class="btn-primary">New Projects</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden">
                <div class="p-6">
                    <div class="lg:flex lg:flex-wrap -mx-3">
                        @forelse($projects as $project)
                            <div class="lg:w-1/3 px-3 pb-6">
                                <a href="{{ $project->path() }}">
                                    <div class="bg-white p-5 rounded-lg shadow" style="height: 200px">
                                        <h3 class="text-xl mb-6 py-4 -ml-5 border-l-4 border-cyan-400 pl-4">{{ $project->title }}</h3>
                                        <div
                                            class="text-sm text-gray-500">{{ Str::limit($project->description, 100) }}
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @empty
                            <div>No projetcs created yet</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
