<?php
require_once __DIR__ . '/../config/config.php';

$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if($mysqli->connect_errno){
	echo "DB connect failed: " . $mysqli->connect_error . "\n";
	exit(1);
}

$sql = "CREATE TABLE IF NOT EXISTS messages (
	id INT AUTO_INCREMENT PRIMARY KEY,
	sender_id INT NOT NULL,
	receiver_id INT NOT NULL,
	message TEXT NOT NULL,
	is_read TINYINT(1) DEFAULT 0,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if($mysqli->query($sql)) echo "messages table ensured.\n";
else echo "Error creating messages: " . $mysqli->error . "\n";

// add kyc_file column to seller_verifications if missing
$sql2 = "ALTER TABLE seller_verifications ADD COLUMN IF NOT EXISTS kyc_file VARCHAR(255) NULL";
// MySQL doesn't support ADD COLUMN IF NOT EXISTS on older versions; guard with information_schema check
$check = $mysqli->query("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA='".DB_NAME."' AND TABLE_NAME='seller_verifications' AND COLUMN_NAME='kyc_file'")->fetch_assoc();
if(!$check){
	if($mysqli->query("ALTER TABLE seller_verifications ADD COLUMN kyc_file VARCHAR(255) NULL")) echo "kyc_file column added.\n";
}

$mysqli->close();
