<?php
require_once 'config.php';

try {
    $tables = ['events', 'tasks', 'projects', 'services', 'blog_posts'];
    foreach ($tables as $table) {
        $stmt = $pdo->query("SHOW TABLES LIKE '$table'");
        if ($stmt->rowCount() > 0) {
            echo "Table '$table' exists.\n";
            $stmt = $pdo->query("DESCRIBE $table");
            $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);
            echo "Columns: " . implode(", ", $columns) . "\n";
        } else {
            echo "Table '$table' does NOT exist.\n";
        }
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
