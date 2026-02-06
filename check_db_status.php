<?php
include 'includes/db.php';

// Check if visitor_analytics table exists
$tableExists = false;
try {
    $result = $pdo->query("SELECT 1 FROM visitor_analytics LIMIT 1");
    $tableExists = true;
} catch (Exception $e) {
    $tableExists = false;
}

if ($tableExists) {
    echo "Table visitor_analytics exists.\n";
    $stmt = $pdo->query("SELECT COUNT(*) FROM visitor_analytics");
    echo "Count: " . $stmt->fetchColumn() . "\n";
} else {
    echo "Table visitor_analytics does NOT exist.\n";
}

// Check services content
$stmt = $pdo->query("SELECT id, title, content FROM services LIMIT 1");
$service = $stmt->fetch(PDO::FETCH_ASSOC);
if ($service) {
    echo "Service Sample Content (ID: {$service['id']}, Title: {$service['title']}):\n";
    echo substr(strip_tags($service['content']), 0, 200) . "...\n";
} else {
    echo "No services found.\n";
}
?>