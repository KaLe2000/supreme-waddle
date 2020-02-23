@extends('layouts.app')

@section('content')
    <header class="flex items-center mb-3 py-4">
        <div class="flex justify-between items-end w-full">
            <div class="text-lg text-purple-500">
                <a href="{{ route('projects.index') }}">My Projects</a> / {{ $project->title }}
            </div>

            <div class="flex items-center">
                <img
                        src="{{ $project->user->gravatar }}"
                        alt="Project owner: {{ $project->user->name }}'s avatar"
                        class="rounded-full w-8 mr-2">
                @forelse ($project->members as $member)
                    <img
                            src="{{ $member->gravatar }}"
                            alt="{{ $member->name }}'s avatar"
                            class="rounded-full w-8 mr-2">
                    @empty
                @endforelse

                <a class="button ml-6" href="{{ route('projects.edit', $project) }}">Edit Project</a>
            </div>
        </div>
    </header>

    <main>
        <div class="lg:flex -mx-3">
            <div class="lg:w-3/4 px-3 mb-6">
                <div class="mb-8">
                    <h2 class="text-purple-500 text-2xl mb-3">Tasks</h2>

                    @foreach($project->tasks as $task)
                        <form action="{{ route('tasks.update', [$project->id, $task->id]) }}" method="POST">
                            @method('PATCH')
                            @csrf
                            <div class="card mb-3">
                                <div class="flex items-center">
                                    <input type="text" name="body" class="w-full bg-gray-700" value="{{ $task->body }}">
                                    <input {{ $task->completed_at ? 'checked' : '' }}
                                            type="checkbox" name="completed_at" onchange="this.form.submit()">
                                </div>
                            </div>
                        </form>
                    @endforeach
                    <div class="card mb-3">
                        <form action="{{ route('tasks.store', $project->id) }}" method="POST">
                            @csrf
                            <input type="text" name="body" class="w-full bg-gray-700"
                                   placeholder="Add new task..."
                                   value="{{ old('body') }}">
                        </form>
                    </div>
                </div>
                <div>
                    <h2 class="text-purple-500 text-2xl mb-3">General Notes</h2>

                    <form action="{{ route('projects.update', $project) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <textarea
                                class="card w-full mb-4"
                                name="notes"
                                placeholder="Anything special that you want to make a note of?"
                        >{{ $project->notes }}</textarea>
                        <button type="submit" class="button">
                            Save
                        </button>
                    </form>
                    @include ('projects.errors')
                </div>
            </div>


            <div class="lg:w-1/4 px-3">
                <div class="mt-12">
                    @include ('projects.card')
                </div>
                <div class="card mt-3">
                    @include ('projects.activity.card')
                </div>
                @can ('manage', $project)
                <div class="card flex flex-col mt-3">
                    @include ('projects.invite')
                </div>
                @endcan
            </div>

        </div>
    </main>
@endsection
