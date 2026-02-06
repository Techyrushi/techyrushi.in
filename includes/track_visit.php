<?php
// Adjust path to admin/config.php
$config_path = __DIR__ . '/../admin/config.php';
if (file_exists($config_path)) {
    require_once $config_path;
}

if (isset($pdo)) {
    try {
        $ip_address = $_SERVER['REMOTE_ADDR'];
        $page_url = $_SERVER['REQUEST_URI'];
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $referrer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null;

        $stmt = $pdo->prepare("INSERT INTO visitor_analytics (ip_address, page_url, user_agent, referrer) VALUES (?, ?, ?, ?)");
        $stmt->execute([$ip_address, $page_url, $user_agent, $referrer]);
    } catch (Exception $e) {
        // Silently fail to not disrupt user experience
        error_log("Analytics Error: " . $e->getMessage());
    }
}
?>
