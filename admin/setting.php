<?php
session_start();
include_once 'dbconnection.php';
if (empty($_SESSION['admin_session'])) {
    header('Location:login.php');
}

$success_msg = "";
$error_msg = "";

// Change Password Logic
if (isset($_POST['change_password'])) {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $admin_id = $_SESSION['admin_session']['id'];

    // Get current password from database
    $stmt = $conn->prepare("SELECT password FROM admin WHERE id = ?");
    $stmt->bind_param("i", $admin_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $current_db_password = $row['password'];

    // Verify old password
    if (password_verify($old_password, $current_db_password) || $old_password == $current_db_password) {
        // Hash new password
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        
        // Update password in database
        $update_stmt = $conn->prepare("UPDATE admin SET password = ? WHERE id = ?");
        $update_stmt->bind_param("si", $hashed_password, $admin_id);
        
        if ($update_stmt->execute()) {
            $success_msg = "Password updated successfully!";
            echo "<script>
                alert('Password changed successfully!');
            </script>";
        } else {
            $error_msg = "Failed to update password. Please try again.";
        }
        $update_stmt->close();
    } else {
        $error_msg = "Current password is incorrect!";
    }
    $stmt->close();
}
?>
<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">

<head>
    <!-- Basic Page Needs -->
    <meta charset="utf-8">
    <!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->
    <title>Change Password</title>

    <meta name="author" content="themesflat.com">

    <!-- Mobile Specific Metas -->
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
            <!-- layout-wrap -->
           <div class="layout-wrap">
                <!-- preload -->
                <div id="preload" class="preload-container">
                    <div class="preloading">
                        <span></span>
                    </div>
                </div>
                <!-- /preload -->
                 <!-- section-menu-left -->
                 <?php include('sidebar.php'); ?>
                  <!-- /section-menu-left -->
                  <!-- section-content-right -->
                  <div class="section-content-right">
                      <!-- header-dashboard -->
                      <?php include('topbar.php'); ?>
                      <!-- /header-dashboard -->
                    <!-- /header-dashboard -->
                    <!-- main-content -->
                    <div class="main-content">
                        <!-- main-content-wrap -->
                        <div class="main-content-inner">
                            <!-- main-content-wrap -->
                            <div class="main-content-wrap">
                                <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                                    <h3>Setting</h3>
                                    <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                                        <li>
                                            <a href="index.php"><div class="text-tiny">Dashboard</div></a>
                                        </li>
                                        <li>
                                            <i class="icon-chevron-right"></i>
                                        </li>
                                        <li>
                                            <div class="text-tiny">Setting</div>
                                        </li>
                                    </ul>
                                </div>
                                <!-- setting -->
                                <form class="form-setting form-style-2" method="POST">
                                    <div class="wg-box">
                                        <div class="left">
                                            <h5 class="mb-4">Reset Password</h5>
                                            <div class="body-text">Setup your password</div>
                                        </div>
                                        <div class="right flex-grow">
                                            <!-- Display Success/Error Messages -->
                                            <?php if (!empty($success_msg)): ?>
                                                <div style="color: green; margin-bottom: 15px; text-align: center;">
                                                    <?php echo $success_msg; ?>
                                                </div>
                                            <?php endif; ?>
                                            <?php if (!empty($error_msg)): ?>
                                                <div style="color: red; margin-bottom: 15px; text-align: center;">
                                                    <?php echo $error_msg; ?>
                                                </div>
                                            <?php endif; ?>
                                           
                                            <fieldset class="name mb-24">
                                                <div class="body-title mb-10">Old Password</div>
                                                <input class="flex-grow" type="password" placeholder="Enter your current password" name="old_password" tabindex="0" aria-required="true" required>
                                            </fieldset>
                                            <fieldset class="text mb-24">
                                                <div class="flex items-center justify-between gap10 mb-10">
                                                    <div class="body-title">New Password</div>
                                                </div>
                                                <input class="flex-grow" type="password" placeholder="Enter your new password" name="new_password" tabindex="0" aria-required="true" required>
                                            </fieldset>
                                           
                                            <div class="flex flex-wrap gap10 mb-50">
                                                <button type="submit" name="change_password" class="tf-button">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                  
                        <!-- bottom-page -->
                        <div class="bottom-page">
                            <div class="body-text">Copyright © <?php echo date('Y'); ?> Iskcon Ravet . Design with</div>
                          
                            <div class="body-text">by <a href="https://designzfactory.in/">designzfactory </a> All rights reserved.</div>
                        </div>
                        <!-- /bottom-page -->
                    </div>
                    <!-- /main-content -->
                </div>
                <!-- /section-content-right -->
            </div>
            <!-- /layout-wrap -->
        </div>
        <!-- /#page -->
    </div>
    <!-- /#wrapper -->

    <!-- Javascript -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrap-select.min.js"></script>
    <script src="js/zoom.js"></script>
    <script src="js/switcher.js"></script>
    <script src="js/theme-settings.js"></script>
    <script src="js/main.js"></script>

</body>
</html>