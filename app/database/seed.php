<?php
require_once __DIR__ . '/../config/config.php';

$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if($mysqli->connect_errno){
	echo "Failed to connect to MySQL: " . $mysqli->connect_error . "\n";
	exit(1);
}

// Minimal seeding: 1 seller, 1 buyer, 2 products
$password = password_hash('password123', PASSWORD_DEFAULT);

// Clear tables (careful)
$mysqli->query("SET FOREIGN_KEY_CHECKS=0;");
$mysqli->query("TRUNCATE TABLE escrows;");
$mysqli->query("TRUNCATE TABLE disputes;");
$mysqli->query("TRUNCATE TABLE orders;");
$mysqli->query("TRUNCATE TABLE products;");
$mysqli->query("TRUNCATE TABLE users;");
$mysqli->query("TRUNCATE TABLE trust_scores;");
$mysqli->query("SET FOREIGN_KEY_CHECKS=1;");

// Insert seller
$stmt = $mysqli->prepare("INSERT INTO users (name, email, password_hash, role, verified) VALUES (?, ?, ?, 'seller', 1)");
$name = 'Agri Seller'; $email = 'seller@example.com'; $stmt->bind_param('sss', $name, $email, $password); $stmt->execute();
$seller_id = $mysqli->insert_id;

// Insert buyer
$stmt = $mysqli->prepare("INSERT INTO users (name, email, password_hash, role, verified) VALUES (?, ?, ?, 'buyer', 1)");
$name = 'Buyer One'; $email = 'buyer@example.com'; $stmt->bind_param('sss', $name, $email, $password); $stmt->execute();
$buyer_id = $mysqli->insert_id;

// Insert products
$stmt = $mysqli->prepare("INSERT INTO products (seller_id, title, description, price, category, stock, images) VALUES (?, ?, ?, ?, ?, ?, ?)");
$imgJson = json_encode(['uploads/sample1.jpg']);
$p1 = ['Fresh Maize', 'High quality maize, 50kg bags', 1200.00, 'Agriculture', 20, $imgJson];
$stmt->bind_param('issdiss', $seller_id, $p1[0], $p1[1], $p1[2], $p1[3], $p1[4], $p1[5]);
$stmt->execute();
$p2 = ['Fertilizer Bag', 'NPK fertilizer 50kg', 450.00, 'Agriculture', 50, json_encode(['uploads/sample2.jpg'])];
$stmt->bind_param('issdiss', $seller_id, $p2[0], $p2[1], $p2[2], $p2[3], $p2[4], $p2[5]);
$stmt->execute();

echo "Seeding completed. Seller ID: $seller_id, Buyer ID: $buyer_id\n";

$mysqli->close();
