<?php
require_once 'config.php';
require_once 'includes/functions.php';

$page_title = 'Home';

// Get featured projects
$sql = "SELECT p.*, c.name as category_name 
        FROM projects p 
        LEFT JOIN categories c ON p.category_id = c.id 
        WHERE p.featured = 1 
        ORDER BY p.created_at DESC 
        LIMIT 6";
$featured_projects = mysqli_query($conn, $sql);

include 'includes/header.php';
?>

<section class="hero">
    <div class="container">
        <div class="hero-content">
            <h1 class="hero-title">Hi, I'm <span>Your Name</span></h1>
            <h2 class="hero-subtitle">Full Stack Developer & Designer</h2>
            <p class="hero-text">I create beautiful, functional websites and applications that solve real problems.</p>
            <div class="hero-buttons">
                <a href="projects.php" class="btn btn-primary">View Projects</a>
                <a href="contact.php" class="btn btn-secondary">Get In Touch</a>
            </div>
        </div>
    </div>
</section>

<section class="featured-projects">
    <div class="container">
        <h2 class="section-title">Featured Projects</h2>
        <div class="projects-grid">
            <?php while($project = mysqli_fetch_assoc($featured_projects)): ?>
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
                    <a href="project-detail.php?slug=<?php echo $project['slug']; ?>" class="btn-link">
                        View Details <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
        
        <div class="text-center" style="margin-top: 3rem;">
            <a href="projects.php" class="btn btn-primary">View All Projects</a>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>