<?php
require_once 'config.php';
require_once 'includes/functions.php';

$page_title = 'Projects';

// Get filter category
$category_filter = isset($_GET['category']) ? clean_input($_GET['category']) : '';

// Build query
$sql = "SELECT p.*, c.name as category_name, c.slug as category_slug 
        FROM projects p 
        LEFT JOIN categories c ON p.category_id = c.id";

if ($category_filter) {
    $sql .= " WHERE c.slug = ?";
}

$sql .= " ORDER BY p.created_at DESC";

// Execute query
if ($category_filter) {
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $category_filter);
    mysqli_stmt_execute($stmt);
    $projects = mysqli_stmt_get_result($stmt);
} else {
    $projects = mysqli_query($conn, $sql);
}

// Get all categories for filter
$categories = get_categories($conn);

include 'includes/header.php';
?>

<section class="page-header">
    <div class="container">
        <h1>My Projects</h1>
        <p>Explore my latest work and creative projects</p>
    </div>
</section>

<section class="projects-section">
    <div class="container">
        <!-- Category Filter -->
        <div class="filter-bar">
            <a href="projects.php" class="filter-btn <?php echo !$category_filter ? 'active' : ''; ?>">
                All Projects
            </a>
            <?php foreach($categories as $cat): ?>
            <a href="projects.php?category=<?php echo $cat['slug']; ?>" 
               class="filter-btn <?php echo $category_filter == $cat['slug'] ? 'active' : ''; ?>">
                <?php echo $cat['name']; ?>
            </a>
            <?php endforeach; ?>
        </div>
        
        <!-- Projects Grid -->
        <div class="projects-grid">
            <?php if(mysqli_num_rows($projects) > 0): ?>
                <?php while($project = mysqli_fetch_assoc($projects)): ?>
                <div class="project-card">
                    <?php if($project['image']): ?>
                        <img src="uploads/projects/<?php echo $project['image']; ?>" alt="<?php echo $project['title']; ?>">
                    <?php else: ?>
                        <div class="project-placeholder">
                            <i class="fas fa-image"></i>
                        </div>
                    <?php endif; ?>
                    
                    <div class="project-info">
                        <span class="project-category"><?php echo $project['category_name']; ?></span>
                        <h3><?php echo $project['title']; ?></h3>
                        <p><?php echo truncate_text($project['description']); ?></p>
                        
                        <div class="project-meta">
                            <?php if($project['technologies']): ?>
                                <div class="technologies">
                                    <?php 
                                    $techs = explode(',', $project['technologies']);
                                    foreach(array_slice($techs, 0, 3) as $tech): 
                                    ?>
                                        <span class="tech-tag"><?php echo trim($tech); ?></span>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <a href="project-detail.php?slug=<?php echo $project['slug']; ?>" class="btn-link">
                            View Details <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="no-projects">
                    <i class="fas fa-folder-open"></i>
                    <p>No projects found in this category.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>