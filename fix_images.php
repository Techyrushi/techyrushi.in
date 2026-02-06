<?php
include 'includes/db.php';
try {
    $pdo->exec("UPDATE testimonials SET image='testi5.jpg' WHERE name='Sneha Reddy'");
    $pdo->exec("UPDATE testimonials SET image='testi4.jpg' WHERE name='Vikram Malhotra'");
    echo "Images corrected.\n";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
