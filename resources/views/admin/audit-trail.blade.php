<x-admin-layout>
    @section('title', 'Admin Audit Trail - Timplato Admin')

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/admin/user-management.css') }}">
        <link rel="stylesheet" href="{{ asset('css/components/components.css') }}">
        <link rel="stylesheet" href="{{ asset('css/customer/review-modal.css') }}">
    @endpush

    <!-- Admin Audit Trail Content -->
    <div class="user-management-content">
        <h2>Admin Audit Trail</h2>
        <div class="user-management-controls">
            <form method="GET" action="{{ route('admin.audit-trail') }}">
                <!-- Sort Dropdown -->
                <select name="sort" class="um-sortby" onchange="this.form.submit()">
                    <option value="">Sort by</option>
                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest First</option>
                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                </select>

                <!-- Action Filter -->
                <select name="action" class="um-category" onchange="this.form.submit()">
                    <option value="">All Actions</option>
                    <option value="create" {{ request('action') == 'create' ? 'selected' : '' }}>Create</option>
                    <option value="update" {{ request('action') == 'update' ? 'selected' : '' }}>Update</option>
                    <option value="delete" {{ request('action') == 'delete' ? 'selected' : '' }}>Delete</option>
                    <option value="login" {{ request('action') == 'login' ? 'selected' : '' }}>Login</option>
                    <option value="logout" {{ request('action') == 'logout' ? 'selected' : '' }}>Logout</option>
                </select>

                <!-- Admin Filter -->
                <select name="admin_id" class="um-category" onchange="this.form.submit()">
                    <option value="">All Admins</option>
                    @foreach ($admins as $admin)
                        <option value="{{ $admin->id }}" {{ request('admin_id') == $admin->id ? 'selected' : '' }}>
                            {{ $admin->getFullName() ?? $admin->email }}
                        </option>
                    @endforeach
                </select>

                <!-- Admin Search -->
                <input type="text" name="search" class="um-search" placeholder="Search admins or actions"
                    value="{{ request('search') }}">
                <button type="submit" class="um-btn">Search</button>
            </form>
        </div>

        <div class="um-table-container">
            <table class="um-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Admin Name</th>
                        <th>Email</th>
                        <th>Action</th>
                        <th>Target</th>
                        <th>IP Address</th>
                        <th>Date & Time</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($logs as $log)
                        <tr>
                            <td>{{ $log->id }}</td>
                            <td>{{ $log->admin->getFullName() ?? 'N/A' }}</td>
                            <td>{{ $log->admin->email ?? 'N/A' }}</td>
                            <td>{{ ucfirst($log->action) }}</td>
                            <td>{{ $log->target_type ?? 'N/A' }}</td>
                            <td>{{ $log->ip_address ?? 'N/A' }}</td>
                            <td>{{ $log->created_at->format('M d, Y H:i') }}</td>
                            <td>
                                <button class="um-action-btn um-action-view" title="View Details"
                                    onclick="openLogModal({{ $log->id }})">
                                    <span class="icon-container"><span class="icon-eye"></span></span>
                                </button>

                                <!-- Log Details Modal -->
                                <div class="modal-overlay" id="logModalOverlay-{{ $log->id }}"
                                    style="display:none;">
                                    <div class="modal-card">
                                        <div class="modal-header">
                                            <h5 class="modal-product-title">Log Details</h5>
                                        </div>

                                        <div class="modal-body">
                                            <p><strong>Admin:</strong> {{ $log->admin->getFullName() ?? 'N/A' }}</p>
                                            <p><strong>Email:</strong> {{ $log->admin->email ?? 'N/A' }}</p>
                                            <p><strong>Action:</strong> {{ ucfirst($log->action) }}</p>
                                            <p><strong>Target:</strong> {{ $log->target_type ?? 'N/A' }}</p>
                                            <p><strong>IP Address:</strong> {{ $log->ip_address ?? 'N/A' }}</p>
                                            <p><strong>Date & Time:</strong>
                                                {{ $log->created_at->format('M d, Y H:i') }}</p>
                                            <p><strong>Details:</strong> {{ $log->details ?? 'N/A' }}</p>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="modal-cancel"
                                                data-target="logModalOverlay-{{ $log->id }}"
                                                style="background-color: #6c757d; color: #fff; border: none; padding: 10px 32px; border-radius: 8px; cursor: pointer;">
                                                Close
                                            </button>
                                        </div>

                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align: center;">No logs found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="om-pagination">
            {{ $logs->appends(request()->only(['search', 'action', 'sort', 'admin_id']))->links('pagination::bootstrap-5') }}
        </div>

        <script>
            function openLogModal(logId) {
                const modal = document.getElementById(`logModalOverlay-${logId}`);
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
