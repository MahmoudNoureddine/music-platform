<?php
require '../config/database.php'; // Include the database configuration

try {
    // Attempt to run a query
    $query = $pdo->query("SHOW TABLES");

    // If successful, fetch and display the results
    $tables = $query->fetchAll(PDO::FETCH_COLUMN);
    echo "Database connection successful!<br>";
    echo "Tables in the database:<br>";
    foreach ($tables as $table) {
        echo "- $table<br>";
    }
} catch (PDOException $e) {
    // Handle errors
    echo "Connection failed: " . $e->getMessage();
}
?>
