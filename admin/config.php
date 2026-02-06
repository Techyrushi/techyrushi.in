<?php
// Define constants for paths if not already defined
if (!defined('ADMIN_PATH')) {
    define('ADMIN_PATH', __DIR__);
}

// Database connection parameters
$db_host = 'localhost';
$db_name = 'techzen_db';
$db_user = 'root';
$db_pass = '';

// Check if running on local development server
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
if ($host == 'localhost:8000') {
    $base_url = "http://localhost:8000/";
    $admin_url = "http://localhost:8000/admin/";
} else {
    $base_url = "http://localhost/techzen/";
    $admin_url = "http://localhost/techzen/admin/";
}

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Log error instead of dying to allow graceful degradation where possible
    error_log("Database connection failed: " . $e->getMessage());
    $pdo = null;
}

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>