<?php
require_once '../config.php';
require_once '../includes/functions.php';

if (!is_admin_logged_in()) {
    redirect('login.php');
}

$page_title = 'Add Project';
$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = clean_input($_POST['title']);
    $slug = create_slug($title);
    $description = clean_input($_POST['description']);
    $full_description = clean_input($_POST['full_description']);
    $category_id = intval($_POST['category_id']);
    $project_url = clean_input($_POST['project_url']);
    $github_url = clean_input($_POST['github_url']);
    $technologies = clean_input($_POST['technologies']);
    $status = clean_input($_POST['status']);
    $featured = isset($_POST['featured']) ? 1 : 0;
    
    // Validation
    if (empty($title)) $errors[] = 'Title is required';
    if (empty($description)) $errors[] = 'Description is required';
    if (empty($category_id)) $errors[] = 'Category is required';
    
    // Check if slug exists
    $sql = "SELECT id FROM projects WHERE slug = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $slug);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if (mysqli_num_rows($result) > 0) {
        $slug = $slug . '-' . time();
    }
    
    // Handle image upload
    $image_filename = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $upload_result = upload_image($_FILES['image']);
        if ($upload_result['success']) {
            $image_filename = $upload_result['filename'];
        } else {
            $errors[] = $upload_result['message'];
        }
    }
    
    if (empty($errors)) {
        $sql = "INSERT INTO projects (title, slug, description, full_description, category_id, image, project_url, github_url, technologies, status, featured) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssssisssssi", $title, $slug, $description, $full_description, $category_id, $image_filename, $project_url, $github_url, $technologies, $status, $featured);
        
        if (mysqli_stmt_execute($stmt)) {
            $success = 'Project added successfully!';
            // Clear form
            $title = $description = $full_description = $project_url = $github_url = $technologies = '';
            $category_id = 0;
            $featured = 0;
        } else {
            $errors[] = 'Failed to add project';
        }
    }
}

$categories = get_categories($conn);
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
                <a href="manage-projects.php"><i class="fas fa-folder"></i> All Projects</a>
                <a href="add-project.php" class="active"><i class="fas fa-plus"></i> Add Project</a>
                <a href="<?php echo SITE_URL; ?>" target="_blank"><i class="fas fa-external-link-alt"></i> View Site</a>
                <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </nav>
        </aside>
        
        <!-- Main Content -->
        <main class="admin-content">
            <div class="admin-header">
                <h1>Add New Project</h1>
            </div>
            
            <?php if($success): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>
            
            <?php if(!empty($errors)): ?>
                <div class="alert alert-danger">
                    <?php foreach($errors as $error): ?>
                        <p><?php echo $error; ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            
            <div class="admin-form-container">
                <form method="POST" enctype="multipart/form-data" class="admin-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Project Title *</label>
                            <input type="text" name="title" value="<?php echo $title ?? ''; ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label>Category *</label>
                            <select name="category_id" required>
                                <option value="">Select Category</option>
                                <?php foreach($categories as $cat): ?>
                                    <option value="<?php echo $cat['id']; ?>" <?php echo (isset($category_id) && $category_id == $cat['id']) ? 'selected' : ''; ?>>
                                        <?php echo $cat['name']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Short Description *</label>
                        <textarea name="description" rows="3" required><?php echo $description ?? ''; ?></textarea>
                        <small>Brief description for project cards (150-200 characters recommended)</small>
                    </div>
                    
                    <div class="form-group">
                        <label>Full Description</label>
                        <textarea name="full_description" rows="6"><?php echo $full_description ?? ''; ?></textarea>
                        <small>Detailed description for project detail page</small>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Project URL</label>
                            <input type="url" name="project_url" value="<?php echo $project_url ?? ''; ?>" placeholder="https://example.com">
                        </div>
                        
                        <div class="form-group">
                            <label>GitHub URL</label>
                            <input type="url" name="github_url" value="<?php echo $github_url ?? ''; ?>" placeholder="https://github.com/username/repo">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Technologies</label>
                        <input type="text" name="technologies" value="<?php echo $technologies ?? ''; ?>" placeholder="PHP, MySQL, JavaScript, CSS">
                        <small>Separate with commas</small>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status">
                                <option value="completed" <?php echo (isset($status) && $status == 'completed') ? 'selected' : ''; ?>>Completed</option>
                                <option value="in-progress" <?php echo (isset($status) && $status == 'in-progress') ? 'selected' : ''; ?>>In Progress</option>
                                <option value="planned" <?php echo (isset($status) && $status == 'planned') ? 'selected' : ''; ?>>Planned</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label>Project Image</label>
                            <input type="file" name="image" accept="image/*">
                            <small>Max size: 5MB. Allowed: JPG, PNG, GIF, WebP</small>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="checkbox-label">
                            <input type="checkbox" name="featured" value="1" <?php echo (isset($featured) && $featured) ? 'checked' : ''; ?>>
                            <span>Feature this project on homepage</span>
                        </label>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Add Project
                        </button>
                        <a href="manage-projects.php" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>