@extends('layouts.app')

@section('content')
    <div class="lg:w-1/2 lg:mx-auto p-6 md:py-12 md:px-16 theme-gradient card">
        <h1 class="text-2xl font-normal mb-10 text-center">
            Let's start something new
        </h1>

        <form action="{{ route('projects.store') }}" method="POST">
            @include ('projects._form', [
            'project' => new \App\Models\Project,
            'button' => 'Create Project'
            ])
        </form>
    </div>
@endsection
