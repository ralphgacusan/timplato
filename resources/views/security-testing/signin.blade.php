@extends('security-testing.layout')

@section('title', 'Log in - Timplato')

@section('content')
    <section class="signin-hero" style="background-image: url('{{ asset('Assets/timplatoLoginBanner.png') }}')">
        <div class="loginContainer">
            <form class="loginForm" action="{{ route('security-testing.signin.submit') }}" method="POST">
                @csrf
                <h1 class="formTitle">Login</h1>
                <p class="lab-fixture-note">Demo account: demo@example.test / LabPassword123!</p>
                <div class="formGroup">
                    <label class="formLabel" for="email">Email</label>
                    <input class="formInput" id="email" name="email" type="text" placeholder="Enter your email"
                        value="{{ $email ?? '' }}">
                </div>
                <div class="formGroup">
                    <label class="formLabel" for="password">Password</label>
                    <input class="formInput" id="password" name="password" type="password"
                        placeholder="Enter your password">
                </div>
                <button class="formButton" type="submit">Login</button>
            </form>
        </div>
    </section>

    @isset($query)
        <style>
            .login-result-dialog {
                width: min(440px, calc(100% - 32px));
                padding: 32px;
                border: 0;
                border-radius: 18px;
                color: #333;
                text-align: center;
                box-shadow: 0 12px 40px rgba(0, 0, 0, .24);
            }

            .login-result-dialog::backdrop {
                background: rgba(32, 24, 48, .62);
            }

            .login-result-dialog__indicator {
                display: grid;
                width: 56px;
                height: 56px;
                margin: 0 auto 16px;
                place-items: center;
                border-radius: 50%;
                color: #fff;
                font-size: 1.75rem;
                font-weight: 700;
            }

            .login-result-dialog--success .login-result-dialog__indicator {
                background: #198754;
            }

            .login-result-dialog--error .login-result-dialog__indicator {
                background: #b42318;
            }

            .login-result-dialog h2 {
                margin: 0 0 10px;
                color: #4b3c7a;
                font-size: 1.5rem;
            }

            .login-result-dialog p {
                margin: 0;
                line-height: 1.5;
            }

            .login-result-dialog form {
                margin-top: 24px;
            }

            .login-result-dialog__button {
                min-width: 120px;
                padding: 10px 20px;
                border: 0;
                border-radius: 6px;
                background: #7c5fe6;
                color: #fff;
                font: inherit;
                font-weight: 600;
                cursor: pointer;
            }

            .login-result-dialog__button:hover {
                background: #5a3bb3;
            }

            .login-result-dialog__button:focus-visible {
                outline: 3px solid #c9bbff;
                outline-offset: 3px;
            }
        </style>

        <dialog id="login-result-dialog"
            class="login-result-dialog {{ $identity && ! $queryError ? 'login-result-dialog--success' : 'login-result-dialog--error' }}"
            aria-labelledby="login-result-title" aria-describedby="login-result-description">
            <div class="login-result-dialog__indicator" aria-hidden="true">
                {{ $identity && ! $queryError ? '✓' : '!' }}
            </div>

            <h2 id="login-result-title">
                @if ($queryError)
                    Unable to log in
                @elseif ($identity)
                    Login successful
                @else
                    Login failed
                @endif
            </h2>

            <p id="login-result-description">
                @if ($queryError)
                    The sign-in request could not be completed. See the diagnostic details below.
                @elseif ($identity)
                    Your credentials matched an account.
                @else
                    We couldn't find an account matching that email and password.
                @endif
            </p>

            <form method="dialog">
                <button class="login-result-dialog__button" type="submit" autofocus>Okay</button>
            </form>
        </dialog>

        <script>
            const loginResultDialog = document.getElementById('login-result-dialog');
            if (loginResultDialog && !loginResultDialog.open) {
                loginResultDialog.showModal();
            }
        </script>

        <section class="lab-panel" aria-live="polite">
            <h2>Sign-in result</h2>
            <p>Query executed:</p>
            <pre><code>{{ $query }}</code></pre>

            @if ($queryError)
                <p role="alert">{{ $queryError }}</p>
            @elseif ($identity)
                <p>Matched account: #{{ $identity['id'] }} — {{ $identity['email'] }}</p>
            @else
                <p>No account matched this query.</p>
            @endif
        </section>
    @endisset

    @include('security-testing.database')
@endsection
