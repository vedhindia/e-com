<?php
session_start();
include_once 'dbconnection.php';
if (empty($_SESSION['admin_session'])) {
    header('Location:login.php');
}


// Check if ID is provided
if(!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: category-list.php");
    exit;
}

$id = mysqli_real_escape_string($conn, $_GET['id']);

// Handle form submission
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $main_category = mysqli_real_escape_string($conn, $_POST['main_category']);
    $subcategory = mysqli_real_escape_string($conn, $_POST['subcategory']);
    
    // Validate inputs
    if(empty($main_category) || empty($subcategory)) {
        $error = "Main category and subcategory are required";
    } else {
        // Update category in database
        $update_query = "UPDATE categories SET main_category='$main_category', subcategory='$subcategory' WHERE id='$id'";
        
        if(mysqli_query($conn, $update_query)) {
            // Success message
            $success = "Category updated successfully";
            // Redirect after 2 seconds
            header("Refresh: 2; URL=category-list.php");
        } else {
            $error = "Error updating category: " . mysqli_error($conn);
        }
    }
}

// Get current category data
$query = "SELECT * FROM categories WHERE id='$id'";
$result = mysqli_query($conn, $query);

if(mysqli_num_rows($result) == 0) {
    header("Location: category-list.php");
    exit;
}

$category = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">

<head>
    <!-- Basic Page Needs -->
    <meta charset="utf-8">
    <!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->
    <title>Edit Category - Remos eCommerce Admin Dashboard</title>

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
                    
                    <!-- main-content -->
                    <div class="main-content">
                        <!-- main-content-wrap -->
                        <div class="main-content-inner">
                            <!-- main-content-wrap -->
                            <div class="main-content-wrap">
                                <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                                    <h3>Edit Category</h3>
                                    <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                                        <li><a href="index-2.html"><div class="text-tiny">Dashboard</div></a></li>
                                        <li><i class="icon-chevron-right"></i></li>
                                        <li><a href="category-list.php"><div class="text-tiny">Category</div></a></li>
                                        <li><i class="icon-chevron-right"></i></li>
                                        <li><div class="text-tiny">Edit Category</div></li>
                                    </ul>
                                </div>
                                
                                <!-- Edit Category Form -->
                                <div class="wg-box mb-30">
                                    <div class="form-box">
                                        <?php if(isset($error)): ?>
                                            <div class="alert alert-danger"><?php echo $error; ?></div>
                                        <?php endif; ?>
                                        
                                        <?php if(isset($success)): ?>
                                            <div class="alert alert-success"><?php echo $success; ?></div>
                                        <?php endif; ?>
                                        
                                        <form method="post" action="" class="form-edit-category">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="main_category">Main Category</label>
                                                        <input type="text" id="main_category" name="main_category" 
                                                               value="<?php echo htmlspecialchars($category['main_category']); ?>" 
                                                               placeholder="Enter main category" required>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="subcategory">Subcategory</label>
                                                        <input type="text" id="subcategory" name="subcategory" 
                                                               value="<?php echo htmlspecialchars($category['subcategory']); ?>" 
                                                               placeholder="Enter subcategory" required>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <div class="button-group">
                                                    <button type="submit" class="tf-button style-1">Update Category</button>
                                                    <a href="category-list.php" class="tf-button style-1 btn-secondary">Cancel</a>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- /Edit Category Form -->
                            </div>
                            <!-- /main-content-wrap -->
                        </div>
                        <!-- /main-content-wrap -->
                        
                        <!-- bottom-page -->
                        <div class="bottom-page">
                            <div class="body-text">Copyright © 2024 Remos. Design with</div>
                            <i class="icon-heart"></i>
                            <div class="body-text">by <a href="https://themeforest.net/user/themesflat/portfolio">Themesflat</a> All rights reserved.</div>
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