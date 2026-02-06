<?php
include 'includes/db.php';

try {
    // Update Testimonials with new Real Images
    $updates = [
        'Aarav Sharma' => 'indian_male_1.jpg',
        'Priya Venkatesh' => 'indian_female_1.jpg',
        'Rajesh Gupta' => 'indian_male_2.jpg',
        'Sneha Reddy' => 'indian_female_2.jpg',
        'Vikram Malhotra' => 'indian_male_3.jpg'
    ];

    $stmt = $pdo->prepare("UPDATE testimonials SET image = ? WHERE name = ?");
    
    foreach ($updates as $name => $image) {
        $stmt->execute([$image, $name]);
        echo "Updated $name to use $image\n";
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
