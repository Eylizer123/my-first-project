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


?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- boxicon cdn link -->
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" type="text/css" href="admin_style.css?v=<?php echo time(); ?>">
    <title>Clothing Shop - Order Page</title>
</head>
<body>
    <?php include '../components/admin_header.php'; ?>
    <div class="main">
        <div class="banner">
            <h1>My Orders</h1>
        </div>
        <div class="title2">
            <a href="dashboard.php">Dashboard</a><span> / Order</span>
        </div>
        <section class="orders">
            <div class="box-container">
                <div class="title">
                    <img src="../Images/KABAYAN CLOTHING LOGO.png" class="logo">
                    <h1>My Orders</h1>
     <p>View your order history and track the status of your purchases.
     If you have any concerns or need to make changes, please contact our support team for assistance.</p>
                </div>

                <?php
                $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ? ORDER BY date DESC");
                $select_orders->execute([$user_id]);

                if ($select_orders->rowCount() > 0) {
                    while ($fetch_order = $select_orders->fetch(PDO::FETCH_ASSOC)) {
                        $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
                        $select_products->execute([$fetch_order['product_id']]);

                        if ($select_products->rowCount() > 0) {
                            while ($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)) {
                ?>
                            <div class="box" <?php if ($fetch_order['status'] == 'canceled') { echo 'style="border: 2px solid red;"'; } ?>>
                                <a href="view_order.php?get_id=<?= $fetch_order['id']; ?>">
                                    <p class="date"><i class="bi bi-calendar-fill"></i><span><?= $fetch_order['date']; ?></span></p>
                                    <?php if ($fetch_product['image'] != '') { ?>
                                        <img src="../image/<?= $fetch_product['image']; ?>" class="image">
                                    <?php } ?>
                                    <div class="row">
                                        <h3 class="name"><?= $fetch_product['name']; ?></h3>
                                        <p class="price">Price: $<?= $fetch_order['price']; ?> x <?= $fetch_order['qty']; ?></p>
                                        <p class="status" style="color: <?php 
                                            if ($fetch_order['status'] == 'delivered') {
                                                echo 'green';
                                            } elseif ($fetch_order['status'] == 'canceled') {
                                                echo 'red';
                                            } else {
                                                echo 'orange';
                                            }
                                        ?>;">
                                            <?= ucfirst($fetch_order['status']); ?>
                                        </p>
                                    </div>
                                </a>
                            </div>
                <?php
                            }
                        }
                    }
                } else {
                    echo '<p class="empty">No orders placed yet!</p>';
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