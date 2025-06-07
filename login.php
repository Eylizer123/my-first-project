<?php
include '../components/connection.php';

session_start();

if(isset($_POST['login'])){
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);

    $pass = sha1($_POST['password']);
    $pass =  filter_var($pass, FILTER_SANITIZE_STRING);
    
    $select_admin = $conn->prepare("SELECT * FROM `admin` WHERE email = ? AND password = ?");
    $select_admin->execute([$email, $pass]);

    if ($select_admin->rowCount() > 0) {

        $fetch_admin_id = $select_admin->fetch(PDO::FETCH_ASSOC);
        $_SESSION['admin_id'] = $fetch_admin_id['id'];
        header('location: dashboard.php');
    }else{
        $warning_msg[] = 'incorrect username or password';
    }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Boxicon CDN link -->
    <link href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="admin_style.css?v=<?php echo time(); ?>">
    <title>Clothing Shop- Register Page</title>
</head>
<body>
    <div class="main">
        <section>
            <div class="form-container" id="admin_login">
                <form action="" method="post" enctype="multipart/form-data">
                    <h3>Login Now</h3>
                    
                    <div class="input-field">
                        <label for="email">User Email <sup>* <br></sup></label>
                        <input type="email" name="email" id="email" maxlength="20" required 
                        placeholder="Enter your email" oninput="this.value.replace(/\s/g, '')">
                    </div>
                    <div class="input-field">
                        <label for="password">User Password <sup>*</sup></label>
                        <input type="password" name="password" id="password" maxlength="20" required 
                        placeholder="Enter your password" oninput="this.value.replace(/\s/g, '')">
                    </div>
                    
                    <button type="submit" name="login" class="btn">Login Now</button>
                    <p>Do not have an account ? <a href="register.php">Register Now</a></p>
                </form>
            </div>
        </section>
    </div>
    <!-- SweetAlert CDN link -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <!-- Custom JS link -->
    <script type="text/javascript" src="script.js"></script>
    <!-- Alert -->
    <?php include '../components/alert.php'; ?>
</body>
</html>