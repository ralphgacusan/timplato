<x-admin-layout>
    @section('title', 'Notification Management')

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/customer/review-modal.css') }}">
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap');

            :root {
                --primary-dark: #304C89;
                --accent-dark-blue: #1E2A47;
                --primary: #648DE5;
                --primary-light: #9EB7E5;
                --accent: #F4AE71;
                --accent-light: #FFBE86;
                --accent-dark: #c78b56;
                --white: #ffffff;
                --gray: #f8f8f8;
                --dark-gray: #464747;
            }

            * {
                font-family: 'Inter', sans-serif;
                box-sizing: border-box;
                margin: 0;
                padding: 0;
            }

            /* Container */
            .container {
                max-width: 1200px;
                margin: 0 auto;
                padding: 0 20px;
            }

            /* Headings */
            h2,
            h4 {
                color: var(--primary-dark);
                font-weight: 600;
                margin-bottom: 12px;
            }

            /* Text muted */
            .text-muted {
                color: #6C757D;
                margin-bottom: 24px;
            }

            /* Buttons */
            .btn-success {
                background-color: #4A8FE7;
                border: none;
                color: #fff;
                padding: 6px 12px;
                font-size: 0.875rem;
                border-radius: 6px;
                cursor: pointer;
                transition: background 0.2s;
            }

            .btn-success:hover {
                background-color: #3a7ad1;
            }

            .btn-primary {
                background-color: #648DE5;
                border: none;
                color: #fff;
                padding: 6px 12px;
                font-size: 0.875rem;
                border-radius: 6px;
                cursor: pointer;
                transition: background 0.2s;
            }

            .btn-primary:hover {
                background-color: var(--primary-dark);
            }

            .btn-danger {
                background-color: #e74c3c;
                border: none;
                color: #fff;
                padding: 6px 12px;
                font-size: 0.875rem;
                border-radius: 6px;
                cursor: pointer;
                transition: background 0.2s;
            }

            .btn-danger:hover {
                background-color: #c0392b;
            }

            /* Tables */
            table {
                width: 100%;
                border-collapse: collapse;
                border-radius: 12px;
                overflow: hidden;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);

            }

            table th,
            table td {
                text-align: center;
                padding: 12px 16px;
                font-size: 0.95rem;
            }

            table thead tr {
                background-color: var(--primary-dark);
                color: #fff;
            }

            table tbody tr {
                background-color: var(--gray);
            }

            table tbody tr:not(:last-child) {
                border-bottom: 1px solid #ddd;
            }

            /* Badges */
            .badge {
                display: inline-block;
                padding: 4px 10px;
                font-size: 0.85rem;
                font-weight: 500;
                border-radius: 6px;
                color: #fff;
            }

            .bg-success {
                background-color: #4A8FE7;
            }

            .bg-danger {
                background-color: #e74c3c;
            }

            /* Form Elements */
            .form-label {
                font-weight: 500;
                margin-bottom: 6px;
                display: block;
            }

            .form-control,
            .form-select,
            textarea {
                width: 100%;
                padding: 10px 14px;
                border-radius: 8px;
                border: 1px solid #ccc;
                font-size: 0.95rem;
            }

            /* Checkbox */
            .form-check {
                display: flex;
                align-items: center;
                margin-bottom: 16px;
            }

            .form-check input {
                margin-right: 8px;
            }

            /* Responsive */
            @media (max-width: 768px) {

                table th,
                table td {
                    padding: 8px 10px;
                    font-size: 0.85rem;
                }

                .btn-success,
                .btn-primary,
                .btn-danger {
                    font-size: 0.8rem;
                    padding: 4px 10px;
                }
            }
        </style>
    @endpush

    <div class="container mt-4" style="padding-top: 100px">
        <h2>Notification Management</h2>
        <p class="text-muted">Enable or disable automated notifications and send manual announcements.</p>



        <h4 class="mt-4">Automated Notifications</h4>
        <table class="table table-bordered mt-2">
            <thead>
                <tr>
                    <th>Notification Type</th>
                    <th>Status</th>
                    <th>Toggle</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($settings as $setting)
                    <tr>
                        <td>{{ $setting->label }}</td>
                        <td>
                            <span class="badge {{ $setting->enabled ? 'bg-success' : 'bg-danger' }}">
                                {{ $setting->enabled ? 'Enabled' : 'Disabled' }}
                            </span>
                        </td>
                        <td>
                            <form action="{{ route('admin.notifications.toggle', $setting->setting_id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-primary">
                                    {{ $setting->enabled ? 'Disable' : 'Enable' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <!-- Button Wrapper for Right Alignment -->
        <div class="d-flex justify-content-end" style="margin-top: 10px;">
            <button class="add-review-btn" id="openNotificationModal">Send Manual Notification</button>
        </div>

        <hr>



        <!-- Modal Overlay -->
        <div class="modal-overlay" id="notificationModal" style="display: none;">
            <div class="modal-card">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4>Send Manual Notification</h4>
                </div>

                <!-- Modal Body -->
                <form action="{{ route('admin.notifications.send') }}" method="POST" class="modal-body">
                    @csrf
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="send_to_all" id="send_to_all"
                            value="1">
                        <label class="form-check-label" for="send_to_all">Send to all users</label>
                    </div>

                    <div class="mb-3" id="userSelect">
                        <label for="user_id" class="form-label">Select User</label>
                        <select name="user_id" id="user_id" class="form-select">
                            <option value="">-- Select User --</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="title" class="form-label">Notification Title</label>
                        <input type="text" name="title" id="title" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="message" class="form-label">Notification Message</label>
                        <textarea name="message" id="message" class="form-control" rows="3" required></textarea>
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" class="modal-btn modal-cancel"
                            id="closeNotificationModal">Cancel</button>
                        <button type="submit" class="modal-btn modal-submit">Send Notification</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Scripts -->
        <script>
            const modal = document.getElementById('notificationModal');
            const openBtn = document.getElementById('openNotificationModal');
            const closeBtn = document.getElementById('closeNotificationModal');
            const sendToAllCheckbox = document.getElementById('send_to_all');
            const userSelectDiv = document.getElementById('userSelect');

            openBtn.addEventListener('click', () => {
                modal.style.display = 'flex';
            });

            closeBtn.addEventListener('click', () => {
                modal.style.display = 'none';
            });

            sendToAllCheckbox.addEventListener('change', function() {
                userSelectDiv.style.display = this.checked ? 'none' : 'block';
            });

            // Optional: close modal on overlay click
            modal.addEventListener('click', function(e) {
                if (e.target === modal) modal.style.display = 'none';
            });
        </script>
    </div>
</x-admin-layout>
