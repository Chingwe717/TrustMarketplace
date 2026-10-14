<?php
require_once __DIR__ . '/../config/config.php';

$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if($mysqli->connect_errno){
	echo "DB connect failed: " . $mysqli->connect_error . "\n";
	exit(1);
}

$sql = "CREATE TABLE IF NOT EXISTS seller_verifications (
	user_id INT PRIMARY KEY,
	status ENUM('unverified','pending','verified','rejected') DEFAULT 'unverified',
	requested_at TIMESTAMP NULL,
	verified_at TIMESTAMP NULL,
	expires_at TIMESTAMP NULL,
	notes TEXT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if($mysqli->query($sql)) echo "seller_verifications table ensured.\n";
else echo "Error creating seller_verifications: " . $mysqli->error . "\n";

$mysqli->close();
