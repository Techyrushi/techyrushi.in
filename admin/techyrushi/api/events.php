<?php
header('Content-Type: application/json');
require_once '../../config.php';

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        $stmt = $pdo->query("SELECT id, title, start, end, class_name as className, description FROM events");
        $events = $stmt->fetchAll();
        echo json_encode($events);
        break;

    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        if (!$data) {
             // Fallback for form data if needed, but JSON is preferred
             $title = $_POST['title'] ?? '';
             $start = $_POST['start'] ?? '';
             $end = $_POST['end'] ?? null;
             $className = $_POST['className'] ?? 'bg-primary';
        } else {
             $title = $data['title'];
             $start = $data['start'];
             $end = $data['end'] ?? null;
             $className = $data['className'] ?? 'bg-primary';
        }

        $stmt = $pdo->prepare("INSERT INTO events (title, start, end, class_name) VALUES (?, ?, ?, ?)");
        $stmt->execute([$title, $start, $end, $className]);
        echo json_encode(['id' => $pdo->lastInsertId(), 'status' => 'success']);
        break;

    case 'PUT':
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $data['id'];
        $title = $data['title'];
        $start = $data['start'];
        $end = $data['end'] ?? null;
        // className might not be sent on simple resize/drop
        $className = $data['className'] ?? null;

        $sql = "UPDATE events SET title = ?, start = ?, end = ?";
        $params = [$title, $start, $end];

        if ($className) {
            $sql .= ", class_name = ?";
            $params[] = $className;
        }

        $sql .= " WHERE id = ?";
        $params[] = $id;

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        echo json_encode(['status' => 'success']);
        break;

    case 'DELETE':
        $data = json_decode(file_get_contents('php://input'), true);
        // If not in body, check query string
        $id = $data['id'] ?? $_GET['id'];

        $stmt = $pdo->prepare("DELETE FROM events WHERE id = ?");
        $stmt->execute([$id]);
        echo json_encode(['status' => 'success']);
        break;
}
?>