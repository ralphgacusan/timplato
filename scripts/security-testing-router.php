<?php

// Run ONLY with: php -S 127.0.0.1:8765 -t public scripts/security-testing-router.php
if (PHP_SAPI !== 'cli-server' || ! in_array($_SERVER['REMOTE_ADDR'] ?? '', ['127.0.0.1', '::1'], true)) {
    http_response_code(404);
    exit;
}

$root = dirname(__DIR__);
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$file = realpath($root.'/public/'.$path);
$public = realpath($root.'/public').DIRECTORY_SEPARATOR;
if ($file && str_starts_with($file, $public) && is_file($file)
    && in_array(strtolower(pathinfo($file, PATHINFO_EXTENSION)), ['css', 'js', 'png', 'jpg', 'jpeg', 'webp', 'svg', 'ico', 'woff', 'woff2'], true)) {
    return false;
}

require $root.'/vendor/autoload.php';
require $root.'/tests/Support/SecurityTestApplication.php';
$app = securityTestApplication('local', getenv('SECURITY_TESTING_ENABLED') === 'true');
$app->handleRequest(\Illuminate\Http\Request::capture());
