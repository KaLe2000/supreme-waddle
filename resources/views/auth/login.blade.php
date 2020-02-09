@extends('layouts.app')

@section('content')
<form method="POST" action="{{ route('login') }}"
      class="lg:w-1/2 lg:mx-auto p-6 md:py-12 md:px-16 theme-gradient card">
    <h1 class="text-2xl font-normal mb-10 text-center">{{ __('Login') }}</h1>
    @csrf

    <div class="field mb-6">
        <label for="email" class="label text-sm mb-2 block">{{ __('E-Mail Address') }}</label>

        <div class="control">
            <input
                    class="input bg-transparent border border-gray-100 rounded p-2 text-xs w-full text-black @error('email') is-invalid @enderror"
                    id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="field mb-6">
        <label for="password" class="label text-sm mb-2 block">{{ __('Password') }}</label>

        <div class="control">
            <input
                    class="input bg-transparent border border-gray-100 rounded p-2 text-xs w-full text-black @error('password') is-invalid @enderror"
                    id="password" type="password" name="password" required autocomplete="current-password">

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="field mb-6">
        <div class="control">
                <input
                        class="input bg-transparent border border-gray-100 rounded p-2 text-xs text-black"
                        type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                <label class="form-check-label" for="remember">
                    {{ __('Remember Me') }}
                </label>
        </div>
    </div>

    <div class="form-group row mb-0">
        <div class="control">
            <button type="submit" class="btn btn-primary button">
                {{ __('Login') }}
            </button>

            @if (Route::has('password.request'))
                <a class="btn btn-link" href="{{ route('password.request') }}">
                    {{ __('Forgot Your Password?') }}
                </a>
            @endif
        </div>
    </div>
</form>
@endsection
