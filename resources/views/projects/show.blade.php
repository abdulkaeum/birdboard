<x-app-layout>
    <x-slot name="header">
        <div class="lg:flex justify-between w-full items-end">
            <p>
                <a href="">My Projects</a> / {{ $project->title }}
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
                                {{-- Tasks --}}

                                <div class="card mb-2">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. At, enim esse et
                                    facilis fugit
                                </div>
                            </div>

                            <div>
                                <h2 class="text-gray text-lg mb-3">Notes</h2>
                                {{-- Notes --}}

                                <label>
                                    <textarea class="card w-full max-h-fit overflow-hidden">{{ $project->title }}</textarea>
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
