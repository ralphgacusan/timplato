<x-admin-layout>
    @section('title', 'Stock History - ' . $product->name)

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/admin/inventory-management.css') }}">
        <link rel="stylesheet" href="{{ asset('css/components/components.css') }}">
    @endpush

    <div class="inventory-management-content">
        <h2>Stock History for: {{ $product->name }}</h2>

        <div class="im-table-container mt-4">
            <table class="im-table stock-history-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Type</th>
                        <th>Quantity</th>
                        <th>Performed By</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transactions as $tx)
                        <tr>
                            <td>{{ $tx->stock_transaction_id }}</td>
                            <td>{{ ucfirst($tx->type) }}</td>
                            <td>{{ $tx->quantity }}</td>
                            <td>{{ $tx->performed_by }}</td>
                            <td>{{ $tx->created_at->format('M d, Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No stock transactions found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            <a href="{{ route('admin.inventory-management') }}" class="btn btn-secondary">Back to Inventory</a>
        </div>
    </div>
</x-admin-layout>
