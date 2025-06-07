<?php
include '../components/connection.php';

session_start();
if (isset($_SESSION['user_id'])) {
$user_id = $_SESSION['user_id'];
}else{
}
$user_id = '';
if (isset($_POST['logout'])) {
session_destroy();
header("location: login.php");
}

    if (isset($_GET['get_id'])) {
    $get_id = $_GET['get_id'];
    }else{
    $get_id = '';
    header('location: order.php');
    }

    if (isset($_POST['cancel'])) {
        $update_order = $conn->prepare("UPDATE `orders` SET status = ? WHERE id = ?");
        $update_order->execute(['canceled', $get_id]);
        header("Location: order.php");
    }


?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- boxicon cdn link -->
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" type="text/css" href="admin_style.css?v=<?php echo time(); ?>">
    <title>Clothing Shop - Order detail Page</title>
</head>
<body>
    <?php include '../components/admin_header.php'; ?>
    <div class="main">
        <div class="banner">
            <h1>order detail</h1>
        </div>
        <div class="title2">
            <a href="dashboard.php">Dashboard</a><span> / Order detail</span>
        </div>
        <section class="order-detail">
  <div class="title">
    <img src="../Images/KABAYAN CLOTHING LOGO.png" class="logo">
    <h1>Order Details</h1>
<p>Here you can find all the information about your order, including item descriptions,
   quantities, prices, and shipping details. Review your order carefully to ensure everything is correct.</p>
  </div>

  <div class="box-container">
    <?php
    $grand_total = 0;
    $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE id = ? LIMIT 1");
    $select_orders->execute([$get_id]);
    
    if ($select_orders->rowCount() > 0) {
      while($fetch_order = $select_orders->fetch(PDO::FETCH_ASSOC)) {
        $select_product = $conn->prepare("SELECT * FROM `products` WHERE id = ? LIMIT 1");
        $select_product->execute([$fetch_order['product_id']]);
        
        if ($select_product->rowCount() > 0) {
          while($fetch_product = $select_product->fetch(PDO::FETCH_ASSOC)) {
            $sub_total = ($fetch_order['price'] * $fetch_order['qty']);
            $grand_total += $sub_total;  
    ?>
    <div class="box">
      <div class="col">
        <p class="title"><i class="bi bi-calendar-fill"></i><?= $fetch_order['date']; ?></p>

                <?php if ($fetch_product['image'] != '') { ?>
                                    <img src="../image/<?= htmlspecialchars($fetch_product['image']); ?>" class="image">
                                <?php } ?>
        <p class="price"><?= $fetch_product['price']; ?> x <?= $fetch_order['qty']; ?></p>
        <h3 class="name"><?= $fetch_product['name']; ?></h3>
        <p class="grand-total">Total amount payable: <span>$<?= $grand_total; ?></span></p>
      </div>
      <div class="col">
        <p class="title">billing address</p>
        <p class="user"><i class="bx  bxs-user"></i><?= $fetch_order['name']; ?></p>
        <p class="user"><i class="bx bxs-phone"></i><?= $fetch_order['number']; ?></p>
        <p class="user"><i class="bx bxs-envelope"></i><?= $fetch_order['email']; ?></p>
        <p class="user"><i class="bx bxs-map-pin"></i><?= $fetch_order['address']; ?></p>
        <p class="title">status</p>
        <p class="status" style="color:<?php if ($fetch_order['status'] == 'delivered') { echo 'green'; } elseif($fetch_order['status'] == 'canceled') { echo 'red'; } else { echo 'orange'; } ?>"><?=$fetch_order['status']; ?></p>
        <?php if ($fetch_order['status'] == 'canceled') { ?>
          <a href="checkout.php?get_id=<?= $fetch_product['id']; ?>" class="btn">order again</a>
        <?php } else { ?>
          <form method="post">
            <button type="submit" name="cancel" class="btn" onclick="return confirm('Do you want to cancel this order?')">cancel order</button>
          </form>
        <?php } ?>
      </div>
    </div>
    <?php
          }
        } else {
          echo '<p class="empty">product not found</p>';
        }
      }
    } else {
      echo '<p class="empty">no order found</p>';
    }
    ?>
  </div>
</section>
    </div>
    <!-- sweetalert cdn link -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <!-- custom js link -->
    <script type="text/javascript" src="script.js"></script>
    <!-- alert -->
    <?php include '../components/alert.php'; ?>
</body>
</html>