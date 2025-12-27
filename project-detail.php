<?php
require_once 'config.php';
require_once 'includes/functions.php';

// Get project slug
$slug = isset($_GET['slug']) ? clean_input($_GET['slug']) : '';

if (!$slug) {
    redirect('projects.php');
}

// Get project details
$sql = "SELECT p.*, c.name as category_name 
        FROM projects p 
        LEFT JOIN categories c ON p.category_id = c.id 
        WHERE p.slug = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $slug);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) == 0) {
    redirect('projects.php');
}

$project = mysqli_fetch_assoc($result);
$page_title = $project['title'];

include 'includes/header.php';
?>

<section class="project-detail">
    <div class="container">
        <div class="project-header">
            <div class="project-breadcrumb">
                <a href="projects.php">Projects</a> / <?php echo $project['title']; ?>
            </div>
            <h1><?php echo $project['title']; ?></h1>
            <div class="project-meta-info">
                <span class="category-badge"><?php echo $project['category_name']; ?></span>
                <span class="status-badge status-<?php echo $project['status']; ?>">
                    <?php echo ucfirst(str_replace('-', ' ', $project['status'])); ?>
                </span>
                <span class="date"><i class="far fa-calendar"></i> <?php echo format_date($project['created_at']); ?></span>
            </div>
        </div>
        
        <?php if($project['image']): ?>
        <div class="project-image">
            <img src="uploads/projects/<?php echo $project['image']; ?>" alt="<?php echo $project['title']; ?>">
        </div>
        <?php endif; ?>
        
        <div class="project-content">
            <div class="project-main">
                <h2>About This Project</h2>
                <p><?php echo nl2br($project['full_description'] ?: $project['description']); ?></p>
                
                <?php if($project['technologies']): ?>
                <div class="tech-stack">
                    <h3>Technologies Used</h3>
                    <div class="tech-list">
                        <?php 
                        $techs = explode(',', $project['technologies']);
                        foreach($techs as $tech): 
                        ?>
                            <span class="tech-badge"><?php echo trim($tech); ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            
            <div class="project-sidebar">
                <div class="sidebar-card">
                    <h3>Project Links</h3>
                    <?php if($project['project_url']): ?>
                    <a href="<?php echo $project['project_url']; ?>" target="_blank" class="btn btn-primary btn-block">
                        <i class="fas fa-external-link-alt"></i> Live Demo
                    </a>
                    <?php endif; ?>
                    
                    <?php if($project['github_url']): ?>
                    <a href="<?php echo $project['github_url']; ?>" target="_blank" class="btn btn-secondary btn-block">
                        <i class="fab fa-github"></i> View Code
                    </a>
                    <?php endif; ?>
                </div>
                
                <div class="sidebar-card">
                    <h3>Project Details</h3>
                    <ul class="project-details-list">
                        <li>
                            <strong>Category:</strong>
                            <span><?php echo $project['category_name']; ?></span>
                        </li>
                        <li>
                            <strong>Status:</strong>
                            <span><?php echo ucfirst(str_replace('-', ' ', $project['status'])); ?></span>
                        </li>
                        <li>
                            <strong>Date:</strong>
                            <span><?php echo format_date($project['created_at']); ?></span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="project-actions">
            <a href="projects.php" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Projects
            </a>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>