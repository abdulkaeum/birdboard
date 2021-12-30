<x-app-layout>
    <x-slot name="header">
        <div class="lg:flex justify-between w-full items-end">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit a Project
            </h2>


            <a href="{{ URL::previous() }}" class="btn-primary">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden">
                <div class="p-6">
                    <form action="/{{ $project->path() }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="card @error('title') border border-red-500 @enderror">
                            <label for="title"></label>
                            <input type="text"
                                   name="title"
                                   id="title"
                                   placeholder="Project title"
                                   class="inputCSS w-full"
                                   value="{{ old('title', $project->title) }}"

                            >
                        </div>

                        <div class="card @error('description') border border-red-500 @enderror">
                            <label for="description"></label>
                            <textarea name="description"
                                      id="description"
                                      placeholder="Project description"
                                      class="inputCSS w-full max-h-fit"

                            >{{ old('description', $project->description) }}</textarea>
                        </div>

                        <button type="submit" class="btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
