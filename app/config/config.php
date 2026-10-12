<?php
// App Root
define('APPROOT', dirname(dirname(__FILE__)));
// URL Root: derive the app's public base path so local and Apache URLs work.
$requestScheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$requestHost = $_SERVER['HTTP_HOST'] ?? 'localhost';
$scriptName = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '/index.php');
$basePath = rtrim(str_replace('\\', '/', dirname($scriptName)), '/');
if ($basePath === '.' || $basePath === '/') {
	$basePath = '';
}
define('URLROOT', $requestScheme . '://' . $requestHost . $basePath);
// Site Name
define('SITENAME', 'TrustMarket');

// DB Params
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'trustmarket_db');
