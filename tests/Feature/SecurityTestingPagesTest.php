<?php

namespace Tests\Feature;

use App\Http\Controllers\Web\SecurityTestController;
use App\Models\User;
use App\Services\SecurityLabDatabase;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

require_once dirname(__DIR__).'/Support/SecurityTestApplication.php';

class SecurityTestingPagesTest extends TestCase
{
    private string $originalStoragePath;

    private string $labStoragePath;

    /** @var list<SecurityLabDatabase> */
    private array $labDatabases = [];

    public function createApplication()
    {
        $app = securityTestApplication();
        $app->make(Kernel::class)->bootstrap();

        return $app;
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->originalStoragePath = $this->app->storagePath();
        $this->labStoragePath = sys_get_temp_dir().DIRECTORY_SEPARATOR.'timplato-security-lab-'.bin2hex(random_bytes(8));
        $this->app->useStoragePath($this->labStoragePath);
        $path = $this->databasePath();
        $trackDatabase = function (SecurityLabDatabase $database): void {
            $this->labDatabases[] = $database;
        };
        $this->app->instance(SecurityTestController::class, new class($path, $trackDatabase) extends SecurityTestController
        {
            public function __construct(private string $path, private \Closure $trackDatabase) {}

            protected function database(): SecurityLabDatabase
            {
                $database = new SecurityLabDatabase($this->path);
                ($this->trackDatabase)($database);

                return $database;
            }
        });
        $this->withServerVariables(['REMOTE_ADDR' => '127.0.0.1']);
        $this->withHeader('Host', 'localhost');
    }

    protected function tearDown(): void
    {
        $connection = new \ReflectionProperty(SecurityLabDatabase::class, 'connection');
        foreach ($this->labDatabases as $database) {
            try {
                $connection->getValue($database)->close();
            } catch (\Throwable) {
                // A reset may already have closed that connection.
            }
        }
        $this->labDatabases = [];
        gc_collect_cycles();

        $this->app->useStoragePath($this->originalStoragePath);
        $this->removeDirectory($this->labStoragePath);

        parent::tearDown();
    }

    public function test_lab_pages_render_the_signin_signup_catalog_and_database_views(): void
    {
        $this->enableLab();

        $this->labGet('/signin-test')
            ->assertOk()
            ->assertSee('SECURITY TESTING ONLY')
            ->assertSee('Sign in to Timplato')
            ->assertSee('name="email"', false)
            ->assertSee('name="password"', false);

        $this->labGet('/signup-test')
            ->assertOk()
            ->assertSee('Create your account')
            ->assertSee('name="name"', false)
            ->assertSee('name="password_confirmation"', false);

        $this->labGet('/products-test')
            ->assertOk()
            ->assertSee('Kitchen essentials')
            ->assertSee('Rice Bowl with Local Designs')
            ->assertSee('Add to cart');

        $this->labGet('/database-test')
            ->assertOk()
            ->assertSee('demo@example.test')
            ->assertSee('users')
            ->assertSee('products')
            ->assertSee('reviews');

        $this->assertFileExists($this->databasePath());
        $this->assertSame($this->databasePath(), $this->labDatabase()->path());
    }

    public function test_lab_signin_uses_its_own_session_and_logout_clears_it(): void
    {
        $this->enableLab();

        $this->postLab('/signin-test', [
            'email' => 'demo@example.test',
            'password' => 'incorrect-password',
        ])->assertOk()->assertSee('Invalid credentials.');
        $this->assertNull(session('security_lab_user'));
        $this->assertGuest();

        $this->postLab('/signin-test', [
            'email' => 'demo@example.test',
            'password' => 'LabPassword123!',
        ])->assertOk()->assertSee('Login successful.');
        $this->assertSame('demo@example.test', data_get(session('security_lab_user'), 'email'));
        $this->assertGuest();

        $this->labGet('/products-test')->assertSee('Hi, Demo User');
        $this->postLab('/logout-test', [])->assertRedirect(route('security-testing.signin'));
        $this->assertNull(session('security_lab_user'));
        $this->assertGuest();
    }

    public function test_lab_signin_demonstrates_boolean_union_and_comment_injection_in_both_fields(): void
    {
        $this->enableLab();

        $attempts = [
            ['email' => "' OR 1=1 -- ", 'password' => 'wrong-password'],
            ['email' => "missing@example.test' OR '1'='1' -- ", 'password' => 'wrong-password'],
            ['email' => 'demo@example.test', 'password' => "' OR '1'='1' -- "],
            ['email' => "' UNION SELECT id, name, email FROM users -- ", 'password' => 'wrong-password'],
            ['email' => 'missing@example.test', 'password' => "' UNION SELECT id, name, email FROM users -- "],
            ['email' => "demo@example.test' -- ", 'password' => 'wrong-password'],
        ];

        foreach ($attempts as $credentials) {
            $this->postLab('/signin-test', $credentials)
                ->assertOk()
                ->assertSee('Login successful.');
            $this->assertSame('demo@example.test', data_get(session('security_lab_user'), 'email'));
            $this->assertGuest();
        }
    }

    public function test_stacked_signin_update_changes_email_and_password_without_reseeding_the_old_account(): void
    {
        $this->enableLab();
        $payload = "demo@example.test'; UPDATE users SET email='updated@example.test', password='UpdatedLabPass123!' WHERE id=1; -- ";

        $this->postLab('/signin-test', [
            'email' => $payload,
            'password' => 'incorrect-password',
        ])->assertOk();

        $database = $this->labDatabase();
        $accounts = $database->rows('SELECT id, email, password FROM users ORDER BY id');
        $this->assertCount(1, $accounts);
        $this->assertSame('updated@example.test', $accounts[0]['email']);
        $this->assertSame('UpdatedLabPass123!', $accounts[0]['password']);

        $this->postLab('/signin-test', [
            'email' => 'demo@example.test',
            'password' => 'LabPassword123!',
        ])->assertOk()->assertSee('Invalid credentials.');
        $this->assertCount(1, $this->labDatabase()->rows('SELECT id FROM users'));

        $this->postLab('/signin-test', [
            'email' => 'updated@example.test',
            'password' => 'UpdatedLabPass123!',
        ])->assertOk()->assertSee('Login successful.');
        $this->assertSame('updated@example.test', data_get(session('security_lab_user'), 'email'));
    }

    public function test_lab_signup_creates_accounts_and_executes_a_stacked_password_update(): void
    {
        $this->enableLab();

        $this->postLab('/signup-test', [
            'name' => 'New Lab User',
            'email' => 'new-user@example.test',
            'password' => 'NewUserPass123!',
            'password_confirmation' => 'NewUserPass123!',
        ])->assertOk()->assertSee('Account created. You are now signed in.');
        $this->assertSame('new-user@example.test', data_get(session('security_lab_user'), 'email'));
        $this->assertCount(1, $this->labDatabase()->rows(
            'SELECT id FROM users WHERE email = :email',
            ['email' => 'new-user@example.test']
        ));

        $this->postLab('/logout-test', []);
        $attackPassword = "attacker-pass'); UPDATE users SET email='signup-updated@example.test', password='SignupUpdated123!' WHERE id=1; -- ";
        $this->postLab('/signup-test', [
            'name' => 'Stacked signup',
            'email' => 'stacked-signup@example.test',
            'password' => $attackPassword,
            'password_confirmation' => $attackPassword,
        ])->assertOk();

        $database = $this->labDatabase();
        $accounts = $database->rows('SELECT id, name, email, password FROM users ORDER BY id');
        $this->assertCount(3, $accounts);
        $this->assertSame('signup-updated@example.test', $accounts[0]['email']);
        $this->assertSame('SignupUpdated123!', $accounts[0]['password']);
        $this->assertSame('stacked-signup@example.test', $accounts[2]['email']);
        $this->assertCount(1, $database->rows('SELECT id FROM users WHERE email = :email', ['email' => 'signup-updated@example.test']));
        $this->assertCount(0, $database->rows('SELECT id FROM users WHERE email = :email', ['email' => 'demo@example.test']));

        $this->postLab('/signin-test', [
            'email' => 'signup-updated@example.test',
            'password' => 'SignupUpdated123!',
        ])->assertOk()->assertSee('Login successful.');
        $this->assertSame('signup-updated@example.test', data_get(session('security_lab_user'), 'email'));
    }

    public function test_stacked_signup_without_a_matching_identity_reports_that_sql_ran(): void
    {
        $this->enableLab();
        $attackName = "Created', 'temp@example.test', 'x', 'temp-password'); UPDATE users SET email='changed@example.test', password='ChangedPass123!' WHERE id=1; -- ";

        $this->postLab('/signup-test', [
            'name' => $attackName,
            'email' => 'requested@example.test',
            'password' => 'RequestedPass123!',
            'password_confirmation' => 'RequestedPass123!',
        ])->assertOk()->assertSee('SQL executed. Check the database viewer for changes.');

        $accounts = $this->labDatabase()->rows('SELECT id, name, email, password FROM users ORDER BY id');
        $this->assertCount(2, $accounts);
        $this->assertSame('changed@example.test', $accounts[0]['email']);
        $this->assertSame('ChangedPass123!', $accounts[0]['password']);
        $this->assertSame('temp@example.test', $accounts[1]['email']);
        $this->assertNull(session('security_lab_user'));
    }

    public function test_lab_has_no_login_throttle_for_repeated_wrong_passwords(): void
    {
        $this->enableLab();

        for ($attempt = 0; $attempt < 12; $attempt++) {
            $this->postLab('/signin-test', [
                'email' => 'demo@example.test',
                'password' => 'wrong-password-'.$attempt,
            ])->assertOk()->assertSee('Invalid credentials.');
        }
    }

    public function test_lab_reviews_persist_raw_per_product_while_the_normal_store_escapes_them(): void
    {
        $this->enableLab();
        $script = '<script>document.documentElement.dataset.labScript="ran";</script>';
        $style = '<style>.review-card{display:none}</style>';
        $handler = '<img src=x onerror="document.documentElement.dataset.labHandler=1">';

        $this->postLab('/review-test', [
            'product_id' => 1,
            'author' => $handler,
            'rating' => 5,
            'comment' => $script,
        ])->assertRedirect('/product-test/1');
        $this->postLab('/review-test', [
            'product_id' => 2,
            'author' => 'Style tester',
            'rating' => 4,
            'comment' => $style,
        ])->assertRedirect('/product-test/2');

        $this->labGet('/product-test/1')
            ->assertOk()
            ->assertSee($script, false)
            ->assertSee($handler, false)
            ->assertDontSee($style, false);
        $this->labGet('/product-test/2')
            ->assertOk()
            ->assertSee($style, false)
            ->assertDontSee($script, false)
            ->assertDontSee($handler, false);

        $this->labGet('/database-test')
            ->assertSee(e($script), false)
            ->assertSee(e($handler), false)
            ->assertDontSee($script, false)
            ->assertDontSee($handler, false);

        $this->assertDatabaseCount('reviews', 0);
        $this->assertDatabaseCount('users', 1);

        $this->actingAs(User::first());
        $this->post('/products/1/reviews', ['rating' => 5, 'comment' => $script])->assertRedirect();
        $this->assertDatabaseHas('reviews', ['comment' => $script, 'rating' => 5]);
        $this->get('/product/1')->assertOk()->assertSee(e($script), false)->assertDontSee($script, false);
        $this->assertCount(2, $this->labDatabase()->rows('SELECT id FROM reviews'));
    }

    public function test_outer_lab_document_uses_an_opaque_sandbox_and_hides_raw_review_markup(): void
    {
        $this->enableLab();
        $payload = '<script>document.documentElement.dataset.labScript="ran";</script>';
        $this->postLab('/review-test', [
            'product_id' => 1,
            'author' => 'Shell check',
            'rating' => 5,
            'comment' => $payload,
        ])->assertRedirect('/product-test/1');

        $this->withoutHeader('X-Security-Lab-Document');
        $response = $this->get('/product-test/1')->assertOk();
        $shell = $response->getContent();
        $httpPolicy = $response->headers->get('Content-Security-Policy');

        $this->assertStringContainsString('sandbox="allow-scripts allow-forms"', $shell);
        $this->assertStringNotContainsString('allow-same-origin', $shell);
        $this->assertStringContainsString("frame-src 'none'", $httpPolicy);
        $this->assertStringContainsString("form-action 'none'", $httpPolicy);
        $this->assertStringContainsString(
            "style-src \${origin}/css/security-testing.css 'unsafe-inline'; img-src \${origin}/images/products/ \${origin}/timplatoLogo/ \${origin}/Assets/ data:",
            $shell
        );
        $this->assertStringContainsString("frame-src 'none'", $shell);
        $this->assertStringNotContainsString("img-src \${origin} ", $shell);
        $this->assertStringNotContainsString("style-src \${origin} 'unsafe-inline'", $shell);
        $this->assertStringContainsString('security-lab:navigate', $shell);
        $this->assertStringContainsString(
            'const allowed = /^\\/(?:signin-test|signup-test|logout-test|products-test|product-test\\/\\d+|review-test(?:\\/reset)?|database-test(?:\\/reset)?|cart-test)$/;',
            $shell
        );
        $this->assertStringNotContainsString($payload, $shell);
    }

    public function test_cart_can_add_remove_and_complete_a_disposable_checkout(): void
    {
        $this->enableLab();

        $this->postLab('/cart-test', ['action' => 'add', 'product_id' => 1, 'quantity' => 2])
            ->assertRedirect('/cart-test');
        $this->labGet('/cart-test')
            ->assertOk()
            ->assertSee('Rice Bowl with Local Designs')
            ->assertSee('2');

        $this->postLab('/cart-test', ['action' => 'remove', 'product_id' => 1, 'quantity' => 1])
            ->assertRedirect('/cart-test');
        $this->labGet('/cart-test')->assertOk()->assertSee('Your cart is waiting for something lovely.');

        $this->postLab('/cart-test', ['action' => 'add', 'product_id' => 2, 'quantity' => 1]);
        $this->postLab('/cart-test', ['action' => 'checkout'])
            ->assertOk()
            ->assertSee('Demo checkout complete. No order or payment was created.');
        $this->labGet('/cart-test')->assertSee('12-Inch Silicone Tip Food Tongs');
        $this->assertGuest();
    }

    public function test_database_view_includes_empty_and_custom_tables_and_escapes_cell_values(): void
    {
        $this->enableLab();
        $database = $this->labDatabase();
        $database->execute('CREATE TABLE training_empty (entry_id INTEGER PRIMARY KEY, note TEXT)');
        $database->execute('CREATE TABLE custom_records (record_id INTEGER PRIMARY KEY, payload TEXT)');
        $database->executePrepared(
            'INSERT INTO custom_records (record_id, payload) VALUES (:id, :payload)',
            ['id' => 1, 'payload' => '<script>custom table</script>']
        );

        $this->labGet('/database-test')
            ->assertOk()
            ->assertSee('training_empty')
            ->assertSee('entry_id')
            ->assertSee('This table is empty. Its schema is shown above.')
            ->assertSee('custom_records')
            ->assertSee('record_id')
            ->assertSee('&lt;script&gt;custom table&lt;/script&gt;', false)
            ->assertDontSee('<script>custom table</script>', false);
    }

    public function test_database_reset_recovers_after_a_table_is_dropped_and_clears_lab_session(): void
    {
        $this->enableLab();
        $this->postLab('/signin-test', [
            'email' => 'demo@example.test',
            'password' => 'LabPassword123!',
        ]);
        $this->postLab('/cart-test', ['action' => 'add', 'product_id' => 1, 'quantity' => 1]);
        $this->labDatabase()->execute('DROP TABLE users');
        $this->closeLabDatabases();

        $this->postLab('/database-test/reset', [])->assertRedirect('/database-test');
        $this->assertNull(session('security_lab_user'));
        $this->assertNull(session('security_lab_cart'));
        $this->labGet('/database-test')
            ->assertOk()
            ->assertSee('demo@example.test')
            ->assertSee('users')
            ->assertSee('products')
            ->assertSee('reviews');
    }

    public function test_sqlite_denies_file_escape_and_extension_loading_operations(): void
    {
        $database = $this->labDatabase();
        $externalFiles = [
            'attached.sqlite',
            'vacuum-copy.sqlite',
            'extension-output.sqlite',
        ];
        $paths = array_map(fn (string $file) => $this->labStoragePath.DIRECTORY_SEPARATOR.'framework'.DIRECTORY_SEPARATOR.$file, $externalFiles);
        $statements = [
            "ATTACH DATABASE '{$paths[0]}' AS external_db",
            "VACUUM INTO '{$paths[1]}'",
            'PRAGMA writable_schema = ON',
            "SELECT load_extension('{$paths[2]}')",
        ];

        foreach ($statements as $statement) {
            try {
                $database->execute($statement);
                $this->fail('Expected SQLite to deny: '.$statement);
            } catch (\Throwable $exception) {
                $this->assertNotSame('', $exception->getMessage());
            }
        }

        foreach ($paths as $path) {
            $this->assertFileDoesNotExist($path);
        }
    }

    public function test_every_lab_route_fails_closed_when_disabled_in_production_from_a_remote_host(): void
    {
        config(['security_testing.enabled' => false]);
        $this->app->instance('env', 'production');
        $this->withServerVariables(['REMOTE_ADDR' => '192.0.2.1']);
        $this->withHeader('Host', 'example.com');
        $this->withSession(['_token' => 'lab-test-token']);

        foreach ([
            '/signin-test', '/signup-test', '/products-test', '/product-test/1',
            '/review-test', '/database-test', '/cart-test',
        ] as $path) {
            $this->get('http://example.com'.$path)->assertNotFound();
        }

        foreach ([
            '/signin-test', '/signup-test', '/logout-test', '/review-test',
            '/review-test/reset', '/database-test/reset', '/cart-test',
        ] as $path) {
            $this->post('http://example.com'.$path, ['_token' => 'lab-test-token'])->assertNotFound();
        }

        $this->assertDatabaseCount('users', 1);
        $this->assertDatabaseCount('reviews', 0);
        $this->assertFileDoesNotExist($this->databasePath());
    }

    public function test_normal_signin_and_reviews_remain_bound_validated_and_isolated(): void
    {
        $user = User::firstOrFail();
        $payload = '<script>alert("normal storefront")</script>';

        $this->post('/signin', ['email' => "' OR 1=1 -- ", 'password' => 'incorrect-password'])
            ->assertSessionHasErrors('email');
        $this->assertGuest();

        DB::enableQueryLog();
        $this->post('/signin', ['email' => $user->email, 'password' => "' OR '1'='1' -- "])
            ->assertSessionHasErrors('email');
        $queries = DB::getQueryLog();
        DB::disableQueryLog();
        $this->assertGuest();
        $userQueries = array_filter($queries, fn (array $query) => str_contains($query['query'], '"users"'));
        $this->assertNotEmpty($userQueries);
        $query = array_values($userQueries)[0];
        $this->assertStringContainsString('?', $query['query']);
        $this->assertContains($user->email, $query['bindings']);
        $this->assertNotContains("' OR '1'='1' -- ", $query['bindings']);

        $this->post('/signin', ['email' => $user->email, 'password' => 'LabPassword123!'])
            ->assertRedirect('/');
        $this->assertAuthenticatedAs($user);

        $this->post('/products/1/reviews', ['rating' => 5, 'comment' => $payload])->assertRedirect();
        $this->assertDatabaseHas('reviews', ['comment' => $payload, 'rating' => 5]);
        $this->get('/product/1')->assertOk()->assertSee(e($payload), false)->assertDontSee($payload, false);

        config(['security_testing.enabled' => true]);
        $this->postLab('/review-test', [
            'product_id' => 1,
            'author' => 'Lab-only review',
            'rating' => 5,
            'comment' => 'Disposable lab row',
        ])->assertRedirect('/product-test/1');
        $this->assertDatabaseCount('users', 1);
        $this->assertDatabaseCount('reviews', 1);
        $this->assertCount(1, $this->labDatabase()->rows('SELECT id FROM reviews'));
        $this->assertFileExists($this->databasePath());
    }

    private function enableLab(): void
    {
        config(['security_testing.enabled' => true]);
    }

    private function labGet(string $uri)
    {
        return $this->withHeader('X-Security-Lab-Document', '1')->get($uri);
    }

    private function postLab(string $uri, array $data)
    {
        return $this->withHeader('X-Security-Lab-Document', '1')->post($uri, $data);
    }

    private function databasePath(): string
    {
        return $this->labStoragePath.DIRECTORY_SEPARATOR.'framework'.DIRECTORY_SEPARATOR.'security-testing.sqlite';
    }

    private function labDatabase(): SecurityLabDatabase
    {
        $database = new SecurityLabDatabase($this->databasePath());
        $this->labDatabases[] = $database;

        return $database;
    }

    private function closeLabDatabases(): void
    {
        $connection = new \ReflectionProperty(SecurityLabDatabase::class, 'connection');
        foreach ($this->labDatabases as $database) {
            try {
                $connection->getValue($database)->close();
            } catch (\Throwable) {
                // A reset may already have closed that connection.
            }
        }
        $this->labDatabases = [];
        gc_collect_cycles();
    }

    private function removeDirectory(string $path): void
    {
        if (! is_dir($path)) {
            return;
        }

        foreach (new \FilesystemIterator($path) as $entry) {
            if ($entry->isDir() && ! $entry->isLink()) {
                $this->removeDirectory($entry->getPathname());
            } else {
                unlink($entry->getPathname());
            }
        }

        rmdir($path);
    }
}
