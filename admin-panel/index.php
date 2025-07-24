<?php 
require "../config/config.php"; 
require "../libs/App.php"; 
require "layouts/header.php"; 

$app = new App();
$app->validateSessionAdminInside();

// Fetch counts
$count_foods = $app->selectOne("SELECT COUNT(*) AS count_foods FROM foods");
$count_orders = $app->selectOne("SELECT COUNT(*) AS count_orders FROM orders");
$count_bookings = $app->selectOne("SELECT COUNT(*) AS count_bookings FROM bookings");
$count_admins = $app->selectOne("SELECT COUNT(*) AS count_admins FROM admins");
?>

<div class="container mt-5">
  <div class="row g-4">
    <div class="col-md-3">
      <div class="card border-primary">
        <div class="card-body">
          <h5 class="card-title">Foods</h5>
          <p class="card-text">Number of foods: <strong><?php echo $count_foods ? $count_foods->count_foods : 0; ?></strong></p>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card border-success">
        <div class="card-body">
          <h5 class="card-title">Orders</h5>
          <p class="card-text">Number of orders: <strong><?php echo $count_orders ? $count_orders->count_orders : 0; ?></strong></p>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card border-warning">
        <div class="card-body">
          <h5 class="card-title">Bookings</h5>
          <p class="card-text">Number of bookings: <strong><?php echo $count_bookings ? $count_bookings->count_bookings : 0; ?></strong></p>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card border-danger">
        <div class="card-body">
          <h5 class="card-title">Admins</h5>
          <p class="card-text">Number of admins: <strong><?php echo $count_admins ? $count_admins->count_admins : 0; ?></strong></p>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require "layouts/footer.php"; ?>
