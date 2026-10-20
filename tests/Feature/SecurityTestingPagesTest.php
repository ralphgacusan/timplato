<?php

namespace Tests\Feature;

use App\Http\Controllers\Web\SecurityTestController;
use App\Models\User;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\DB;
use PDO;
use Tests\TestCase;

require_once dirname(__DIR__).'/Support/SecurityTestApplication.php';

class SecurityTestingPagesTest extends TestCase
{
    public function createApplication()
    {
        $app = securityTestApplication();
        $app->make(Kernel::class)->bootstrap();

        return $app;
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->withServerVariables(['REMOTE_ADDR' => '127.0.0.1']);
        $this->withHeader('Host', 'localhost');
        $pdo = new PDO('sqlite::memory:', null, null, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        $pdo->exec('CREATE TABLE users (id INTEGER PRIMARY KEY, email TEXT, password_hash TEXT);
            CREATE TABLE products (id INTEGER PRIMARY KEY, name TEXT);
            CREATE TABLE reviews (id INTEGER PRIMARY KEY, product_id INTEGER, author TEXT, comment TEXT, created_at TEXT DEFAULT CURRENT_TIMESTAMP);
            INSERT INTO products VALUES (1, "Kitchen Test Bowl")');
        $pdo->prepare('INSERT INTO users VALUES (1, ?, ?)')->execute(['demo@example.test', hash('sha256', 'LabPassword123!')]);
        $this->app->instance(SecurityTestController::class, new class($pdo) extends SecurityTestController
        {
            public function __construct(private PDO $pdo) {}

            protected function database(): PDO
            {
                $this->pdo->exec('PRAGMA query_only = OFF');

                return $this->pdo;
            }
        });
    }

    private function enableLab(): void
    {
        config(['security_testing.enabled' => true]);
    }

    public function test_both_pages_keep_the_banner_and_show_the_lab_database_below_the_form(): void
    {
        $this->enableLab();

        foreach (['/signin-test' => 'password', '/review-test' => 'comment'] as $path => $field) {
            $this->get($path)
                ->assertOk()
                ->assertSee('SECURITY TESTING ONLY')
                ->assertSeeInOrder(['name="'.$field.'"', 'Database file:', '<td>demo@example.test</td>'], false)
                ->assertSee('<td>Kitchen Test Bowl</td>', false);
        }

        $this->get('/signin-test')
            ->assertSee('>Login</button>', false)
            ->assertSee('name="email" type="text"', false)
            ->assertDontSee('Run test query');
    }

    public function test_all_lab_routes_fail_closed_when_disabled_even_in_production_from_a_remote_host(): void
    {
        config(['security_testing.enabled' => false]);
        $this->app->instance('env', 'production');
        $this->withServerVariables(['REMOTE_ADDR' => '192.0.2.1']);
        $this->withHeader('Host', 'example.com');
        $this->withSession(['_token' => 'lab-test-token']);

        foreach (['/signin-test', '/review-test'] as $path) {
            $this->get('http://example.com'.$path)->assertNotFound();
            $this->post('http://example.com'.$path, ['_token' => 'lab-test-token'])->assertNotFound();
        }
        $this->post('http://example.com/review-test/reset', ['_token' => 'lab-test-token'])->assertNotFound();
    }

    public function test_enabled_lab_routes_work_in_production_from_a_remote_host_without_fixture_marker(): void
    {
        $this->enableLab();
        $this->app->forgetInstance('security-testing.fixture');
        $this->app->instance('env', 'production');
        $this->withServerVariables(['REMOTE_ADDR' => '192.0.2.1']);
        $this->withHeader('Host', 'example.com');
        $this->withSession(['_token' => 'lab-test-token']);

        $usersBefore = DB::table('users')->orderBy('id')->get()->toArray();
        $reviewsBefore = DB::table('reviews')->orderBy('id')->get()->toArray();

        $this->get('http://example.com/signin-test')
            ->assertOk()
            ->assertSee('SECURITY TESTING ONLY');
        $this->get('http://example.com/review-test')
            ->assertOk()
            ->assertSee('SECURITY TESTING ONLY');
        $this->post('http://example.com/signin-test', [
            '_token' => 'lab-test-token',
            'email' => 'demo@example.test',
            'password' => 'LabPassword123!',
        ])
            ->assertOk()
            ->assertSee('Matched account: #1 — demo@example.test');
        $this->post('http://example.com/review-test', [
            '_token' => 'lab-test-token',
            'author' => 'Remote tester',
            'comment' => 'Disposable lab review',
        ])->assertRedirect('/review-test');
        $this->post('http://example.com/review-test/reset', ['_token' => 'lab-test-token'])
            ->assertRedirect('/review-test');

        $this->assertEquals($usersBefore, DB::table('users')->orderBy('id')->get()->toArray());
        $this->assertEquals($reviewsBefore, DB::table('reviews')->orderBy('id')->get()->toArray());
        $this->assertGuest();
    }

    public function test_enabled_lab_routes_work_from_ipv6_loopback(): void
    {
        $this->enableLab();
        $this->withServerVariables(['REMOTE_ADDR' => '::1']);
        $this->get('http://[::1]/signin-test')->assertOk();
    }

    public function test_lab_creates_and_persists_its_own_sqlite_file(): void
    {
        $this->enableLab();
        $originalStorage = $this->app->storagePath();
        $temporaryStorage = $originalStorage.'/framework/lab-storage-'.bin2hex(random_bytes(8));
        $databaseFile = $temporaryStorage.'/framework/security-testing.sqlite';
        $this->app->useStoragePath($temporaryStorage);
        $this->app->instance(SecurityTestController::class, new SecurityTestController);

        try {
            $this->get('/signin-test')->assertOk()->assertSee('demo@example.test');
            $this->assertFileExists($databaseFile);
            $this->post('/review-test', ['author' => 'File tester', 'comment' => 'Persisted lab review'])
                ->assertRedirect('/review-test');
            $this->get('/review-test')->assertOk()->assertSee('Persisted lab review');
            $this->assertDatabaseCount('reviews', 0);
            $this->assertDatabaseMissing('users', ['email' => 'demo@example.test']);
        } finally {
            $this->app->useStoragePath($originalStorage);
            if (is_file($databaseFile)) {
                unlink($databaseFile);
            }
            if (is_dir($temporaryStorage.'/framework')) {
                rmdir($temporaryStorage.'/framework');
            }
            if (is_dir($temporaryStorage)) {
                rmdir($temporaryStorage);
            }
        }
    }

    public function test_sql_signin_uses_the_read_only_vulnerable_fixture_and_shows_its_data(): void
    {
        $this->enableLab();

        $this->get('/signin-test')
            ->assertOk()
            ->assertSee('demo@example.test')
            ->assertSee('Kitchen Test Bowl')
            ->assertSee('<td>demo@example.test</td>', false)
            ->assertSee('<td>Kitchen Test Bowl</td>', false)
            ->assertDontSee('id="login-result-dialog"', false)
            ->assertSee(storage_path('framework/security-testing.sqlite'));

        $this->post('/signin-test', ['email' => 'demo@example.test', 'password' => 'wrong-password'])
            ->assertOk()
            ->assertSee('Login failed')
            ->assertSee('Okay')
            ->assertSee('No account matched this query.');
        $this->post('/signin-test', ['email' => 'demo@example.test', 'password' => 'LabPassword123!'])
            ->assertOk()
            ->assertSee('Login successful')
            ->assertSee('Matched account: #1 — demo@example.test');
        $this->post('/signin-test', ['email' => "' OR 1=1 -- ", 'password' => 'wrong-password'])
            ->assertOk()
            ->assertSee('Login successful')
            ->assertSee('Matched account: #1 — demo@example.test');

        $this->post('/signin-test', ['email' => "'", 'password' => 'wrong-password'])
            ->assertOk()
            ->assertSee('Unable to log in')
            ->assertDontSee('Login successful');

        $this->assertGuest();
        $this->assertDatabaseCount('users', 1);
        $this->assertDatabaseMissing('users', ['email' => 'demo@example.test']);
    }

    public function test_normal_signin_rejects_injection_and_still_accepts_valid_credentials(): void
    {
        $this->post('/signin', ['email' => "' OR 1=1 -- ", 'password' => 'wrong-password'])
            ->assertSessionHasErrors('email');
        $this->assertGuest();
        DB::enableQueryLog();
        $this->post('/signin', ['email' => 'safe@example.test', 'password' => "' OR 1=1 -- "])
            ->assertSessionHasErrors('email');
        $this->assertGuest();
        $userQueries = array_filter(DB::getQueryLog(), fn ($query) => str_contains($query['query'], '"users"'));
        $this->assertNotEmpty($userQueries);
        $this->assertContains('safe@example.test', array_values($userQueries)[0]['bindings']);
        $this->post('/signin', ['email' => 'safe@example.test', 'password' => 'LabPassword123!'])
            ->assertRedirect('/');
        $this->assertAuthenticated();
    }

    public function test_lab_reviews_store_raw_html_but_normal_reviews_escape_it(): void
    {
        $this->enableLab();
        $payload = '<script>alert("Timplato XSS test")</script>';
        $this->post('/review-test', ['author' => '<b>Tester</b>', 'comment' => $payload])
            ->assertRedirect('/review-test');
        $this->get('/review-test')->assertOk()->assertSee($payload, false)->assertSee('&lt;b&gt;Tester&lt;/b&gt;', false);
        $this->get('/signin-test')
            ->assertOk()
            ->assertSee('Kitchen Test Bowl')
            ->assertSee(e($payload), false)
            ->assertDontSee($payload, false);
        $this->assertGuest();
        $this->assertDatabaseCount('reviews', 0);
        $this->actingAs(User::first());
        $this->post('/products/1/reviews', ['rating' => 5, 'comment' => $payload])->assertRedirect();
        $this->assertDatabaseHas('reviews', ['comment' => $payload, 'rating' => 5]);
        $this->get('/product/1')->assertOk()->assertSee(e($payload), false)->assertDontSee($payload, false);
    }

    public function test_lab_accepts_empty_review_and_reset_does_not_touch_normal_reviews(): void
    {
        $this->enableLab();
        $this->post('/review-test', ['comment' => 'Disposable review'])->assertRedirect('/review-test');
        $this->post('/review-test', [])->assertRedirect('/review-test');
        $this->post('/review-test/reset')->assertRedirect('/review-test');
        $this->get('/review-test')->assertSee('No reviews yet. Be the first to review this product!');
        $this->assertDatabaseCount('reviews', 0);
    }

    public function test_normal_pages_and_review_validation_remain_available(): void
    {
        foreach (['/signin', '/signup', '/products', '/product/1', '/'] as $path) {
            $this->get($path)->assertOk();
        }
        $this->post('/products/1/reviews', ['rating' => 5])->assertRedirect('/signin');
        $this->actingAs(User::first());
        $this->post('/products/1/reviews', ['rating' => 9, 'comment' => str_repeat('a', 1001)])
            ->assertSessionHasErrors(['rating', 'comment']);
        $this->assertDatabaseCount('reviews', 0);
        $this->post('/signup', [])->assertSessionHasErrors(['first_name', 'last_name', 'email', 'password']);
    }
}
