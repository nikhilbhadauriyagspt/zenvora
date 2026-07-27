<?php
/**
 * Zenvora Global Solutions - Database Connection Configuration
 */

$host = 'localhost';
$db_name = 'zenvora_db';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8", $username, $password);
    // Enable exceptions on errors
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Fetch records as associative arrays
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // If the database has not been initialized yet, do not block execution of standard pages
    $pdo = null;
}
