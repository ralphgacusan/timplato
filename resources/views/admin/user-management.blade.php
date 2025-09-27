<x-admin-layout>
    @section('title', 'User Management - Timplato Admin')

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/admin/user-management.css') }}">
        <link rel="stylesheet" href="{{ asset('css/components/components.css') }}">
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
                        <th>Last Sign In</th>
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
                                {{ $user->last_login_at ? \Carbon\Carbon::parse($user->last_login_at)->format('M d, Y H:i') : 'Never logged in' }}
                            </td>
                            <td>
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="um-action-btn um-action-delete" title="Delete"
                                        onclick="return confirm('Are you sure you want to delete this user?')">
                                        <span class="icon-container"><span class="icon-trash"></span></span>
                                    </button>
                                </form>
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
    </div>
</x-admin-layout>
