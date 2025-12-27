<?php
// Helper Functions

// Sanitize input
function clean_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Create URL slug
function create_slug($string) {
    $string = strtolower($string);
    $string = preg_replace('/[^a-z0-9\s-]/', '', $string);
    $string = preg_replace('/[\s-]+/', '-', $string);
    $string = trim($string, '-');
    return $string;
}

// Check if admin is logged in
function is_admin_logged_in() {
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

// Redirect function
function redirect($url) {
    header("Location: " . $url);
    exit();
}

// Format date
function format_date($date) {
    return date('F j, Y', strtotime($date));
}

// Truncate text
function truncate_text($text, $length = 150) {
    if (strlen($text) <= $length) {
        return $text;
    }
    return substr($text, 0, $length) . '...';
}

// Upload image
function upload_image($file) {
    if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
        return ['success' => false, 'message' => 'No file uploaded or upload error'];
    }
    
    $file_size = $file['size'];
    $file_tmp = $file['tmp_name'];
    $file_name = $file['name'];
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    
    if ($file_size > MAX_FILE_SIZE) {
        return ['success' => false, 'message' => 'File size exceeds limit'];
    }
    
    if (!in_array($file_ext, ALLOWED_TYPES)) {
        return ['success' => false, 'message' => 'Invalid file type'];
    }
    
    $new_filename = uniqid() . '_' . time() . '.' . $file_ext;
    $upload_path = UPLOAD_PATH . $new_filename;
    
    if (!is_dir(UPLOAD_PATH)) {
        mkdir(UPLOAD_PATH, 0755, true);
    }
    
    if (move_uploaded_file($file_tmp, $upload_path)) {
        return ['success' => true, 'filename' => $new_filename];
    }
    
    return ['success' => false, 'message' => 'Failed to move uploaded file'];
}

// Delete image
function delete_image($filename) {
    $file_path = UPLOAD_PATH . $filename;
    if (file_exists($file_path)) {
        return unlink($file_path);
    }
    return false;
}

// Get all categories
function get_categories($conn) {
    $sql = "SELECT * FROM categories ORDER BY name ASC";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// Get project count
function get_project_count($conn) {
    $sql = "SELECT COUNT(*) as count FROM projects";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['count'];
}

// Get message count
function get_message_count($conn, $status = 'new') {
    $sql = "SELECT COUNT(*) as count FROM contact_messages WHERE status = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $status);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    return $row['count'];
}
?>