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

    // Browser stats - Fetch more to ensure we capture different versions/browsers
    $stmt = $pdo->query("
        SELECT user_agent, COUNT(*) as count 
        FROM visitor_analytics 
        GROUP BY user_agent 
        ORDER BY count DESC 
        LIMIT 100
    ");
    $browsers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $clean_browsers = [];
    foreach ($browsers as $b) {
        $agent = $b['user_agent'];
        $count = $b['count'];
        $name = 'Other';
        
        // Check specific browsers first (order matters)
        if (stripos($agent, 'Edg') !== false) {
            $name = 'Edge';
        } elseif (stripos($agent, 'OPR') !== false || stripos($agent, 'Opera') !== false) {
            $name = 'Opera';
        } elseif (stripos($agent, 'Chrome') !== false) {
            $name = 'Chrome';
        } elseif (stripos($agent, 'Firefox') !== false) {
            $name = 'Firefox';
        } elseif (stripos($agent, 'Safari') !== false) {
            $name = 'Safari';
        } elseif (stripos($agent, 'Trident') !== false || stripos($agent, 'MSIE') !== false) {
            $name = 'Internet Explorer';
        }
        
        if (isset($clean_browsers[$name])) {
            $clean_browsers[$name] += $count;
        } else {
            $clean_browsers[$name] = $count;
        }
    }
    
    // Sort by count desc
    arsort($clean_browsers);
    
    // Keep top 5 and group others
    $final_browsers = [];
    $other_count = 0;
    $i = 0;
    foreach ($clean_browsers as $name => $count) {
        if ($i < 4) {
            $final_browsers[] = ['label' => $name, 'value' => $count];
        } else {
            $other_count += $count;
        }
        $i++;
    }
    
    if ($other_count > 0) {
        $final_browsers[] = ['label' => 'Other', 'value' => $other_count];
    }
    
    $response['browser_stats'] = $final_browsers;

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
