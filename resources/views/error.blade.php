@extends('app')

@section('name', 'error')

@section('content')
    <div class="center-pane-area">
        <div class="pane-stack">
            <div id="error-title">
                <h1 id="error-title-heading" >
                    <span
                        class="write-out all-caps"
                        data-text="Error @yield('error-code')"
                    ></span><span class="blink">_</span>
                </h1>

                @if ($exception->getMessage())
                    <p id="error-title-subtitle" class="subtitle">
                        {{ $exception->getMessage() }}
                    </p>
                @endif
            </div>
        </div>

        @auth
            <div class="pane-stack">
                <a class="pane-button" href="{{ route('dashboard') }}">
                    cd home
                </a>
            </div>
        @endauth
    </div>
@endsection