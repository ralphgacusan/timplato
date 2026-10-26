<?php

// Dedicated fixture bootstrap: never opens the database configured in .env.
function securityTestApplication(string $environment = 'testing', bool $enabled = false)
{
    $root = dirname(__DIR__, 2);
    foreach (['APP_CONFIG_CACHE' => $root.'/storage/framework/security-testing-no-config.php',
        'APP_ROUTES_CACHE' => $root.'/storage/framework/security-testing-no-routes.php'] as $key => $value) {
        putenv("$key=$value");
        $_ENV[$key] = $_SERVER[$key] = $value;
    }

    $app = require $root.'/bootstrap/app.php';
    $app->instance('security-testing.fixture', true);
    $app->useEnvironmentPath(__DIR__)->loadEnvironmentFrom('security-testing.env');
    $app->afterBootstrapping(\Illuminate\Foundation\Bootstrap\LoadConfiguration::class,
        function ($app) use ($environment, $enabled) {
            $fixtureDatabase = $app->basePath('storage/framework/security-testing-original.sqlite');
            if ($environment === 'local' && ! is_file($fixtureDatabase)) {
                touch($fixtureDatabase);
            }
            $app['config']->set([
                'app.env' => $environment,
                'app.key' => 'base64:'.base64_encode(str_repeat('L', 32)),
                'app.debug' => false,
                'app.url' => 'http://127.0.0.1:8765',
                'database.default' => 'sqlite',
                'database.connections.sqlite.url' => null,
                'database.connections.sqlite.database' => $environment === 'local' ? $fixtureDatabase : ':memory:',
                'session.driver' => $environment === 'testing' ? 'array' : 'file',
                'session.cookie' => 'timplato_security_lab_session',
                'session.secure' => false,
                'cache.default' => $environment === 'local' ? 'file' : 'array',
                'cache.prefix' => 'timplato-security-fixture-cache-',
                'cache.stores.file.path' => $app->basePath('storage/framework/cache/security-testing/data'),
                'cache.stores.file.lock_path' => $app->basePath('storage/framework/cache/security-testing/locks'),
                'queue.default' => 'sync',
                'mail.default' => 'array',
                'security_testing.enabled' => $enabled,
            ]);
            $app->instance('env', $environment);
        });
    $app->booting(function () use ($root, $environment) {
        // Build only the tables used by signin, catalog, reviews and layout.
        // Do not run the unrelated, currently conflicting order migrations.
        foreach (['users', 'categories', 'products', 'product_images', 'carts',
            'cart_items', 'wishlists', 'reviews', 'notifications', 'settings', 'pages', 'banners'] as $table) {
            if ($environment === 'local' && \Illuminate\Support\Facades\Schema::hasTable($table)) {
                continue;
            }
            $files = glob($root.'/database/migrations/*create_'.$table.'_table.php');
            (require $files[0])->up();
        }
    });
    $app->booted(function () {
        \App\Models\User::firstOrCreate(['email' => 'safe@example.test'], [
            'first_name' => 'Disposable', 'last_name' => 'Tester',
            'email' => 'safe@example.test', 'password' => 'LabPassword123!', 'role' => 'user',
        ]);
        $category = \App\Models\Category::firstOrCreate(['name' => 'Test Kitchen']);
        \App\Models\Product::firstOrCreate(['name' => 'Kitchen Test Bowl'], [
            'name' => 'Kitchen Test Bowl', 'description' => 'Disposable security test product',
            'price' => 10, 'stock_quantity' => 5, 'category_id' => $category->category_id,
        ]);
    });

    return $app;
}
