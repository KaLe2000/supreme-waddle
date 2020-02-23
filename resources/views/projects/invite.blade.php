<h3 class="font-normal text-xl py-4 -ml-5 mb-3 border-l-4 border-purple-600 pl-4">
    Invite a user
</h3>

<footer>
    <form action="{{ route('projects.invite', $project) }}" method="POST" class="text-right">
        @csrf

        <div class="mb-3">
            <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="john@doe.com"
                    class="input bg-transparent border border-gray-100 rounded p-2 text-xs w-full py-2 px-3">
        </div>

        <button type="submit" class="button">
            Invite
        </button>
    </form>
</footer>

@include ('projects.errors', [
'bag' => 'invitations'
])