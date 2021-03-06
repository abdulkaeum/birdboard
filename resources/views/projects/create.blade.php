<x-app-layout>
    <x-slot name="header">
        <div class="lg:flex justify-between w-full items-end">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create a Project
            </h2>

            <a href="{{ URL::previous() }}" class="btn-primary">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden">
                <div class="p-6">
                    <form action="/projects" method="POST">
                        @csrf

                        <div class="card @error('title') border border-red-500 @enderror">
                            <label for="title"></label>
                            <input type="text"
                                   name="title"
                                   id="title"
                                   placeholder="Project title @error('title')is required @enderror"
                                   class="inputCSS w-full"
                                   value="{{ old('title') }}"
                                   required
                            >
                        </div>

                        <div class="card @error('description') border border-red-500 @enderror">
                            <label for="description"></label>
                            <textarea name="description"
                                      id="description"
                                      placeholder="Project description @error('title')is required @enderror"
                                      class="inputCSS w-full"
                                      required
                            >{{ old('description') }}</textarea>
                        </div>

                        <button type="submit" class="btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
