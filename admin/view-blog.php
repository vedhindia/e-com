<?php
// Include database connection
include('dbconnection.php');

// Check if blog ID is provided
if(!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: blog-list.php");
    exit;
}

$blog_id = (int)$_GET['id'];

// Fetch blog details
$query = "SELECT b.* FROM blogs b WHERE b.id = $blog_id AND b.status = 'published'";
$result = mysqli_query($conn, $query);

if(mysqli_num_rows($result) == 0) {
    header("Location: blog-list.php");
    exit;
}

$blog = mysqli_fetch_assoc($result);

// Format date
$created_date = date("F j, Y", strtotime($blog['created_at']));

// Fetch blog images
$images_query = "SELECT image_path, is_featured FROM blog_images WHERE blog_id = $blog_id ORDER BY is_featured DESC, id ASC";
$images_result = mysqli_query($conn, $images_query);
$images = [];
$featured_image = null;

while($img = mysqli_fetch_assoc($images_result)) {
    $images[] = $img['image_path'];
    if($img['is_featured'] && !$featured_image) {
        $featured_image = $img['image_path'];
    }
}

// If no images found, use a default image
if(count($images) == 0) {
    $images[] = 'images/blogs/default.png';
    $featured_image = 'images/blogs/default.png';
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
                                    <h3>Blog Detail</h3>
                                    <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                                        <li>
                                            <a href="index.php"><div class="text-tiny">Dashboard</div></a>
                                        </li>
                                        <li>
                                            <i class="icon-chevron-right"></i>
                                        </li>
                                        <li>
                                            <a href="blog-list.php"><div class="text-tiny">Blogs</div></a>
                                        </li>
                                        <li>
                                            <i class="icon-chevron-right"></i>
                                        </li>
                                        <li>
                                            <div class="text-tiny">Blog Detail</div>
                                        </li>
                                    </ul>
                                </div>
                                <!-- Blog Detail -->
                                <div class="wg-box">
                                    <div class="tf-main-product section-image-zoom flex">
                                        <div class="tf-product-media-wrap">
                                            <div class="thumbs-slider">
                                                <div class="swiper tf-product-media-thumbs other-image-zoom" data-direction="vertical">
                                                    <div class="swiper-wrapper">
                                                        <?php foreach($images as $image): ?>
                                                        <div class="swiper-slide">
                                                            <div class="item">
                                                                <img src="<?php echo $image; ?>" alt="<?php echo htmlspecialchars($blog['title']); ?>">
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
                                                                    <img class="tf-image-zoom" data-zoom="<?php echo $image; ?>" src="<?php echo $image; ?>" alt="<?php echo htmlspecialchars($blog['title']); ?>">
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
                                                    <h3><?php echo htmlspecialchars($blog['title']); ?></h3>
                                                    <div class="body-title">
                                                        <span class="mr-3">
                                                            <i class="icon-user mr-1"></i> <?php echo htmlspecialchars($blog['author'] ?? 'Anonymous'); ?>
                                                        </span>
                                                        <span>
                                                            <i class="icon-calendar mr-1"></i> <?php echo $created_date; ?>
                                                        </span>
                                                    </div>
                                                </div>
                                                
                                                <!-- Display blog details -->
                                                <div class="product-details mt-4">
                                                    <?php if(!empty($blog['excerpt'])): ?>
                                                    <div class="mb-3">
                                                        <strong class="body-text">Description:</strong>
                                                        <div class="mt-2 body-title-2"><?php echo htmlspecialchars($blog['excerpt']); ?></div>
                                                    </div>
                                                    <?php endif; ?>
                                                    
                                                    <div class="mb-3">
                                                        <strong class="body-text">Status:</strong> 
                                                        <span class="body-title-2"><?php echo ucfirst($blog['status']); ?></span>
                                                    </div>
                                                    
                                                    <div class="mb-3">
                                                        <strong class="body-text">Last Updated:</strong> 
                                                        <span class="body-title-2"><?php echo date("F j, Y", strtotime($blog['updated_at'])); ?></span>
                                                    </div>
                                                    
                                                    <?php if(!empty($blog['content'])): ?>
                                                    <div class="mb-3">
                                                        <strong class="body-text">Content:</strong>
                                                        <div class="mt-2 body-text"><?php echo nl2br(htmlspecialchars($blog['content'])); ?></div>
                                                    </div>
                                                    <?php endif; ?>
                                                </div>
                                                
                                                <!-- Edit button -->
                                                <div class="mt-4">
                                                    <a href="edit-blog.php?id=<?php echo $blog_id; ?>" class="tf-button style-1">
                                                        <i class="icon-edit-3 mr-2"></i> Edit Blog
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /Blog Detail -->
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