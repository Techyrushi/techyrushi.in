<?php
require_once 'includes/db.php';

try {
    // Create visitor_analytics table
    $sql = "CREATE TABLE IF NOT EXISTS visitor_analytics (
        id INT AUTO_INCREMENT PRIMARY KEY,
        ip_address VARCHAR(45),
        user_agent VARCHAR(255),
        page_url VARCHAR(255),
        browser VARCHAR(50),
        platform VARCHAR(50),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $pdo->exec($sql);
    echo "Table visitor_analytics created or already exists.<br>";

    // Check if data exists
    $stmt = $pdo->query("SELECT COUNT(*) FROM visitor_analytics");
    $count = $stmt->fetchColumn();

    if ($count == 0) {
        echo "Inserting dummy data for analytics...<br>";
        // Insert some dummy data for the last 7 days
        $browsers = ['Chrome', 'Firefox', 'Safari', 'Edge', 'Opera'];
        $platforms = ['Windows', 'Mac', 'Linux', 'Android', 'iOS'];
        
        for ($i = 0; $i < 50; $i++) {
            $days_ago = rand(0, 7);
            $browser = $browsers[array_rand($browsers)];
            $platform = $platforms[array_rand($platforms)];
            $date = date('Y-m-d H:i:s', strtotime("-$days_ago days"));
            
            $stmt = $pdo->prepare("INSERT INTO visitor_analytics (ip_address, browser, platform, created_at) VALUES ('127.0.0.1', :browser, :platform, :created_at)");
            $stmt->execute([
                ':browser' => $browser,
                ':platform' => $platform,
                ':created_at' => $date
            ]);
        }
        echo "Dummy data inserted.<br>";
    } else {
        echo "Data already exists.<br>";
    }

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>