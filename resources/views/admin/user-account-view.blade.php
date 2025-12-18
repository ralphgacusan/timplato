<x-admin-layout>
    @section('title', 'User Profile - Timplato')

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/auth/user-profile.css') }}">
        <link rel="stylesheet" href="{{ asset('css/customer/review-modal.css') }}">
    @endpush

    <div class="container py-5">
        <div class="row g-4">
            <!-- Profile Photo & Name -->
            <div class="col-lg-4">
                <div class="card p-4 text-center shadow-sm">
                    <div class="mb-3">
                        <img id="profilePhoto"
                            src="{{ $user->profile_picture_path ? asset($user->profile_picture_path) : asset('timplatoLogo/Timplato-Blue-LOGO.png') }}"
                            alt="Profile Photo" class="rounded-circle"
                            style="width:140px;height:140px;object-fit:cover;">
                    </div>
                    <div class="fw-semibold fs-4">
                        {{ $user->getFullName() }}
                    </div>
                    <div class="text-primary fs-5">
                        @php
                            $status = '';

                            // Suspended
                            if ($user->suspended_until && \Carbon\Carbon::parse($user->suspended_until)->isFuture()) {
                                $status = '<span class="status suspended">Suspended</span>';
                            }
                            // Active (currently logged in)
                            elseif ($user->last_login_at && !$user->last_logout_at) {
                                $status = '<span class="status active">Active</span>';
                            } elseif (
                                $user->last_login_at &&
                                $user->last_logout_at &&
                                \Carbon\Carbon::parse($user->last_logout_at)->lt($user->last_login_at)
                            ) {
                                // still logged in (logout time < login time)
                                $status = '<span class="status active">Active</span>';
                            }
                            // Inactive (logged out)
                            elseif ($user->last_login_at) {
                                $status =
                                    '<span class="status inactive">Inactive — Last signed in: ' .
                                    \Carbon\Carbon::parse($user->last_login_at)->format('M d, Y H:i') .
                                    '</span>';
                            }
                            // Never logged in
                            else {
                                $status = '<span class="status inactive">Inactive — Never logged in</span>';
                            }
                        @endphp

                        {!! $status !!}



                    </div>
                </div>
            </div>

            <!-- Address Display -->
            <div class="col-lg-8">
                @php
                    $defaultAddress = $user->addresses->where('is_default', 1)->first();
                @endphp
                <div class="card p-4 mb-4 shadow-sm">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="fw-semibold">Address
                            @if ($defaultAddress)
                                <span class="badge bg-secondary ms-1">{{ $defaultAddress->label }}</span>
                            @endif
                        </div>
                        <a href="{{ route('admin.user-account-edit-address', $user) }}" class="btn btn-warning btn-sm">
                            Manage Addresses
                        </a>
                    </div>

                    <!-- Row 1: Street Address + ZIP -->
                    <div class="row g-2 mb-2">
                        <div class="col-md-8">
                            <label class="form-label">Street Address</label>
                            <input type="text" class="form-control" value="{{ $defaultAddress?->address ?? 'N/A' }}"
                                readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">ZIP Code</label>
                            <input type="text" class="form-control" value="{{ $defaultAddress?->zip_code ?? 'N/A' }}"
                                readonly>
                        </div>
                    </div>

                    <!-- Row 2: Country / City / State -->
                    <div class="row g-2 mb-2">
                        <div class="col-md-4">
                            <label class="form-label">Country</label>
                            <input type="text" class="form-control" value="{{ $defaultAddress?->country ?? 'N/A' }}"
                                readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">City</label>
                            <input type="text" class="form-control" value="{{ $defaultAddress?->city ?? 'N/A' }}"
                                readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">State/Province</label>
                            <input type="text" class="form-control" value="{{ $defaultAddress?->state ?? 'N/A' }}"
                                readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- General Information Display -->
        <div class="card p-4 mt-4 shadow-sm">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-semibold mb-0">General Information</h5>

                <!-- Buttons container -->
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.user-account-edit-information', $user) }}" class="btn btn-warning btn-sm">
                        Edit Profile
                    </a>

                    <button type="submit" onclick="openDeleteModal({{ $user->id }})"
                        class="btn btn-warning
                            btn-sm"
                        style="background-color: red; border-color: red; color: white;">
                        Delete User
                    </button>


                    <!-- Manage User Modal -->
                    <div class="modal-overlay" id="deleteUserModalOverlay-{{ $user->id }}" style="display:none;">
                        <div class="modal-card">
                            <div class="modal-header">
                                <h5 class="modal-product-title">Manage User Account</h5>
                            </div>

                            <div class="modal-body">
                                @if ($user->suspended_until && $user->suspended_until->isFuture())
                                    <p>
                                        This account is <strong>currently suspended</strong> until
                                        <strong>{{ $user->suspended_until->format('M d, Y H:i A') }}</strong>.
                                    </p>
                                    <p>Do you want to <strong>unsuspend</strong> or permanently delete this account?</p>
                                @else
                                    <p>Do you want to permanently delete this account or suspend it for 30 days?</p>
                                @endif
                            </div>

                            <div class="modal-footer" style="gap: 8px;">
                                <!-- Cancel -->
                                <button type="button" class="modal-btn modal-cancel"
                                    data-target="deleteUserModalOverlay-{{ $user->id }}"
                                    style="padding: 6px 16px; font-size: 0.9rem; background-color: #d1d5db; color: #1f2937;">
                                    Cancel
                                </button>

                                @if ($user->suspended_until && $user->suspended_until->isFuture())
                                    <!-- Unsuspend -->
                                    <form action="{{ route('admin.users.unsuspend', $user->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        <button type="submit" class="modal-btn modal-submit"
                                            style="padding: 6px 16px; font-size: 0.9rem; background-color: #22c55e; border-color: #22c55e; color: #fff;">
                                            Unsuspend User
                                        </button>
                                    </form>
                                @else
                                    <!-- Suspend -->
                                    <form action="{{ route('admin.users.suspend', $user->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        <button type="submit" class="modal-btn modal-submit"
                                            style="padding: 6px 16px; font-size: 0.9rem; background-color: #fbbf24; border-color: #fbbf24; color: #1f2937;">
                                            Suspend 30 Days
                                        </button>
                                    </form>
                                @endif

                                <!-- Delete -->
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="modal-btn modal-submit"
                                        style="padding: 6px 16px; font-size: 0.9rem; background-color: #ef4444; border-color: #ef4444; color: #fff;"
                                        onclick="return confirm('⚠️ Are you sure you want to permanently delete this account? This action cannot be undone.')">
                                        Delete Permanently
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>



                </div>
            </div>


            <!-- Row 1: Names -->
            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <label class="form-label">First Name</label>
                    <input type="text" class="form-control" value="{{ $user->first_name }}" readonly>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Middle Name</label>
                    <input type="text" class="form-control" value="{{ $user->middle_name ?? 'N/A' }}" readonly>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Last Name</label>
                    <input type="text" class="form-control" value="{{ $user->last_name }}" readonly>
                </div>
            </div>

            <!-- Row 2: Gender and Date of Birth -->
            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <label class="form-label">Gender</label>
                    <input type="text" class="form-control"
                        value="{{ ucfirst(str_replace('_', ' ', $user->gender ?? 'N/A')) }}" readonly>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Date of Birth</label>
                    <input type="text" class="form-control"
                        value="{{ $user->date_of_birth ? \Carbon\Carbon::parse($user->date_of_birth)->format('F d, Y') : 'N/A' }}"
                        readonly>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Role</label>
                    <input type="text" class="form-control" value="{{ ucfirst($user->role ?? 'N/A') }}" readonly>
                </div>

            </div>

            <!-- Row 3: Contact Info -->
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Phone Number</label>
                    <input type="text" class="form-control" value="{{ $user->phone ?? 'N/A' }}" readonly>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email Address</label>
                    <input type="text" class="form-control" value="{{ $user->email }}" readonly>
                </div>
            </div>
        </div>

        <script src="{{ asset('js/customer/delivery.js') }}"></script>
        <script>
            function openDeleteModal(userId) {
                const modal = document.getElementById(`deleteUserModalOverlay-${userId}`);
                if (modal) modal.style.display = 'flex';
            }

            document.querySelectorAll('.modal-cancel').forEach(btn => {
                btn.addEventListener('click', function() {
                    const target = this.getAttribute('data-target');
                    const modal = document.getElementById(target);
                    if (modal) modal.style.display = 'none';
                });
            });
        </script>
    </div>
</x-admin-layout>
