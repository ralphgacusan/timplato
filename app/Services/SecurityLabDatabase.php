<?php

namespace App\Services;

use SQLite3;
use SQLite3Result;
use SQLite3Stmt;

class SecurityLabDatabase
{
    private const SCHEMA_VERSION = 1;

    private const PRODUCTS = [
        [1, 'Rice Bowl with Local Designs', 'A glazed ceramic bowl with a colorful local pattern.', 249.00, 24, 'rice_bowl_with_local_designs_1.jpg', 'Tableware'],
        [2, '12-Inch Silicone Tip Food Tongs', 'Stainless steel tongs with heat-resistant silicone tips.', 179.00, 18, '12inch_food_tongs_with_silicone_tips_1.jpg', 'Kitchen Tools'],
        [3, '1L Glass Pitcher with Lid', 'A clear glass pitcher for serving water, juice, and iced tea.', 329.00, 12, '1lglass_pitcher_with_lid_1.jpg', 'Drinkware'],
        [4, '3-Piece Knife Set with Covers', 'Everyday kitchen knives supplied with protective covers.', 399.00, 10, '3piece_knife_set_with_cover_1.jpg', 'Kitchen Tools'],
        [5, '5-Piece Silicone Spatula Set', 'Flexible silicone spatulas for mixing, scraping, and cooking.', 289.00, 16, '5piece_silicone_spatula_set_1.jpg', 'Kitchen Tools'],
        [6, '4-Piece Non-Stick Cookware Set', 'A practical non-stick set for everyday home cooking.', 1299.00, 8, '4piece_granite_pan_set_1.jpg', 'Cookware'],
    ];

    private SQLite3 $connection;

    private string $databasePath;

    public function __construct(?string $path = null)
    {
        $this->databasePath = $path ?? storage_path('framework/security-testing.sqlite');
        $this->connect();
    }

    public function path(): string
    {
        return $this->databasePath;
    }

    /** Execute the submitted SQL stack, then return the first row of a read-only SELECT/WITH. */
    public function execute(string $sql): ?array
    {
        $this->connection->exec($sql);

        if (! preg_match('/^\s*(SELECT|WITH)\b/i', $sql)) {
            return null;
        }

        $statement = $this->connection->prepare($sql);

        if (! $statement instanceof SQLite3Stmt) {
            return null;
        }

        if (! $statement->readOnly()) {
            $statement->close();

            return null;
        }

        $result = $statement->execute();
        $row = $result instanceof SQLite3Result ? $result->fetchArray(SQLITE3_ASSOC) : false;
        if ($result instanceof SQLite3Result) {
            $result->finalize();
        }

        $statement->close();

        return is_array($row) ? $row : null;
    }

    /** Run an internal prepared read and return all result rows. */
    public function rows(string $sql, array $bindings = []): array
    {
        $statement = $this->connection->prepare($sql);
        $this->bind($statement, $bindings);
        $result = $statement->execute();
        $rows = [];

        if ($result instanceof SQLite3Result) {
            while (($row = $result->fetchArray(SQLITE3_ASSOC)) !== false) {
                $rows[] = $row;
            }

            $result->finalize();
        }

        $statement->close();

        return $rows;
    }

    /** Run an internal prepared write and return the affected row count. */
    public function executePrepared(string $sql, array $bindings = []): int
    {
        $statement = $this->connection->prepare($sql);
        $this->bind($statement, $bindings);
        $result = $statement->execute();
        if ($result instanceof SQLite3Result) {
            $result->finalize();
        }

        $statement->close();

        return $this->connection->changes();
    }

    /** Return every user table with its columns and current rows. */
    public function tables(): array
    {
        $tableNames = $this->rows(
            "SELECT name FROM sqlite_master WHERE type = 'table' ORDER BY name"
        );
        $tables = [];

        foreach ($tableNames as $table) {
            $name = $table['name'];
            $identifier = '"'.str_replace('"', '""', $name).'"';

            try {
                $columns = $this->rows('PRAGMA table_info('.$identifier.')');
                $tables[$name] = [
                    'columns' => $columns,
                    'rows' => $this->rows('SELECT * FROM '.$identifier),
                    'error' => null,
                ];
            } catch (\Throwable $exception) {
                $tables[$name] = [
                    'columns' => [],
                    'rows' => [],
                    'error' => $exception->getMessage(),
                ];
            }
        }

        return $tables;
    }

    /** Replace the disposable database with a clean, seeded lab database. */
    public function reset(): void
    {
        $this->connection->close();

        foreach ([$this->databasePath, $this->databasePath.'-wal', $this->databasePath.'-shm'] as $file) {
            if (is_file($file) && ! unlink($file)) {
                throw new \RuntimeException('Unable to reset the security-testing database.');
            }
        }

        $this->connect();
    }

    private function connect(): void
    {
        $directory = dirname($this->databasePath);

        if (! is_dir($directory) && ! mkdir($directory, 0775, true) && ! is_dir($directory)) {
            throw new \RuntimeException('Unable to create the security-testing database directory.');
        }

        $isNew = ! is_file($this->databasePath) || filesize($this->databasePath) === 0;
        $this->connection = new SQLite3(
            $this->databasePath,
            SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE
        );
        $this->connection->enableExceptions(true);
        $this->connection->busyTimeout(2000);
        $this->connection->exec('PRAGMA max_page_count = 16384');
        $this->connection->exec('PRAGMA foreign_keys = ON');

        if ($isNew) {
            $this->createSchema();
        } else {
            $this->migrateExistingSchema();
        }

        $this->connection->setAuthorizer(
            static fn (int $action, ?string $argumentOne, ?string $argumentTwo, ?string $database, ?string $trigger): int => self::authorize(
                $action,
                $argumentOne,
                $argumentTwo,
                $database,
                $trigger
            )
        );
    }

    private function createSchema(): void
    {
        $this->connection->exec(<<<'SQL'
            CREATE TABLE IF NOT EXISTS users (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name TEXT NOT NULL,
                email TEXT NOT NULL UNIQUE,
                password TEXT NOT NULL,
                password_hash TEXT NOT NULL,
                created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP
            );
            CREATE TABLE IF NOT EXISTS products (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name TEXT NOT NULL,
                description TEXT NOT NULL,
                price REAL NOT NULL DEFAULT 0,
                stock INTEGER NOT NULL DEFAULT 0,
                image TEXT NOT NULL DEFAULT '',
                category TEXT NOT NULL DEFAULT ''
            );
            CREATE TABLE IF NOT EXISTS reviews (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                product_id INTEGER NOT NULL,
                author TEXT NOT NULL,
                comment TEXT NOT NULL,
                rating INTEGER NOT NULL DEFAULT 5,
                created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
            );
            SQL
        );

        $this->seedInitialData();
        $this->connection->exec('PRAGMA user_version = '.self::SCHEMA_VERSION);
    }

    private function migrateExistingSchema(): void
    {
        $version = (int) $this->connection->querySingle('PRAGMA user_version');

        if ($version >= self::SCHEMA_VERSION) {
            return;
        }

        $this->addColumnIfTableExists('users', 'name', "TEXT NOT NULL DEFAULT 'Lab User'");
        $this->addColumnIfTableExists('users', 'password', "TEXT NOT NULL DEFAULT ''");
        $this->addColumnIfTableExists('users', 'created_at', "TEXT NOT NULL DEFAULT ''");
        $this->addColumnIfTableExists('products', 'description', "TEXT NOT NULL DEFAULT ''");
        $this->addColumnIfTableExists('products', 'price', 'REAL NOT NULL DEFAULT 0');
        $this->addColumnIfTableExists('products', 'stock', 'INTEGER NOT NULL DEFAULT 0');
        $this->addColumnIfTableExists('products', 'image', "TEXT NOT NULL DEFAULT ''");
        $this->addColumnIfTableExists('products', 'category', "TEXT NOT NULL DEFAULT ''");
        $this->addColumnIfTableExists('reviews', 'rating', 'INTEGER NOT NULL DEFAULT 5');

        if ($this->tableExists('users') && $this->hasColumn('users', 'password_hash')) {
            $this->executePrepared(
                'UPDATE users SET password = :password WHERE email = :email AND password_hash = :password_hash AND password = :empty',
                [
                    'password' => 'LabPassword123!',
                    'email' => 'demo@example.test',
                    'password_hash' => hash('sha256', 'LabPassword123!'),
                    'empty' => '',
                ]
            );
        }

        // Upgrade the earlier one-product fixture once while preserving existing product rows.
        if ($this->tableExists('products')) {
            $this->seedProducts();
            $this->fillProductDetailsOnce();
        }

        $this->connection->exec('PRAGMA user_version = '.self::SCHEMA_VERSION);
    }

    private function seedInitialData(): void
    {
        $this->executePrepared(
            'INSERT OR IGNORE INTO users (name, email, password, password_hash) VALUES (:name, :email, :password, :password_hash)',
            [
                'name' => 'Demo User',
                'email' => 'demo@example.test',
                'password' => 'LabPassword123!',
                'password_hash' => hash('sha256', 'LabPassword123!'),
            ]
        );

        $this->seedProducts();
    }

    private function seedProducts(): void
    {
        foreach (self::PRODUCTS as [$id, $name, $description, $price, $stock, $image, $category]) {
            $this->executePrepared(
                'INSERT OR IGNORE INTO products (id, name, description, price, stock, image, category) VALUES (:id, :name, :description, :price, :stock, :image, :category)',
                compact('id', 'name', 'description', 'price', 'stock', 'image', 'category')
            );
        }
    }

    private function fillProductDetailsOnce(): void
    {
        foreach (self::PRODUCTS as [$id, $name, $description, $price, $stock, $image, $category]) {
            $this->executePrepared(
                "UPDATE products SET description = CASE WHEN description = '' THEN :description ELSE description END, price = CASE WHEN price = 0 THEN :price ELSE price END, stock = CASE WHEN stock = 0 THEN :stock ELSE stock END, image = CASE WHEN image = '' THEN :image ELSE image END, category = CASE WHEN category = '' THEN :category ELSE category END WHERE id = :id",
                compact('id', 'description', 'price', 'stock', 'image', 'category')
            );
        }
    }

    private function addColumnIfTableExists(string $table, string $column, string $definition): void
    {
        if (! $this->tableExists($table) || $this->hasColumn($table, $column)) {
            return;
        }

        $this->connection->exec("ALTER TABLE \"$table\" ADD COLUMN \"$column\" $definition");
    }

    private function hasColumn(string $table, string $column): bool
    {
        return in_array($column, array_column($this->rows("PRAGMA table_info(\"$table\")"), 'name'), true);
    }

    private function tableExists(string $table): bool
    {
        $statement = $this->connection->prepare("SELECT 1 FROM sqlite_master WHERE type = 'table' AND name = :name");
        $statement->bindValue(':name', $table, SQLITE3_TEXT);
        $result = $statement->execute();
        $exists = $result instanceof SQLite3Result && $result->fetchArray(SQLITE3_NUM) !== false;
        if ($result instanceof SQLite3Result) {
            $result->finalize();
        }

        $statement->close();

        return $exists;
    }

    private function bind(SQLite3Stmt $statement, array $bindings): void
    {
        foreach ($bindings as $key => $value) {
            $parameter = is_int($key) ? $key + 1 : (str_starts_with((string) $key, ':') ? $key : ':'.$key);
            $type = match (true) {
                is_null($value) => SQLITE3_NULL,
                is_bool($value), is_int($value) => SQLITE3_INTEGER,
                is_float($value) => SQLITE3_FLOAT,
                default => SQLITE3_TEXT,
            };

            $statement->bindValue($parameter, $value, $type);
        }
    }

    private static function authorize(
        int $action,
        ?string $argumentOne,
        ?string $argumentTwo,
        ?string $database,
        ?string $trigger
    ): int {
        if (in_array($action, [SQLite3::ATTACH, SQLite3::DETACH], true)) {
            return SQLite3::DENY;
        }

        if ($action === SQLite3::PRAGMA && ! in_array(strtolower((string) $argumentOne), [
            'table_info',
            'table_xinfo',
            'index_list',
            'index_info',
            'foreign_key_list',
            'database_list',
        ], true)) {
            return SQLite3::DENY;
        }

        if ($action === SQLite3::FUNCTION && in_array(strtolower((string) $argumentTwo), [
            'load_extension',
            'readfile',
            'writefile',
            'fts3_tokenizer',
        ], true)) {
            return SQLite3::DENY;
        }

        if ($database !== null && ! in_array(strtolower($database), ['main', 'temp'], true)) {
            return SQLite3::DENY;
        }

        return SQLite3::OK;
    }
}
