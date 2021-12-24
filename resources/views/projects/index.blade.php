<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between w-full items-end">
            <h2 class="font-semibold text-lg text-gray-800 leading-tight">
                {{ __('Project Dashboard') }}
            </h2>

            <a href="/projects/create" class="btn-primary">New Projects</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden">
                <div class="p-6">
                    <div class="lg:flex lg:flex-wrap -mx-3">
                        @forelse($projects as $project)
                            <div class="lg:w-1/3 px-3 pb-6">
                                @include('projects._card')
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
