<?php
session_start();
include_once 'dbconnection.php';
if (empty($_SESSION['admin_session'])) {
    header('Location: login.php');
    exit();
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $main_category_id = mysqli_real_escape_string($conn, $_POST['main_category']);
    $subcategory_name = mysqli_real_escape_string($conn, $_POST['subcategory']);
    
    // Get the category name based on the selected ID
    $category_query = "SELECT main_category FROM categories WHERE id = '$main_category_id'";
    $category_result = mysqli_query($conn, $category_query);
    $category_row = mysqli_fetch_assoc($category_result);
    $category_name = $category_row['main_category'];
    
    // Check if the subcategory already exists under this category
    $check_query = "SELECT * FROM subcategories WHERE category_id = '$main_category_id' AND subcategory_name = '$subcategory_name'";
    $check_result = mysqli_query($conn, $check_query);
    
    if (mysqli_num_rows($check_result) > 0) {
        // Subcategory already exists
        echo "<script>alert('This subcategory already exists under the selected category!');</script>";
    } else {
        // Insert the new subcategory with both category ID and name
        $insert_query = "INSERT INTO subcategories (category_id, category_name, subcategory_name) 
                         VALUES ('$main_category_id', '$category_name', '$subcategory_name')";
        if (mysqli_query($conn, $insert_query)) {
            echo "<script>
                    alert('Subcategory added successfully!');
                    window.location.href = 'category-list.php'; // Redirect to the same page or another page
                  </script>";
        } else {
            echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
        }
    }
}

// Fetch categories from the database
$categoryQuery = "SELECT * FROM categories ORDER BY main_category";
$categoryResult = mysqli_query($conn, $categoryQuery);
?>

 <!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">

<head>
    <!-- Basic Page Needs -->
    <meta charset="utf-8">
    <meta name="author" content="themesflat.com">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Iskcon Ravet</title>

    <!-- Theme Styles -->
    <link rel="stylesheet" type="text/css" href="css/animate.min.css">
    <link rel="stylesheet" type="text/css" href="css/animation.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap-select.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">

    <!-- Font and Icons -->
    <link rel="stylesheet" href="font/fonts.css">
    <link rel="stylesheet" href="icon/style.css">

    <!-- Favicon -->
    <link rel="shortcut icon" href="images/favicon.png">
    <link rel="apple-touch-icon-precomposed" href="images/favicon.png">
</head>

<body class="body">
    <!-- Wrapper -->
    <div id="wrapper">
        <!-- Page -->
        <div id="page">
            <!-- Layout Wrap -->
            <div class="layout-wrap">
                
                <!-- Preload -->
                <div id="preload" class="preload-container">
                    <div class="preloading">
                        <span></span>
                    </div>
                </div>
                <!-- /Preload -->

                <!-- Sidebar -->
                <?php include('sidebar.php'); ?>
                <!-- /Sidebar -->

                <!-- Main Content -->
                <div class="section-content-right">

                    <!-- Topbar -->
                    <?php include('topbar.php'); ?>
                    <!-- /Topbar -->

                    <!-- Main Content -->
                    <div class="main-content">
                        <div class="main-content-inner">
                            <div class="main-content-wrap">
                                <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                                    <h3>Category Information</h3>
                                    <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                                        <li>
                                            <a href="index-2.html">
                                                <div class="text-tiny">Dashboard</div>
                                            </a>
                                        </li>
                                        <li><i class="icon-chevron-right"></i></li>
                                        <li>
                                            <a href="#"><div class="text-tiny">Category</div></a>
                                        </li>
                                        <li><i class="icon-chevron-right"></i></li>
                                        <li>
                                            <div class="text-tiny">Sub Category</div>
                                        </li>
                                    </ul>
                                </div>

                               <!-- New Category Form -->
                               <div class="wg-box">
                                    <form class="form-new-product form-style-1" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" autocomplete="off">
                                        
                                        <!-- Main Category Dropdown -->
                                        <fieldset class="name">
                                            <div class="body-title">Main Category <span class="tf-color-1">*</span></div>
                                            <select class="form-select" name="main_category" required>
                                                <option value="">Select Main Category</option>
                                                <?php
                                                // Reset the result pointer
                                                if(mysqli_num_rows($categoryResult) > 0) {
                                                    mysqli_data_seek($categoryResult, 0);
                                                    while($row = mysqli_fetch_assoc($categoryResult)) {
                                                        echo '<option value="'.$row['id'].'">'.$row['main_category'].'</option>';
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </fieldset>

                                        <!-- Subcategory Name -->
                                        <fieldset class="name">
                                            <div class="body-title">Subcategory Name <span class="tf-color-1">*</span></div>
                                            <input class="flex-grow" type="text" name="subcategory" placeholder="Enter subcategory name" required>
                                        </fieldset>

                                        <!-- Submit Button -->
                                        <div class="bot">
                                            <button class="tf-button w208" type="submit">Save</button>
                                        </div>
                                        
                                    </form>
                                </div>
                                <!-- /New Category Form -->
                            </div>
                        </div>

                        <!-- Bottom Page -->
                        <div class="bottom-page">
                            <div class="body-text">Copyright © 2025 Iskcon Ravet . Design with</div>
                          
                            <div class="body-text">by <a href="https://designzfactory.in/">designzfactory </a> All rights reserved.</div>
                        </div>
                        <!-- /Bottom Page -->

                    </div>
                    <!-- /Main Content -->
                </div>
                <!-- /Main Content -->
            </div>
            <!-- /Layout Wrap -->
        </div>
        <!-- /Page -->
    </div>
    <!-- /Wrapper -->

    <!-- JavaScript Files -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrap-select.min.js"></script>
    <script src="js/zoom.js"></script>
    <script src="js/switcher.js"></script>
    <script src="js/theme-settings.js"></script>
    <script src="js/main.js"></script>

</body>

</html>
