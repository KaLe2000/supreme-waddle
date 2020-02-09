@extends('layouts.app')

@section('content')
    <div class="lg:w-1/2 lg:mx-auto p-6 md:py-12 md:px-16 theme-gradient card">
        <h1 class="text-2xl font-normal mb-10 text-center">
            Edit your project
        </h1>

        <form action="{{ route('projects.update', $project) }}" method="POST">
            @method('PATCH')
            @include ('projects._form', [
            'button' => 'Update Project'
            ])
        </form>
    </div>
@endsection
