<?php
include 'includes/db.php';

echo "Tasks Table:\n";
$stmt = $pdo->query("DESCRIBE tasks");
$columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
print_r($columns);

echo "\nEvents Table:\n";
$stmt = $pdo->query("DESCRIBE events");
$columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
print_r($columns);

echo "\nAppointments Table:\n";
$stmt = $pdo->query("DESCRIBE appointments");
$columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
print_r($columns);
?>