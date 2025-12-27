<?php
require_once '../config.php';
require_once '../includes/functions.php';

if (!is_admin_logged_in()) {
    redirect('login.php');
}

$project_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if (!$project_id) {
    redirect('manage-projects.php');
}

// Get project data
$sql = "SELECT * FROM projects WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $project_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) == 0) {
    redirect('manage-projects.php');
}

$project = mysqli_fetch_assoc($result);

// Delete image if exists
if ($project['image']) {
    delete_image($project['image']);
}

// Delete project
$sql = "DELETE FROM projects WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $project_id);

if (mysqli_stmt_execute($stmt)) {
    $_SESSION['success_message'] = 'Project deleted successfully!';
} else {
    $_SESSION['error_message'] = 'Failed to delete project!';
}

redirect('manage-projects.php');
?>