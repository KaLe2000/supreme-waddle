@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col">
                <form action="{{ route('projects.store') }}" method="POST">
                    @csrf
                    <div>
                        <label for="title">Title</label><br>
                        <input type="text" id="title" name="title" value="{{ old('title') }}"><br>
                        <label for="description">Description</label><br>
                        <textarea name="description" id="description" cols="30" rows="10">
                            {{ old('description') }}
                        </textarea><br>
                        <input type="submit">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
