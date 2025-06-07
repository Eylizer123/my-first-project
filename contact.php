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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Boxicons CDN link -->
    <link href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="admin_style.css?v=<?php echo time(); ?>">
    <title> Clothing Shop - Contact Us</title>
</head>
<body>
    <?php include '../components/admin_header.php'; ?>

    <div class="main">
        <div class="banner">
            <h1>Contact Us</h1>
        </div>
        <div class="title2">
            <a href="dashboard.php">Dashboard</a><span> / Contact Us</span>
        </div>

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
                        <h3>Worldwide Delivery</h3>
                        <p>Dropship worldwide</p>
                    </div>
                </div>
            </div>       
        <div class="form-container">
            <form method="post">
                <div class="title">
                    <img src="../Images/KABAYAN CLOTHING LOGO.png" class="logo" alt="Logo">
                    <h1>Leave a Message</h1>
                </div>
                <div class="input-field">
                    <p>Your Name <sup>*</sup></p>
                    <input type="text" name="name" required>
                </div>
                <div class="input-field">
                    <p>Your Email <sup>*</sup></p>
                    <input type="email" name="email" required>
                </div>
                <div class="input-field">
                    <p>Your Number <sup>*</sup></p>
                    <input type="text" name="number" required>
                </div>
                <div class="input-field">
                    <p>Your Message <sup>*</sup></p>
                    <textarea name="message" required></textarea>
                </div>
                <button type="submit" name="submit-btn" class="btn">Send Message</button>
            </form>
    </div>
    <div class="address">
                <div class="title">
                    <img src="../Images/KABAYAN CLOTHING LOGO.png" class="logo" alt="Logo">
                    <h1>Contact Details</h1>
                    <p>If you have any questions or need assistance, 
                        feel free to reach out to us. Our customer support team is here to help you with your inquiries.</p>
                </div>
                <div class="box-container">
                    <div class="box">
                        <i class="bx bxs-map-pin"></i>
                        <div>
                            <h4>Address</h4>
                            <p>Gen.tinio,Cabanatuan</p>
                        </div>
                    </div>
                    <div class="box">
                        <i class="bx bxs-phone-call"></i>
                        <div>
                            <h4>Phone Number</h4>
                            <p>09292340918</p>
                        </div>
                    </div>
                    <div class="box">
                        <i class="bx bxs-envelope"></i>
                        <div>
                            <h4>Email</h4>
                            <p>KabayanClothing@gmail.com</p>
                        </div>
                    </div>
                </div>
            </div>
    <!-- SweetAlert CDN link -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <!-- Custom JS link -->
    <script type="text/javascript" src="script.js"></script>
    <!-- Alert -->
    <?php include '../components/alert.php'; ?>
</body>
</html>