<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title><?php echo $pageTitle ?? 'Computer Parts Store'; ?></title>
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
<header class="header">
    <div class="container">
        <div class="logo">
            <a href="<?php echo SITE_URL; ?>">PC Parts Hub</a>
        </div>
        <nav class="navbar">
            <ul class="nav-menu">
                <li><a href="<?php echo SITE_URL; ?>">Home</a></li>
                <li><a href="<?php echo SITE_URL; ?>products.php">Products</a></li>
                <li><a href="<?php echo SITE_URL; ?>about.php">About</a></li>
                <li><a href="<?php echo SITE_URL; ?>contact.php">Contact</a></li>
                <li><a href="<?php echo SITE_URL; ?>cart.php"><i class="fas fa-shopping-cart"></i> Cart</a></li>
                <?php if(isAdminLoggedIn()): ?>
                    <li><a href="<?php echo SITE_URL; ?>admin/dashboard.php"><i class="fas fa-user-shield"></i> Admin</a></li>
                <?php endif; ?>
            </ul>
            <div class="hamburger">
                <span></span><span></span><span></span>
            </div>
        </nav>
    </div>
</header>
<main>