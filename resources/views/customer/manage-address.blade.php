<x-customer-layout>
    @section('title', 'Manage Addresses - Timplato')

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/auth/user-profile.css') }}">
    @endpush

    <div class="container py-5">
        <div class="card p-4 shadow-sm">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="fw-semibold fs-5">Manage Addresses</div>

                <div>
                    <a href="{{ route('auth.user-profile') }}" class="btn btn-warning btn-sm"
                        style="background-color: grey">
                        Back to Profile
                    </a>

                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#addAddressModal">
                        Add Address
                    </button>
                </div>

            </div>

            @php
                $addresses = Auth::user()->addresses;
            @endphp

            @if ($addresses->isEmpty())
                <p class="text-muted">No addresses found. Add your first address!</p>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered align-middle text-center">
                        <thead class="table-light">
                            <tr>
                                <th>Label</th>
                                <th>Street</th>
                                <th>ZIP</th>
                                <th>Country</th>
                                <th>City</th>
                                <th>State/Province</th>
                                <th>Default</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($addresses as $address)
                                <tr>
                                    <td>{{ $address->label }}</td>
                                    <td>{{ $address->address }}</td>
                                    <td>{{ $address->zip_code }}</td>
                                    <td>{{ $address->country }}</td>
                                    <td>{{ $address->city }}</td>
                                    <td>{{ $address->state }}</td>
                                    <td>{{ $address->is_default ? 'Yes' : 'No' }}</td>
                                    <td>
                                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#editAddressModal{{ $address->address_id }}">
                                            Edit
                                        </button>
                                        <form
                                            action="{{ route('auth.user-profile.manage-address.destroy', $address->address_id) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm"
                                                onclick="return confirm('Delete this address?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="editAddressModal{{ $address->address_id }}" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <form
                                                action="{{ route('auth.user-profile.manage-address.update', $address->address_id) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Address</h5>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row g-3">
                                                        <div class="col-md-3">
                                                            <label class="form-label">Label</label>
                                                            <select class="form-select" name="label">
                                                                <option value="Home"
                                                                    {{ $address->label == 'Home' ? 'selected' : '' }}>
                                                                    Home
                                                                </option>
                                                                <option value="Work"
                                                                    {{ $address->label == 'Work' ? 'selected' : '' }}>
                                                                    Work
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label">Street Address</label>
                                                            <input type="text" class="form-control" name="address"
                                                                value="{{ $address->address }}" required>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="form-label">ZIP Code</label>
                                                            <input type="text" class="form-control" name="zip_code"
                                                                value="{{ $address->zip_code }}" required>
                                                        </div>
                                                    </div>

                                                    <div class="row g-3 mt-2">
                                                        <div class="col-md-4">
                                                            <label class="form-label">Country</label>
                                                            <input type="text" class="form-control" name="country"
                                                                value="{{ $address->country }}" required>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label">City</label>
                                                            <input type="text" class="form-control" name="city"
                                                                value="{{ $address->city }}" required>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label">State/Province</label>
                                                            <input type="text" class="form-control" name="state"
                                                                value="{{ $address->state }}" required>
                                                        </div>
                                                    </div>

                                                    <div class="form-check mt-3">
                                                        <input class="form-check-input" type="checkbox"
                                                            name="is_default" value="1"
                                                            {{ $address->is_default ? 'checked' : '' }}>
                                                        <label class="form-check-label">Set as default</label>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-warning">Save Changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <!-- Add Address Modal -->
    <div class="modal fade" id="addAddressModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('auth.user-profile.manage-address.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Address</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label">Label</label>
                                <select class="form-select" name="label">
                                    <option value="Home">Home</option>
                                    <option value="Work">Work</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Street Address</label>
                                <input type="text" class="form-control" name="address" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">ZIP Code</label>
                                <input type="text" class="form-control" name="zip_code" required>
                            </div>
                        </div>

                        <div class="row g-3 mt-2">
                            <div class="col-md-4">
                                <label class="form-label">Country</label>
                                <input type="text" class="form-control" name="country" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">City</label>
                                <input type="text" class="form-control" name="city" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">State/Province</label>
                                <input type="text" class="form-control" name="state" required>
                            </div>
                        </div>

                        <div class="form-check mt-3">
                            <input class="form-check-input" type="checkbox" name="is_default" value="1">
                            <label class="form-check-label">Set as default</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-warning">Add Address</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-customer-layout>
