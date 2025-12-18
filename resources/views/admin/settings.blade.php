<x-admin-layout>
    @section('title', 'Settings & Configuration - Timplato Admin')

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
        <h2>Settings & Configuration</h2>
        <p class="text-muted">Manage platform-wide settings like currency, contact info, payment, and delivery methods.
        </p>

        {{-- GENERAL SETTINGS --}}
        <form action="{{ route('settings.update') }}" method="POST" class="mb-5">
            @csrf
            @method('PUT')

            <div class="row mb-3">
                {{-- Default Currency --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Default Currency</label>
                    <select name="currency" class="form-select">
                        @foreach (['PHP', 'USD'] as $currency)
                            <option value="{{ $currency }}"
                                {{ ($settings['currency'] ?? 'PHP') == $currency ? 'selected' : '' }}>
                                {{ $currency }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Store Contact Email --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Store Contact Email</label>
                    <input type="email" name="store_email" class="form-control"
                        value="{{ $settings['store_email'] ?? 'support@timplato.com' }}">
                </div>
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Save General Settings</button>
            </div>
        </form>

        {{-- PAYMENT METHODS --}}
        <div class="mb-5">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4>Payment Methods</h4>
                <button class="btn btn-success btn-sm" onclick="openModal('addPaymentModal')">+ Add Payment
                    Method</button>
            </div>

            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($paymentMethods as $method)
                        <tr>
                            <td>{{ $method->name }}</td>
                            <td>{{ $method->description ?? '—' }}</td>
                            <td>
                                <button class="btn btn-sm btn-primary"
                                    onclick="openEditModal('{{ $method->id }}', '{{ $method->name }}', '{{ $method->description }}')">
                                    Edit
                                </button>
                                <form action="{{ route('payment.destroy', $method->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Delete this payment method?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted">No payment methods yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- DELIVERY METHODS --}}
        <div>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4>Delivery Methods</h4>
                <button class="btn btn-success btn-sm" onclick="openModal('addDeliveryModal')">+ Add Delivery
                    Option</button>
            </div>

            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Fee (₱)</th>
                        <th>Description</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($deliveryMethods as $delivery)
                        <tr>
                            <td>{{ $delivery->name }}</td>
                            <td>{{ number_format($delivery->fee, 2) }}</td>
                            <td>{{ $delivery->description ?? '—' }}</td>
                            <td>
                                <button class="btn btn-sm btn-primary"
                                    onclick="openEditDeliveryModal('{{ $delivery->id }}', '{{ $delivery->name }}', '{{ $delivery->fee }}', '{{ $delivery->description }}')">
                                    Edit
                                </button>
                                <form action="{{ route('delivery.destroy', $delivery->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Delete this delivery option?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">No delivery methods yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{-- VOUCHERS --}}
        <div class="mt-5">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4>Vouchers</h4>
                <button class="btn btn-success btn-sm" onclick="openModal('addVoucherModal')">+ Add Voucher</button>
            </div>

            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Type</th>
                        <th>Value</th>
                        <th>Description</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($vouchers as $voucher)
                        <tr>
                            <td>{{ $voucher->code }}</td>
                            <td class="text-capitalize">{{ $voucher->discount_type }}</td>
                            <td>
                                {{ $voucher->discount_type === 'percentage'
                                    ? $voucher->discount_value * 100 . '%'
                                    : '₱' . number_format($voucher->discount_value, 2) }}
                            </td>
                            <td>{{ $voucher->description ?? '—' }}</td>
                            <td>
                                <button class="btn btn-sm btn-primary"
                                    onclick="openEditVoucherModal('{{ $voucher->id }}', '{{ $voucher->code }}', '{{ $voucher->discount_type }}', '{{ $voucher->discount_value }}', '{{ $voucher->description }}')">
                                    Edit
                                </button>
                                <form action="{{ route('voucher.destroy', $voucher->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Delete this voucher?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">No vouchers yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- ADD VOUCHER MODAL --}}
        <div class="modal-overlay" id="addVoucherModal" style="display:none;">
            <div class="modal-card">
                <form action="{{ route('voucher.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h4>Add Voucher</h4>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Code</label>
                            <input type="text" name="code" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Discount Type</label>
                            <select name="discount_type" class="form-select" required>
                                <option value="fixed">Fixed (₱)</option>
                                <option value="percentage">Percentage (%)</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Discount Value</label>
                            <input type="number" name="discount_value" class="form-control" step="0.01" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="modal-btn modal-cancel"
                            onclick="closeModal('addVoucherModal')">Cancel</button>
                        <button type="submit" class="modal-btn modal-submit">Save</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- EDIT VOUCHER MODAL --}}
        <div class="modal-overlay" id="editVoucherModal" style="display:none;">
            <div class="modal-card">
                <form id="editVoucherForm" method="POST">
                    @csrf @method('PUT')
                    <div class="modal-header">
                        <h4>Edit Voucher</h4>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Code</label>
                            <input type="text" id="editVoucherCode" name="code" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Discount Type</label>
                            <select id="editVoucherType" name="discount_type" class="form-select" required>
                                <option value="fixed">Fixed (₱)</option>
                                <option value="percentage">Percentage (%)</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Discount Value</label>
                            <input type="number" id="editVoucherValue" name="discount_value" class="form-control"
                                step="0.01" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea id="editVoucherDesc" name="description" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="modal-btn modal-cancel"
                            onclick="closeModal('editVoucherModal')">Cancel</button>
                        <button type="submit" class="modal-btn modal-submit">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ADD PAYMENT MODAL --}}
    <div class="modal-overlay" id="addPaymentModal" style="display:none;">
        <div class="modal-card">
            <form action="{{ route('payment.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h4>Add Payment Method</h4>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="modal-btn modal-cancel"
                        onclick="closeModal('addPaymentModal')">Cancel</button>
                    <button type="submit" class="modal-btn modal-submit">Save</button>
                </div>
            </form>
        </div>
    </div>

    {{-- EDIT PAYMENT MODAL --}}
    <div class="modal-overlay" id="editPaymentModal" style="display:none;">
        <div class="modal-card">
            <form id="editPaymentForm" method="POST">
                @csrf @method('PUT')
                <div class="modal-header">
                    <h4>Edit Payment Method</h4>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" id="editPaymentName" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea id="editPaymentDesc" name="description" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="modal-btn modal-cancel"
                        onclick="closeModal('editPaymentModal')">Cancel</button>
                    <button type="submit" class="modal-btn modal-submit">Update</button>
                </div>
            </form>
        </div>
    </div>

    {{-- ADD DELIVERY MODAL --}}
    <div class="modal-overlay" id="addDeliveryModal" style="display:none;">
        <div class="modal-card">
            <form action="{{ route('delivery.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h4>Add Delivery Option</h4>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Fee</label>
                        <input type="number" name="fee" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="modal-btn modal-cancel"
                        onclick="closeModal('addDeliveryModal')">Cancel</button>
                    <button type="submit" class="modal-btn modal-submit">Save</button>
                </div>
            </form>
        </div>
    </div>

    {{-- EDIT DELIVERY MODAL --}}
    <div class="modal-overlay" id="editDeliveryModal" style="display:none;">
        <div class="modal-card">
            <form id="editDeliveryForm" method="POST">
                @csrf @method('PUT')
                <div class="modal-header">
                    <h4>Edit Delivery Option</h4>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" id="editDeliveryName" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Fee</label>
                        <input type="number" id="editDeliveryFee" name="fee" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea id="editDeliveryDesc" name="description" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="modal-btn modal-cancel"
                        onclick="closeModal('editDeliveryModal')">Cancel</button>
                    <button type="submit" class="modal-btn modal-submit">Update</button>
                </div>
            </form>
        </div>
    </div>




    {{-- JS --}}
    <script>
        function openModal(id) {
            document.getElementById(id).style.display = 'flex';
        }

        function closeModal(id) {
            document.getElementById(id).style.display = 'none';
        }

        function openEditModal(id, name, description) {
            document.getElementById('editPaymentName').value = name;
            document.getElementById('editPaymentDesc').value = description;
            document.getElementById('editPaymentForm').action = `/payment-methods/${id}`;
            openModal('editPaymentModal');
        }

        function openEditDeliveryModal(id, name, fee, description) {
            document.getElementById('editDeliveryName').value = name;
            document.getElementById('editDeliveryFee').value = fee;
            document.getElementById('editDeliveryDesc').value = description;
            document.getElementById('editDeliveryForm').action = `/delivery-methods/${id}`;
            openModal('editDeliveryModal');
        }

        function openEditVoucherModal(id, code, type, value, description) {
            document.getElementById('editVoucherForm').action = `/vouchers/${id}`;
            document.getElementById('editVoucherCode').value = code;
            document.getElementById('editVoucherType').value = type;

            // ✅ Convert decimal back to percentage if type is percentage
            if (type === 'percentage') {
                value = parseFloat(value) * 100;
            }

            document.getElementById('editVoucherValue').value = value;
            document.getElementById('editVoucherDesc').value = description || '';

            openModal('editVoucherModal');
        }
    </script>
</x-admin-layout>
