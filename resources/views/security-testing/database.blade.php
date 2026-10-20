<section class="lab-panel lab-database">
    <h2>Disposable lab SQLite data</h2>
    <p>Database file: <code>{{ $databasePath }}</code></p>

    <h3>Users</h3>
    <div class="lab-table-wrap">
        <table>
            <thead>
                <tr><th>ID</th><th>Email</th></tr>
            </thead>
            <tbody>
                @forelse ($labTables['users'] as $row)
                    <tr><td>{{ $row['id'] }}</td><td>{{ $row['email'] }}</td></tr>
                @empty
                    <tr><td colspan="2">No users.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <h3>Products</h3>
    <div class="lab-table-wrap">
        <table>
            <thead>
                <tr><th>ID</th><th>Name</th></tr>
            </thead>
            <tbody>
                @forelse ($labTables['products'] as $row)
                    <tr><td>{{ $row['id'] }}</td><td>{{ $row['name'] }}</td></tr>
                @empty
                    <tr><td colspan="2">No products.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <h3>Reviews</h3>
    <div class="lab-table-wrap">
        <table>
            <thead>
                <tr><th>ID</th><th>Product ID</th><th>Author</th><th>Comment</th><th>Created</th></tr>
            </thead>
            <tbody>
                @forelse ($labTables['reviews'] as $row)
                    <tr>
                        <td>{{ $row['id'] }}</td>
                        <td>{{ $row['product_id'] }}</td>
                        <td>{{ $row['author'] }}</td>
                        <td>{{ $row['comment'] }}</td>
                        <td>{{ $row['created_at'] }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5">No reviews.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
