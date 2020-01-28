@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col">
            <h1>{{ $project->title }}</h1>
            <p>
                {{ $project->description }}
            </p>
            <a href="{{ route('projects.index') }}">Go Back</a>
        </div>
    </div>
@endsection
