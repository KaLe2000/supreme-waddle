@extends('layouts.app')

@section('content')
    <header class="flex items-center mb-3 py-4">
        <div class="flex justify-between items-end w-full">
            <h2 class="text-purple-500">My Projects</h2>
            <a class="button" href="{{ route('projects.create') }}">New Project</a>
        </div>
    </header>

    <main class="lg:flex lg:flex-wrap -mx-3">
        @forelse($projects as $project)
            <div class="lg:w-1/3 px-3 pb-6">
                <div class="bg-gray-700 p-5 rounded shadow text-white">
                    <h3 class="font-normal text-xl py-4 -ml-5 mb-3 border-l-4 border-purple-600 pl-4">
                        <a href="{{ $project->path() }}">{{ $project->title }}</a>
                    </h3>
                    <div class="text-gray-500">
                        {{ Str::limit($project->description, 100) }}
                    </div>
                </div>
            </div>
        @empty
            <p>Nothing yet here.</p>
        @endforelse
    </main>

@endsection
