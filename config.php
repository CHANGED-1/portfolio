<?php
// Database Configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'Moses@19');
define('DB_NAME', 'portfolio_db');

// Site Configuration
define('SITE_NAME', 'My Portfolio');
define('SITE_URL', 'http://localhost:8001');
define('ADMIN_EMAIL', 'admin@portfolio.com');

// File Upload Configuration
define('UPLOAD_PATH', __DIR__ . '/uploads/projects/');
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_TYPES', ['jpg', 'jpeg', 'png', 'gif', 'webp']);

// Create database connection
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Start session
session_start();

// Timezone
date_default_timezone_set('UTC');
?>