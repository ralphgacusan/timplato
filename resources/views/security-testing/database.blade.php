@php
    $tableData = $tables ?? [];
@endphp
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lab database | Timplato</title>
    <link rel="stylesheet" href="{{ asset('css/security-testing.css') }}">
</head>
<body class="database-page">
    <div class="security-banner security-banner--database">SECURITY TESTING ONLY · LAB DATABASE VIEWER</div>
    <header class="database-topbar">
        <a class="database-logo" href="{{ route('security-testing.products') }}">
            <img src="{{ asset('timplatoLogo/Timplato-White2.png') }}" alt="Timplato">
            <span>Training database</span>
        </a>
        <nav aria-label="Store navigation">
            <a href="{{ route('security-testing.products') }}">← Return to the store</a>
            <a href="{{ route('security-testing.cart') }}">Cart</a>
            <a href="{{ route('security-testing.signin') }}">Sign in</a>
        </nav>
    </header>

    <div class="database-workspace">
        <aside class="database-sidebar">
            <p class="database-sidebar__label">Database</p>
            <h1>security_lab</h1>
            <p class="database-sidebar__hint">SQLite · Training data</p>
            <p class="database-sidebar__label database-sidebar__label--tables">Tables</p>
            <nav aria-label="Database tables">
                @forelse ($tableData as $tableName => $table)
                    <a href="#table-{{ \Illuminate\Support\Str::slug($tableName) }}">
                        <span aria-hidden="true">▦</span>{{ $tableName }}
                        <small>{{ count($table['rows'] ?? []) }}</small>
                    </a>
                @empty
                    <p>No tables returned.</p>
                @endforelse
            </nav>
            <div class="database-sidebar__footer">Disposable lab data</div>
        </aside>

        <main class="database-main">
            <div class="database-breadcrumb"><span>Server</span><span>›</span><span>security_lab</span><span>›</span><strong>Tables</strong></div>
            <div class="database-heading">
                <div>
                    <p class="eyebrow">Table browser</p>
                    <h2>Database tables</h2>
                    <p>Inspect the training database structure and its current records.</p>
                </div>
                <span class="database-engine">SQLite</span>
            </div>

            <details class="database-reset">
                <summary>Reset the lab database</summary>
                <div>
                    <p>This clears training accounts and reviews, then restores the demo catalog.</p>
                    <form action="{{ route('security-testing.database.reset') }}" method="POST">
                        @csrf
                        <button class="button button--danger" type="submit">Reset lab data</button>
                    </form>
                </div>
            </details>

            @if ($message ?? session('feedback'))
                <div class="notice {{ ($queryError ?? false) ? 'notice--error' : '' }}" role="status">{{ $message ?? session('feedback') }}</div>
            @endif
            @if ($queryError ?? false)
                <div class="database-error" role="alert"><strong>Query error</strong><p>{{ $queryError }}</p></div>
            @endif

            @forelse ($tableData as $tableName => $table)
                <section class="database-table-card" id="table-{{ \Illuminate\Support\Str::slug($tableName) }}">
                    <div class="database-table-card__heading">
                        <div>
                            <p class="database-kicker">Table</p>
                            <h3><span aria-hidden="true">▦</span> {{ $tableName }}</h3>
                        </div>
                        <span class="database-row-count">{{ count($table['rows'] ?? []) }} rows</span>
                    </div>
                    @if ($table['error'] ?? false)
                        <div class="database-error" role="alert">{{ $table['error'] }}</div>
                    @endif

                    <details class="database-structure" open>
                        <summary>Structure <span>{{ count($table['columns'] ?? []) }} columns</span></summary>
                        <div class="database-scroll">
                            <table class="database-grid database-grid--structure">
                                <thead>
                                    <tr>
                                        <th>Column</th><th>Type</th><th>Null</th><th>Default</th><th>Key</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($table['columns'] ?? [] as $column)
                                        <tr>
                                            <td><code>{{ $column['name'] ?? '' }}</code></td>
                                            <td>{{ $column['type'] ?? '' }}</td>
                                            <td>{{ (int) ($column['notnull'] ?? 0) === 1 ? 'NO' : 'YES' }}</td>
                                            <td>
                                                @if (($column['dflt_value'] ?? null) === null)
                                                    <span class="database-null">NULL</span>
                                                @else
                                                    {{ $column['dflt_value'] }}
                                                @endif
                                            </td>
                                            <td>{{ (int) ($column['pk'] ?? 0) > 0 ? 'PRIMARY KEY' : '' }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="5">No column metadata.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </details>

                    <div class="database-scroll">
                        <table class="database-grid">
                            <thead>
                                <tr>
                                    @forelse ($table['columns'] ?? [] as $column)
                                        <th>{{ $column['name'] ?? '' }}</th>
                                    @empty
                                        <th>Result</th>
                                    @endforelse
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($table['rows'] ?? [] as $row)
                                    <tr>
                                        @forelse ($table['columns'] ?? [] as $column)
                                            @php
                                                $columnName = $column['name'] ?? '';
                                                $cellValue = $row[$columnName] ?? null;
                                            @endphp
                                            <td>
                                                @if ($cellValue === null)
                                                    <span class="database-null">NULL</span>
                                                @else
                                                    {{ is_scalar($cellValue) ? (string) $cellValue : json_encode($cellValue) }}
                                                @endif
                                            </td>
                                        @empty
                                            <td>{{ json_encode($row) }}</td>
                                        @endforelse
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="database-no-rows" colspan="{{ max(count($table['columns'] ?? []), 1) }}">This table is empty. Its schema is shown above.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if (!empty($table['sql']))
                        <details class="database-sql">
                            <summary>CREATE TABLE statement</summary>
                            <pre><code>{{ $table['sql'] }}</code></pre>
                        </details>
                    @endif
                </section>
            @empty
                <div class="database-empty">No training tables are available.</div>
            @endforelse
        </main>
    </div>
</body>
</html>
