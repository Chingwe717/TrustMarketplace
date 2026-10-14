<?php
$requestPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$publicRoot = __DIR__ . DIRECTORY_SEPARATOR . 'public';
$relativePath = ltrim(str_replace('/', DIRECTORY_SEPARATOR, rawurldecode($requestPath)), DIRECTORY_SEPARATOR);
$targetPath = $publicRoot . DIRECTORY_SEPARATOR . $relativePath;

if ($requestPath !== '/' && is_file($targetPath)) {
    return false;
}

$route = trim($requestPath, '/');
if ($route !== '') {
    $_GET['url'] = $route;
}

require $publicRoot . DIRECTORY_SEPARATOR . 'index.php';
