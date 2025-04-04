<?php
session_start();
include_once 'dbconnection.php';

$error_msg = "";
$success_msg = "";
$show_alert = false;

if (isset($_POST['reset_password'])) {
    $email = $_POST['email'];
    
    // Check if email exists in the database
    $stmt = $conn->prepare("SELECT * FROM admin WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $count = $result->num_rows;
    
    if ($count == 1) {
        // Generate a random token
        $token = bin2hex(random_bytes(32));
        $expire_time = date('Y-m-d H:i:s', strtotime('+1 hour'));
        
        // Store token in the database
        $update_stmt = $conn->prepare("UPDATE admin SET reset_token = ?, token_expire = ? WHERE email = ?");
        $update_stmt->bind_param("sss", $token, $expire_time, $email);
        
        if ($update_stmt->execute()) {
            // Create reset link
            $reset_link = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/reset-password.php?token=" . $token;
            
            // In a real application, you would send this via email
            $success_msg = "Password reset link has been sent to your email address. The link is valid for 1 hour.";
            
            // For demonstration purposes, we'll display the link (in production, you'd send this via email)
            $success_msg .= "<br><br>Reset Link (for demonstration): <a href='$reset_link'>$reset_link</a>";
            
            // Show JavaScript alert
            echo "<script>
                alert('Password reset link has been sent to your email address.');
            </script>";
            $show_alert = true;
        } else {
            $error_msg = "Failed to process your request. Please try again.";
        }
        $update_stmt->close();
    } else {
        $error_msg = "Email address not found.";
    }
    
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Forgot Password - Iskcon Ravet</title>
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
                        <h3>Forgot Password</h3>
                        <div class="body-text">Enter your email address to receive a password reset link</div>

                        <!-- Display Error Message if Any -->
                        <?php if (!empty($error_msg)): ?>
                            <div style="color: red; text-align: center; margin-top: 15px;">
                                <?php echo $error_msg; ?>
                            </div>
                        <?php endif; ?>

                        <!-- Display Success Message if Any -->
                        <?php if (!empty($success_msg)): ?>
                            <div style="color: green; text-align: center; margin-top: 15px;">
                                <?php echo $success_msg; ?>
                            </div>
                        <?php endif; ?>

                        <form class="form-login flex flex-column gap24" method="POST">
                            <fieldset class="email">
                                <div class="body-title mb-10">Email address <span class="tf-color-1">*</span></div>
                                <input type="email" name="email" placeholder="Enter your email address" required>
                            </fieldset>
                            
                            <button type="submit" name="reset_password" class="tf-button w-full">Send Reset Link</button>
                        </form>

                        <div class="body-text text-center">
                            Remember your password? <a href="login.php" class="tf-color">Back to Login</a>
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