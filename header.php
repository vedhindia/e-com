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
	                            <li><a href="order.html"><i class="ti-bag"></i>My Account</a></li>
	                            <li><a href="order-tracking.html"><i class="ti-location-pin"></i>Track Order</a></li>
	                            <li class="hide-m"><a href="wishlist.html"><i class="ti-heart"></i>Favourites</a></li>
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
    include "admin/dbconnection.php";
    
    // Get all categories
    $sql = "SELECT * FROM categories";
    $result = mysqli_query($conn, $sql);
    
    // Loop through each category
    while($row = mysqli_fetch_assoc($result)) {
        echo '<li><a href="#">' . $row["main_category"] . '<span class="submenu-indicator"></span></a>';
        
        // Get subcategories for this category
        $cat_id = $row["id"];
        $sub_sql = "SELECT * FROM subcategories WHERE category_id = $cat_id";
        $sub_result = mysqli_query($conn, $sub_sql);
        
        // If subcategories exist
        if(mysqli_num_rows($sub_result) > 0) {
            echo '<ul class="nav-dropdown nav-submenu">';
            
            // Loop through subcategories
            while($sub_row = mysqli_fetch_assoc($sub_result)) {
                echo '<li><a href="product.php?id=' . $sub_row["id"] . '">' . $sub_row["subcategory_name"] . '</a></li>';
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
	                            <li><a href="login-signup.html"><i class="ti-user"></i></a></li>
	                            <li><a href="javascript:void(0);" onclick="openRightMenu()"><i
	                                        class="ti-shopping-cart"></i><span class="cart_counter">0</span></a></li>
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