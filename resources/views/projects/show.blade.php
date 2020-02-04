@extends('layouts.app')

@section('content')
    <header class="flex items-center mb-3 py-4">
        <div class="flex justify-between items-end w-full">
            <p class="text-lg text-purple-500">
                <a href="{{ route('projects.index') }}">My Projects</a> / {{ $project->title }}
            </p>
            <a class="button" href="{{ route('projects.create') }}">New Project</a>
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
                                <div class="flex">
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

                    <textarea class="card w-full">Lorem ipsum.</textarea>
                </div>
            </div>


            <div class="lg:w-1/4 px-3">
                @include ('projects.card')
                <a href="{{ route('projects.index') }}">Go Back</a>
            </div>
        </div>
    </main>
@endsection
