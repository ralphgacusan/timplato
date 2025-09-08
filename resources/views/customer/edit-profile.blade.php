<x-customer-layout>
    @section('title', 'Edit Profile - Timplato')

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/customer/edit-user-profile.css') }}">
    @endpush

    <div class="container py-5">
        <!-- Form starts here -->
        <form id="generalForm" method="POST" action="{{ route('auth.user-profile.update') }}"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row g-4">
                <!-- Profile Photo & Name -->
                <div class="col-lg-4">
                    <div class="card p-4 text-center shadow-sm h-100" style="max-width:400px;margin:auto;">
                        <div class="mb-3 position-relative">
                            <img id="profilePhoto"
                                src="{{ Auth::user()->profile_picture_path ? asset(Auth::user()->profile_picture_path) : asset('timplatoLogo/Timplato-Blue-LOGO.png') }}"
                                alt="Profile Photo" class="rounded-circle"
                                style="width:140px;height:140px;object-fit:cover;">

                            <input type="file" name="profile_photo" id="profilePhotoInput" accept="image/*"
                                style="display:none;">
                            <div class="d-flex justify-content-center gap-2 mt-3">
                                <button class="btn btn-warning" id="editPhotoBtn" type="button">Edit Photo</button>
                                <button class="btn btn-danger" id="removePhotoBtn" type="button">Remove Photo</button>
                            </div>
                        </div>
                        <div class="fw-semibold fs-4">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</div>
                        <div class="text-primary fs-5">{{ Auth::user()->phone ?? 'No phone set' }}
                            <span class="ms-1"><i class="bi bi-patch-check-fill"></i></span>
                        </div>
                    </div>
                </div>

                <!-- General Information Edit -->
                <div class="col-lg-8">
                    <div class="card p-4 shadow-sm h-100">
                        <div class="fw-semibold mb-3 fs-5">Edit General Information</div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label">First Name</label>
                                <input type="text" class="form-control" name="first_name"
                                    value="{{ Auth::user()->first_name }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Last Name</label>
                                <input type="text" class="form-control" name="last_name"
                                    value="{{ Auth::user()->last_name }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Gender</label>
                                <select class="form-select" name="gender" required>
                                    <option value="male" {{ Auth::user()->gender == 'male' ? 'selected' : '' }}>Male
                                    </option>
                                    <option value="female" {{ Auth::user()->gender == 'female' ? 'selected' : '' }}>
                                        Female</option>
                                    <option value="other" {{ Auth::user()->gender == 'other' ? 'selected' : '' }}>
                                        Other</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Date of Birth</label>
                                <input type="date" class="form-control" name="date_of_birth"
                                    value="{{ Auth::user()->date_of_birth?->format('Y-m-d') }}" required>
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Phone Number</label>
                                <input type="text" class="form-control" name="phone"
                                    value="{{ Auth::user()->phone ?? '' }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email Address</label>
                                <input type="email" class="form-control" name="email"
                                    value="{{ Auth::user()->email }}" required>
                            </div>
                        </div>

                        <div class="text-end">
                            <a href="{{ route('auth.user-profile') }}" class="btn btn-warning btn-sm"
                                style="background-color:grey">Cancel</a>
                            <button type="submit" class="btn btn-warning btn-sm">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!-- Form ends here -->
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const profilePhoto = document.getElementById('profilePhoto');
                const profilePhotoInput = document.getElementById('profilePhotoInput');
                const editPhotoBtn = document.getElementById('editPhotoBtn');
                const removePhotoBtn = document.getElementById('removePhotoBtn');

                // Trigger file input
                editPhotoBtn.addEventListener('click', function() {
                    profilePhotoInput.click();
                });

                // Preview selected photo
                profilePhotoInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(ev) {
                            profilePhoto.src = ev.target.result;
                        };
                        reader.readAsDataURL(file);
                    }
                });

                // Remove photo
                removePhotoBtn.addEventListener('click', function() {

                    profilePhoto.src = '{{ asset('timplatoLogo/Timplato-Blue-LOGO.png') }}';
                    profilePhotoInput.value = '';

                });
            });
        </script>
    @endpush
</x-customer-layout>
