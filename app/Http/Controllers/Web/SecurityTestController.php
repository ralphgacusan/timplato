<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use PDO;
use PDOException;

class SecurityTestController extends Controller
{
    public function signinForm(): View
    {
        $database = $this->database();
        $database->exec('PRAGMA query_only = ON');

        return view('security-testing.signin', $this->signinViewData($database));
    }

    public function signin(Request $request): View
    {
        $email = $this->stringInput($request->input('email'));
        $password = $this->stringInput($request->input('password'));
        $passwordHash = hash('sha256', $password);
        $query = "SELECT id, email FROM users WHERE email = '{$email}' AND password_hash = '{$passwordHash}' LIMIT 1";
        $identity = null;
        $queryError = null;
        $database = $this->database();

        try {
            $database->exec('PRAGMA query_only = ON');
            $row = $database->query($query)->fetch(PDO::FETCH_ASSOC);

            if ($row !== false) {
                $identity = [
                    'id' => $row['id'],
                    'email' => $row['email'],
                ];
            }
        } catch (PDOException $exception) {
            $queryError = 'The test query failed: '.$exception->getMessage();
        }

        return view('security-testing.signin', [
            'email' => $email,
            'identity' => $identity,
            'query' => $query,
            'queryError' => $queryError,
            ...$this->signinViewData($database),
        ]);
    }

    public function reviews(): View
    {
        $database = $this->database();
        $database->exec('PRAGMA query_only = ON');
        $product = $database->query('SELECT id, name FROM products WHERE id = 1')->fetch(PDO::FETCH_ASSOC);
        $reviews = $database->query(
            'SELECT id, author, comment, created_at FROM reviews WHERE product_id = 1 ORDER BY id DESC'
        )->fetchAll(PDO::FETCH_ASSOC);

        return view('security-testing.reviews', [
            'product' => $product,
            'reviews' => $reviews,
            ...$this->signinViewData($database),
        ]);
    }

    public function storeReview(Request $request): RedirectResponse
    {
        $author = $this->stringInput($request->input('author'));
        $comment = $this->stringInput($request->input('comment'));
        $database = $this->database();
        $statement = $database->prepare(
            'INSERT INTO reviews (product_id, author, comment) VALUES (1, :author, :comment)'
        );
        $statement->execute([
            'author' => $author,
            'comment' => $comment,
        ]);

        return redirect()->route('security-testing.reviews');
    }

    public function resetReviews(): RedirectResponse
    {
        $database = $this->database();
        $database->exec('DELETE FROM reviews WHERE product_id = 1');

        return redirect()->route('security-testing.reviews');
    }

    private function signinViewData(PDO $database): array
    {
        return [
            'databasePath' => storage_path('framework/security-testing.sqlite'),
            'labTables' => [
                'users' => $database->query('SELECT id, email FROM users ORDER BY id')->fetchAll(PDO::FETCH_ASSOC),
                'products' => $database->query('SELECT id, name FROM products ORDER BY id')->fetchAll(PDO::FETCH_ASSOC),
                'reviews' => $database->query(
                    'SELECT id, product_id, author, comment, created_at FROM reviews ORDER BY id'
                )->fetchAll(PDO::FETCH_ASSOC),
            ],
        ];
    }

    protected function database(): PDO
    {
        $directory = storage_path('framework');

        if (! is_dir($directory) && ! mkdir($directory, 0775, true) && ! is_dir($directory)) {
            throw new \RuntimeException('Unable to create the security-testing database directory.');
        }

        $database = new PDO(
            'sqlite:'.$directory.DIRECTORY_SEPARATOR.'security-testing.sqlite',
            null,
            null,
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
        $database->exec('PRAGMA foreign_keys = ON');
        $database->exec(
            'CREATE TABLE IF NOT EXISTS users (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                email TEXT NOT NULL UNIQUE,
                password_hash TEXT NOT NULL
            )'
        );
        $database->exec(
            'CREATE TABLE IF NOT EXISTS products (
                id INTEGER PRIMARY KEY,
                name TEXT NOT NULL
            )'
        );
        $database->exec(
            'CREATE TABLE IF NOT EXISTS reviews (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                product_id INTEGER NOT NULL,
                author TEXT NOT NULL,
                comment TEXT NOT NULL,
                created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
            )'
        );

        $seedAccount = $database->prepare(
            'INSERT OR IGNORE INTO users (email, password_hash) VALUES (:email, :password_hash)'
        );
        $seedAccount->execute([
            'email' => 'demo@example.test',
            'password_hash' => hash('sha256', 'LabPassword123!'),
        ]);

        $database->exec("INSERT OR IGNORE INTO products (id, name) VALUES (1, 'Kitchen Test Bowl')");

        return $database;
    }

    private function stringInput(mixed $value): string
    {
        return is_string($value) ? $value : '';
    }
}
