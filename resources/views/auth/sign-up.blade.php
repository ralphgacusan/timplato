<x-customer-layout>

    @section('title', 'Sign Up - Timplato')

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/auth/sign-up.css') }}">
    @endpush

    <div class="hero-section">
        <header class="heroHeader"
            style="background-image: url('{{ asset('Assets/timplatoLoginBanner.png') }}'); 
               background-size: cover; 
               background-position: center; 
               background-repeat: no-repeat;">
            <div class="loginContainer">
                <form class="signupForm">
                    <h2 class="formTitle">Sign Up</h2>

                    <!-- First Name & Last Name -->
                    <div class="formRow">
                        <div class="formGroup">
                            <label for="firstName" class="formLabel">First Name</label>
                            <input type="text" id="firstName" class="formInput" placeholder="Enter your first name"
                                required>
                        </div>
                        <div class="formGroup">
                            <label for="lastName" class="formLabel">Last Name</label>
                            <input type="text" id="lastName" class="formInput" placeholder="Enter your last name"
                                required>
                        </div>
                    </div>

                    <!-- Email & Phone -->
                    <div class="formRow">
                        <div class="formGroup">
                            <label for="email" class="formLabel">Email</label>
                            <input type="email" id="email" class="formInput" placeholder="Enter your email"
                                required>
                        </div>
                        <div class="formGroup">
                            <label for="phone" class="formLabel">Phone Number</label>
                            <input type="tel" id="phone" class="formInput" placeholder="Enter your phone number"
                                required>
                        </div>
                    </div>

                    <!-- Passwords -->
                    <div class="formRow">
                        <div class="formGroup">
                            <label for="password" class="formLabel">Password</label>
                            <input type="password" id="password" class="formInput" placeholder="Enter your password"
                                required>
                        </div>
                        <div class="formGroup">
                            <label for="repassword" class="formLabel">Re-enter Password</label>
                            <input type="password" id="repassword" class="formInput"
                                placeholder="Re-enter your password" required>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="formRow buttonsRow">
                        <button type="submit" class="formButton">Sign Up</button>
                        <button type="button" class="formButton googleButton">
                            <img src="{{ asset('Assets/google_logo.webp') }}" alt="Google" class="googleIcon"> Sign Up
                            with Google
                        </button>
                    </div>

                </form>
                <p class="signupPrompt">Already have an account? <a href="{{ route('auth.signin') }}"
                        class="signupLink">Login</a>
                </p>
            </div>
        </header>
    </div>

</x-customer-layout>
