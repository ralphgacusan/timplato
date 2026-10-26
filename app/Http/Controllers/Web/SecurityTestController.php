<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\SecurityLabDatabase;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Throwable;

class SecurityTestController extends Controller
{
    public function signinForm(Request $request): View
    {
        return view('security-testing.signin', [
            'signup' => false,
            'email' => '',
            'query' => null,
            'queryError' => null,
            'identity' => $request->session()->get('security_lab_user'),
            'message' => null,
            'feedback' => null,
            'databasePath' => $this->database()->path(),
        ]);
    }

    public function signin(Request $request): View
    {
        $email = $this->stringInput($request->input('email'));
        $password = $this->stringInput($request->input('password'));
        $query = "SELECT id, name, email FROM users WHERE email = '{$email}' AND password = '{$password}' LIMIT 1";
        $identity = null;
        $queryError = null;
        $feedback = null;
        $database = $this->database();

        try {
            $identity = $database->execute($query);

            if ($identity !== null) {
                $request->session()->put('security_lab_user', $identity);
                $feedback = 'Login successful.';
            } else {
                $request->session()->forget('security_lab_user');
                $feedback = 'Invalid credentials.';
            }
        } catch (Throwable $exception) {
            $request->session()->forget('security_lab_user');
            $queryError = 'The test query failed: '.$exception->getMessage();
            $feedback = 'The SQL statement could not be completed.';
        }

        return view('security-testing.signin', [
            'signup' => false,
            'email' => $email,
            'identity' => $identity,
            'query' => $query,
            'queryError' => $queryError,
            'message' => $feedback,
            'feedback' => $feedback,
            'databasePath' => $database->path(),
        ]);
    }

    public function signupForm(Request $request): View
    {
        return view('security-testing.signin', [
            'signup' => true,
            'email' => '',
            'query' => null,
            'queryError' => null,
            'identity' => $request->session()->get('security_lab_user'),
            'message' => null,
            'feedback' => null,
            'databasePath' => $this->database()->path(),
        ]);
    }

    public function signup(Request $request): View
    {
        $name = $this->stringInput($request->input('name'));
        $email = $this->stringInput($request->input('email'));
        $password = $this->stringInput($request->input('password'));
        $passwordHash = hash('sha256', $password);
        $query = "INSERT INTO users (name, email, password_hash, password) VALUES ('{$name}', '{$email}', '{$passwordHash}', '{$password}')";
        $database = $this->database();
        $identity = null;
        $queryError = null;
        $feedback = null;

        try {
            $database->execute($query);
            $accounts = $database->rows(
                'SELECT id, name, email FROM users WHERE email = :email ORDER BY id DESC LIMIT 1',
                ['email' => $email]
            );
            $identity = $accounts[0] ?? null;

            if ($identity !== null) {
                $request->session()->put('security_lab_user', $identity);
                $feedback = 'Account created. You are now signed in.';
            } else {
                $feedback = 'SQL executed. Check the database viewer for changes.';
            }
        } catch (Throwable $exception) {
            $queryError = 'The test query failed: '.$exception->getMessage();
            $feedback = 'The signup SQL could not be completed.';
        }

        return view('security-testing.signin', [
            'signup' => true,
            'email' => $email,
            'identity' => $identity,
            'query' => $query,
            'queryError' => $queryError,
            'message' => $feedback,
            'feedback' => $feedback,
            'databasePath' => $database->path(),
        ]);
    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->forget('security_lab_user');

        return redirect()->route('security-testing.signin');
    }

    public function products(): View
    {
        $database = $this->database();
        $products = [];
        $queryError = null;

        try {
            $products = array_map(
                $this->withProductImage(...),
                $database->rows('SELECT id, name, description, price, stock, image, category FROM products ORDER BY id')
            );
        } catch (Throwable $exception) {
            $queryError = 'The product query failed: '.$exception->getMessage();
        }

        return view('security-testing.products', [
            'products' => $products,
            'queryError' => $queryError,
            'databasePath' => $database->path(),
        ]);
    }

    public function product(int $id): View
    {
        $database = $this->database();
        $product = null;
        $reviews = [];
        $queryError = null;

        try {
            $products = $database->rows(
                'SELECT id, name, description, price, stock, image, category FROM products WHERE id = :id LIMIT 1',
                ['id' => $id]
            );
            $product = isset($products[0]) ? $this->withProductImage($products[0]) : null;
            $reviews = $database->rows(
                'SELECT id, product_id, author, comment, rating, created_at FROM reviews WHERE product_id = :id ORDER BY id DESC',
                ['id' => $id]
            );
        } catch (Throwable $exception) {
            $queryError = 'The product query failed: '.$exception->getMessage();
        }

        return view('security-testing.reviews', [
            'product' => $product,
            'reviews' => $reviews,
            'queryError' => $queryError,
            'databasePath' => $database->path(),
        ]);
    }

    public function reviews(Request $request): View
    {
        $productId = (int) $request->query('product_id', 1);

        return $this->product($productId);
    }

    public function storeReview(Request $request): RedirectResponse
    {
        $productId = (int) $request->input('product_id', 1);
        $database = $this->database();

        try {
            $database->executePrepared(
                'INSERT INTO reviews (product_id, author, comment, rating) VALUES (:product_id, :author, :comment, :rating)',
                [
                    'product_id' => $productId,
                    'author' => $this->stringInput($request->input('author')),
                    'comment' => $this->stringInput($request->input('comment')),
                    'rating' => (int) $request->input('rating', 5),
                ]
            );
        } catch (Throwable $exception) {
            return redirect()
                ->route($productId === 1 ? 'security-testing.reviews' : 'security-testing.product', $productId === 1 ? [] : ['id' => $productId])
                ->with('feedback', 'The review could not be saved: '.$exception->getMessage());
        }

        return redirect()->route('security-testing.product', ['id' => $productId]);
    }

    public function resetReviews(Request $request): RedirectResponse
    {
        $productId = (int) $request->input('product_id', 1);
        try {
            $this->database()->executePrepared(
                'DELETE FROM reviews WHERE product_id = :product_id',
                ['product_id' => $productId]
            );
        } catch (Throwable $exception) {
            return redirect()
                ->route($productId === 1 ? 'security-testing.reviews' : 'security-testing.product', $productId === 1 ? [] : ['id' => $productId])
                ->with('feedback', 'Reviews could not be reset: '.$exception->getMessage());
        }

        return redirect()->route('security-testing.product', ['id' => $productId]);
    }

    public function databasePage(): View
    {
        $database = $this->database();
        $tables = [];
        $queryError = null;

        try {
            $tables = $database->tables();
        } catch (Throwable $exception) {
            $queryError = 'The database could not be read: '.$exception->getMessage();
        }

        return view('security-testing.database', [
            'databasePath' => $database->path(),
            'databaseTables' => $tables,
            'tables' => $tables,
            'queryError' => $queryError,
            'message' => null,
        ]);
    }

    public function resetDatabase(Request $request): RedirectResponse
    {
        $this->database()->reset();
        $request->session()->forget(['security_lab_user', 'security_lab_cart']);

        return redirect()->route('security-testing.database');
    }

    public function cart(Request $request): View
    {
        return $this->cartView($request, null);
    }

    public function updateCart(Request $request): RedirectResponse|View
    {
        $database = $this->database();
        $cart = $request->session()->get('security_lab_cart', []);
        $cart = is_array($cart) ? $cart : [];
        $productId = (int) $request->input('product_id', 0);
        $quantity = max(1, (int) $request->input('quantity', 1));
        $action = $this->stringInput($request->input('action', 'add'));

        if ($action === 'remove') {
            unset($cart[$productId]);
            $request->session()->put('security_lab_cart', $cart);

            return redirect()->route('security-testing.cart')->with('feedback', 'Item removed from the lab cart.');
        }

        if ($action === 'checkout') {
            return $this->cartView(
                $request,
                $cart === []
                    ? 'Your lab cart is empty. No checkout was started.'
                    : 'Demo checkout complete. No order or payment was created.'
            );
        }

        try {
            $products = $database->rows(
                'SELECT id FROM products WHERE id = :id LIMIT 1',
                ['id' => $productId]
            );
        } catch (Throwable $exception) {
            return $this->cartView($request, 'The cart query failed: '.$exception->getMessage());
        }

        if ($products === []) {
            return redirect()->route('security-testing.cart')->with('feedback', 'That product is not in the lab catalog.');
        }

        $cart[$productId] = max(0, (int) ($cart[$productId] ?? 0)) + $quantity;
        $request->session()->put('security_lab_cart', $cart);

        return redirect()->route('security-testing.cart')->with(
            'feedback',
            $action === 'buy' ? 'Item added to the lab cart for a demo purchase.' : 'Item added to the lab cart.'
        );
    }

    protected function database(): SecurityLabDatabase
    {
        return new SecurityLabDatabase();
    }

    private function cartView(Request $request, ?string $feedback): View
    {
        $database = $this->database();
        $items = [];
        $total = 0.0;
        $queryError = null;
        $cart = $request->session()->get('security_lab_cart', []);
        $cart = is_array($cart) ? $cart : [];

        try {
            foreach ($cart as $productId => $quantity) {
                $rows = $database->rows(
                    'SELECT id, name, description, price, stock, image, category FROM products WHERE id = :id LIMIT 1',
                    ['id' => (int) $productId]
                );

                if ($rows === []) {
                    continue;
                }

                $product = $this->withProductImage($rows[0]);
                $product['quantity'] = max(1, (int) $quantity);
                $product['line_total'] = (float) $product['price'] * $product['quantity'];
                $total += $product['line_total'];
                $items[] = $product;
            }
        } catch (Throwable $exception) {
            $queryError = 'The cart query failed: '.$exception->getMessage();
        }

        return view('security-testing.cart', [
            'items' => $items,
            'total' => $total,
            'queryError' => $queryError,
            'message' => $feedback ?? $request->session()->get('feedback'),
            'feedback' => $feedback ?? $request->session()->get('feedback'),
            'databasePath' => $database->path(),
        ]);
    }

    private function withProductImage(array $product): array
    {
        if ($product['image'] !== '' && ! str_starts_with($product['image'], 'images/products/')) {
            $product['image'] = 'images/products/'.$product['image'];
        }

        return $product;
    }

    private function stringInput(mixed $value): string
    {
        return is_string($value) ? $value : '';
    }
}
