<?php
require_once 'config.php';

try {
    // Add tags column to blog_posts if it doesn't exist
    $stmt = $pdo->query("SHOW COLUMNS FROM blog_posts LIKE 'tags'");
    if ($stmt->rowCount() == 0) {
        $pdo->exec("ALTER TABLE blog_posts ADD COLUMN tags VARCHAR(255) DEFAULT NULL AFTER content");
        echo "Column 'tags' added to 'blog_posts' table.<br>";
    } else {
        echo "Column 'tags' already exists in 'blog_posts' table.<br>";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
