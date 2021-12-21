<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create a Project
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="/projects" method="POST">
                        @csrf

                        <div>
                            <label for="title">Title</label>
                            <input type="text" name="title" id="title" placeholder="Title">
                        </div>

                        <div>
                            <label for="description">Description</label>
                            <textarea name="description" id="description" cols="30" rows="10" placeholder="Add a description"></textarea>
                        </div>

                        <button type="submit">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
