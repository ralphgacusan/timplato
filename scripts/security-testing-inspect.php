<?php

// Read-only inspection of the disposable lab file. Does not boot Laravel.
if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}

$path = dirname(__DIR__).'/storage/framework/security-testing.sqlite';
if (! is_file($path)) {
    fwrite(STDERR, "Open /review-test on the local lab server first to initialize the fixture database.\n");
    exit(1);
}

$database = new PDO('sqlite:'.$path, null, null, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
$database->exec('PRAGMA query_only = ON');
$tables = [
    'users' => 'SELECT id, email FROM users ORDER BY id',
    'products' => 'SELECT id, name FROM products ORDER BY id',
    'reviews' => 'SELECT id, product_id, author, comment, created_at FROM reviews ORDER BY id',
];

echo 'SQLite lab file: ', realpath($path), PHP_EOL;
foreach ($tables as $name => $query) {
    echo PHP_EOL, $name, PHP_EOL;
    echo json_encode($database->query($query)->fetchAll(PDO::FETCH_ASSOC), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR), PHP_EOL;
}
