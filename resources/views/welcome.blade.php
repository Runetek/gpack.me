@extends('layouts.app')

@section('content')
    <div class="flex-center position-ref full-height">
        @if (Route::has('login'))
            <div class="top-right links">
                @auth
                    <a href="{{ url('/home') }}">Home</a>
                @else
                    <a href="{{ route('login') }}">Login</a>
                    <a href="{{ route('register') }}">Register</a>
                @endauth
            </div>
        @endif

        <div class="content">
            <div class="title m-b-md">
                gpack
            </div>

            <p style="font-size: 32px; padding-top: 30px">
                <vue-typer
                    :text="['gamepacks', 'deobs', 'automated analysis']"
                    :pre-type-delay="200"
                    caret-animation="phase"
                ></vue-typer>
            </p>
        </div>
    </div>
@endsection
