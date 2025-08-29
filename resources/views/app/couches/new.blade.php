@extends('app')

@section('name', 'new-couch')

@section('content')
    <div class="pane-area">
        <div class="pane-stack">
            <div id="new-couch-title">
                <h1 id="new-couch-title-heading" >
                    <span
                        class="write-out all-caps"
                        data-text="New Couch"
                    ></span><span class="blink">_</span>
                </h1>
            </div>
        </div>

        <div class="pane-stack">
            <a class="pane-button" href="{{ route('couches') }}">
                abort
            </a>
        </div>
    </div>

    <div class="center-pane-area">
        <div class="pane">
            <div class="error-container">
                @error('name')
                    <p class="error">
                        {{ $message }}
                    </p>
                @enderror

                @yield('errors')
            </div>

            <form method="POST" action="{{ route('couches.new') }}">
                @csrf

                <div>
                    <label class="data-label">
                        Couch Name:

                        <input
                            class="data-input"
                            type="text"
                            name="name"
                            required
                            autofocus
                        >
                    </label>
                </div>

                <div>
                    <button class="data-button" type="submit">
                        create
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection