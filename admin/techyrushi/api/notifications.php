<?php
header('Content-Type: application/json');
require_once '../../config.php';

try {
    $response = [
        'enquiries_count' => 0,
        'appointments_count' => 0,
        'enquiries' => [],
        'appointments' => []
    ];

    // Count unread enquiries
    $stmt = $pdo->query("SELECT COUNT(*) FROM contact_enquiries WHERE is_read = 0");
    $response['enquiries_count'] = $stmt->fetchColumn();

    // Get latest unread enquiries
    $stmt = $pdo->query("SELECT id, name, subject, created_at FROM contact_enquiries WHERE is_read = 0 ORDER BY created_at DESC LIMIT 5");
    $response['enquiries'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Count pending appointments
    $stmt = $pdo->query("SELECT COUNT(*) FROM appointments WHERE status = 'pending'");
    $response['appointments_count'] = $stmt->fetchColumn();

    // Get latest pending appointments
    $stmt = $pdo->query("SELECT id, name, topic, appointment_date, appointment_time FROM appointments WHERE status = 'pending' ORDER BY created_at DESC LIMIT 5");
    $response['appointments'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($response);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
