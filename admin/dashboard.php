<?php
require_once '../config.php';
require_once '../includes/functions.php';

if (!is_admin_logged_in()) {
    redirect('login.php');
}

$page_title = 'Dashboard';

// Get statistics
$total_projects = get_project_count($conn);
$new_messages = get_message_count($conn, 'new');

// Get recent projects
$sql = "SELECT p.*, c.name as category_name 
        FROM projects p 
        LEFT JOIN categories c ON p.category_id = c.id 
        ORDER BY p.created_at DESC 
        LIMIT 5";
$recent_projects = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> - Admin Panel</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="admin-page">
    <div class="admin-wrapper">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <div class="admin-brand">
                <h2>Admin Panel</h2>
            </div>
            <nav class="admin-nav">
                <a href="dashboard.php" class="active"><i class="fas fa-chart-line"></i> Dashboard</a>
                <a href="manage-projects.php"><i class="fas fa-folder"></i> All Projects</a>
                <a href="add-project.php"><i class="fas fa-plus"></i> Add Project</a>
                <a href="<?php echo SITE_URL; ?>" target="_blank"><i class="fas fa-external-link-alt"></i> View Site</a>
                <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </nav>
        </aside>
        
        <!-- Main Content -->
        <main class="admin-content">
            <div class="admin-header">
                <h1>Dashboard</h1>
                <p>Welcome back, <?php echo $_SESSION['admin_username']; ?>!</p>
            </div>
            
            <!-- Statistics Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <i class="fas fa-folder"></i>
                    </div>
                    <div class="stat-info">
                        <h3><?php echo $total_projects; ?></h3>
                        <p>Total Projects</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="stat-info">
                        <h3><?php echo $new_messages; ?></h3>
                        <p>New Messages</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="stat-info">
                        <h3><?php echo mysqli_num_rows(mysqli_query($conn, "SELECT * FROM projects WHERE featured = 1")); ?></h3>
                        <p>Featured Projects</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <!-- <div class="stat-info">
                        <h3> -->
                            <?php 
                            // echo mysqli_