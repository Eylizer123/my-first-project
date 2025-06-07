<?php
include '../components/connection.php';

session_start();

$user_id = ''; // Initialize user_id as empty by default
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}

if (isset($_POST['logout'])) {
    session_destroy();
    $admin_id = $_SESSION['admin_id'] ?? null; // Use null coalescing to prevent undefined index

    if (!isset($admin_id)) {
        header("Location: login.php");
        exit(); // It's good practice to call exit after a header redirection
    }
}

// Adding product to wishlist
if (isset($_POST['add_to_wishlist'])) {
    $id = unique_id();
    $product_id = $_POST['product_id'];

    $varify_wishlist = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ? AND product_id = ?");
    $varify_wishlist->execute([$user_id, $product_id]);

    $cart_num = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ? AND product_id = ?");
    $cart_num->execute([$user_id, $product_id]);

    if ($varify_wishlist->rowCount() > 0) {
        $warning_msg[] = 'Product already exists in your wishlist';
    } else if ($cart_num->rowCount() > 0) {
        $warning_msg[] = 'Product already exists in your cart';
    } else {
        $select_price = $conn->prepare("SELECT * FROM `products` WHERE id = ? LIMIT 1");
        $select_price->execute([$product_id]);
        $fetch_price = $select_price->fetch(PDO::FETCH_ASSOC); // Corrected typo here

        $insert_wishlist = $conn->prepare("INSERT INTO `wishlist` (id, user_id, product_id, price) VALUES (?, ?, ?, ?)");
        $insert_wishlist->execute([$id, $user_id, $product_id, $fetch_price['price']]);
        $success_msg[] = 'Product added to wishlist successfully';
    }
}

//adding product in cart
if (isset($_POST['add_to_cart'])) {
    $id = unique_id(); 
    $product_id = $_POST['product_id'];
   
    $qty = $_POST['qty'];
    $qty = filter_var($_POST['qty'], FILTER_SANITIZE_NUMBER_INT);

    // Correcting the variable syntax here
    $varify_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ? AND product_id = ?");
    $varify_cart->execute([$user_id, $product_id]);

    $max_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
    $max_cart_items->execute([$user_id]);

    if ($varify_cart->rowCount() > 0) {
        $warning_msg[] = 'Product already exists in your cart';
    } else if ($max_cart_items->rowCount() > 20) {
        $warning_msg[] = 'Cart is full';
    } else {
        $select_price = $conn->prepare("SELECT * FROM `products` WHERE id = ? LIMIT 1");
        $select_price->execute([$product_id]);
        $fetch_price = $select_price->fetch(PDO::FETCH_ASSOC);

        // Correcting the syntax of the INSERT query
        $insert_cart = $conn->prepare("INSERT INTO `cart` (id, user_id, product_id, price, qty) VALUES (?, ?, ?, ?, ?)");
        $insert_cart->execute([$id, $user_id, $product_id, $fetch_price['price'], $qty]);

        $success_msg[] = 'Product added to cart successfully';
    }
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- boxicon cdn link -->
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" type="text/css" href="admin_style.css?v=<?php echo time(); ?>">
    <title>Clothing Shop - Product Detail Page</title>
</head>
<body>
    <?php include '../components/admin_header.php'; ?>
    
    <div class="main">
        <div class="banner">
            <h1>Product Detail</h1>
        </div>
        <div class="title2">
            <a href="dashboard.php">Dashboard</a><span> / Product Detail</span>
        </div>
        <section class="read-post">
            <h1 class="heading">Read Product</h1>
            <?php
            // Fetch product details
            if (isset($_GET['id'])) {
                $get_id = $_GET['id'];
                $select_product = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
                $select_product->execute([$get_id]);

                if ($select_product->rowCount() > 0) {
                    while ($fetch_product = $select_product->fetch(PDO::FETCH_ASSOC)) {
            ?> 
            <form action="" method="post">
                <input type="hidden" name="product_id" value="<?= $fetch_product['id']; ?>">
                
                <div class="status" style="color: <?php echo ($fetch_product['status'] == 'active') ? 'green' : 'red'; ?>">
                    <?= htmlspecialchars($fetch_product['status']); ?>
                </div>
                <?php if ($fetch_product['image'] != '') { ?>
                            <img src="../image/<?= $fetch_product['image']; ?>" class="image">
                        <?php } ?>
                <div class="price">$<?= htmlspecialchars($fetch_product['price']); ?>/-</div>
                <div class="title"><?= htmlspecialchars($fetch_product['name']); ?></div>
                <div class="content"><?= htmlspecialchars($fetch_product['product_detail']); ?></div>
                <div class="flex-btn">
                    <a href="view_page.php?id=<?= $fetch_product['id']; ?>" class="btn">ViewPage</a>
                    <button type="submit" name="add_to_cart" class="btn" onclick="return confirm('Add this product to cart?');">AddCart</button>
                    <button type="submit" name="add_to_wishlist" class="btn" onclick="return confirm('Add this product to wishlist?');">AddWishlist</button>
                </div>
                <div class="flex">                       
                    <input type="number" name="qty" required min="1" value="1" max="99" maxlength="2" class="qty">
                </div>
                <a href="checkout.php?get_id=<?= $fetch_product['id']; ?>" class="btn">Buy Now</a> 
                <br> 
                <br>  
                <a href="view_product.php?id=<?= $get_id;?>" class="btn">go back</a>
            </form>
            <?php
                    }
                } else {
                    echo '<div class="empty"><p>No product found! <br> <a href="add_products.php" style="margin-top:1.5rem;" class="btn">Add Product</a></p></div>';
                }
            } else {
                echo '<div class="empty"><p>Invalid product ID!</p></div>';
            }
            ?>          
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