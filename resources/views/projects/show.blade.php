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

                    @forelse($project->tasks as $task)
                        <div class="card mb-3">{{ $task->body }}</div>
                    @empty
                        <div class="card mb-3">Lorem ipsum.</div>
                    @endforelse
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
