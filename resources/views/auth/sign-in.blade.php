<x-customer-layout>

    @section('title', 'Log in - Timplato')

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/auth/sign-in.css') }}">
    @endpush

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
                        <input type="email" id="email" name="email" class="formInput"
                            placeholder="Enter your email" value="{{ old('email') }}" required>
                        @error('email')
                            <span class="error-message" style="color:red; font-size:0.7rem;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="formGroup">
                        <label for="password" class="formLabel">Password</label>
                        <input type="password" id="password" name="password" class="formInput"
                            placeholder="Enter your password" required>
                        @error('password')
                            <span class="error-message" style="color:red; font-size:7rem;">{{ $message }}</span>
                        @enderror
                    </div>

                    <a href="#forgot-password" class="forgotPasswordLink">Forgot Password?</a>
                    <button type="submit" class="formButton">Login</button>

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

</x-customer-layout>
