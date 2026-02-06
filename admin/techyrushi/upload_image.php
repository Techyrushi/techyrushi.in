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

if (isset($_FILES['upload'])) {
    $file = $_FILES['upload'];
    
    // Check for errors
    if ($file['error'] !== UPLOAD_ERR_OK) {
        returnMsg('File upload error.');
    }

    // Validate file type
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    if (!in_array($file['type'], $allowed_types)) {
        returnMsg('Invalid file type. Only JPG, PNG, GIF, and WEBP are allowed.');
    }

    // Generate unique filename
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = time() . '_' . uniqid() . '.' . $extension;
    $target_path = $upload_dir . $filename;

    // Move file
    if (move_uploaded_file($file['tmp_name'], $target_path)) {
        // Return success response in CKEditor 4.5+ JSON format
        // The URL needs to be accessible from the browser
        $url = '../../assets/images/uploads/' . $filename; // Relative to the admin script might be tricky if not absolute path from root. 
        // Let's assume the admin is in /admin/techyrushi/ and assets are in /assets/
        // So from browser: http://localhost/techzen/assets/images/uploads/filename
        
        // We need the absolute URL or root-relative URL.
        // Assuming project root is /techzen/
        $web_path = '/techzen/assets/images/uploads/' . $filename;

        echo json_encode([
            'uploaded' => 1,
            'fileName' => $filename,
            'url' => $web_path
        ]);
    } else {
        returnMsg('Failed to move uploaded file.');
    }
} else {
    returnMsg('No file uploaded.');
}
?>
