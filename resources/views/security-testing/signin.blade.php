@extends('security-testing.layout')

@section('title', !empty($signup) ? 'Create account | Timplato' : 'Sign in | Timplato')

@section('content')
    @php
        $isSignup = !empty($signup);
        $emailValue = $email ?? old('email', '');
    @endphp

    <section class="auth-hero" style="background-image: linear-gradient(90deg, rgba(31, 42, 69, .48), rgba(31, 42, 69, .08)), url('{{ asset('Assets/timplatoLoginBanner.png') }}')">
        <div class="auth-hero__copy">
            <p class="eyebrow">Made for the heart of your home</p>
            <h1>Good days start in the kitchen.</h1>
            <p>Discover thoughtful kitchen essentials made for the meals, rituals, and people you love.</p>
        </div>

        <section class="auth-card" aria-labelledby="auth-title">
            <a class="auth-card__back" href="{{ route('security-testing.products') }}">← Back to the shop</a>
            <p class="eyebrow">{{ $isSignup ? 'Join the Timplato table' : 'Welcome back' }}</p>
            <h2 id="auth-title">{{ $isSignup ? 'Create your account' : 'Sign in to Timplato' }}</h2>
            <p class="auth-card__intro">{{ $isSignup ? 'Create a lab account to explore the training storefront.' : 'Pick up where you left off and find something lovely for your kitchen.' }}</p>
            @unless ($isSignup)
                <p class="demo-credentials">Demo account: <strong>demo@example.test</strong><br>Password: <strong>LabPassword123!</strong></p>
            @endunless

            @if (isset($message) || isset($query) || session()->has('status') || session()->has('feedback'))
                <div class="notice {{ !empty($identity) || session()->has('status') || session()->has('feedback') ? 'notice--success' : 'notice--info' }}" role="status" aria-live="polite" id="auth-feedback">
                    @if (isset($message))
                        {{ $message }}
                    @elseif (session()->has('feedback'))
                        {{ session('feedback') }}
                    @elseif (session()->has('status'))
                        {{ session('status') }}
                    @elseif ($queryError ?? false)
                        Sign-in query failed. Open the lab query details below for the database response.
                    @elseif (!empty($identity))
                        Login successful. Welcome{{ !empty($identity['name']) ? ', '.$identity['name'] : '' }}.
                    @else
                        Invalid credentials. Please check your email and password.
                    @endif
                </div>
            @endif

            <form class="auth-form" action="{{ $isSignup ? route('security-testing.signup.submit') : route('security-testing.signin.submit') }}" method="POST">
                @csrf
                @if ($isSignup)
                    <div class="field">
                        <label for="name">Full name</label>
                        <input id="name" name="name" type="text" autocomplete="name" placeholder="Your name" value="{{ old('name', '') }}" required>
                        @error('name') <span class="field-error">{{ $message }}</span> @enderror
                    </div>
                @endif

                <div class="field">
                    <label for="email">Email address</label>
                    <input id="email" name="email" type="text" autocomplete="email" placeholder="you@example.com" value="{{ $emailValue }}" required>
                    @error('email') <span class="field-error">{{ $message }}</span> @enderror
                </div>
                <div class="field">
                    <label for="password">Password</label>
                    <input id="password" name="password" type="password" autocomplete="{{ $isSignup ? 'new-password' : 'current-password' }}" placeholder="Enter your password" required>
                    @error('password') <span class="field-error">{{ $message }}</span> @enderror
                </div>
                @if ($isSignup)
                    <div class="field">
                        <label for="password_confirmation">Confirm password</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" placeholder="Enter your password again">
                    </div>
                @endif

                <button class="button button--primary button--wide" type="submit" id="{{ $isSignup ? 'signup-submit' : 'signin-submit' }}">
                    {{ $isSignup ? 'Create account' : 'Sign in' }}
                </button>
            </form>

            <p class="auth-switch">
                {{ $isSignup ? 'Already have an account?' : 'New to Timplato?' }}
                <a href="{{ $isSignup ? route('security-testing.signin') : route('security-testing.signup') }}">
                    {{ $isSignup ? 'Sign in' : 'Create an account' }}
                </a>
            </p>

            @if (isset($query) || ($queryError ?? false))
                <details class="lab-details" id="query-details">
                    <summary>{{ $isSignup ? 'View sign-up query details' : 'View sign-in query details' }}</summary>
                    <p>{{ $isSignup ? 'Training feedback from the sign-up request:' : 'Training feedback from the sign-in request:' }}</p>
                    @isset($query)
                        <pre><code>{{ $query }}</code></pre>
                    @endisset
                    @if ($queryError ?? false)
                        <p class="field-error" role="alert">{{ $queryError }}</p>
                    @endif
                </details>
            @endif
        </section>
    </section>
@endsection
