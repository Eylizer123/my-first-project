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

//adding product in cart
if (isset($_POST['add_to_cart'])) {
    $id = unique_id(); 
    $product_id = $_POST['product_id'];
   
    $qty = isset($_POST['qty']) ?
   filter_var($_POST['qty'], FILTER_SANITIZE_NUMBER_INT):1 ;

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


// Deleting item from the wishlist
if (isset($_POST['delete_item'])) {
    $wishlist_id = filter_var($_POST['wishlist_id'], FILTER_SANITIZE_STRING);

    // Verify if the wishlist item exists
    $verify_delete_items = $conn->prepare("SELECT * FROM `wishlist` WHERE id = ?");
    $verify_delete_items->execute([$wishlist_id]);

    if ($verify_delete_items->rowCount() > 0) {
        // If the wishlist item exists, delete it
        $delete_wishlist_id = $conn->prepare("DELETE FROM `wishlist` WHERE id = ?");
        $delete_wishlist_id->execute([$wishlist_id]);

        $success_msg[] = "Wishlist item deleted successfully";
    } else {
        $warning_msg[] = "Wishlist item already deleted";
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
    <title>Clothing Shop - Wishlist Page</title>
</head>
<body>
    <?php include '../components/admin_header.php'; ?>
    
    <div class="main">
        <div class="banner">
            <h1>My Wishlist</h1>
        </div>
        <div class="title2">
            <a href="dashboard.php">Dashboard</a><span> / Wishlist</span>
        </div>
        <section class="read-post">
            <h1 class="title">Products Added to Wishlist</h1>
            <div class="box-container">
                <?php
                $grand_total = 0;
                $select_wishlist = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ?");
                $select_wishlist->execute([$user_id]);

                if ($select_wishlist->rowCount() > 0) {
                    while ($fetch_wishlist = $select_wishlist->fetch(PDO::FETCH_ASSOC)) {
                        $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
                        $select_products->execute([$fetch_wishlist['product_id']]);

                        if ($select_products->rowCount() > 0) {
                            $fetch_products = $select_products->fetch(PDO::FETCH_ASSOC);
                ?>
                            <form method="post" action="" class="box">
                                <input type="hidden" name="wishlist_id" value="<?= htmlspecialchars($fetch_wishlist['id']); ?>">
                                <?php if ($fetch_products['image'] != '') { ?>
                                    <img src="../image/<?= htmlspecialchars($fetch_products['image']); ?>" class="image">
                                <?php } ?>
                                <div class="button">
                                <button type="submit" name="add_to_cart">Add to Cart</button>
                                
                                <button type="submit" name="delete_item" onclick="return confirm('Delete this item?');">
                                   Delete Item
                                      </button>

                                </div>
                                <h3 class="name"><?= htmlspecialchars($fetch_products['name']); ?></h3>
                                <input type="hidden" name="product_id" value="<?= htmlspecialchars($fetch_products['id']); ?>">
                                <div class="flex">
                                    <p class="price">Price: $<?= htmlspecialchars($fetch_products['price']); ?>/-</p>                
               
                                </div>
                                <a href="checkout.php?get_id=<?= htmlspecialchars($fetch_products['id']); ?>" class="btn">Buy Now</a>
                            </form>
                <?php
                            $grand_total += $fetch_wishlist['price'];
                        }
                    }
                } else {
                    echo '<p class="empty">No products added yet!</p>';
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