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
                                            <div class="text-tiny">New Category</div>
                                        </li>
                                    </ul>
                                </div>

                                <!-- New Category Form -->
                                <div class="wg-box">
                                    <form class="form-new-product form-style-1" method="post" action="addcategory.php" autocomplete="off">
                                        
                                        <!-- Main Category Name -->
                                        <fieldset class="name">
                                            <div class="body-title">Main Category Name <span class="tf-color-1">*</span></div>
                                            <input class="flex-grow" type="text" name="main_category" placeholder="Enter main category name" required>
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
