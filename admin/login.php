<?php
session_start(); // Start the session

include 'dbconnection.php';

// Initialize error message
$error_msg = "";

// Check if the user is already logged in
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: index.php"); // Redirect to home page if already logged in
    exit();
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the user inputs
    $email = $_POST['email'];
    $password = $_POST['password'];

    // SQL query to find the user by email
    $sql = "SELECT * FROM admin WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // If email exists in the database
    if ($result->num_rows > 0) {
        // Fetch the user record
        $row = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $row['password'])) {
            // Set session variables for successful login
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_email'] = $email;
            $_SESSION['admin_id'] = $row['id']; // Optional: Store user ID in session

            // Redirect to index.php with a success message
            echo "<script>
                    alert('Admin login successfully done!');
                    window.location.href = 'index.php';
                  </script>";
        } else {
            // Invalid password
            $error_msg = "Invalid email or password.";
        }
    } else {
        // Email not found
        $error_msg = "No user found with that email address.";
    }

    // Close the prepared statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
    <meta charset="utf-8">
    <title>Iskcon Ravet</title>
    <meta name="author" content="themesflat.com">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- Theme Style -->
    <link rel="stylesheet" type="text/css" href="css/animate.min.css">
    <link rel="stylesheet" type="text/css" href="css/animation.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap-select.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">

    <!-- Font -->
    <link rel="stylesheet" href="font/fonts.css">

    <!-- Icon -->
    <link rel="stylesheet" href="icon/style.css">

    <!-- Favicon and Touch Icons  -->
    <link rel="shortcut icon" href="images/favicon.png">
    <link rel="apple-touch-icon-precomposed" href="images/favicon.png">
</head>

<body class="body">
    <!-- #wrapper -->
    <div id="wrapper">
        <!-- #page -->
        <div id="page" class="">

            <div class="wrap-login-page">
                <div class="flex-grow flex flex-column justify-center gap30">
                    <a href="index.php" id="site-logo-inner"></a>
                    <div class="login-box">
                        <div>
                            <h3>Admin Login</h3>
                            <div class="body-text">Enter your email & password to login</div>
                        </div>

                        <!-- Display Error Message if Any -->
                        <?php if ($error_msg != ""): ?>
                            <div style="color: red; text-align: center;">
                                <?php echo $error_msg; ?>
                            </div>
                        <?php endif; ?>

                        <form class="form-login flex flex-column gap24" method="POST">
                            <fieldset class="email">
                                <div class="body-title mb-10">Email address <span class="tf-color-1">*</span></div>
                                <input class="flex-grow" type="email" placeholder="Enter your email address" name="email" tabindex="0" value="" aria-required="true" required="">
                            </fieldset>
                            <fieldset class="password">
                                <div class="body-title mb-10">Password <span class="tf-color-1">*</span></div>
                                <input class="password-input" type="password" placeholder="Enter your password" name="password" tabindex="0" value="" aria-required="true" required="">
                                <span class="show-pass">
                                    <i class="icon-eye view"></i>
                                    <i class="icon-eye-off hide"></i>
                                </span>
                            </fieldset>
                            <div class="flex justify-between items-center">
                                <div class="flex gap10">
                                    <input class="" type="checkbox" id="signed">
                                    <label class="body-text" for="signed">Keep me signed in</label>
                                </div>
                                <a href="forgot-password.php" class="body-text tf-color">Forgot password?</a>
                            </div>
                            <button type="submit" class="tf-button w-full">Login</button>
                        </form>

                        <div>
                            <div class="text-tiny mb-16 text-center">Or continue with social account</div>
                            <div class="flex gap16 mobile-wrap">
                                <a href="#" class="tf-button style-2 w-full">
                                    <span class="tf-color-3">Sign in with Google</span>
                                </a>
                                <a href="#" class="tf-button style-2 w-full">
                                    <span class="tf-color-3">Sign in with Facebook</span>
                                </a>
                            </div>
                        </div>
                        <div class="body-text text-center">
                            You don't have an account yet?
                            <a href="sign-up.php" class="body-text tf-color">Register Now</a>
                        </div>
                    </div>
                </div>

                <div class="bottom-page">
                    <div class="body-text">Copyright © <?php echo date('Y'); ?> Iskcon Ravet. Design</div>
                    <div class="body-text">by <a href="https://designzfactory.in/">designzfactory</a> All rights reserved.</div>
                </div>

            </div>
        </div>
        <!-- /#page -->
    </div>
    <!-- /#wrapper -->

    <!-- Javascript -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrap-select.min.js"></script>
    <script src="js/main.js"></script>

</body>
</html>
