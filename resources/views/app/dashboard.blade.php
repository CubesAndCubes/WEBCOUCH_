@extends('app')

@section('name', 'dashboard')

@section('content')
    <div class="center-pane-area">
        <div class="pane-stack">
            <div id="dashboard-title">
                <h1 id="dashboard-title-heading" >
                    <span
                        class="write-out all-caps"
                        data-text="Hello {{ $user->name }}"
                    ></span><span class="blink">_</span>
                </h1>
            </div>
        </div>

        <div class="pane-stack">
            <a class="pane-button" href="{{ route('couches') }}">
                cd my_couches
            </a>

            <a class="pane-button" href="{{ route('library') }}">
                cd media_library
            </a>

            <button class="pane-button" type="submit" form="logout">
                sign out
            </button>
        </div>
    </div>

    <form id="logout" action="{{ route('logout') }}" method="POST">
        @csrf
    </form>
@endsection