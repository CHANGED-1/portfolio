<?php
require_once '../config.php';
require_once '../includes/functions.php';

if (!is_admin_logged_in()) {
    redirect('login.php');
}

$page_title = 'Manage Projects';

// Get all projects
$sql = "SELECT p.*, c.name as category_name 
        FROM projects p 
        LEFT JOIN categories c ON p.category_id = c.id 
        ORDER BY p.created_at DESC";
$projects = mysqli_query($conn, $sql);
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
                <a href="dashboard.php"><i class="fas fa-chart-line"></i> Dashboard</a>
                <a href="manage-projects.php" class="active"><i class="fas fa-folder"></i> All Projects</a>
                <a href="add-project.php"><i class="fas fa-plus"></i> Add Project</a>
                <a href="<?php echo SITE_URL; ?>" target="_blank"><i class="fas fa-external-link-alt"></i> View Site</a>
                <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </nav>
        </aside>
        
        <!-- Main Content -->
        <main class="admin-content">
            <div class="admin-header">
                <h1>All Projects</h1>
                <a href="add-project.php" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add New Project
                </a>
            </div>
            
            <div class="admin-section">
                <div class="table-responsive">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Technologies</th>
                                <th>Status</th>
                                <th>Featured</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(mysqli_num_rows($projects) > 0): ?>
                                <?php while($project = mysqli_fetch_assoc($projects)): ?>
                                <tr>
                                    <td>
                                        <?php if($project['image']): ?>
                                            <img src="../uploads/projects/<?php echo $project['image']; ?>" alt="" class="table-image">
                                        <?php else: ?>
                                            <div class="table-image-placeholder">
                                                <i class="fas fa-image"></i>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <strong><?php echo $project['title']; ?></strong><br>
                                        <small><?php echo truncate_text($project['description'], 60); ?></small>
                                    </td>
                                    <td><?php echo $project['category_name']; ?></td>
                                    <td>
                                        <?php 
                                        if($project['technologies']) {
                                            $techs = explode(',', $project['technologies']);
                                            echo count($techs) . ' tech' . (count($techs) > 1 ? 's' : '');
                                        } else {
                                            echo '-';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <span class="badge badge-<?php echo $project['status']; ?>">
                                            <?php echo ucfirst(str_replace('-', ' ', $project['status'])); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if($project['featured']): ?>
                                            <i class="fas fa-star text-warning"></i>
                                        <?php else: ?>
                                            <i class="far fa-star text-muted"></i>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo format_date($project['created_at']); ?></td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="../project-detail.php?slug=<?php echo $project['slug']; ?>" target="_blank" class="btn-icon" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="edit-project.php?id=<?php echo $project['id']; ?>" class="btn-icon" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="delete-project.php?id=<?php echo $project['id']; ?>" class="btn-icon btn-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this project?')">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="text-center">No projects found. <a href="add-project.php">Add your first project</a></td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</body>
</html>