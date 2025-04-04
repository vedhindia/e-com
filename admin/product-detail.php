<?php
session_start();
include_once 'dbconnection.php';
if (empty($_SESSION['admin_session'])) {
    header('Location:login.php');
}


// Check if product ID is provided
if(!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: product-list.php");
    exit;
}

$product_id = (int)$_GET['id'];

// Fetch product details - removed references to product_colors and product_sizes
$query = "SELECT p.*, 
          (SELECT MIN(price) FROM product_prices WHERE product_id = p.id) as single_price,
          (SELECT MIN(price) FROM product_units WHERE product_id = p.id) as min_unit_price
          FROM products p 
          WHERE p.id = $product_id";
$result = mysqli_query($conn, $query);

if(mysqli_num_rows($result) == 0) {
    header("Location: product-list.php");
    exit;
}

$product = mysqli_fetch_assoc($result);

// Determine price to display
$price = isset($product['has_multiple_units']) && $product['has_multiple_units'] ? $product['min_unit_price'] : $product['single_price'];

// Fetch product images
$images_query = "SELECT image_path FROM product_images WHERE product_id = $product_id ORDER BY id ASC";
$images_result = mysqli_query($conn, $images_query);
$images = [];
while($img = mysqli_fetch_assoc($images_result)) {
    $images[] = $img['image_path'];
}

// If no images found, use a default image
if(count($images) == 0) {
    $images[] = 'images/products/default.png';
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
    <meta charset="utf-8">
    <title>Remos eCommerce Admin Dashboard HTML Template</title>

    <meta name="author" content="themesflat.com">

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- Theme Style -->
    <link rel="stylesheet" type="text/css" href="css/animate.min.css">
    <link rel="stylesheet" type="text/css" href="css/animation.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap-select.min.css">
    <link rel="stylesheet" type="text/css" href="css/swiper-bundle.min.css">
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
                                    <h3>Product Detail</h3>
                                    <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                                        <li>
                                            <a href="index.php"><div class="text-tiny">Dashboard</div></a>
                                        </li>
                                        <li>
                                            <i class="icon-chevron-right"></i>
                                        </li>
                                        <li>
                                            <a href="#"><div class="text-tiny">Ecommerce</div></a>
                                        </li>
                                        <li>
                                            <i class="icon-chevron-right"></i>
                                        </li>
                                        <li>
                                            <div class="text-tiny">Product Detail</div>
                                        </li>
                                    </ul>
                                </div>
                                <!-- Product Detail -->
                                <div class="wg-box">
                                    <div class="tf-main-product section-image-zoom flex">
                                        <div class="tf-product-media-wrap">
                                            <div class="thumbs-slider">
                                                <div class="swiper tf-product-media-thumbs other-image-zoom" data-direction="vertical">
                                                    <div class="swiper-wrapper">
                                                        <?php foreach($images as $image): ?>
                                                        <div class="swiper-slide">
                                                            <div class="item">
                                                                <img src="<?php echo $image; ?>" alt="<?php echo htmlspecialchars($product['product_name']); ?>">
                                                            </div>
                                                        </div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </div>
                                                <div class="swiper tf-product-media-main" id="gallery-swiper-started">
                                                    <div class="swiper-wrapper" >
                                                        <?php foreach($images as $image): ?>
                                                        <div class="swiper-slide">
                                                            <div class="item">
                                                                <a href="<?php echo $image; ?>" target="_blank" data-pswp-width="500px" data-pswp-height="500px">
                                                                    <img class="tf-image-zoom" data-zoom="<?php echo $image; ?>" src="<?php echo $image; ?>" alt="<?php echo htmlspecialchars($product['product_name']); ?>">
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                    <div class="swiper-button-next button-style-arrow thumbs-next"></div>
                                                    <div class="swiper-button-prev button-style-arrow thumbs-prev"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tf-product-info-wrap relative flex-grow">
                                            <div class="tf-zoom-main"></div>
                                            <div class="tf-product-info-list other-image-zoom">
                                                <div class="tf-product-info-title">
                                                    <h3><?php echo htmlspecialchars($product['product_name']); ?></h3>
                                                    <div class="price body-title">₹<?php echo number_format($price, 2); ?></div>
                                                </div>
                                                
                                                <!-- Display product details -->
                                                <div class="product-details mt-4">
                                                    <div class="mb-3">
                                                        <strong class="body-text">Weight:</strong> 
                                                        <span class="body-title-2"><?php echo htmlspecialchars($product['weight']); ?></span>
                                                    </div>
                                                    <div class="mb-3">
                                                        <strong class="body-text">Dimensions:</strong> 
                                                        <span class="body-title-2"><?php echo htmlspecialchars($product['dimensions']); ?></span>
                                                    </div>
                                                    <div class="mb-3">
                                                        <strong class="body-text">Availability:</strong> 
                                                        <span class="body-title-2"><?php echo $product['availability']; ?></span>
                                                    </div>
                                                    <div class="mb-3">
                                                        <strong class="body-text">Country Origin:</strong> 
                                                        <span class="body-title-2"><?php echo $product['country_origin']; ?></span>
                                                    </div>
                                                     <div class="mb-3">
                                                        <strong class="body-text">Source Type:</strong> 
                                                        <span class="body-title-2"><?php echo $product['source_type']; ?></span>
                                                    </div> 
                                                    <div class="mb-3">
                                                        <strong class="body-text">Container Type:</strong> 
                                                        <span class="body-title-2"><?php echo $product['container_type']; ?></span>
                                                    </div>
                                                    <?php if(!empty($product['description'])): ?>
                                                    <div class="mb-3">
                                                        <strong class="body-text">Description:</strong>
                                                        <div class="mt-2 body-text"><?php echo nl2br(htmlspecialchars($product['description'])); ?></div>
                                                    </div>
                                                    <?php endif; ?>
                                                </div>
                                                
                                             
                                                <!-- Edit button -->
                                                <div class="mt-4">
                                                    <a href="edit-product.php?id=<?php echo $product_id; ?>" class="tf-button style-1">
                                                        <i class="icon-edit-3 mr-2"></i> Edit Product
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /Product Detail -->
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
    <script src="js/swiper-bundle.min.js"></script>
    <script src="js/carousel.js"></script>
    <script src="js/main.js"></script>

</body>
</html>