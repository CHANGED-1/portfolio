<?php
require_once '../config.php';
require_once '../includes/functions.php';

if (!is_admin_logged_in()) {
    redirect('login.php');
}

$page_title = 'Edit Project';
$errors = [];
$success = '';

// Get project ID
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

// Handle form submission
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
    
    // Check if slug exists for other projects
    $sql = "SELECT id FROM projects WHERE slug = ? AND id != ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "si", $slug, $project_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if (mysqli_num_rows($result) > 0) {
        $slug = $slug . '-' . time();
    }
    
    // Handle image upload
    $image_filename = $project['image'];
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $upload_result = upload_image($_FILES['image']);
        if ($upload_result['success']) {
            // Delete old image
            if ($project['image']) {
                delete_image($project['image']);
            }
            $image_filename = $upload_result['filename'];
        } else {
            $errors[] = $upload_result['message'];
        }
    }
    
    // Handle image deletion
    if (isset($_POST['delete_image']) && $project['image']) {
        delete_image($project['image']);
        $image_filename = '';
    }
    
    if (empty($errors)) {
        $sql = "UPDATE projects SET title = ?, slug = ?, description = ?, full_description = ?, category_id = ?, image = ?, project_url = ?, github_url = ?, technologies = ?, status = ?, featured = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssssisssssii", $title, $slug, $description, $full_description, $category_id, $image_filename, $project_url, $github_url, $technologies, $status, $featured, $project_id);
        
        if (mysqli_stmt_execute($stmt)) {
            $success = 'Project updated successfully!';
            // Refresh project data
            $project['title'] = $title;
            $project['description'] = $description;
            $project['full_description'] = $full_description;
            $project['category_id'] = $category_id;
            $project['image'] = $image_filename;
            $project['project_url'] = $project_url;
            $project['github_url'] = $github_url;
            $project['technologies'] = $technologies;
            $project['status'] = $status;
            $project['featured'] = $featured;
        } else {
            $errors[] = 'Failed to update project';
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
                <a href="manage-projects.php" class="active"><i class="fas fa-folder"></i> All Projects</a>
                <a href="add-project.php"><i class="fas fa-plus"></i> Add Project</a>
                <a href="<?php echo SITE_URL; ?>" target="_blank"><i class="fas fa-external-link-alt"></i> View Site</a>
                <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </nav>
        </aside>
        
        <!-- Main Content -->
        <main class="admin-content">
            <div class="admin-header">
                <h1>Edit Project</h1>
                <a href="../project-detail.php?slug=<?php echo $project['slug']; ?>" target="_blank" class="btn btn-secondary">
                    <i class="fas fa-eye"></i> View Project
                </a>
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
                            <input type="text" name="title" value="<?php echo $project['title']; ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label>Category *</label>
                            <select name="category_id" required>
                                <option value="">Select Category</option>
                                <?php foreach($categories as $cat): ?>
                                    <option value="<?php echo $cat['id']; ?>" <?php echo ($project['category_id'] == $cat['id']) ? 'selected' : ''; ?>>
                                        <?php echo $cat['name']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Short Description *</label>
                        <textarea name="description" rows="3" required><?php echo $project['description']; ?></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label>Full Description</label>
                        <textarea name="full_description" rows="6"><?php echo $project['full_description']; ?></textarea>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Project URL</label>
                            <input type="url" name="project_url" value="<?php echo $project['project_url']; ?>">
                        </div>
                        
                        <div class="form-group">
                            <label>GitHub URL</label>
                            <input type="url" name="github_url" value="<?php echo $project['github_url']; ?>">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Technologies</label>
                        <input type="text" name="technologies" value="<?php echo $project['technologies']; ?>">
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status">
                                <option value="completed" <?php echo ($project['status'] == 'completed') ? 'selected' : ''; ?>>Completed</option>
                                <option value="in-progress" <?php echo ($project['status'] == 'in-progress') ? 'selected' : ''; ?>>In Progress</option>
                                <option value="planned" <?php echo ($project['status'] == 'planned') ? 'selected' : ''; ?>>Planned</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label>Project Image</label>
                            <input type="file" name="image" accept="image/*">
                        </div>
                    </div>
                    
                    <?php if($project['image']): ?>
                    <div class="form-group">
                        <label>Current Image</label>
                        <div class="current-image">
                            <img src="../uploads/projects/<?php echo $project['image']; ?>" alt="Current">
                            <label class="checkbox-label">
                                <input type="checkbox" name="delete_image" value="1">
                                <span>Delete this image</span>
                            </label>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <div class="form-group">
                        <label class="checkbox-label">
                            <input type="checkbox" name="featured" value="1" <?php echo $project['featured'] ? 'checked' : ''; ?>>
                            <span>Feature this project on homepage</span>
                        </label>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Project
                        </button>
                        <a href="manage-projects.php" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>