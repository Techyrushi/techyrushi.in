<?php
require_once 'config.php';

try {
    // Events table for Calendar
    $pdo->exec("CREATE TABLE IF NOT EXISTS events (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        start DATETIME NOT NULL,
        end DATETIME,
        class_name VARCHAR(50) DEFAULT 'bg-primary',
        description TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    // Tasks table for Taskboard
    $pdo->exec("CREATE TABLE IF NOT EXISTS tasks (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        description TEXT,
        status VARCHAR(50) DEFAULT 'todo',
        due_date DATE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )");

    // SEO Metadata table
    $pdo->exec("CREATE TABLE IF NOT EXISTS seo_metadata (
        id INT AUTO_INCREMENT PRIMARY KEY,
        route VARCHAR(100) NOT NULL UNIQUE,
        page_title VARCHAR(255),
        meta_keywords TEXT,
        meta_description TEXT,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )");

    // Visitor Analytics table
    $pdo->exec("CREATE TABLE IF NOT EXISTS visitor_analytics (
        id INT AUTO_INCREMENT PRIMARY KEY,
        ip_address VARCHAR(45),
        page_url VARCHAR(255),
        visit_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        user_agent TEXT,
        referrer VARCHAR(255)
    )");

    echo "Tables created successfully.";

} catch (PDOException $e) {
    die("DB Error: " . $e->getMessage());
}
?>