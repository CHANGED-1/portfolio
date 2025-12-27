<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title . ' - ' . SITE_NAME : SITE_NAME; ?></title>
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <div class="nav-brand">
                <a href="<?php echo SITE_URL; ?>"><?php echo SITE_NAME; ?></a>
            </div>
            <ul class="nav-menu">
                <li><a href="<?php echo SITE_URL; ?>">Home</a></li>
                <li><a href="<?php echo SITE_URL; ?>/projects.php">Projects</a></li>
                <li><a href="<?php echo SITE_URL; ?>/contact.php">Contact</a></li>
            </ul>
            <div class="nav-toggle" id="navToggle">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </nav>