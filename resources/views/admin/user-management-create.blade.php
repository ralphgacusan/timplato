<x-admin-layout>

    @section('title', 'Add User - Timplato')

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
        <header class="heroHeader">
            <div class="loginContainer" style="max-width: 1100px;"> <!-- widened container -->
                <form class="signupForm" action="{{ route('admin.user-management.store') }}" method="POST">
                    @csrf
                    <h2 class="formTitle">Add User</h2>

                    <!-- Row 1: First, Middle, Last Name -->
                    <div class="formRow" style="display: flex; gap: 1rem;">
                        <div class="formGroup" style="flex: 1;">
                            <label for="firstName" class="formLabel">First Name</label>
                            <input type="text" id="firstName" name="first_name" class="formInput"
                                placeholder="Enter first name" value="{{ old('first_name') }}" required>
                            @error('first_name')
                                <span class="error-message" style="color:red; font-size:0.7rem;">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="formGroup" style="flex: 1;">
                            <label for="middleName" class="formLabel">Middle Name (Optional)</label>
                            <input type="text" id="middleName" name="middle_name" class="formInput"
                                placeholder="Enter middle name" value="{{ old('middle_name') }}">
                            @error('middle_name')
                                <span class="error-message" style="color:red; font-size:0.7rem;">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="formGroup" style="flex: 1;">
                            <label for="lastName" class="formLabel">Last Name</label>
                            <input type="text" id="lastName" name="last_name" class="formInput"
                                placeholder="Enter last name" value="{{ old('last_name') }}" required>
                            @error('last_name')
                                <span class="error-message" style="color:red; font-size:0.7rem;">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Row 2: Email, Phone, Gender -->
                    <div class="formRow" style="display: flex; gap: 1rem;">
                        <div class="formGroup" style="flex: 1;">
                            <label for="email" class="formLabel">Email</label>
                            <input type="email" id="email" name="email" class="formInput"
                                placeholder="Enter email" value="{{ old('email') }}" required>
                            @error('email')
                                <span class="error-message" style="color:red; font-size:0.7rem;">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="formGroup" style="flex: 1;">
                            <label for="phone" class="formLabel">Phone Number</label>
                            <input type="tel" id="phone" name="phone" class="formInput"
                                placeholder="Enter phone number" value="{{ old('phone') }}" required>
                            @error('phone')
                                <span class="error-message" style="color:red; font-size:0.7rem;">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="formGroup" style="flex: 1;">
                            <label for="gender" class="formLabel">Gender</label>
                            <select id="gender" name="gender" class="formInput" required>
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

                    </div>

                    <!-- Row 3: Date of Birth, Password, Confirm Password -->
                    <div class="formRow" style="display: flex; gap: 1rem;">
                        <div class="formGroup position-relative" style="flex: 1;">
                            <label for="date_of_birth" class="formLabel">Date of Birth</label>
                            <input type="text" id="date_of_birth" name="date_of_birth" class="formInput"
                                placeholder="Select date of birth" value="{{ old('date_of_birth') }}" required>
                            <span class="input-icon"><i class="icon-calendar"></i></span>
                            @error('date_of_birth')
                                <span class="error-message"
                                    style="color:red; font-size:0.7rem;">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="formGroup" style="flex: 1;">
                            <label for="password" class="formLabel">Password</label>
                            <input type="password" id="password" name="password" class="formInput"
                                placeholder="Enter password" required>
                            @error('password')
                                <span class="error-message"
                                    style="color:red; font-size:0.7rem;">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="formGroup" style="flex: 1;">
                            <label for="repassword" class="formLabel">Confirm Password</label>
                            <input type="password" id="repassword" name="password_confirmation" class="formInput"
                                placeholder="Re-enter password" required>
                            @error('password')
                                <span class="error-message"
                                    style="color:red; font-size:0.7rem;">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="formGroup" style="flex: 1;">
                            <label for="role" class="formLabel">Role</label>
                            <select id="role" name="role" class="formInput" required>
                                <option value="" disabled selected>Select role</option>
                                <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                            @error('role')
                                <span class="error-message"
                                    style="color:red; font-size:0.7rem;">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>

                    <!-- Buttons (Inside the Signup Form) -->
                    <div class="formRow buttonsRow">

                        <!-- Row 1: Side-by-side buttons -->
                        <div class="buttonGroup">
                            <!-- Add User -->
                            <button type="submit" class="formButton">
                                Add User
                            </button>

                            <!-- Cancel -->
                            <button type="button" class="formButton"
                                style="background-color: #6c757d; color: white; border: none; border-radius: 8px; font-weight: 500; cursor: pointer; transition: background-color 0.3s ease;"
                                onclick="window.location.href='{{ route('admin.user-management') }}'">
                                Cancel
                            </button>


                        </div>

                        {{-- <!-- Row 2: Login link -->
                        <p class="signupPrompt">
                            Already have an account?
                            <a href="{{ route('login') }}" class="signupLink">Login</a>
                        </p> --}}
                    </div>


                </form>




            </div>


        </header>
    </div>

</x-admin-layout>
