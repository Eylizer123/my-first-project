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
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- boxicon cdn link -->
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" type="text/css" href="admin_style.css?v=<?php echo time(); ?>">
    <title>Clothing Shop - All Products Page</title>
</head>
<body>
    <?php include '../components/admin_header.php'; ?>
    <div class="main">
        <div class="banner">
            <h1>All Products</h1>
        </div>
        <div class="title2">
            <a href="dashboard.php">Dashboard</a><span> / All Products</span>
        </div>
        <section class="show-post">
            <h1 class="heading">All Products</h1>
            <div class="box-container">
                <?php
                $select_products = $conn->prepare("SELECT * FROM `products`");
                $select_products->execute();

                if ($select_products->rowCount() > 0) {
                    while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
                ?>
                    <form action="" method="post" class="box">
                        <input type="hidden" name="product_id" value="<?= $fetch_products['id']; ?>">
                        <?php if ($fetch_products['image'] != '') { ?>
                            <img src="../image/<?= $fetch_products['image']; ?>" class="image">
                        <?php } ?>
                        <div class="price">$<?= $fetch_products['price']; ?>/-</div>
                        <div class="title"><?= $fetch_products['name']; ?></div>
                        <div class="flex-btn">
                            <a href="view_page.php?id=<?= $fetch_products['id']; ?>" class="btn">ViewPage</a>
                            <button type="submit" name="add_to_cart" class="btn" onclick="return confirm('Add this product to cart?');">AddCart</button>
                            <button type="submit" name="add_to_wishlist" class="btn" onclick="return confirm('Add this product to wishlist?');">AddWishlist</button>
                        </div>
                        <div class="flex">
                           <label for="size"></label>
                           <select name="size" id="size" required>
                           <option value="" disabled selected>size</option>
                           <option value="S">Small (S)</option>
                           <option value="M">Medium (M)</option>
                           <option value="L">Large (L)</option>
                           <option value="XL">Extra Large (XL)</option>
                           </select>
    
                           <input type="number" name="qty" required min="1" value="1" max="99" maxlength="2" class="qty">
                           </div>
                        <a href="checkout.php?get_id=<?= $fetch_products['id']; ?>" class="btn">Buy Now</a>
                    </form>
                <?php
                    }
                } else {
                    echo '
                    <div class="empty">
                        <p>No product added yet! <br> <a href="add_products.php" style="margin-top:1.5rem;" class="btn">Add Product</a></p>
                    </div>
                    ';
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