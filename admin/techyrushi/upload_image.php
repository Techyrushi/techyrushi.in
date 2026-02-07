<?php
// Define upload directory
$upload_dir = '../../assets/images/uploads/';
if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

// Function to return JSON response for CKEditor
function returnMsg($msg) {
    echo json_encode(['error' => ['message' => $msg]]);
    exit;
}

if (isset($_FILES['upload']) || isset($_FILES['file'])) {
    $file = isset($_FILES['upload']) ? $_FILES['upload'] : $_FILES['file'];
    $is_tinymce = isset($_FILES['file']);
    
    // Check for errors
    if ($file['error'] !== UPLOAD_ERR_OK) {
        if ($is_tinymce) {
            header('HTTP/1.1 500 Server Error');
            echo json_encode(['error' => 'File upload error.']);
            exit;
        }
        returnMsg('File upload error.');
    }

    // Validate file type
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    if (!in_array($file['type'], $allowed_types)) {
        if ($is_tinymce) {
            header('HTTP/1.1 400 Bad Request');
            echo json_encode(['error' => 'Invalid file type.']);
            exit;
        }
        returnMsg('Invalid file type. Only JPG, PNG, GIF, and WEBP are allowed.');
    }

    // Generate unique filename
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = time() . '_' . uniqid() . '.' . $extension;
    $target_path = $upload_dir . $filename;

    // Move file
    if (move_uploaded_file($file['tmp_name'], $target_path)) {
        // We need the absolute URL or root-relative URL.
        // Determine the project root dynamically
        $script_dir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])); // e.g. /techzen/admin/techyrushi
        // We are in admin/techyrushi, so go up 2 levels to get to root
        $project_root = dirname(dirname($script_dir)); 
        // Ensure we don't end up with a double slash or empty if root is /
        $project_root = ($project_root == '/' || $project_root == '\\') ? '' : $project_root;
        
        $web_path = $project_root . '/assets/images/uploads/' . $filename;

        if ($is_tinymce) {
            echo json_encode(['location' => $web_path]);
        } else {
            echo json_encode([
                'uploaded' => 1,
                'fileName' => $filename,
                'url' => $web_path
            ]);
        }
    } else {
        if ($is_tinymce) {
            header('HTTP/1.1 500 Server Error');
            echo json_encode(['error' => 'Failed to move uploaded file.']);
            exit;
        }
        returnMsg('Failed to move uploaded file.');
    }
} else {
    returnMsg('No file uploaded.');
}
?>
