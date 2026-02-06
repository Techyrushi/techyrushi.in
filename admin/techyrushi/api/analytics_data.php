<?php
header('Content-Type: application/json');
require_once '../../config.php';

try {
    $response = [
        'daily_visits' => [],
        'browser_stats' => [],
        'total_visits' => 0
    ];

    // Total visits
    $stmt = $pdo->query("SELECT COUNT(*) FROM visitor_analytics");
    $response['total_visits'] = $stmt->fetchColumn();

    // Daily visits (last 7 days)
    $stmt = $pdo->query("
        SELECT DATE(visit_time) as date, COUNT(*) as count 
        FROM visitor_analytics 
        WHERE visit_time >= DATE_SUB(CURDATE(), INTERVAL 6 DAY)
        GROUP BY DATE(visit_time) 
        ORDER BY date ASC
    ");
    $response['daily_visits'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Browser stats (simplified from user_agent)
    // In a real app, we'd use a parser. Here we'll just do simple LIKE checks or just group by user_agent if not too many
    // Let's try to extract common browsers with SQL if possible, or just send raw user_agent counts and let JS parse (or just show raw top 5)
    
    // For simplicity, let's just group by user_agent string limited to 50 chars or similar
    // Or better, let's just return top 5 user agents
    $stmt = $pdo->query("
        SELECT user_agent, COUNT(*) as count 
        FROM visitor_analytics 
        GROUP BY user_agent 
        ORDER BY count DESC 
        LIMIT 5
    ");
    $browsers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Simple JS-side parsing is better, but let's try to make it cleaner here
    $clean_browsers = [];
    foreach ($browsers as $b) {
        $agent = $b['user_agent'];
        $name = 'Other';
        if (strpos($agent, 'Chrome') !== false) $name = 'Chrome';
        elseif (strpos($agent, 'Firefox') !== false) $name = 'Firefox';
        elseif (strpos($agent, 'Safari') !== false) $name = 'Safari';
        elseif (strpos($agent, 'Edge') !== false) $name = 'Edge';
        
        if (isset($clean_browsers[$name])) {
            $clean_browsers[$name] += $b['count'];
        } else {
            $clean_browsers[$name] = $b['count'];
        }
    }
    
    // Format for Morris Donut: {label: "Name", value: 123}
    foreach ($clean_browsers as $name => $count) {
        $response['browser_stats'][] = ['label' => $name, 'value' => $count];
    }

    // Engagement Stats (Enquiries vs Appointments) - Last 6 Months
    $stmt = $pdo->query("
        SELECT DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as count 
        FROM contact_enquiries 
        WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
        GROUP BY DATE_FORMAT(created_at, '%Y-%m')
        ORDER BY month ASC
    ");
    $enquiries = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

    $stmt = $pdo->query("
        SELECT DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as count 
        FROM appointments 
        WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
        GROUP BY DATE_FORMAT(created_at, '%Y-%m')
        ORDER BY month ASC
    ");
    $appointments = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

    $months = array_unique(array_merge(array_keys($enquiries), array_keys($appointments)));
    sort($months);

    $response['engagement_stats'] = [];
    foreach ($months as $m) {
        $response['engagement_stats'][] = [
            'y' => $m,
            'a' => isset($enquiries[$m]) ? $enquiries[$m] : 0,
            'b' => isset($appointments[$m]) ? $appointments[$m] : 0
        ];
    }

    echo json_encode($response);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
