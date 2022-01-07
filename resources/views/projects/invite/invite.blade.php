<div class="card flex flex-col">
    <h3 class="text-xl mb-6 py-4 -ml-5 border-l-4 border-cyan-400 pl-4">
        Invite a user
    </h3>
    <form action="/{{ $project->path() . '/invitations'}}" method="POST">
        @csrf
        <label>
            <input type="email" name="email"
                   class="border border-gray-400 rounded w-full mb-3"
                   placeholder="Email address"
            >
        </label>

        <button type="submit" class="btn-primary">Invite</button>

        @error('email')
        <div class="text-red-600 text-sm mt-2">
            {{ $message }}
        </div>
        @enderror
    </form>
</div>
