<?php
// Start session early (only once)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include configuration and App class
require_once __DIR__ . "/config/config.php";
require_once __DIR__ . "/libs/App.php";

// Define constants safely
if (!defined('APPURL')) {
    define('APPURL', 'http://localhost/restoran');
}
if (!defined('APPIMAGES')) {
    define('APPIMAGES', APPURL . '/admin-panel/foods-admins/foods-images');
}

// Instantiate App class (constructor connects to DB and starts session)
$app = new App();

// Fetch meals (Breakfast, Lunch, Dinner) and reviews
$meals_1 = $app->selectAll("SELECT * FROM foods WHERE meal_id=1");
$meals_2 = $app->selectAll("SELECT * FROM foods WHERE meal_id=2");
$meals_3 = $app->selectAll("SELECT * FROM foods WHERE meal_id=3");
$reviews = $app->selectAll("SELECT * FROM reviews");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Restoran - Bootstrap Restaurant Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Favicon -->
    <link href="<?php echo APPURL; ?>/img/favicon.ico" rel="icon" />

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&family=Pacifico&display=swap" rel="stylesheet" />

    <!-- Icon Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />

    <!-- Libraries Stylesheets -->
    <link href="<?php echo APPURL; ?>/lib/animate/animate.min.css" rel="stylesheet" />
    <link href="<?php echo APPURL; ?>/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet" />
    <link href="<?php echo APPURL; ?>/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="<?php echo APPURL; ?>/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Custom CSS -->
    <link href="<?php echo APPURL; ?>/css/style.css" rel="stylesheet" />
</head>

<body>
    <div class="container-xxl bg-white p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->

        <!-- Navbar Start -->
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
                    <a href="<?php echo APPURL; ?>/service.php" class="nav-item nav-link">Services</a>
                    <a href="<?php echo APPURL; ?>/contact.php" class="nav-item nav-link">Contact</a>

                    <?php if (isset($_SESSION['username'])) : ?>
                        <a href="<?php echo APPURL; ?>/booking.php" class="nav-item nav-link">Booking</a>
                        <a href="<?php echo APPURL; ?>/food/cart.php" class="nav-item nav-link">
                            <i class="fa fa-shopping-cart"></i> Cart
                        </a>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <?php echo htmlspecialchars($_SESSION['username']); ?>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="<?php echo APPURL; ?>/users/bookings.php">My Bookings</a></li>
                                <li><a class="dropdown-item" href="<?php echo APPURL; ?>/users/orders.php">My Orders</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
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
        <!-- Navbar End -->

        <!-- Hero Section -->
        <div class="container-xxl py-5 bg-dark hero-header mb-5">
            <div class="container my-5 py-5">
                <div class="row align-items-center g-5">
                    <div class="col-lg-6 text-center text-lg-start">
                        <h1 class="display-3 text-white animated slideInLeft">
                            Enjoy Our<br>Delicious Meals
                        </h1>
                        <p class="text-white animated slideInLeft mb-4 pb-2">
                            Experience the best dining with our mouth-watering dishes prepared fresh daily. Savor every bite in a cozy and welcoming atmosphere.
                        </p>
                        <a href="<?php echo APPURL; ?>/booking.php" class="btn btn-primary py-sm-3 px-sm-5 me-3 animated slideInLeft">
                            Book A Table
                        </a>
                    </div>
                    <div class="col-lg-6 text-center text-lg-end overflow-hidden">
                        <img class="img-fluid" src="<?php echo APPURL; ?>/img/hero.png" alt="Hero Image">
                    </div>
                </div>
            </div>
        </div>

        <!-- Service Section -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="row g-4">
                    <?php
                    // Service items
                    $services = [
                        ['icon' => 'fa-user-tie', 'title' => 'Expert Chefs', 'desc' => 'Our highly skilled chefs prepare every dish with passion and creativity.'],
                        ['icon' => 'fa-utensils', 'title' => 'Top Quality Food', 'desc' => 'We use only the freshest ingredients to ensure your meal is delicious and nutritious.'],
                        ['icon' => 'fa-cart-plus', 'title' => 'Easy Online Ordering', 'desc' => 'Order your favorite meals conveniently through our user-friendly online platform.'],
                        ['icon' => 'fa-headset', 'title' => '24/7 Customer Support', 'desc' => 'We are here for you round the clock to assist with your orders and inquiries.']
                    ];
                    foreach ($services as $index => $service) : ?>
                        <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.<?php echo (1 + $index * 2); ?>s">
                            <div class="service-item rounded pt-3">
                                <div class="p-4">
                                    <i class="fa fa-3x <?php echo $service['icon']; ?> text-primary mb-4"></i>
                                    <h5><?php echo $service['title']; ?></h5>
                                    <p><?php echo $service['desc']; ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- About Section -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="row g-5 align-items-center">
                    <div class="col-lg-6">
                        <div class="row g-3">
                            <div class="col-6 text-start">
                                <img class="img-fluid rounded w-100 wow zoomIn" data-wow-delay="0.1s" src="<?php echo APPURL; ?>/img/about-1.jpg" alt="Our Chefs">
                            </div>
                            <div class="col-6 text-start">
                                <img class="img-fluid rounded w-75 wow zoomIn" data-wow-delay="0.3s" src="<?php echo APPURL; ?>/img/about-2.jpg" alt="Fresh Ingredients" style="margin-top: 25%;">
                            </div>
                            <div class="col-6 text-end">
                                <img class="img-fluid rounded w-75 wow zoomIn" data-wow-delay="0.5s" src="<?php echo APPURL; ?>/img/about-3.jpg" alt="Cozy Dining Area">
                            </div>
                            <div class="col-6 text-end">
                                <img class="img-fluid rounded w-100 wow zoomIn" data-wow-delay="0.7s" src="<?php echo APPURL; ?>/img/about-4.jpg" alt="Delicious Dishes">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <h5 class="section-title ff-secondary text-start text-primary fw-normal">About Us</h5>
                        <h1 class="mb-4">
                            Welcome to <i class="fa fa-utensils text-primary me-2"></i>Restoran
                        </h1>
                        <p class="mb-4">
                            At Restoran, we are committed to providing exceptional dining experiences. Our talented team combines the finest ingredients with expert preparation to create memorable meals for every guest.
                        </p>
                        <p class="mb-4">
                            Whether you're joining us for a family dinner or a special occasion, we strive to deliver top quality food and outstanding service in a warm and inviting ambiance.
                        </p>
                        <div class="row g-4 mb-4">
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center border-start border-5 border-primary px-3">
                                    <h1 class="flex-shrink-0 display-5 text-primary mb-0" data-toggle="counter-up">15</h1>
                                    <div class="ps-4">
                                        <p class="mb-0">Years of</p>
                                        <h6 class="text-uppercase mb-0">Experience</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center border-start border-5 border-primary px-3">
                                    <h1 class="flex-shrink-0 display-5 text-primary mb-0" data-toggle="counter-up">50</h1>
                                    <div class="ps-4">
                                        <p class="mb-0">Skilled</p>
                                        <h6 class="text-uppercase mb-0">Master Chefs</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a class="btn btn-primary py-3 px-5 mt-2" href="<?php echo APPURL; ?>/about.php">Read More</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Menu Section -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                    <h5 class="section-title ff-secondary text-center text-primary fw-normal">Food Menu</h5>
                    <h1 class="mb-5">Most Popular Items</h1>
                </div>
                <div class="tab-class text-center wow fadeInUp" data-wow-delay="0.1s">
                    <ul class="nav nav-pills d-inline-flex justify-content-center border-bottom mb-5">
                        <?php
                        $tabs = [
                            ['id' => 'tab-1', 'icon' => 'fa-coffee', 'small' => 'Popular', 'title' => 'Breakfast', 'active' => true],
                            ['id' => 'tab-2', 'icon' => 'fa-hamburger', 'small' => 'Special', 'title' => 'Lunch', 'active' => false],
                            ['id' => 'tab-3', 'icon' => 'fa-utensils', 'small' => 'Delicious', 'title' => 'Dinner', 'active' => false]
                        ];
                        foreach ($tabs as $tab) : ?>
                            <li class="nav-item">
                                <a class="d-flex align-items-center text-start mx-3 <?php echo $tab['active'] ? 'ms-0 pb-3 active' : 'pb-3'; ?>" data-bs-toggle="pill" href="#<?php echo $tab['id']; ?>">
                                    <i class="fa <?php echo $tab['icon']; ?> fa-2x text-primary"></i>
                                    <div class="ps-3">
                                        <small class="text-body"><?php echo $tab['small']; ?></small>
                                        <h6 class="mt-n1 mb-0"><?php echo $tab['title']; ?></h6>
                                    </div>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <div class="tab-content">
                        <?php
                        $mealsArr = [$meals_1, $meals_2, $meals_3];
                        foreach ($tabs as $index => $tab) : ?>
                            <div id="<?php echo $tab['id']; ?>" class="tab-pane fade show p-0 <?php echo $tab['active'] ? 'active' : ''; ?>">
                                <div class="row g-4">
                                    <?php foreach ($mealsArr[$index] as $meal) : ?>
                                        <div class="col-lg-6">
                                            <div class="d-flex align-items-center">
                                                <img class="flex-shrink-0 img-fluid rounded" src="<?php echo APPIMAGES; ?>/<?php echo htmlspecialchars($meal->image); ?>" alt="<?php echo htmlspecialchars($meal->name); ?>" style="width: 80px;">
                                                <div class="w-100 d-flex flex-column text-start ps-4">
                                                    <h5 class="d-flex justify-content-between border-bottom pb-2">
                                                        <span><?php echo htmlspecialchars($meal->name); ?></span>
                                                        <span class="text-primary">₹<?php echo htmlspecialchars($meal->price); ?></span>
                                                    </h5>
                                                    <small class="fst-italic"><?php echo htmlspecialchars($meal->description); ?></small>
                                                    <a href="<?php echo APPURL; ?>/food/add-cart.php?id=<?php echo (int)$meal->id; ?>" class="btn btn-primary py-2 top-0 end-0 mt-2 me-2">View Details</a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <?php require __DIR__ . "/includes/footer.php"; ?>
    </div> <!-- container-xxl -->

    <!-- Scripts: Bootstrap JS, your JS etc, you can add here -->
    <script src="<?php echo APPURL; ?>/js/bootstrap.bundle.min.js"></script>
</body>

</html>
