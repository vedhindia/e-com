<?php
session_start();
include_once 'dbconnection.php';

$error_msg = "";
$success_msg = "";
$token_valid = false;
$token = "";

// Check if token is provided in URL
if (isset($_GET['token'])) {
    $token = $_GET['token'];
    
    // Verify token exists and is not expired
    $stmt = $conn->prepare("SELECT * FROM admin WHERE reset_token = ? AND token_expire > NOW()");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();
    $count = $result->num_rows;
    
    if ($count == 1) {
        $token_valid = true;
    } else {
        $error_msg = "Invalid or expired token. Please request a new password reset link.";
    }
    $stmt->close();
} else {
    $error_msg = "Invalid request. Please use the reset link sent to your email.";
}

// Process password reset form
if (isset($_POST['set_new_password']) && $token_valid) {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $token = $_POST['token'];
    
    // Validate passwords match
    if ($new_password != $confirm_password) {
        $error_msg = "Passwords do not match.";
    } else {
        // Hash the new password
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        
        // Update password and clear token
        $update_stmt = $conn->prepare("UPDATE admin SET password = ?, reset_token = NULL, token_expire = NULL WHERE reset_token = ?");
        $update_stmt->bind_param("ss", $hashed_password, $token);
        
        if ($update_stmt->execute()) {
            $success_msg = "Password has been reset successfully. You can now <a href='login.php'>login</a> with your new password.";
            $token_valid = false; // Hide the form after successful reset
            
            // Show JavaScript alert
            echo "<script>
                alert('Password has been reset successfully!');
                setTimeout(function() {
                    window.location.href = 'login.php';
                }, 3000); // Redirect to login page after 3 seconds
            </script>";
        } else {
            $error_msg = "Failed to reset password. Please try again.";
        }
        $update_stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Reset Password - Iskcon Ravet</title>
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
                        <h3>Reset Password</h3>
                        <div class="body-text">Create a new password for your account</div>

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

                        <?php if ($token_valid): ?>
                            <form class="form-login flex flex-column gap24" method="POST">
                                <input type="hidden" name="token" value="<?php echo $token; ?>">
                                
                                <fieldset class="password">
                                    <div class="body-title mb-10">New Password <span class="tf-color-1">*</span></div>
                                    <input type="password" name="new_password" placeholder="Enter your new password" required>
                                </fieldset>
                                
                                <fieldset class="password">
                                    <div class="body-title mb-10">Confirm Password <span class="tf-color-1">*</span></div>
                                    <input type="password" name="confirm_password" placeholder="Confirm your new password" required>
                                </fieldset>
                                
                                <button type="submit" name="set_new_password" class="tf-button w-full">Reset Password</button>
                            </form>
                        <?php endif; ?>

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