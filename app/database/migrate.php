<?php
require_once __DIR__ . '/../config/config.php';

$sqlFile = __DIR__ . '/schema.sql';
if(!file_exists($sqlFile)){
	echo "schema.sql not found at $sqlFile\n";
	exit(1);
}

$sql = file_get_contents($sqlFile);

$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS);
if($mysqli->connect_errno){
	echo "Failed to connect to MySQL: " . $mysqli->connect_error . "\n";
	exit(1);
}

// Execute multi-statement SQL
if ($mysqli->multi_query($sql)) {
	do {
		if ($res = $mysqli->store_result()) {
			$res->free();
		}
	} while ($mysqli->more_results() && $mysqli->next_result());
	echo "Database migrations executed successfully.\n";
} else {
	echo "Error executing migrations: " . $mysqli->error . "\n";
}

$mysqli->close();
