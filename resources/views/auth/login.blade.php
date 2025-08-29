@extends('app')

@section('name', 'login')

@section('content')
    <x-title />

    <div class="center-pane-area">
        <div class="pane">
            <h2>
                /login
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

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div>
                    <label class="data-label">
                        Email:

                        <input
                            class="data-input"
                            type="email"
                            name="email"
                            value="{{ !empty($_GET['email']) ? $_GET['email'] : old('email') }}"
                            required
                            autocomplete="email"
                            autofocus
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
                            autocomplete="current-password"
                        >
                    </label>
                </div>

                <div>
                    <label>
                        <input type="checkbox" name="remember" @if (old('remember')) checked @endif />
                        
                        Remember me
                    </label>
                </div>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" id="password-request-link">
                        Passwort vergessen?
                    </a>
                @endif

                <div>
                    <button class="data-button" type="submit">
                        sign in
                    </button>
                </div>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}" id="register-link">
                        Need an account?
                    </a>
                @endif
            </form>
        </div>
    </div>
@endsection