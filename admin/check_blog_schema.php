<?php
require_once 'config.php';
$stmt = $pdo->query("DESCRIBE blog_posts");
$columns = $stmt->fetchAll(PDO::FETCH_COLUMN);
print_r($columns);
?>
