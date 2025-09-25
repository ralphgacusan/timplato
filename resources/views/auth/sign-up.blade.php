<x-customer-layout>

    @section('title', 'Sign Up - Timplato')

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/auth/sign-up.css') }}">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    @endpush

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {

                // Date of birth picker
                flatpickr("#date_of_birth", {
                    dateFormat: "Y-m-d", // YYYY-MM-DD
                    maxDate: "today", // Cannot pick future dates
                    allowInput: false, // Only use calendar, prevent typing
                    clickOpens: true, // Opens on input click
                });

            });
        </script>
    @endpush


    <div class="hero-section">
        <header class="heroHeader"
            style="background-image: url('{{ asset('Assets/timplatoLoginBanner.png') }}'); 
               background-size: cover; 
               background-position: center; 
               background-repeat: no-repeat;">
            <div class="loginContainer">
                <form class="signupForm" action="{{ route('auth.submit.signup') }}" method="POST">
                    @csrf
                    <h2 class="formTitle">Sign Up</h2>

                    <!-- First Name & Last Name -->
                    <div class="formRow">
                        <div class="formGroup">
                            <label for="firstName" class="formLabel">First Name</label>
                            <input type="text" id="firstName" name="first_name" class="formInput"
                                placeholder="Enter your first name" value="{{ old('first_name') }}" required>
                            @error('first_name')
                                <span class="error-message" style="color:red; font-size:0.7rem;">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="formGroup">
                            <label for="lastName" class="formLabel">Last Name</label>
                            <input type="text" id="lastName" name="last_name" class="formInput"
                                placeholder="Enter your last name" value="{{ old('last_name') }}" required>
                            @error('last_name')
                                <span class="error-message" style="color:red; font-size:0.7rem;">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Email & Phone -->
                    <div class="formRow">
                        <div class="formGroup">
                            <label for="email" class="formLabel">Email</label>
                            <input type="email" id="email" name="email" class="formInput"
                                placeholder="Enter your email" value="{{ old('email') }}" required>
                            @error('email')
                                <span class="error-message" style="color:red; font-size:0.7rem;">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="formGroup">
                            <label for="phone" class="formLabel">Phone Number</label>
                            <input type="tel" id="phone" name="phone" class="formInput"
                                placeholder="Enter your phone number" value="{{ old('phone') }}">
                            @error('phone')
                                <span class="error-message" style="color:red; font-size:0.7rem;">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Gender & Date of Birth -->
                    <div class="formRow">
                        <!-- Gender -->
                        <div class="formGroup">
                            <label for="gender" class="formLabel">Gender</label>
                            <select id="gender" name="gender" class="formInput">
                                <option value="" disabled selected>Select your gender</option>
                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female
                                </option>
                                <option value="prefer_not_to_say"
                                    {{ old('gender') == 'prefer_not_to_say' ? 'selected' : '' }}>Prefer not to say
                                </option>
                            </select>
                            @error('gender')
                                <span class="error-message" style="color:red; font-size:0.7rem;">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Date of Birth -->
                        <div class="formGroup position-relative">
                            <label for="date_of_birth" class="formLabel">Date of Birth</label>
                            <input type="text" id="date_of_birth" name="date_of_birth" class="formInput"
                                placeholder="Select your date of birth" value="{{ old('date_of_birth') }}" readonly>
                            <span class="input-icon"><i class="icon-calendar"></i></span>
                            @error('date_of_birth')
                                <span class="error-message" style="color:red; font-size:0.7rem;">{{ $message }}</span>
                            @enderror
                        </div>


                    </div>

                    <!-- Passwords -->
                    <div class="formRow">
                        <!-- Password -->
                        <div class="formGroup">
                            <label for="password" class="formLabel">Password</label>
                            <input type="password" id="password" name="password" class="formInput"
                                placeholder="Enter your password" required>
                            @error('password')
                                <span class="error-message" style="color:red; font-size:0.7rem;">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="formGroup">
                            <label for="repassword" class="formLabel">Confirm Password</label>
                            <input type="password" id="repassword" name="password_confirmation" class="formInput"
                                placeholder="Re-enter your password" required>
                            {{-- Confirmed errors belong to "password" --}}
                            @error('password')
                                <span class="error-message"
                                    style="color:red; font-size:0.7rem;">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <input type="hidden" name="role" value="user">



                    <!-- Buttons -->
                    <div class="formRow buttonsRow">
                        <button type="submit" class="formButton">Sign Up</button>

                    </div>

                </form>

                <div class="formRow buttonsRow">

                    <!-- Google Sign Up (separate form) -->
                    <form action="{{ route('google.redirect') }}" method="GET">
                        <button type="submit" class="formButton googleButton">
                            <img src="{{ asset('Assets/google_logo.webp') }}" alt="Google" class="googleIcon">
                            Sign Up with Google
                        </button>
                    </form>
                    <p class="signupPrompt">Already have an account? <a href="{{ route('login') }}"
                            class="signupLink">Login</a>
                    </p>
                </div>
            </div>

        </header>
    </div>

</x-customer-layout>
