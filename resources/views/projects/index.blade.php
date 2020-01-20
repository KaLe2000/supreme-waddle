@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col">
                @forelse($projects as $project)
                        <p>
                            <a href="{{ $project->path() }}">
                                {{ $project->title }}
                            </a>
                        </p>
                    @empty
                        <p>Nothing yet here.</p>
                    @endforelse
            </div>
        </div>
    </div>
@endsection
