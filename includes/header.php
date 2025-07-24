<?php
// Start session if not started yet
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Define constants if not defined
if (!defined('APPURL')) {
    define('APPURL', 'http://localhost/restoran');
}
if (!defined('APPIMAGES')) {
    define('APPIMAGES', APPURL . '/admin-panel/foods-admins/foods-images');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Restoran</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Favicon -->
    <link href="<?php echo APPURL; ?>/img/favicon.ico" rel="icon" />

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&family=Pacifico&display=swap" rel="stylesheet" />

    <!-- Icon Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />

    <!-- Libraries Styles -->
    <link href="<?php echo APPURL; ?>/lib/animate/animate.min.css" rel="stylesheet" />
    <link href="<?php echo APPURL; ?>/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet" />
    <link href="<?php echo APPURL; ?>/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Bootstrap CSS and your style -->
    <link href="<?php echo APPURL; ?>/css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?php echo APPURL; ?>/css/style.css" rel="stylesheet" />
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4 px-lg-5 py-3 py-lg-0">
    <a href="<?php echo APPURL; ?>" class="navbar-brand p-0">
        <h1 class="text-primary m-0"><i class="fa fa-utensils me-3"></i>Restoran</h1>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="fa fa-bars"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav ms-auto py-0 pe-4">
            <a href="<?php echo APPURL; ?>" class="nav-item nav-link active">Home</a>
            <a href="<?php echo APPURL; ?>/about.php" class="nav-item nav-link">About</a>
            <a href="<?php echo APPURL; ?>/service.php" class="nav-item nav-link">Service</a>
            <a href="<?php echo APPURL; ?>/contact.php" class="nav-item nav-link">Contact</a>
            <?php if (isset($_SESSION['username'])) : ?>
                <a href="<?php echo APPURL; ?>/booking.php" class="nav-item nav-link">Booking</a>
                <a href="<?php echo APPURL; ?>/food/cart.php" class="nav-item nav-link">
                    <i class="fa fa-shopping-cart"></i> Cart
                </a>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                        <?php echo htmlspecialchars($_SESSION['username']); ?>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="<?php echo APPURL; ?>/users/bookings.php">Bookings</a></li>
                        <li><a class="dropdown-item" href="<?php echo APPURL; ?>/users/orders.php">Orders</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="<?php echo APPURL; ?>/auth/logout.php">Logout</a></li>
                    </ul>
                </li>
            <?php else : ?>
                <a href="<?php echo APPURL; ?>/auth/login.php" class="nav-item nav-link">Login</a>
                <a href="<?php echo APPURL; ?>/auth/register.php" class="nav-item nav-link">Register</a>
            <?php endif; ?>
        </div>
    </div>
</nav>
