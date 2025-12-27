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
                        <h3><?php echo mysqli_num_rows(mysqli_query($conn, "SELECT * FROM projects WHERE status = 'completed'")); ?></h3>
                        <p>Completed Projects</p>
                    </div>
                </div>
            </div>
            
            <!-- Recent Projects -->
            <div class="admin-section">
                <div class="section-header">
                    <h2>Recent Projects</h2>
                    <a href="add-project.php" class="btn btn-primary">Add New</a>
                </div>
                
                <div class="table-responsive">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($project = mysqli_fetch_assoc($recent_projects)): ?>
                            <tr>
                                <td>
                                    <strong><?php echo $project['title']; ?></strong>
                                    <?php if($project['featured']): ?>
                                        <span class="badge badge-warning">Featured</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo $project['category_name']; ?></td>
                                <td>
                                    <span class="badge badge-<?php echo $project['status']; ?>">
                                        <?php echo ucfirst($project['status']); ?>
                                    </span>
                                </td>
                                <td><?php echo format_date($project['created_at']); ?></td>
                                <td>
                                    <a href="edit-project.php?id=<?php echo $project['id']; ?>" class="btn-icon" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="delete-project.php?id=<?php echo $project['id']; ?>" class="btn-icon btn-danger" title="Delete" onclick="return confirm('Are you sure?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</body>
</html>