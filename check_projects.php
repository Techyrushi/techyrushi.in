<?php
include 'includes/db.php';

try {
    echo "Checking projects table...\n";
    $stmt = $pdo->query("SELECT * FROM projects LIMIT 5");
    $projects = $stmt->fetchAll();
    echo "Count: " . count($projects) . "\n";
    foreach ($projects as $p) {
        echo "ID: " . $p['id'] . ", Title: " . $p['title'] . ", Slug: " . $p['slug'] . "\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>