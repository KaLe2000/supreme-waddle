<div class="card flex flex-col h-full">
    <h3 class="font-normal text-xl py-4 -ml-5 mb-3 border-l-4 border-purple-600 pl-4">
        <a href="{{ $project->path() }}">{{ $project->title }}</a>
    </h3>
    <div class="text-gray-500 mb-4 flex-1">
        {{ Str::limit($project->description, 100) }}
    </div>

    @can ('manage', $project)
        <footer>
            <form action="{{ route('projects.destroy', $project) }}" method="POST" class="text-right">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-xs">
                    Delete
                </button>
            </form>
        </footer>
    @endcan
</div>
