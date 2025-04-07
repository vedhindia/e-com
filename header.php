<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once 'admin/dbconnection.php';

// Function to get cart count
function getInitialCartCount($conn) {
    if (!isset($_SESSION['user_id'])) {
        return 0;
    }
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT COUNT(DISTINCT product_id) as count FROM cart WHERE user_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $user_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        return $row['count'] ?? 0;
    }
    return 0;
}

// Function to get wishlist count
function getWishlistCount($conn) {
    if (!isset($_SESSION['user_id'])) {
        return 0;
    }
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT COUNT(*) as count FROM wishlist WHERE user_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $user_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        return $row['count'] ?? 0;
    }
    return 0;
}

// Get initial counts
$initial_cart_count = getInitialCartCount($conn);
$initial_wishlist_count = getWishlistCount($conn);
?>

<!-- Add this CSS in the head section -->
<style>
.wishlist-icon {
    position: relative;
    color: #333; /* Default color */
    transition: color 0.3s ease;
}
.wishlist-icon.active {
    color: #ff0000 !important; /* Force red color when active */
}
.wishlist-count {
    position: absolute;
    top: -8px;
    right: -8px;
    background: #ff0000;
    color: white;
    border-radius: 50%;
    padding: 2px 6px;
    font-size: 12px;
}
</style>

<div class="header">
    <!-- Topbar -->
    <div class="header_topbar dark">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-4">
                    <ul class="tp-list nbr ml-2">
                        <li class="dropdown dropdown-currency hidden-xs hidden-sm">
                            <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Eng<i
                                    class="ml-1 fa fa-angle-down"></i></a>
                            <ul class="dropdown-menu mlix-wrap">
                                <li><a href="javascript:void(0);">English</a></li>
                                <li><a href="javascript:void(0);">French</a></li>
                                <li><a href="javascript:void(0);">Spainish</a></li>
                                <li><a href="javascript:void(0);">Italy</a></li>
                            </ul>
                        </li>
                        <li class="dropdown dropdown-currency hidden-xs hidden-sm">
                            <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">USD<i
                                    class="ml-1 fa fa-angle-down"></i></a>
                            <ul class="dropdown-menu mlix-wrap">
                                <li><a href="javascript:void(0);">EUR</a></li>
                                <li><a href="javascript:void(0);">AUD</a></li>
                                <li><a href="javascript:void(0);">GBP</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-8">
                    <div class="topbar_menu">
                        <ul>
                            <li><a href="order.php"><i class="ti-bag"></i>My Account</a></li>
                            <li><a href="order-tracking.html"><i class="ti-location-pin"></i>Track Order</a></li>
                            <li class="hide-m">
                                <a href="wishlist.php" class="wishlist-icon <?php echo $initial_wishlist_count > 0 ? 'active' : ''; ?>">
                                    <i class="ti-heart"></i>
                                    <?php if ($initial_wishlist_count > 0): ?>
                                        <span class="wishlist-count"><?php echo $initial_wishlist_count; ?></span>
                                    <?php endif; ?>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main header -->
    <div class="general_header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-2 col-md-2 col-sm-3 col-4">
                    <a class="nav-brand" href="#">
                        <img src="admin/images/ISKCON_Logo.png" class="logo" alt="" />
                    </a>
                </div>
                <div class="col-lg-7 col-md-7 col-sm-4 col-3">
                    <nav id="navigation" class="navigation navigation-landscape">
                        <div class="nav-header">
                            <div class="nav-toggle"></div>
                        </div>
                        <div class="nav-menus-wrapper" style="transition-property: none;">
                            <ul class="nav-menu">
                                <li class="active"><a href="index.php">Home<span class="submenu-indicator"></span></a></li>
                                
                                <?php
                                // Get all categories
                                $sql = "SELECT * FROM categories";
                                $result = mysqli_query($conn, $sql);
                                
                                // Loop through each category
                                while($row = mysqli_fetch_assoc($result)) {
                                    $main_category = $row["main_category"];
                                    $main_category_id = $row["id"];
                                    
                                    echo '<li><a href="product.php?main_category=' . urlencode($main_category) . '">' . $main_category . '<span class="submenu-indicator"></span></a>';
                                    
                                    // Get subcategories for this category
                                    $cat_id = $row["id"];
                                    $sub_sql = "SELECT * FROM subcategories WHERE category_id = $cat_id";
                                    $sub_result = mysqli_query($conn, $sub_sql);
                                    
                                    // If subcategories exist
                                    if(mysqli_num_rows($sub_result) > 0) {
                                        echo '<ul class="nav-dropdown nav-submenu">';
                                        
                                        // Loop through subcategories
                                        while($sub_row = mysqli_fetch_assoc($sub_result)) {
                                            $subcategory = $sub_row["subcategory_name"];
                                            $subcategory_id = $sub_row["id"];
                                            
                                            echo '<li><a href="product.php?main_category=' . urlencode($main_category) . '&subcategory=' . urlencode($subcategory) . '">' . $subcategory . '</a></li>';
                                        }
                                        
                                        echo '</ul>';
                                    }
                                    
                                    echo '</li>';
                                }
                                ?>
                                
                                <li><a href="blog.php">Blog<span class="submenu-indicator"></span></a></li>
                                <li><a href="contact.php">Contact<span class="submenu-indicator"></span></a></li>
                            </ul>
                        </div>
                    </nav>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-5 col-5">
                    <div class="general_head_right">
                        <ul>
                            <li><a data-toggle="collapse" href="#mySearch" role="button" aria-expanded="false"
                                    aria-controls="mySearch"><i class="ti-search"></i></a></li>
                            <li><a href="login-signup.php"><i class="ti-user"></i></a></li>
                            <li><a href="my-cart.php"><i class="ti-shopping-cart"></i><span class="cart_counter"><?php echo $initial_cart_count; ?></span></a></li>
                        </ul>
                    </div>
                    <div class="collapse" id="mySearch">
                        <div class="blocks search_blocks">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search entire store here...">
                                <div class="input-group-append">
                                    <button class="btn search_btn" type="button"><i class="ti-search"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add this script to update cart count via AJAX -->
<script>
$(document).ready(function() {
    // Function to update cart count
    function updateCartCount() {
        $.ajax({
            url: 'get-cart-count.php',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if(response.success) {
                    $('.cart_counter').text(response.cart_count);
                }
            }
        });
    }

    // Update cart count every 5 seconds
    setInterval(updateCartCount, 5000);
});
</script>

<!-- Add this JavaScript before the closing body tag -->
<script>
$(document).ready(function() {
    // Function to update wishlist count and icon color
    function updateWishlistCount() {
        $.get('get-wishlist-count.php', function(response) {
            if (response.success) {
                const count = response.wishlist_count;
                const wishlistIcon = $('.wishlist-icon');
                
                if (count > 0) {
                    wishlistIcon.addClass('active');
                    if (!wishlistIcon.find('.wishlist-count').length) {
                        wishlistIcon.append(`<span class="wishlist-count">${count}</span>`);
                    } else {
                        wishlistIcon.find('.wishlist-count').text(count);
                    }
                } else {
                    wishlistIcon.removeClass('active');
                    wishlistIcon.find('.wishlist-count').remove();
                }
            }
        });
    }

    // Update wishlist count and icon color every 5 seconds
    setInterval(updateWishlistCount, 5000);
    
    // Initial update
    updateWishlistCount();
});
</script>