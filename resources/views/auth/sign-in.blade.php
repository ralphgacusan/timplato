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
                <form class="loginForm">
                    <h2 class="formTitle">Login</h2>
                    <div class="formGroup">
                        <label for="email" class="formLabel">Email</label>
                        <input type="email" id="email" class="formInput" placeholder="Enter your email" required>
                    </div>
                    <div class="formGroup">
                        <label for="password" class="formLabel">Password</label>
                        <input type="password" id="password" class="formInput" placeholder="Enter your password"
                            required>
                    </div>
                    <a href="#forgot-password" class="forgotPasswordLink">Forgot Password?</a>
                    <button type="submit" class="formButton">Login</button>
                    <button type="button" class="formButton googleButton">
                        <img src="{{ asset('Assets/google_logo.webp') }}" alt="Google" class="googleIcon"> Log in with
                        Google
                    </button>
                </form>
                <p class="signupPrompt">Don't have an account? <a href="{{ route('auth.signup') }}"
                        class="signupLink">Sign up</a>
                </p>
            </div>
        </header>
    </div>

</x-customer-layout>
