<?php
header('Content-Type: application/json');
require_once '../../config.php';

// Helper to get JSON input
function getJsonInput() {
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        return null;
    }
    return $data;
}

$method = $_SERVER['REQUEST_METHOD'];

try {
    switch ($method) {
        case 'GET':
            $stmt = $pdo->query("SELECT * FROM tasks ORDER BY created_at DESC");
            $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($tasks);
            break;

        case 'POST':
            $data = getJsonInput();
            if (!$data) {
                http_response_code(400);
                echo json_encode(['status' => 'error', 'message' => 'Invalid JSON']);
                exit;
            }

            $title = $data['title'] ?? '';
            $description = $data['description'] ?? '';
            $status = $data['status'] ?? 'todo';
            $due_date = !empty($data['due_date']) ? $data['due_date'] : null;
            $start_date = !empty($data['start_date']) ? $data['start_date'] : null;
            $end_date = !empty($data['end_date']) ? $data['end_date'] : null;

            if (empty($title)) {
                http_response_code(400);
                echo json_encode(['status' => 'error', 'message' => 'Title is required']);
                exit;
            }

            $stmt = $pdo->prepare("INSERT INTO tasks (title, description, status, due_date, start_date, end_date) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$title, $description, $status, $due_date, $start_date, $end_date]);
            echo json_encode(['id' => $pdo->lastInsertId(), 'status' => 'success']);
            break;

        case 'PUT':
            $data = getJsonInput();
            if (!$data) {
                http_response_code(400);
                echo json_encode(['status' => 'error', 'message' => 'Invalid JSON']);
                exit;
            }

            $id = $data['id'] ?? null;
            if (!$id) {
                http_response_code(400);
                echo json_encode(['status' => 'error', 'message' => 'ID is required']);
                exit;
            }

            // Fetch existing task to merge changes
            $stmt = $pdo->prepare("SELECT * FROM tasks WHERE id = ?");
            $stmt->execute([$id]);
            $existingTask = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$existingTask) {
                http_response_code(404);
                echo json_encode(['status' => 'error', 'message' => 'Task not found']);
                exit;
            }

            $title = $data['title'] ?? $existingTask['title'];
            $description = $data['description'] ?? $existingTask['description'];
            $status = $data['status'] ?? $existingTask['status'];
            $due_date = isset($data['due_date']) ? $data['due_date'] : $existingTask['due_date'];
            $start_date = isset($data['start_date']) ? $data['start_date'] : $existingTask['start_date'];
            $end_date = isset($data['end_date']) ? $data['end_date'] : $existingTask['end_date'];

            $stmt = $pdo->prepare("UPDATE tasks SET title = ?, description = ?, status = ?, due_date = ?, start_date = ?, end_date = ? WHERE id = ?");
            $stmt->execute([$title, $description, $status, $due_date, $start_date, $end_date, $id]);
            echo json_encode(['status' => 'success']);
            break;

        case 'DELETE':
            $data = getJsonInput();
            $id = $data['id'] ?? $_GET['id'] ?? null;

            if (!$id) {
                http_response_code(400);
                echo json_encode(['status' => 'error', 'message' => 'ID is required']);
                exit;
            }

            $stmt = $pdo->prepare("DELETE FROM tasks WHERE id = ?");
            $stmt->execute([$id]);
            echo json_encode(['status' => 'success']);
            break;
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>