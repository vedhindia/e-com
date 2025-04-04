<?php
session_start();
include_once 'dbconnection.php';

$error_msg = "";

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM admin WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $count = $result->num_rows;

    if ($count == 1) {
        $row = $result->fetch_assoc();
        $dbpass = $row["password"];

        if ($password == $dbpass) {  // Consider using password_hash() for better security
            $_SESSION['admin_session'] = $row;
            echo "<script> location.replace('index.php');</script>";
            exit;
        } else {
            $error_msg = "Password Not Match...";
        }
    } else {
        $error_msg = "Wrong Details...";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Iskcon Ravet</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- Theme Style -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="shortcut icon" href="images/favicon.png">
</head>

<body class="body">
    <div id="wrapper">
        <div id="page" class="">

            <div class="wrap-login-page">
                <div class="flex-grow flex flex-column justify-center gap30">
                    <a href="index.php" id="site-logo-inner"></a>
                    <div class="login-box">
                        <h3>Admin Login</h3>
                        <div class="body-text">Enter your email & password to login</div>

                        <!-- Display Error Message if Any -->
                        <?php if (!empty($error_msg)): ?>
                            <div style="color: red; text-align: center;">
                                <?php echo $error_msg; ?>
                            </div>
                        <?php endif; ?>

                        <form class="form-login flex flex-column gap24" method="POST">
                            <fieldset class="email">
                                <div class="body-title mb-10">Email address <span class="tf-color-1">*</span></div>
                                <input type="email" name="email" placeholder="Enter your email address" required>
                            </fieldset>
                            <fieldset class="password">
                                <div class="body-title mb-10">Password <span class="tf-color-1">*</span></div>
                                <input type="password" name="password" placeholder="Enter your password" required>
                            </fieldset>
                            <div class="flex justify-between items-center">
                                <label><input type="checkbox"> Keep me signed in</label>
                                <a href="forgot-password.php" class="body-text tf-color">Forgot password?</a>
                            </div>
                            <button type="submit" name="login" class="tf-button w-full">Login</button>
                        </form>

                        <div class="body-text text-center">
                            You don't have an account? <a href="sign-up.php" class="tf-color">Register Now</a>
                        </div>
                    </div>
                </div>

                <div class="bottom-page">
                    <div class="body-text">Copyright © <?php echo date('Y'); ?> Iskcon Ravet. Design by 
                        <a href="https://designzfactory.in/">designzfactory</a>. All rights reserved.
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Javascript -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
