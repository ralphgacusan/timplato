<x-customer-layout>

    @section('title', 'Log in - Timplato')

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/auth/sign-in.css') }}">
    @endpush

    @php
        $protection = $loginProtection ?? ['locked' => false, 'remaining' => 5, 'max_attempts' => 5, 'retry_after' => 0, 'retry_at' => null, 'window_minutes' => 15];
        $locked = $protection['locked'];
        $busy = ($protection['reason'] ?? '') === 'busy';
    @endphp

    <div class="hero-section">
        <header class="heroHeader"
            style="background-image: url('{{ asset('Assets/timplatoLoginBanner.png') }}'); 
               background-size: cover; 
               background-position: center; 
               background-repeat: no-repeat;">
            <div class="loginContainer">
                <form class="loginForm" action="{{ route('auth.submit.signin') }}" method="POST">
                    @csrf
                    <h2 class="formTitle">Login</h2>
                    <div class="formGroup">
                        <label for="email" class="formLabel">Email</label>
                        <input type="email" id="email" name="email" class="formInput" maxlength="255" autocomplete="username"
                            placeholder="Enter your email" value="{{ $loginEmail ?? old('email') }}" required>
                        @error('email')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="formGroup">
                        <label for="password" class="formLabel">Password</label>
                        <input type="password" id="password" name="password" class="formInput" maxlength="4096" autocomplete="current-password"
                            placeholder="Enter your password" required>
                        @error('password')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div id="signin-protection" class="signin-protection {{ $locked ? 'signin-protection--locked' : '' }}"
                        data-locked="{{ $locked ? 'true' : 'false' }}" data-retry-after="{{ $protection['retry_after'] }}"
                        data-retry-at="{{ $protection['retry_at'] }}" data-max-attempts="{{ $protection['max_attempts'] }}" role="status">
                        <strong id="signin-protection-title">{{ $busy ? 'Sign-in is busy' : ($locked ? 'Sign-in temporarily blocked' : 'Sign-in protection is active') }}</strong>
                        <p id="signin-attempts-message">
                            @if ($locked)
                                Too many unsuccessful attempts. Password sign-in will be available again at
                                <time class="signin-retry-time" datetime="{{ $protection['retry_at'] }}">{{ $protection['retry_at'] }}</time>.
                            @else
                                {{ $protection['remaining'] }} of {{ $protection['max_attempts'] }} attempts remaining.
                            @endif
                        </p>
                        <p class="signin-protection-note">Repeated unsuccessful attempts temporarily pause password sign-in to protect your account.</p>
                    </div>
                    <button type="submit" class="formButton" id="signin-submit" @disabled($locked)>{{ $locked ? 'Temporarily blocked' : 'Login' }}</button>

                </form>
                <form action="{{ route('google.redirect') }}" method="GET">
                    <button type="submit" class="formButton googleButton">
                        <img src="{{ asset('Assets/google_logo.webp') }}" alt="Google" class="googleIcon">
                        Log in with Google
                    </button>
                </form>
                <p class="signupPrompt">Don't have an account? <a href="{{ route('auth.signup') }}"
                        class="signupLink">Sign up</a>
                </p>
            </div>
        </header>
    </div>

    @if ($locked)
        <dialog id="signin-lockout-dialog" class="signin-lockout-dialog" aria-labelledby="signin-lockout-title" aria-describedby="signin-lockout-description">
            <span class="signin-lockout-symbol" aria-hidden="true">!</span>
            <h2 id="signin-lockout-title">{{ $busy ? 'Sign-in is busy' : 'Sign-in temporarily blocked' }}</h2>
            <p id="signin-lockout-description">{{ $busy ? 'Another sign-in request is being checked. Please try again shortly.' : 'Too many unsuccessful sign-in attempts. Further password sign-in requests are blocked until the waiting period ends.' }}</p>
            <div class="signin-lockout-time">
                <span>You can try again at</span>
                <time class="signin-retry-time" datetime="{{ $protection['retry_at'] }}">{{ $protection['retry_at'] }}</time>
                <small>Philippine time</small>
            </div>
            <p id="signin-countdown" aria-live="off"></p>
            <p class="signin-protection-note">Refreshing the page or opening a new tab does not reset the limit.</p>
            <form method="dialog"><button class="formButton" type="submit" autofocus>I understand</button></form>
        </dialog>
    @endif
    <script src="{{ asset('js/auth/sign-in.js') }}" defer></script>

</x-customer-layout>
