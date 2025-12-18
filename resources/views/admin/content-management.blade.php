<x-admin-layout>
    @section('title', 'Content Management - Timplato Admin')

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
                margin-bottom: 40px;
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

            img {
                max-width: 100%;
                border-radius: 8px;
            }

            /* Modal Overlay */
            .modal-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
                display: flex;
                justify-content: center;
                align-items: center;
                z-index: 9999;
            }

            /* Modal Card */
            .modal-card {
                background-color: var(--white);
                border-radius: 16px;
                max-width: 500px;
                width: 100%;
                padding: 24px;
                box-shadow: 0 6px 18px rgba(0, 0, 0, 0.12);
                display: flex;
                flex-direction: column;
            }

            /* Modal Header */
            .modal-header h4 {
                font-weight: 600;
                color: var(--primary-dark);
                margin-bottom: 16px;
            }

            /* Modal Body */
            .modal-body .mb-3 {
                margin-bottom: 16px;
            }

            .modal-body label {
                display: block;
                font-weight: 500;
                margin-bottom: 6px;
            }

            .modal-body input,
            .modal-body textarea {
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
            }

            .form-check input {
                margin-right: 8px;
            }

            /* Modal Footer */
            .modal-footer {
                display: flex;
                justify-content: flex-end;
                gap: 10px;
                margin-top: 16px;
            }

            .modal-btn {
                padding: 8px 16px;
                font-size: 0.9rem;
                border-radius: 8px;
                border: none;
                cursor: pointer;
                transition: background 0.2s, transform 0.15s;
            }

            .modal-submit {
                background-color: var(--primary);
                color: #fff;
            }

            .modal-submit:hover {
                background-color: var(--primary-dark);
                transform: scale(1.05);
            }

            .modal-cancel {
                background-color: #ccc;
                color: #333;
            }

            .modal-cancel:hover {
                background-color: #b3b3b3;
            }

            /* Responsive */
            @media (max-width: 768px) {
                .modal-card {
                    max-width: 90%;
                }

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
        <h2>Content Management System</h2>
        <p class="text-muted">Manage static pages, team members, banners, and homepage content.</p>



        {{-- TEAM MEMBERS --}}
        <div class="mb-5">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4>Team Members</h4>
                <button class="btn btn-success btn-sm" onclick="openModal('addTeamModal')">+ Add Team Member</button>
            </div>

            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Title</th>
                        <th>Image</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($teamMembers as $member)
                        <tr>
                            <td>{{ $member->name }}</td>
                            <td>{{ $member->title }}</td>
                            <td>
                                <img src="{{ asset($member->image) }}" alt="{{ $member->name }}" width="80">
                            </td>
                            <td>
                                <button class="btn btn-sm btn-primary"
                                    onclick="openEditTeamModal('{{ $member->id }}', '{{ $member->name }}', '{{ $member->title }}', '{{ $member->image }}')">
                                    Edit
                                </button>
                                <form action="{{ route('admin.team-members.destroy', $member->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Delete this member?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">No team members yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- BANNERS --}}
        <div class="mb-5">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4>Banners / Promotions</h4>
                <button class="btn btn-success btn-sm" onclick="openModal('addBannerModal')">+ Add Banner</button>
            </div>

            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Slug</th>
                        <th>Image</th>
                        <th>Link</th>
                        <th>Section</th>
                        <th>Order</th>
                        <th>Active</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($banners as $banner)
                        <tr>
                            <td>{{ $banner->title }}</td>
                            <td>{{ $banner->slug ?? '—' }}</td>
                            <td><img src="{{ asset($banner->image) }}" width="100" alt="{{ $banner->title }}"></td>
                            <td>{{ $banner->link ?? '—' }}</td>
                            <td>{{ $banner->section }}</td>
                            <td>{{ $banner->order }}</td>
                            <td>{{ $banner->active ? 'Yes' : 'No' }}</td>
                            <td>
                                <button class="btn btn-sm btn-primary"
                                    onclick="openEditBannerModal(
        '{{ $banner->id }}',
        '{{ addslashes($banner->title) }}',
        '{{ $banner->image }}',
        '{{ $banner->link }}',
        {{ $banner->active ? 'true' : 'false' }},
        '{{ addslashes($banner->section) }}',
        '{{ $banner->order }}',
        '{{ $banner->slug ?? '' }}'
    )">
                                    Edit
                                </button>



                                <form action="{{ route('admin.banners.destroy', $banner->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Delete this banner?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">No banners yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>


        {{-- PAGES --}}
        <div class="mb-5">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4>Static Pages</h4>
                <button class="btn btn-success btn-sm" onclick="openModal('addPageModal')">+ Add Page</button>
            </div>

            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Slug</th>
                        <th>Section</th>
                        <th>Order</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pages as $page)
                        <tr>
                            <td>{{ $page->title }}</td>
                            <td>{{ $page->slug }}</td>
                            <td>{{ $page->section }}</td>
                            <td>{{ $page->order }}</td>
                            <td>
                                <button class="btn btn-sm btn-primary"
                                    onclick="openEditPageModal(
        '{{ $page->id }}',
        '{{ addslashes($page->title) }}',
        '{{ addslashes($page->slug) }}',
        '{{ addslashes($page->content) }}',
        '{{ addslashes($page->section) }}',
        '{{ $page->order }}'
    )">
                                    Edit
                                </button>



                                <form action="{{ route('admin.pages.destroy', $page->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE') <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Delete this page?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">No pages found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

    {{-- ======================
    MODALS FOR CMS SECTION
====================== --}}
    {{-- ======================
         MODALS FOR PAGES & BANNERS
    ====================== --}}

    {{-- ADD PAGE --}}
    <div class="modal-overlay" id="addPageModal" style="display:none;">
        <div class="modal-card">
            <form action="{{ route('admin.pages.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h4>Add Page</h4>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Slug</label>
                        <input type="text" name="slug" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Section</label>
                        <input type="text" name="section" class="form-control"
                            placeholder="main, hero, contact etc.">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Order</label>
                        <input type="number" name="order" class="form-control" value="0">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Content</label>
                        <textarea name="content" class="form-control" rows="5" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="modal-btn modal-cancel"
                        onclick="closeModal('addPageModal')">Cancel</button>
                    <button type="submit" class="modal-btn modal-submit">Save</button>
                </div>
            </form>
        </div>
    </div>

    {{-- EDIT PAGE --}}
    <div class="modal-overlay" id="editPageModal" style="display:none;">
        <div class="modal-card">
            <form id="editPageForm" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="modal-header">
                    <h4>Edit Page</h4>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" id="editPageTitle" name="title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Slug</label>
                        <input type="text" id="editPageSlug" name="slug" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Section</label>
                        <input type="text" id="editPageSection" name="section" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Order</label>
                        <input type="number" id="editPageOrder" name="order" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Content</label>
                        <textarea id="editPageContent" name="content" class="form-control" rows="5" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="modal-btn modal-cancel"
                        onclick="closeModal('editPageModal')">Cancel</button>
                    <button type="submit" class="modal-btn modal-submit">Update</button>
                </div>
            </form>
        </div>
    </div>


    {{-- ADD TEAM MEMBER MODAL --}}
    <div class="modal-overlay" id="addTeamModal" style="display:none;">
        <div class="modal-card">
            <form action="{{ route('admin.team-members.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h4>Add Team Member</h4>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Image</label>
                        <input type="file" name="image" class="form-control" accept="image/*" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="modal-btn modal-cancel"
                        onclick="closeModal('addTeamModal')">Cancel</button>
                    <button type="submit" class="modal-btn modal-submit">Save</button>
                </div>
            </form>
        </div>
    </div>

    {{-- EDIT TEAM MEMBER MODAL --}}
    <div class="modal-overlay" id="editTeamModal" style="display:none;">
        <div class="modal-card">
            <form id="editTeamForm" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="modal-header">
                    <h4>Edit Team Member</h4>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" id="editTeamName" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" id="editTeamTitle" name="title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Current Image</label><br>
                        <img id="currentTeamImage" src="" alt="Current Image" width="100">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">New Image (optional)</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="modal-btn modal-cancel"
                        onclick="closeModal('editTeamModal')">Cancel</button>
                    <button type="submit" class="modal-btn modal-submit">Update</button>
                </div>
            </form>
        </div>
    </div>


    {{-- ADD BANNER --}}
    <div class="modal-overlay" id="addBannerModal" style="display:none;">
        <div class="modal-card">
            <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h4>Add Banner</h4>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Page Slug (optional)</label>
                        <input type="text" name="slug" class="form-control"
                            placeholder="about-us, home, contact">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Link (optional)</label>
                        <input type="url" name="link" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Image</label>
                        <input type="file" name="image" class="form-control" accept="image/*" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Section</label>
                        <input type="text" name="section" class="form-control" placeholder="hero, sidebar, main"
                            value="main">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Order</label>
                        <input type="number" name="order" class="form-control" value="0">
                    </div>
                    <div class="form-check mb-3">
                        <input type="checkbox" name="active" id="addBannerActive" class="form-check-input" checked>
                        <label class="form-check-label" for="addBannerActive">Active</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="modal-btn modal-cancel"
                        onclick="closeModal('addBannerModal')">Cancel</button>
                    <button type="submit" class="modal-btn modal-submit">Save</button>
                </div>
            </form>
        </div>
    </div>

    {{-- EDIT BANNER --}}
    <div class="modal-overlay" id="editBannerModal" style="display:none;">
        <div class="modal-card">
            <form id="editBannerForm" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="modal-header">
                    <h4>Edit Banner</h4>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" id="editBannerTitle" name="title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Page Slug (optional)</label>
                        <input type="text" id="editBannerSlug" name="slug" class="form-control"
                            placeholder="about-us, home, contact">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Link</label>
                        <input type="url" id="editBannerLink" name="link" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Current Image</label><br>
                        <img id="currentBannerImage" src="" alt="Current Image" width="100">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">New Image (optional)</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Section</label>
                        <input type="text" id="editBannerSection" name="section" class="form-control"
                            placeholder="hero, sidebar, main" value="main">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Order</label>
                        <input type="number" id="editBannerOrder" name="order" class="form-control"
                            value="0">
                    </div>
                    <div class="form-check mb-3">
                        <input type="checkbox" id="editBannerActive" name="active" class="form-check-input">
                        <label class="form-check-label" for="editBannerActive">Active</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="modal-btn modal-cancel"
                        onclick="closeModal('editBannerModal')">Cancel</button>
                    <button type="submit" class="modal-btn modal-submit">Update</button>
                </div>
            </form>
        </div>
    </div>

    {{-- JS --}}
    <script>
        // Open a modal by ID
        function openModal(id) {
            const modal = document.getElementById(id);
            if (modal) modal.style.display = 'flex';
        }

        // Close a modal by ID
        function closeModal(id) {
            const modal = document.getElementById(id);
            if (modal) modal.style.display = 'none';
        }

        // ===== PAGES =====
        function openEditPageModal(id, title, slug, content, section, order) {
            const form = document.getElementById('editPageForm');
            if (!form) return;

            // Directly set action like Team Members
            form.action = `/admin/content-pages/${id}`;

            document.getElementById('editPageTitle').value = title || '';
            document.getElementById('editPageSlug').value = slug || '';
            document.getElementById('editPageContent').value = content || '';
            document.getElementById('editPageSection').value = section || 'main';
            document.getElementById('editPageOrder').value = order || 0;

            openModal('editPageModal');
        }



        // ===== TEAM MEMBERS =====
        function openEditTeamModal(id, name, title, image) {
            const form = document.getElementById('editTeamForm');
            if (!form) return;

            form.action = `/admin/team-members/${id}`;
            document.getElementById('editTeamName').value = name || '';
            document.getElementById('editTeamTitle').value = title || '';
            if (image) {
                const imgEl = document.getElementById('currentTeamImage');
                if (imgEl) imgEl.src = image;
            }
            openModal('editTeamModal');
        }

        function openEditBannerModal(id, title, image, link, active, section, order, slug) {
            const form = document.getElementById('editBannerForm');
            if (!form) return;

            // Directly set action like Team Members
            form.action = `/admin/banners/${id}`;

            document.getElementById('editBannerTitle').value = title || '';
            document.getElementById('editBannerLink').value = link || '';
            document.getElementById('editBannerSection').value = section || 'main';
            document.getElementById('editBannerOrder').value = order || 0;
            document.getElementById('editBannerActive').checked = active;
            document.getElementById('editBannerSlug').value = slug || '';
            if (image) document.getElementById('currentBannerImage').src = image;

            openModal('editBannerModal');
        }




        // Optional: Close modals when clicking outside
        window.onclick = function(event) {
            const modals = document.querySelectorAll('.modal-overlay');
            modals.forEach(modal => {
                if (event.target === modal) modal.style.display = 'none';
            });
        }
    </script>

</x-admin-layout>
