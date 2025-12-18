<x-admin-layout>
    @section('title', 'User Management - Timplato Admin')

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/admin/user-management.css') }}">
        <link rel="stylesheet" href="{{ asset('css/components/components.css') }}">
        <link rel="stylesheet" href="{{ asset('css/customer/review-modal.css') }}">
    @endpush

    <!-- User Management Content -->
    <div class="user-management-content">
        <h2>User Management</h2>
        <div class="user-management-controls">
            <form method="GET" action="{{ route('admin.user-management') }}">
                <!-- Sort Dropdown -->
                <select name="sort" class="um-sortby" onchange="this.form.submit()">
                    <option value="">Sort by</option>
                    <option value="az" {{ request('sort') == 'az' ? 'selected' : '' }}>Name (A-Z)</option>
                    <option value="za" {{ request('sort') == 'za' ? 'selected' : '' }}>Name (Z-A)</option>
                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Date Created (Newest)
                    </option>
                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Date Created (Oldest)
                    </option>
                    <option value="last-login" {{ request('sort') == 'last-login' ? 'selected' : '' }}>Last Sign In
                    </option>
                </select>

                <!-- Role Filter -->
                <select name="role" class="um-category" onchange="this.form.submit()">
                    <option value="">All Roles</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User</option>
                </select>

                <!-- Search -->
                <input type="text" name="search" class="um-search" placeholder="Search users"
                    value="{{ request('search') }}">
                <button type="submit" class="um-btn">Search</button>
            </form>

            <button class="um-add-btn" onclick="window.location.href='{{ route('admin.user-management.create') }}'">
                Add User
            </button>
        </div>

        <div class="um-table-container">
            <table class="um-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Role</th>
                        <th>Date Created</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->getFullName() }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone ?? 'N/A' }}</td>
                            <td>{{ ucfirst($user->role) }}</td>
                            <td>{{ $user->created_at->format('M d, Y H:i') }}</td>
                            <td>
                                @php
                                    $status = '';

                                    // Suspended
                                    if (
                                        $user->suspended_until &&
                                        \Carbon\Carbon::parse($user->suspended_until)->isFuture()
                                    ) {
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
                                            '<span class="status inactive">Last signed in: ' .
                                            \Carbon\Carbon::parse($user->last_login_at)->format('M d, Y') .
                                            '</span>';
                                    }
                                    // Never logged in
                                    else {
                                        $status = '<span class="status inactive">Never logged in</span>';
                                    }
                                @endphp

                                {!! $status !!}




                            </td>


                            <td>
                                {{-- <button class="um-action-btn um-action-edit" title="Edit"
                                    onclick="window.location.href='{{ route('admin.users.destroy', $user->id) }}'">
                                    <span class="icon-container"><span class="icon-pencil"></span></span>
                                </button> --}}

                                <button type="submit" class="um-action-btn um-action-delete" title="Delete"
                                    onclick="openDeleteModal({{ $user->id }})">
                                    <span class="icon-container"><span class="icon-trash"></span></span>
                                </button>
                                <!-- Manage User Modal -->
                                <div class="modal-overlay" id="deleteUserModalOverlay-{{ $user->id }}"
                                    style="display:none;">
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
                                                <p>Do you want to <strong>unsuspend</strong> or permanently delete this
                                                    account?</p>
                                            @else
                                                <p>Do you want to permanently delete this account or suspend it for 30
                                                    days?</p>
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
                                                <form action="{{ route('admin.users.unsuspend', $user->id) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    <button type="submit" class="modal-btn modal-submit"
                                                        style="padding: 6px 16px; font-size: 0.9rem; background-color: #22c55e; border-color: #22c55e; color: #fff;">
                                                        Unsuspend User
                                                    </button>
                                                </form>
                                            @else
                                                <!-- Suspend -->
                                                <form action="{{ route('admin.users.suspend', $user->id) }}"
                                                    method="POST" style="display:inline;">
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




                                <button class="um-action-btn um-action-view" title="View"
                                    onclick="window.location.href='{{ route('admin.user-account-view', ['id' => $user->id]) }}'">
                                    <span class="icon-container"><span class="icon-eye"></span></span>
                                </button>

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align: center;">No users found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="om-pagination">
            {{ $users->appends(request()->only(['search', 'role', 'sort']))->links('pagination::bootstrap-5') }}
        </div>

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
