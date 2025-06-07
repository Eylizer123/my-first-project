<?php
include '../components/connection.php';

session_start();

// Check if the user is logged in, otherwise set user_id to an empty string
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = ''; // Assign empty string only if not logged in
}

// Logout and redirect to register page
if (isset($_POST['logout'])) {
    session_destroy();
    header("location: register.php");
    exit(); // Ensure no further code is executed after redirect
}

// Another logout condition - redirect to login page (Note: this part is redundant)
if (isset($_POST['logout'])) {
    session_destroy();
    header("location: login.php");
    exit(); // Ensure no further code is executed after redirect
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
    <title> Clothing Shop - about us page</title>
</head>
<body>
    <?php include '../components/admin_header.php'; ?>
    <div class="main">
        <div class="banner">
            <h1>about us</h1>
        </div>
        <div class="title2">
            <a href="dashboard.php">Dashboard</a><span> / about </span>
        </div>
        <div class="about-category">
    <div class="box">
        <img src="../image/tshirt 1.jpg" alt="Lemon Green Coffee">
        <div class="detail">
            <h1>Clothing Tshirt</h1>
            <a href="view_product.php" class="btn">Shop Now</a>
        </div>
    </div>
    <div class="box">
        <img src="../image/tshirt 2.jpeg" alt="Lemon Teaname Coffee">
        <div class="detail">          
            <h1>Clothing Tshirt</h1>
            <a href="view_product.php" class="btn">Shop Now</a>
        </div>
    </div>
    <div class="box">
        <img src="../image/tshirt 2.jpeg" alt="Lemon Teaname Coffee">
        <div class="detail">
            <h1>Clothing Tshirt</h1>
            <a href="view_product.php" class="btn">Shop Now</a>
        </div>
    </div>
    <div class="box">
        <img src="../image/tshirt 3.jpeg" alt="Lemon Green Coffee">
        <div class="detail">
            <h1>Clothing Tshirt</h1>
            <a href="view_product.php" class="btn">Shop Now</a>
        </div>
    </div>
</div>

<section class="services">
<div class="title">
            <img src="../images/KABAYAN CLOTHING LOGO.png" class="logo">
            <h1>Why you choose us</h1>
            <p>Experience Filipino heritage in every stitch—authentic, 
                sustainable clothing crafted by local artisans, blending culture and style to let you wear pride and support communities.</p>
    <div class="box-container">
        <div class="box">
            <img src="../image/eyli.png" alt="Great Savings Icon">
            <div class="detail">
                <h3>Great Savings</h3>
                <p>Save big on every order</p>
            </div>
        </div>
        <div class="box">
            <img src="../image/eylis.png" alt="24/7 Support Icon">
            <div class="detail">
                <h3>24/7 Support</h3>
                <p>One-on-one support</p>
            </div>
        </div>
        <div class="box">
            <img src="../image/eyliss.png" alt="Gift Vouchers Icon">
            <div class="detail">
                <h3>Gift Vouchers</h3>
                <p>Vouchers on every festival</p>
            </div>
        </div>
        <div class="box">
            <img src="../image/eyliz.png" alt="Worldwide Delivery Icon">
            <div class="detail">
                <h3>Local Delivery</h3>
                <p>Dropship Local</p>
            </div>
        </div>
    </div>
</section>
<div class="about">
  <div class="row">
    <div class="img-box">
      <img src="../KABAYAN SYSTEM PROJECT/bg1 .png">
    </div>
    <div class="detail">
    <h1>Visit Our Stylish Showroom!</h1>
    <p>Our showroom offers thoughtfully crafted clothing with unique designs. Whether you need a statement piece or something versatile,
         our collection is made to inspire confidence and elevate your style. Discover quality pieces made with care.</p>
      <a href="view_product.php" class="btn">shop now</a>
    </div>
  </div>
</div>


    </div>
    <!-- sweetalert cdn link -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <!-- custom js link -->
    <script type="text/javascript" src="script.js"></script>
    <!-- alert -->
    <?php include '../components/alert.php'; ?>
</body>
</html>