<?php
require "config/config.php";
require "libs/App.php";
require "includes/header.php";

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirect if the user did not come from a proper referer (optional, as in your original)
if (!isset($_SERVER['HTTP_REFERER'])) {
    echo "<script>window.location.href='" . APPURL . "'</script>";
    exit;
}

// Initialize App instance
$app = new App();

if (isset($_POST['submit'])) {
    // Sanitize and assign inputs
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $date_booking = trim($_POST['date_booking'] ?? '');
    $num_people = trim($_POST['num_people'] ?? '');
    $special_request = trim($_POST['special_request'] ?? '');
    $status = "Pending";
    $user_id = $_SESSION['user_id'] ?? null;

    // Basic validation - also ensure user is logged in
    if (!$user_id) {
        // If user ID not set in session, redirect to login maybe
        echo "<script>alert('You must be logged in to book a table.');</script>";
        echo "<script>window.location.href='auth/login.php'</script>";
        exit;
    }

    // Validate that booking date is in the future — parse and compare appropriately
    $booking_timestamp = strtotime($date_booking);
    $current_timestamp = time();

    if ($booking_timestamp && $booking_timestamp > $current_timestamp) {
        $query = "INSERT INTO bookings (name, email, date_booking, num_people, special_request, status, user_id) 
                  VALUES (:name, :email, :date_booking, :num_people, :special_request, :status, :user_id)";
        
        $arr = [
            ":name" => $name,
            ":email" => $email,
            ":date_booking" => date('Y-m-d H:i:s', $booking_timestamp), // store in standard datetime format
            ":num_people" => $num_people,
            ":special_request" => $special_request,
            ":status" => $status,
            ":user_id" => $user_id,
        ];
        
        $path = "index.php";
        
        $app->insert($query, $arr, $path);
    } else {
        echo "<script>alert('Invalid date selected. Please pick a date and time in the future.')</script>";
        echo "<script>window.location.href='index.php'</script>";
        exit;
    }
}
?>

<?php require "includes/footer.php"; ?>
