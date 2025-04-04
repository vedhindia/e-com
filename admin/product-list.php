<?php
session_start();
include_once 'dbconnection.php';
if (empty($_SESSION['admin_session'])) {
    header('Location:login.php');
}


// Pagination settings
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10; // Default 10 items per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Default page 1
$offset = ($page - 1) * $limit;

// Search functionality
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$search_condition = '';
if(!empty($search)) {
    $search_condition = " WHERE p.product_name LIKE '%$search%' OR p.id LIKE '%$search%'";
}

// Count total products for pagination
$count_query = "SELECT COUNT(*) as total FROM products p $search_condition";
$count_result = mysqli_query($conn, $count_query);
$total_records = mysqli_fetch_assoc($count_result)['total'];
$total_pages = ceil($total_records / $limit);

// Fetch products with pagination and search
$query = "SELECT p.*, 
          (SELECT MIN(price) FROM product_prices WHERE product_id = p.id) as single_price,
          (SELECT MIN(price) FROM product_units WHERE product_id = p.id) as min_unit_price,
          (SELECT image_path FROM product_images WHERE product_id = p.id LIMIT 1) as image_path
          FROM products p
          $search_condition
          ORDER BY p.id DESC
          LIMIT $offset, $limit";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
    <!-- Basic Page Needs -->
    <meta charset="utf-8">
    <!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->
    <title>Isckon Ravet</title>

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
                                    <h3>Product List</h3>
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
                                            <div class="text-tiny">Product List</div>
                                        </li>
                                    </ul>
                                </div>
                                <!-- product-list -->
                                <div class="wg-box">
                                    
                                    <div class="flex items-center justify-between gap10 flex-wrap">
                                        <div class="wg-filter flex-grow">
                                            <div class="show">
                                                <div class="text-tiny">Showing</div>
                                                <div class="select">
                                                    <select class="" onchange="changeLimit(this.value)">
                                                        <option value="10" <?php echo $limit == 10 ? 'selected' : ''; ?>>10</option>
                                                        <option value="20" <?php echo $limit == 20 ? 'selected' : ''; ?>>20</option>
                                                        <option value="30" <?php echo $limit == 30 ? 'selected' : ''; ?>>30</option>
                                                    </select>
                                                </div>
                                                <div class="text-tiny">entries</div>
                                            </div>
                                            <form class="form-search" method="get" action="">
                                                <fieldset class="name">
                                                    <input type="text" placeholder="Search here..." name="search" value="<?php echo htmlspecialchars($search); ?>" tabindex="2" aria-required="true" required="">
                                                    <input type="hidden" name="limit" value="<?php echo $limit; ?>">
                                                    <input type="hidden" name="page" value="1"> <!-- Reset to page 1 when searching -->
                                                </fieldset>
                                                <div class="button-submit">
                                                    <button class="" type="submit"><i class="icon-search"></i></button>
                                                </div>
                                            </form>
                                        </div>
                                        <a class="tf-button style-1 w208" href="add-product.php"><i class="icon-plus"></i>Add new</a>
                                    </div>
                                    <div class="wg-table table-product-list">
                                        <ul class="table-title flex gap20 mb-14">
                                            <li>
                                                <div class="body-title">Product Name</div>
                                            </li>    
                                            
                                            <li>
                                                <div class="body-title">Price</div>
                                            </li>
                                            <li>
                                                <div class="body-title">Weight</div>
                                            </li>
                                            <li>
                                                <div class="body-title">Dimensions</div>
                                            </li>
                                            <li>
                                                <div class="body-title">Stock</div>
                                            </li>
                                            <li>
                                                <div class="body-title">Action</div>
                                            </li>
                                        </ul>
                                        <ul class="flex flex-column">
                                            <?php 
                                            if(mysqli_num_rows($result) > 0) {
                                                while($row = mysqli_fetch_assoc($result)) {
                                                    // Determine price to display
                                                    $price = $row['has_multiple_units'] ? $row['min_unit_price'] : $row['single_price'];
                                                    
                                                    // Check stock status
                                                    $stock_status = $row['availability'] == 'in_stock' ? 
                                                        '<div class="block-available">In stock</div>' : 
                                                        '<div class="block-not-available">Out of stock</div>';
                                                    
                                                    // Get image path or default
                                                    $image_path = !empty($row['image_path']) ? $row['image_path'] : 'images/products/default.png';
                                            ?>
                                            <li class="product-item gap14">
                                                <div class="image no-bg">
                                                    <img src="<?php echo $image_path; ?>" alt="<?php echo htmlspecialchars($row['product_name']); ?>">
                                                </div>
                                                <div class="flex items-center justify-between gap20 flex-grow">
                                                    <div class="name">
                                                        <a href="#" class="body-title-2"><?php echo htmlspecialchars($row['product_name']); ?></a>
                                                    </div>
                                                    <div class="body-text">₹<?php echo number_format($price, 2); ?></div>
                                                    <div class="body-text"><?php echo htmlspecialchars($row['weight']); ?></div>
                                                    <div class="body-text"><?php echo htmlspecialchars($row['dimensions']); ?></div>
                                                    <div>
                                                    <?php echo $row['availability']; ?>
                                                    </div>
                                                    <div class="list-icon-function">
                                                        <div class="item eye">
                                                            <a href="product-detail.php?id=<?php echo $row['id']; ?>"><i class="icon-eye"></i></a>
                                                        </div>
                                                        <div class="item edit">
                                                            <a href="edit-product.php?id=<?php echo $row['id']; ?>"><i class="icon-edit-3"></i></a>
                                                        </div>
                                                        <div class="item trash">
                                                            <a href="#" onclick="deleteProduct(<?php echo $row['id']; ?>); return false;"><i class="icon-trash-2"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <?php 
                                                }
                                            } else {
                                                echo "<li class='text-center p-4'>No products found</li>";
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                    <div class="divider"></div>
                                    <div class="flex items-center justify-between flex-wrap gap10">
                                        <div class="text-tiny">Showing <?php echo min($total_records, $limit); ?> of <?php echo $total_records; ?> entries</div>
                                        <ul class="wg-pagination">
                                            <li <?php if($page <= 1){ echo 'class="disabled"'; } ?>>
                                                <a href="<?php if($page <= 1){ echo '#'; } else { echo "?page=".($page - 1)."&limit=$limit&search=$search"; } ?>">
                                                    <i class="icon-chevron-left"></i>
                                                </a>
                                            </li>
                                            <?php 
                                            $start_page = max(1, $page - 2);
                                            $end_page = min($total_pages, $start_page + 4);
                                            if($end_page - $start_page < 4 && $total_pages > 4) {
                                                $start_page = max(1, $end_page - 4);
                                            }
                                            
                                            for($i = $start_page; $i <= $end_page; $i++) { 
                                            ?>
                                            <li <?php if($page == $i) echo 'class="active"'; ?>>
                                                <a href="?page=<?php echo $i; ?>&limit=<?php echo $limit; ?>&search=<?php echo urlencode($search); ?>"><?php echo $i; ?></a>
                                            </li>
                                            <?php } ?>
                                            <li <?php if($page >= $total_pages){ echo 'class="disabled"'; } ?>>
                                                <a href="<?php if($page >= $total_pages){ echo '#'; } else { echo "?page=".($page + 1)."&limit=$limit&search=$search"; } ?>">
                                                    <i class="icon-chevron-right"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- /product-list -->
                            </div>
                            <!-- /main-content-wrap -->
                        </div>
                        <!-- /main-content-wrap -->
                        <!-- bottom-page -->
                        <div class="bottom-page">
                            <div class="body-text">Copyright © 2025 Iskcon Ravet . Design with</div>
                          
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
    
    <script>
    // Function to change items per page
    function changeLimit(limit) {
        window.location.href = `?limit=${limit}&page=1&search=<?php echo urlencode($search); ?>`;
    }
    
    // Function to delete product
    function deleteProduct(id) {
        if(confirm('Are you sure you want to delete this product?')) {
            // AJAX call to delete product
            $.ajax({
                type: "POST",
                url: "delete-product.php",
                data: {id: id},
                success: function(response) {
                    alert("Product deleted successfully!");
                    location.reload();
                },
                error: function() {
                    alert("Error deleting product!");
                }
            });
        }
    }
    </script>

</body>
</html>