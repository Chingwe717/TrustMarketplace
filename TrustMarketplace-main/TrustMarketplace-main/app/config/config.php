<?php
if (!defined('APPROOT')) {
    define('APPROOT', dirname(dirname(__FILE__)));
}

// URL Root: the app runs from the site root in local dev, so avoid using the route path as a base directory.
$requestScheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$requestHost = $_SERVER['HTTP_HOST'] ?? 'localhost';
define('URLROOT', $requestScheme . '://' . $requestHost);

// Site Name
define('SITENAME', 'TrustMarket');

// DB Params
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'trustmarket_db');
