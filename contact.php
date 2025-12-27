<?php
require_once 'config.php';
require_once 'includes/functions.php';

$page_title = 'Contact';
$success = '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = clean_input($_POST['name']);
    $email = clean_input($_POST['email']);
    $subject = clean_input($_POST['subject']);
    $message = clean_input($_POST['message']);
    
    // Validation
    if (empty($name)) $errors[] = 'Name is required';
    if (empty($email)) $errors[] = 'Email is required';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Invalid email';
    if (empty($subject)) $errors[] = 'Subject is required';
    if (empty($message)) $errors[] = 'Message is required';
    
    if (empty($errors)) {
        $sql = "INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $subject, $message);
        
        if (mysqli_stmt_execute($stmt)) {
            $success = 'Thank you! Your message has been sent successfully.';
            // Clear form
            $name = $email = $subject = $message = '';
        } else {
            $errors[] = 'Something went wrong. Please try again.';
        }
    }
}

include 'includes/header.php';
?>

<section class="page-header">
    <div class="container">
        <h1>Get In Touch</h1>
        <p>Have a project in mind? Let's work together!</p>
    </div>
</section>

<section class="contact-section">
    <div class="container">
        <div class="contact-grid">
            <div class="contact-info">
                <h2>Let's Talk</h2>
                <p>I'm always interested in hearing about new projects and opportunities.</p>
                
                <div class="contact-details">
                    <div class="contact-item">
                        <i class="fas fa-envelope"></i>
                        <div>
                            <h4>Email</h4>
                            <p><?php echo ADMIN_EMAIL; ?></p>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <div>
                            <h4>Location</h4>
                            <p>Your City, Country</p>
                        </div>
                    </div>
                </div>
                
                <div class="social-links-large">
                    <a href="#"><i class="fab fa-github"></i></a>
                    <a href="#"><i class="fab fa-linkedin"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                </div>
            </div>
            
            <div class="contact-form-wrapper">
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
                
                <form method="POST" class="contact-form">
                    <div class="form-group">
                        <input type="text" name="name" placeholder="Your Name" value="<?php echo $name ?? ''; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <input type="email" name="email" placeholder="Your Email" value="<?php echo $email ?? ''; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <input type="text" name="subject" placeholder="Subject" value="<?php echo $subject ?? ''; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <textarea name="message" rows="6" placeholder="Your Message" required><?php echo $message ?? ''; ?></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-block">Send Message</button>
                </form>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>