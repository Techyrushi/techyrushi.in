<?php
require_once 'config.php';

try {
    // Add is_read column to contact_enquiries if it doesn't exist
    $stmt = $pdo->query("SHOW COLUMNS FROM contact_enquiries LIKE 'is_read'");
    if ($stmt->rowCount() == 0) {
        $pdo->exec("ALTER TABLE contact_enquiries ADD COLUMN is_read TINYINT(1) DEFAULT 0");
        echo "Added is_read column to contact_enquiries.<br>";
    } else {
        echo "Column is_read already exists in contact_enquiries.<br>";
    }

    // Add topic column to appointments if it doesn't exist
    $stmt = $pdo->query("SHOW COLUMNS FROM appointments LIKE 'topic'");
    if ($stmt->rowCount() == 0) {
        $pdo->exec("ALTER TABLE appointments ADD COLUMN topic VARCHAR(200) AFTER phone");
        echo "Added topic column to appointments.<br>";
    } else {
        echo "Column topic already exists in appointments.<br>";
    }

    echo "Schema update completed.";

} catch (PDOException $e) {
    die("DB Error: " . $e->getMessage());
}
?>
