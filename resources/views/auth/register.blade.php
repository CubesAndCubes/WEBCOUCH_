@extends('app')

@section('name', 'register')

@section('content')
    <x-title />

    <div class="center-pane-area">
        <div class="pane">
            <h2>
                /register
            </h2>

            <div class="error-container">
                @error('password')
                    <p class="error">
                        {{ $message }}
                    </p>
                @enderror

                @error('email')
                    <p class="error">
                        {{ $message }}
                    </p>
                @enderror

                @yield('errors')
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div>
                    <label class="data-label">
                        Username:

                        <input
                            class="data-input"
                            type="text"
                            name="name"
                            value="{{ !empty($_GET['name']) ? $_GET['name'] : old('name') }}"
                            required
                            autofocus
                        >
                    </label>
                </div>

                <div>
                    <label class="data-label">
                        Email:

                        <input
                            class="data-input"
                            type="email"
                            name="email"
                            value="{{ !empty($_GET['email']) ? $_GET['email'] : old('email') }}"
                            required
                        >
                    </label>
                </div>

                <div>
                    <label class="data-label">
                        Password:

                        <input
                            class="data-input"
                            type="password"
                            name="password"
                            minlength="8"
                            required
                        >
                    </label>
                </div>

                <div>
                    <label class="data-label">
                        Repeat password:

                        <input
                            class="data-input"
                            type="password"
                            name="password_confirmation"
                            minlength="8"
                            required
                        >
                    </label>
                </div>

                <div>
                    <button class="data-button" type="submit">
                        sign up
                    </button>
                </div>

                @if (Route::has('login'))
                    <a href="{{ route('login') }}" id="login-link">
                        I already have an account!
                    </a>
                @endif
            </form>
        </div>
    </div>
@endsection