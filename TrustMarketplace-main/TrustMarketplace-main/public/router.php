<?php
// Route requests through the front controller when using PHP's built-in server.
$requestPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$publicRoot = realpath(__DIR__);
$filePath = realpath($publicRoot . DIRECTORY_SEPARATOR . ltrim(
    str_replace('/', DIRECTORY_SEPARATOR, rawurldecode($requestPath)),
    DIRECTORY_SEPARATOR
));

if ($filePath !== false && str_starts_with($filePath, $publicRoot . DIRECTORY_SEPARATOR) && is_file($filePath)) {
    return false;
}

$route = trim($requestPath, '/');
if ($route !== '') {
    $_GET['url'] = $route;
}

require __DIR__ . '/index.php';