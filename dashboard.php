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
    <title>Clothing Shop - home page</title>
</head>
<body>
    <?php include '../components/admin_header.php'; ?>
    <div class="main">
        <div class="banner">
            <h1>home</h1>
        </div>
        <div class="title2">
            <a href="dashboard.php">Dashboard</a><span> / home</span>
        </div>
        <section class="home-section">
     <div class="slider">
    <div class="slider_slider slide1">
        <div class="overlay"></div>
        <div class="slide-detail">
            <h1>Welcome to My Shop</h1>
            <p>Tuklasin ang mga damit na may kalidad at gawang local</p>
            <a href="view_product.php" class="btn">Shop Now</a>
        </div>
        <div class="hero-dec-top"></div>
        <div class="hero-dec-bottom"></div>
    </div>
    <!-- slide end -->
    <div class="slider_slider slide2">
        <div class="overlay"></div>
        <div class="slide-detail">
            <h1>Welcome to My Shop</h1>
            <p>Tuklasin ang mga damit na may kalidad at gawang local</p>
            <a href="view_product.php" class="btn">Shop Now</a>
        </div>
        <div class="hero-dec-top"></div>
        <div class="hero-dec-bottom"></div>
    </div>
    <!-- slide end -->
    <div class="slider_slider slide3">
        <div class="overlay"></div>
        <div class="slide-detail">
            <h1>Welcome to My Shop</h1>
            <p>Tuklasin ang mga damit na may kalidad at gawang local</p>
            <a href="view_product.php" class="btn">Shop Now</a>
        </div>
        <div class="hero-dec-top"></div>
        <div class="hero-dec-bottom"></div>
    </div>
   <!-- slide end -->
    <div class="slider_slider slide4">
        <div class="overlay"></div>
        <div class="slide-detail">
            <h1>Welcome to My Shop</h1>
            <p>Tuklasin ang mga damit na may kalidad at gawang local</p>
            <a href="view_product.php" class="btn">Shop Now</a>
        </div>
        <div class="hero-dec-top"></div>
        <div class="hero-dec-bottom"></div>
    </div>
   <!-- slide end -->
    <div class="slider_slider slide5">
        <div class="overlay"></div>
        <div class="slide-detail">
            <h1>Welcome to My Shop</h1>
            <p>Tuklasin ang mga damit na may kalidad at gawang local</p>
            <a href="view_product.php" class="btn">Shop Now</a>
        </div>
        <div class="hero-dec-top"></div>
        <div class="hero-dec-bottom"></div>
    </div>
<!-- slide end -->
<div class="left-arrow">
    <i class="bx bxs-left-arrow"></i>
</div>
<div class="right-arrow">
    <i class="bx bxs-right-arrow"></i>
</div>
</section>
<section class="container">
    <div class="box-container">
        <div class="box">
            <img src="../Images/ICON-JORDAN CLARKSON.png" alt="Healthy Tea">
            <span>Clothing</span>
<h1>Save Up to 10% Off</h1>
<p>Ang aming Clothing Shop ay nag-aalok ng makabagong damit na may tradisyunal na gawang Pilipino, 
    na angkop sa anumang okasyon. Tuklasin ang mga damit na may kalidad at gawang local.</p>
    </div>
</section>
<section class="shop">
   
    <div class="box-container">
        <div class="box">
            <img src="../image/tshirt 1.jpg" alt="Product 1">
            <a href="view_product.php" class="btn">Shop Now</a>
        </div>
        <div class="box">
            <img src="../image/tshirt 3.jpeg" alt="Product 2">
            <a href="view_product.php" class="btn">Shop Now</a>
        </div>
        <div class="box">
            <img src="../image/tshirt 4.jpeg" alt="Product 3">
            <a href="view_product.php" class="btn">Shop Now</a>
        </div>
        <div class="box">
            <img src="../image/tshirt 1.jpg" alt="Product 4">
            <a href="view_product.php" class="btn">Shop Now</a>
        </div>
        <div class="box">
            <img src="../image/tshirt 1.jpg" alt="Product 5">
            <a href="view_product.php" class="btn">Shop Now</a>
        </div>
        <div class="box">
            <img src="../image/tshirt 2.jpeg" alt="Product 6">
            <a href="view_product.php" class="btn">Shop Now</a>
        </div>
    </div>
</section>

<section class="shop-category">
    <div class="box-container">
        <div class="box">
            <img src="../Images/ICON-3 STARS AND A SUN.png" alt="Big Offers">
            <div class="detail">
                <span>BIG OFFERS</span>
                <h1>Extra 10% off</h1>
                <a href="view_product.php" class="btn">Shop Now</a>
            </div>
        </div>
        <div class="box">
            <img src="../Images/ICON-DYAMANTE.png" alt="New in Taste">
            <div class="detail">
                <h1>Product Home</h1>
                <a href="view_product.php" class="btn">Shop Now</a>
            </div>
        </div>
    </div>
</section>
<section class="services">
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
    </div>
    <!-- sweetalert cdn link -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <!-- custom js link -->
    <script type="text/javascript" src="script.js"></script>
    <!-- alert -->
    <?php include '../components/alert.php'; ?>
</body>
</html>