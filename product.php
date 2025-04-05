<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<!DOCTYPE html>
<html lang="en">
	
<head>
		<meta charset="utf-8" />
		<meta name="author" content="www.frebsite.nl" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		
        <title>Odex - Organic Food & Grocery Market HTML Template</title>
		 
        <!-- Custom CSS -->
        <link href="assets/css/styles.css" rel="stylesheet">
		
    </head>
	
    <body class="grocery-theme">
	
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <div id="preloader"><div class="preloader"><span></span><span></span></div></div>
		
		
        <!-- ============================================================== -->
        <!-- Main wrapper - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <div id="main-wrapper">
		
            <!-- ============================================================== -->
            <!-- Top header  -->
            <!-- ============================================================== -->
            <!-- Start Navigation -->
			<?php include('header.php')?>
			<!-- End Navigation -->
			<div class="clearfix"></div>
			<!-- ============================================================== -->
			<!-- Top header  -->
			<!-- ============================================================== -->
			
			<!-- =========================== Breadcrumbs =================================== -->
			<div class="min-banner">
				<img src="assets/img/min/banner-6.jpg" class="img-fluid" alt="" />
			</div>
			<div class="brd_wraps pt-2 pb-2">
				<div class="container">
					<nav aria-label="breadcrumb" class="simple_breadcrumbs">
					  <ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="index.php"><i class="ti-home"></i></a></li>
						<?php
						if(isset($_GET['main_category']) && isset($_GET['subcategory'])) {
							echo '<li class="breadcrumb-item"><a href="#">'.$_GET['main_category'].'</a></li>';
							echo '<li class="breadcrumb-item active" aria-current="page">'.$_GET['subcategory'].'</li>';
						}
						?>
					  </ol>
					</nav>
				</div>
			</div>
			<!-- =========================== Breadcrumbs =================================== -->
			
			
			<!-- =========================== Search Products =================================== -->
			<section class="gray">
				<div class="container">
					
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12">
							
							<!-- Shorter Toolbar -->
							<div class="row">
								<div class="col-lg-12 col-md-12">
									<div class="toolbar toolbar-products">
										<div class="toolbar-sorter sorter">
											<label class="sorter-label" for="sorter">Sort By</label>
											<select id="sorter" data-role="sorter" class="sorter-options">
												<option value="position" selected="selected">Position</option>
												<option value="name">Product Name</option>
												<option value="price">Price</option>
											</select>
											<a href="#" class="action sorter-action"><i class="ti-arrow-up"></i></a>
										</div>
													
										<div class="modes">
											<a class="modes-mode mode-grid" title="Grid" href="#"><i class="ti-layout-grid3"></i></a>		
											<a class="modes-mode mode-list" title="Grid" href="#"><i class="ti-view-list"></i></a>													
										</div>

										<div class="field limiter">
											<label class="label" for="limiter">
												<span>Show</span>
											</label>
											<div class="control">
												<select id="limiter" data-role="limiter" class="limiter-options">
													<option value="5">5</option>
													<option value="10" selected="selected">10</option>
													<option value="15">15</option>
													<option value="20">20</option>
													<option value="25">25</option>
												</select>
											</div>
										</div>
									</div>
								</div>
							</div>
							
							<!-- row -->
							<div class="row">
                            <?php
                            include_once 'admin/dbconnection.php';

                            if(isset($_GET['main_category']) && isset($_GET['subcategory'])) {
                                $main_category = mysqli_real_escape_string($conn, $_GET['main_category']);
                                $sub_category = mysqli_real_escape_string($conn, $_GET['subcategory']);

                                // Debug information
                                echo "<!-- Debug Info: -->";
                                echo "<!-- Main Category: " . $main_category . " -->";
                                echo "<!-- Sub Category: " . $sub_category . " -->";

                                // Updated SQL query to match the database structure
                                $sql = "SELECT p.*, 
                                        GROUP_CONCAT(DISTINCT pi.image_path) as images,
                                        COALESCE(MIN(pu.price), 0) as product_price,
                                        sc.category_name as main_category_name,
                                        sc.subcategory_name as sub_category_name
                                        FROM products p
                                        LEFT JOIN product_images pi ON p.id = pi.product_id
                                        LEFT JOIN product_units pu ON p.id = pu.product_id
                                        LEFT JOIN subcategories sc ON (p.main_category = sc.category_name AND p.subcategory = sc.subcategory_name)
                                        WHERE p.main_category = ? AND p.subcategory = ?
                                        GROUP BY p.id";

                                $stmt = mysqli_prepare($conn, $sql);
                                if($stmt) {
                                    mysqli_stmt_bind_param($stmt, "ss", $main_category, $sub_category);
                                    
                                    // Debug the actual values being used in the query
                                    echo "<!-- Query Parameters: main_category=" . $main_category . ", subcategory=" . $sub_category . " -->";
                                    
                                    mysqli_stmt_execute($stmt);
                                    $result = mysqli_stmt_get_result($stmt);

                                    echo "<!-- Query Results: " . mysqli_num_rows($result) . " products found -->";

                                    if(mysqli_num_rows($result) > 0) {
                                        while($row = mysqli_fetch_assoc($result)) {
                                            // Process images
                                            $images = array();
                                            if($row['images']) {
                                                $images = explode(',', $row['images']);
                                            }
                                            
                                            // Get price
                                            $price = $row['product_price'] ?? 0;
                                            $discount_price = $price * 0.85; // 15% discount
                                            
                                            // Debug product information
                                            echo "<!-- Product Debug: ID=" . $row['id'] . ", Name=" . $row['product_name'] . " -->";
                                            
                                            // Display product
                                            ?>
                                            <!-- Single Item -->
                                            <div class="col-lg-3 col-md-4 col-sm-6">
                                                <div class="woo_product_grid">
                                                    <span class="woo_pr_tag hot"><?php echo $row['availability']; ?></span>
                                                    <div class="woo_product_thumb">
                                                        <?php
                                                        $image_path = !empty($images) ? 'admin/' . $images[0] : 'assets/img/product/1.jpg';
                                                        echo "<!-- Image Path: " . $image_path . " -->";
                                                        ?>
                                                        <img src="<?php echo $image_path; ?>" class="img-fluid" alt="<?php echo $row['product_name']; ?>" 
                                                             onerror="this.onerror=null; this.src='assets/img/product/1.jpg';">
                                                    </div>
                                                    <div class="woo_product_caption center">
                                                        <div class="woo_rate">
                                                            <i class="fa fa-star filled"></i>
                                                            <i class="fa fa-star filled"></i>
                                                            <i class="fa fa-star filled"></i>
                                                            <i class="fa fa-star filled"></i>
                                                            <i class="fa fa-star"></i>
                                                        </div>
                                                        <div class="woo_title">
                                                            <h4 class="woo_pro_title">
                                                                <a href="detail.php?id=<?php echo $row['id']; ?>"><?php echo $row['product_name']; ?></a>
                                                            </h4>
                                                        </div>
                                                        <div class="woo_price">
                                                            <h6>₹<?php echo number_format($discount_price, 2); ?>
                                                                <span class="less_price">₹<?php echo number_format($price, 2); ?></span>
                                                            </h6>
                                                        </div>
                                                    </div>
                                                    <div class="woo_product_cart hover">
                                                        <ul>
                                                            <li>
                                                                <a href="javascript:void(0);" data-toggle="modal" data-target="#viewproduct-over" 
                                                                   class="woo_cart_btn btn_cart" data-product-id="<?php echo $row['id']; ?>">
                                                                    <i class="ti-eye"></i>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="add-to-cart.php?id=<?php echo $row['id']; ?>" class="woo_cart_btn btn_view">
                                                                    <i class="ti-shopping-cart"></i>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:void(0);" class="woo_cart_btn btn_save wishlist-btn" 
                                                                   data-product-id="<?php echo $row['id']; ?>">
                                                                    <i class="ti-heart"></i>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>								
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    } else {
                                        echo '<div class="col-12"><p class="text-center">No products found in this category.</p></div>';
                                    }
                                    mysqli_stmt_close($stmt);
                                } else {
                                    echo '<div class="col-12"><p class="text-center">Error preparing database query: ' . mysqli_error($conn) . '</p></div>';
                                }
                            } else {
                                echo '<div class="col-12"><p class="text-center">Please select a category and subcategory.</p></div>';
                            }
                            ?>
							</div>
							<!-- row -->
							
							<div class="row">
								<div class="col-lg-12">
									<nav aria-label="Page navigation example">
									  <ul class="pagination">
										<li class="page-item left">
										  <a class="page-link" href="#" aria-label="Previous">
											<span aria-hidden="true"><i class="ti-arrow-left mr-1"></i>Prev</span>
										  </a>
										</li>
										<li class="page-item"><a class="page-link" href="#">1</a></li>
										<li class="page-item active"><a class="page-link" href="#">2</a></li>
										<li class="page-item"><a class="page-link" href="#">3</a></li>
										<li class="page-item right">
										  <a class="page-link" href="#" aria-label="Next">
											<span aria-hidden="true"><i class="ti-arrow-right mr-1"></i>Next</span>
										  </a>
										</li>
									  </ul>
									</nav>
								</div>
							</div>
							
						</div>
						
					</div>
				</div>
			</section>
			<!-- =========================== Search Products =================================== -->

			<!-- ============================ Call To Action ================================== --> 
			<section class="theme-bg call_action_wrap-wrap">
				<div class="container">
					<div class="row">
						<div class="col-lg-12">
							
							<div class="call_action_wrap">
								<div class="call_action_wrap-head">
									<h3>Do You Have Questions ?</h3>
									<span>We'll help you to grow your career and growth.</span>
								</div>
								<div class="newsletter_box">
									<div class="input-group">
										<input type="text" class="form-control" placeholder="Subscribe here...">
										<div class="input-group-append">
										<button class="btn search_btn" type="button"><i class="fas fa-arrow-alt-circle-right"></i></button>
										</div>
									</div>
								</div>
							</div>
							
						</div>
					</div>
				</div>
			</section>
			<!-- ============================ Call To Action End ================================== -->
			
			<!-- ============================ Footer Start ================================== -->
			<?php include('footer.php')?>
			<!-- ============================ Footer End ================================== -->
			
			<!-- cart -->
			<!-- Switcher Start -->
			<div class="w3-ch-sideBar w3-bar-block w3-card-2 w3-animate-right" style="display:none;right:0;" id="rightMenu">
				<div class="rightMenu-scroll">
					<h4 class="cart_heading">Your cart</h4>
					<button onclick="closeRightMenu()" class="w3-bar-item w3-button w3-large"><i class="ti-close"></i></button>
					<div class="right-ch-sideBar" id="side-scroll">
						<div class="cart_select_items">
							<!-- Cart items will be loaded here dynamically -->
						</div>
						
						<div class="cart_subtotal">
							<h6>Subtotal<span class="theme-cl" id="cart-subtotal">₹0.00</span></h6>
						</div>
						
						<div class="cart_action">
							<ul>
								<li><a href="my-cart.html" class="btn btn-go-cart btn-theme">View/Edit Cart</a></li>
								<li><a href="checkout.html" class="btn btn-checkout">Checkout Now</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>

			<!-- Left Collapse navigation -->
			<div class="w3-ch-sideBar-left w3-bar-block w3-card-2 w3-animate-right"  style="display:none;right:0;" id="leftMenu">
				<div class="rightMenu-scroll">
					<div class="flixel">
						<h4 class="cart_heading">Navigation</h4>
						<button onclick="closeLeftMenu()" class="w3-bar-item w3-button w3-large"><i class="ti-close"></i></button>
					</div>
					
					<div class="right-ch-sideBar">
						
						<div class="side_navigation_collapse">
							<div class="d-navigation">
								<ul id="side-menu">
									<li class="dropdown">
										<a href="#">Category<span class="ti-angle-left"></span></a>
										<ul class="nav nav-second-level">
											<li><a href="#">Grocery</a></li>
											<li><a href="#">Organic</a></li>
											<li><a href="#">Electronics</a></li>
											<li><a href="#">Fashion</a></li>
											<li><a href="#">Education</a></li>
											<li><a href="#">Beauty</a></li>
											
											<li class="dropdown">
												<a href="#">Digital<span class="ti-angle-left"></span></a>
												<ul class="nav nav-second-level">
													<li><a href="#">Sub Product</a></li>
													<li><a href="#">Sub Product</a></li>
													<li><a href="#">Sub Product</a></li>
													<li><a href="#">Sub Product</a></li>
												</ul>
											</li>
										</ul>
									</li>
									
									<li class="dropdown">
										<a href="#">Brands<span class="ti-angle-left"></span></a>
										<ul class="nav nav-second-level">
											<li><a href="#">Nike</a></li>
											<li><a href="#">Apple</a></li>
											<li><a href="#">Hackerl</a></li>
											<li><a href="#">Tuffan</a></li>
											<li><a href="#">Orio</a></li>
											<li><a href="#">Kite</a></li>
										</ul>
									</li>
									
									<li class="dropdown">
										<a href="#">Products<span class="ti-angle-left"></span></a>
										<ul class="nav nav-second-level">
											<li><a href="#">3 Columns products</a></li>
											<li><a href="#">4 Columns products</a></li>
											<li><a href="#">5 Columns products</a></li>
											<li><a href="#">6 Columns products</a></li>
											<li><a href="#">7 Columns products</a></li>
											<li><a href="#">8 Columns products</a></li>
										</ul>
									</li>
									
									<li><a href="#">About Us</a></li>
									<li><a href="#">Blogs</a></li>
									<li><a href="#">Contact Us</a></li>
									<li><a href="#">Buy Odex</a></li>
								</ul>
							</div>
						</div>
					</div>
					
				</div>
			</div>
			<!-- Left Collapse navigation -->
			
			<!-- Product View -->
			<div class="modal fade" id="viewproduct-over" tabindex="-1" role="dialog" aria-labelledby="add-payment" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
					<div class="modal-content" id="view-product">
						<span class="mod-close" data-dismiss="modal" aria-hidden="true"><i class="ti-close"></i></span>
						<div class="modal-body">
							<div class="row align-items-center">
								<div class="col-lg-6 col-md-12 col-sm-12">
									<!-- Product Gallery -->
									<div class="product-gallery-wrap">
										<!-- Loading State -->
										<div class="sp-loading">
											<div class="spinner-border text-primary" role="status">
												<span class="sr-only">Loading...</span>
											</div>
											<p class="mt-2">Loading Images...</p>
										</div>
										
										<!-- Main Gallery -->
										<div class="product-gallery">
											<div class="swiper-container gallery-main">
												<div class="swiper-wrapper">
													<!-- Main images will be loaded here -->
												</div>
												<div class="swiper-button-next"></div>
												<div class="swiper-button-prev"></div>
											</div>
											
											<!-- Thumbnails -->
											<div class="swiper-container gallery-thumbs">
												<div class="swiper-wrapper">
													<!-- Thumbnail images will be loaded here -->
												</div>
											</div>
										</div>
									</div>
								</div>
								
								<div class="col-lg-6 col-md-12 col-sm-12">
									<div class="woo_pr_detail">
										<div class="woo_cats_wrps">
											<a href="#" class="woo_pr_cats" id="quick-view-category">Category</a>
											<span class="woo_pr_trending" id="quick-view-availability">In Stock</span>
										</div>
										<h2 class="woo_pr_title" id="quick-view-title">Product Title</h2>
										
										<div class="woo_pr_reviews">
											<div class="woo_pr_rating">
												<i class="fa fa-star filled"></i>
												<i class="fa fa-star filled"></i>
												<i class="fa fa-star filled"></i>
												<i class="fa fa-star filled"></i>
												<i class="fa fa-star"></i>
											</div>
										</div>
										
										<div class="woo_pr_price">
											<div class="woo_pr_offer_price">
												<h3>₹<span id="quick-view-discount-price">0.00</span>
													<span class="org_price">₹<span id="quick-view-price">0.00</span></span>
												</h3>
											</div>
										</div>
										
										<div class="woo_pr_short_desc">
											<p id="quick-view-description">Loading...</p>
										</div>
										
										<div id="product-units-container">
											<!-- Units will be loaded here -->
										</div>
										
										<div class="woo_pr_color flex_inline_center mb-3">
											<div class="woo_pr_varient">
												<h6>Weight:</h6>
											</div>
											<div class="woo_colors_list pl-3">
												<span id="quick-view-weight">Loading...</span>
											</div>
										</div>
										
										<div class="woo_pr_color flex_inline_center mb-3">
											<div class="woo_pr_varient">
												<h6>Dimensions:</h6>
											</div>
											<div class="woo_colors_list pl-3">
												<span id="quick-view-dimensions">Loading...</span>
											</div>
										</div>
										
										<div class="woo_pr_color flex_inline_center mb-3">
											<div class="woo_pr_varient">
												<h6>Country of Origin:</h6>
											</div>
											<div class="woo_colors_list pl-3">
												<span id="quick-view-origin">Loading...</span>
											</div>
										</div>
										
										<div class="woo_btn_action">
											<div class="col-12 col-lg-auto">
												<input type="number" id="quick-view-quantity" class="form-control mb-2 full-width" value="1" min="1" />
											</div>
										</div>
										
										<div class="woo_btn_action">
											<div class="col-12 col-lg-auto">
												<button type="button" class="btn btn-block btn-dark mb-2 add-to-cart-btn">
													Add to Cart <i class="ti-shopping-cart-full ml-2"></i>
												</button>
											</div>
											<div class="col-12 col-lg-auto">
												<button type="button" class="btn btn-gray btn-block mb-2 add-to-wishlist-btn wishlist-btn" 
														data-product-id="<?php echo $row['id']; ?>">
													Wishlist <i class="ti-heart ml-2"></i>
												</button>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- End Modal -->

		</div>
		<!-- ============================================================== -->
		<!-- End Wrapper -->
		<!-- ============================================================== -->

		<!-- ============================================================== -->
		<!-- All Jquery -->
		<!-- ============================================================== -->
		<script src="assets/js/jquery.min.js"></script>
		<script src="assets/js/popper.min.js"></script>
		<script src="assets/js/bootstrap.min.js"></script>
		<script src="assets/js/metisMenu.min.js"></script>
		<script src="assets/js/owl-carousel.js"></script>
		<script src="assets/js/ion.rangeSlider.min.js"></script>
		<script src="assets/js/smoothproducts.js"></script>
		<script src="assets/js/jquery-rating.js"></script>
		<script src="assets/js/jQuery.style.switcher.js"></script>
		<script src="assets/js/custom.js"></script>
		
		<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
		<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

		<style>
		/* Modal Styles */
		.modal-lg {
			max-width: 900px;
		}

		.modal-content {
			border-radius: 8px;
			overflow: hidden;
		}

		/* Product Gallery Styles */
		.product-gallery-wrap {
			position: relative;
			margin-bottom: 30px;
		}

		.sp-loading {
			position: absolute;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			background: rgba(255, 255, 255, 0.9);
			display: flex;
			flex-direction: column;
			justify-content: center;
			align-items: center;
			z-index: 1000;
		}

		.gallery-main {
			margin-bottom: 10px;
			border: 1px solid #ddd;
			border-radius: 8px;
			overflow: hidden;
		}

		.gallery-main .swiper-slide {
			height: 400px;
			display: flex;
			align-items: center;
			justify-content: center;
			background: #fff;
		}

		.gallery-main img {
			max-width: 100%;
			max-height: 100%;
			object-fit: contain;
			transition: transform 0.3s ease;
		}

		.gallery-thumbs {
			height: 100px;
			box-sizing: border-box;
			padding: 10px 0;
		}

		.gallery-thumbs .swiper-slide {
			height: 100%;
			opacity: 0.4;
			cursor: pointer;
			border: 2px solid transparent;
			border-radius: 4px;
			overflow: hidden;
			transition: all 0.3s ease;
		}

		.gallery-thumbs .swiper-slide img {
			width: 100%;
			height: 100%;
			object-fit: cover;
		}

		.gallery-thumbs .swiper-slide-thumb-active {
			opacity: 1;
			border-color: #007bff;
		}

		/* Navigation Buttons */
		.swiper-button-next,
		.swiper-button-prev {
			background-color: rgba(0, 0, 0, 0.5);
			width: 40px;
			height: 40px;
			border-radius: 50%;
			color: #fff;
			transition: all 0.3s ease;
		}

		.swiper-button-next:after,
		.swiper-button-prev:after {
			font-size: 20px;
		}

		.swiper-button-next:hover,
		.swiper-button-prev:hover {
			background-color: rgba(0, 0, 0, 0.8);
		}

		/* Product Info Styles */
		.woo_pr_detail {
			padding: 20px 0;
		}

		.woo_pr_title {
			font-size: 24px;
			margin-bottom: 15px;
		}

		.woo_pr_price {
			font-size: 24px;
			margin-bottom: 20px;
		}

		.org_price {
			text-decoration: line-through;
			color: #999;
			font-size: 0.8em;
			margin-left: 10px;
		}

		/* Responsive Styles */
		@media (max-width: 768px) {
			.modal-lg {
				max-width: 95%;
				margin: 10px;
			}
			
			.gallery-main .swiper-slide {
				height: 300px;
			}
			
			.gallery-thumbs {
				height: 80px;
			}
			
			.gallery-thumbs .swiper-slide {
				width: 80px;
			}
		}

		/* Add these new styles for the wishlist button */
		.woo_cart_btn.btn_save {
			background: #fff;
			transition: all 0.3s ease;
		}

		.woo_cart_btn.btn_save.active {
			background: #ff0000 !important;
			border-color: #ff0000 !important;
		}

		.woo_cart_btn.btn_save.active i {
			color: #ffffff !important;
		}

		.wishlist-btn {
			cursor: pointer;
			transition: all 0.3s ease;
		}

		.wishlist-btn.active {
			color: #ff0000;
		}
		</style>

		<script>
		$(document).ready(function() {
			let galleryThumbs = null;
			let galleryMain = null;
			
			// Clean up function for Swiper instances
			function cleanupSwipers() {
				if(galleryMain) {
					galleryMain.destroy();
					galleryMain = null;
				}
				if(galleryThumbs) {
					galleryThumbs.destroy();
					galleryThumbs = null;
				}
			}
			
			// Reset modal content
			function resetModal() {
				$('.gallery-main .swiper-wrapper').empty();
				$('.gallery-thumbs .swiper-wrapper').empty();
				$('#product-units-container').empty();
				$('#quick-view-title').text('Loading...');
				$('#quick-view-description').text('Loading...');
				$('#quick-view-price').text('0.00');
				$('#quick-view-discount-price').text('0.00');
				$('.sp-loading').show();
			}
			
			// Initialize Swiper sliders
			function initializeSliders() {
				return new Promise((resolve) => {
					setTimeout(() => {
						try {
							galleryThumbs = new Swiper('.gallery-thumbs', {
								spaceBetween: 10,
								slidesPerView: 4,
								freeMode: true,
								watchSlidesProgress: true,
								breakpoints: {
									320: {
										slidesPerView: 3,
									},
									480: {
										slidesPerView: 4,
									}
								}
							});
							
							galleryMain = new Swiper('.gallery-main', {
								spaceBetween: 10,
								navigation: {
									nextEl: '.swiper-button-next',
									prevEl: '.swiper-button-prev',
								},
								thumbs: {
									swiper: galleryThumbs
								},
								zoom: {
									maxRatio: 2,
								}
							});
							
							resolve(true);
						} catch(error) {
							console.error('Error initializing Swiper:', error);
							resolve(false);
						}
					}, 300);
				});
			}
			
			// Quick view button click handler
			$('.btn_cart').on('click', async function(e) {
				e.preventDefault();
				const productId = $(this).data('product-id');
				
				// Store product ID in modal for later use
				$('#viewproduct-over').data('product-id', productId);
				
				// Reset modal state
				cleanupSwipers();
				resetModal();
				
				try {
					const response = await $.ajax({
						url: 'get-product-details.php',
						type: 'GET',
						data: { id: productId },
						dataType: 'json'
					});
					
					if(response.success && response.product) {
						const product = response.product;
						console.log('Product data:', product); // Debug log
						
						// Update product details
						$('#quick-view-title').text(product.name || 'No Name Available');
						$('#quick-view-description').text(product.description || 'No description available');
						$('#quick-view-availability').text(product.availability || 'Status unknown');
						$('#quick-view-price').text(product.price || '0.00');
						$('#quick-view-discount-price').text(product.discount_price || '0.00');
						$('#quick-view-weight').text(product.weight || 'N/A');
						$('#quick-view-dimensions').text(product.dimensions || 'N/A');
						$('#quick-view-origin').text(product.country_origin || 'N/A');
						
						// Store product ID in add to cart button
						$('.add-to-cart-btn').data('product-id', productId);
						
						// Update units if available
						if(product.has_multiple_units && product.units && product.units.length > 0) {
							const unitsHtml = `
								<div class="woo_pr_color flex_inline_center mb-3">
									<div class="woo_pr_varient"><h6>Select Unit:</h6></div>
									<div class="woo_colors_list pl-3">
										${product.units.map((unit, index) => `
											<div class="custom-control custom-radio">
												<input type="radio" class="custom-control-input" name="unitRadio" 
													id="unit${unit.id}" value="${unit.id}" 
													data-price="${unit.price}" ${index === 0 ? 'checked' : ''}>
												<label class="custom-control-label" for="unit${unit.id}">
													${unit.unit_value} ${unit.unit_type} - ₹${unit.price}
												</label>
											</div>
										`).join('')}
									</div>
								</div>`;
							$('#product-units-container').html(unitsHtml);
							
							// Store whether the product has units
							$('.add-to-cart-btn').data('has-units', true);
						} else {
							$('#product-units-container').empty();
							$('.add-to-cart-btn').data('has-units', false);
						}
						
						// Update images
						if(product.images && product.images.length > 0) {
							console.log('Processing images:', product.images); // Debug log
							
							const mainHtml = product.images.map(image => {
								// Check if the image path is already correct
								const imagePath = image.includes('admin/') ? image : `admin/${image}`;
								console.log('Main image path:', imagePath); // Debug log
								
								return `
									<div class="swiper-slide">
										<div class="gallery-image-wrapper">
											<img src="${imagePath}" class="img-fluid" alt="${product.name}"
												 onerror="this.onerror=null; this.src='assets/img/product/1.jpg'; console.log('Image failed to load:', this.src);">
										</div>
									</div>
								`;
							}).join('');
							
							const thumbsHtml = product.images.map(image => {
								// Check if the image path is already correct
								const imagePath = image.includes('admin/') ? image : `admin/${image}`;
								console.log('Thumbnail image path:', imagePath); // Debug log
								
								return `
									<div class="swiper-slide">
										<div class="gallery-thumb-wrapper">
											<img src="${imagePath}" class="img-fluid" alt="${product.name}"
												 onerror="this.onerror=null; this.src='assets/img/product/1.jpg'; console.log('Thumbnail failed to load:', this.src);">
										</div>
									</div>
								`;
							}).join('');
							
							$('.gallery-main .swiper-wrapper').html(mainHtml);
							$('.gallery-thumbs .swiper-wrapper').html(thumbsHtml);
						} else {
							console.log('No images found, using default'); // Debug log
							const defaultHtml = `
								<div class="swiper-slide">
									<div class="gallery-image-wrapper">
										<img src="assets/img/product/1.jpg" class="img-fluid" alt="${product.name}">
									</div>
								</div>`;
							$('.gallery-main .swiper-wrapper').html(defaultHtml);
							$('.gallery-thumbs .swiper-wrapper').html(defaultHtml);
						}
						
						// Add CSS for image wrappers
						const styleElement = document.createElement('style');
						styleElement.textContent = `
							.gallery-image-wrapper {
								width: 100%;
								height: 100%;
								display: flex;
								align-items: center;
								justify-content: center;
								background: #fff;
							}
							.gallery-image-wrapper img {
								max-width: 100%;
								max-height: 100%;
								object-fit: contain;
							}
							.gallery-thumb-wrapper {
								width: 100%;
								height: 100%;
								display: flex;
								align-items: center;
								justify-content: center;
								background: #fff;
							}
							.gallery-thumb-wrapper img {
								width: 100%;
								height: 100%;
								object-fit: cover;
							}
						`;
						document.head.appendChild(styleElement);
						
						// Initialize sliders
						await initializeSliders();
						
						// Hide loading indicator
						$('.sp-loading').hide();
					} else {
						throw new Error(response.message || 'Error loading product details');
					}
				} catch(error) {
					console.error('Error:', error);
					showNotification('Error loading product details. Please try again.');
					$('.sp-loading').hide();
				}
			});
			
			// Clean up when modal is closed
			$('#viewproduct-over').on('hidden.bs.modal', function() {
				cleanupSwipers();
				// Clear stored product ID
				$(this).removeData('product-id');
				$('.add-to-cart-btn').removeData('product-id');
			});
			
			// Update price when unit is selected
			$(document).on('change', 'input[name="unitRadio"]', function() {
				const price = $(this).data('price');
				if(price) {
					const discountPrice = price * 0.85; // 15% discount
					$('#quick-view-price').text(price.toFixed(2));
					$('#quick-view-discount-price').text(discountPrice.toFixed(2));
				}
			});

			// Function to check wishlist status
			function checkWishlistStatus(productId) {
				$.get('check-wishlist.php', { product_id: productId }, function(response) {
					if (response.success && response.in_wishlist) {
						$(`.wishlist-btn[data-product-id="${productId}"]`).addClass('active');
						$(`.woo_cart_btn.btn_save[data-product-id="${productId}"]`).addClass('active');
					}
				});
			}

			// Function to add to wishlist
			function addToWishlist(productId) {
				$.post('add-to-wishlist.php', { product_id: productId }, function(response) {
					if (response.success) {
						$(`.wishlist-btn[data-product-id="${productId}"]`).addClass('active');
						$(`.woo_cart_btn.btn_save[data-product-id="${productId}"]`).addClass('active');
						showNotification(response.message, 'success');
					} else {
						showNotification(response.message, 'error');
					}
				});
			}

			// Check wishlist status for all products on page load
			$('.wishlist-btn, .woo_cart_btn.btn_save').each(function() {
				const productId = $(this).data('product-id');
				checkWishlistStatus(productId);
			});

			// Handle wishlist button clicks
			$(document).on('click', '.wishlist-btn, .woo_cart_btn.btn_save', function(e) {
				e.preventDefault();
				const productId = $(this).data('product-id');
				if (productId) {
					addToWishlist(productId);
				} else {
					showNotification('Invalid product ID', 'error');
				}
			});

			// Update modal's wishlist button when modal is shown
			$('#viewproduct-over').on('show.bs.modal', function(e) {
				const button = $(e.relatedTarget);
				const productId = button.data('product-id');
				
				if (productId) {
					// Update the modal's wishlist button with the correct product ID
					$('.add-to-wishlist-btn').data('product-id', productId);
					// Check wishlist status for this product
					checkWishlistStatus(productId);
				}
			});

			// Function to show notifications
			function showNotification(message, type = 'error') {
				const bgColor = type === 'success' ? '#4CAF50' : '#f44336';
				const notification = $('<div>')
					.css({
						'position': 'fixed',
						'top': '20px',
						'right': '20px',
						'background-color': bgColor,
						'color': 'white',
						'padding': '15px',
						'border-radius': '4px',
						'z-index': '9999',
						'max-width': '300px',
						'box-shadow': '0 2px 5px rgba(0,0,0,0.2)'
					})
					.text(message);

				$('body').append(notification);
				setTimeout(() => notification.fadeOut('slow', function() { $(this).remove(); }), 5000);
			}
		});
		</script>
		
		<script>
		function openLeftMenu() {
			document.getElementById("leftMenu").style.display = "block";
		}
		function closeLeftMenu() {
			document.getElementById("leftMenu").style.display = "none";
		}
		</script>
		
		<script>
		function openFilterSearch() {
			document.getElementById("filter_search").style.display = "block";
		}
		function closeFilterSearch() {
			document.getElementById("filter_search").style.display = "none";
		}
		</script>

		<!-- Add to cart functionality -->
		<script>
		function showNotification(message, type = 'error') {
			// You can replace this with a more sophisticated notification system
			const bgColor = type === 'success' ? '#4CAF50' : '#f44336';
			const notification = $('<div>')
				.css({
					'position': 'fixed',
					'top': '20px',
					'right': '20px',
					'background-color': bgColor,
					'color': 'white',
					'padding': '15px',
					'border-radius': '4px',
					'z-index': '9999',
					'max-width': '300px',
					'box-shadow': '0 2px 5px rgba(0,0,0,0.2)'
				})
				.text(message);

			$('body').append(notification);
			setTimeout(() => notification.fadeOut('slow', function() { $(this).remove(); }), 5000);
		}

		function addToCart(productId, quantity = 1, unitId = null) {
			if(!productId) {
				showNotification('Invalid product ID');
				return;
			}
			
			// Show loading state
			const loadingOverlay = $('<div>')
				.css({
					'position': 'fixed',
					'top': '0',
					'left': '0',
					'width': '100%',
					'height': '100%',
					'background': 'rgba(0,0,0,0.5)',
					'display': 'flex',
					'justify-content': 'center',
					'align-items': 'center',
					'z-index': '9998'
				})
				.append('<div class="spinner-border text-light" role="status"><span class="sr-only">Loading...</span></div>');
			
			$('body').append(loadingOverlay);

			$.ajax({
				url: 'add-to-cart.php',
				type: 'POST',
				data: {
					product_id: productId,
					quantity: quantity,
					unit_id: unitId
				},
				dataType: 'json'
			})
			.done(function(response) {
				console.log('Cart response:', response); // Debug log
				
				if(response.success) {
					// Update cart counter
					$('.cart_counter').text(response.cart_count);
					
					// Show success message
					showNotification(response.message, 'success');
					
					// Close modal if open
					$('#viewproduct-over').modal('hide');
				} else {
					// Show error message
					let errorMessage = response.message;
					if(response.debug_info) {
						console.error('Debug info:', response.debug_info);
						errorMessage += '\nPlease try again or contact support if the problem persists.';
					}
					showNotification(errorMessage);
				}
			})
			.fail(function(jqXHR, textStatus, errorThrown) {
				console.error('AJAX Error:', {
					status: jqXHR.status,
					statusText: jqXHR.statusText,
					responseText: jqXHR.responseText,
					textStatus: textStatus,
					errorThrown: errorThrown
				});
				
				let errorMessage = 'Error occurred while adding product to cart. ';
				if(jqXHR.responseJSON && jqXHR.responseJSON.message) {
					errorMessage += jqXHR.responseJSON.message;
				} else if(jqXHR.status === 404) {
					errorMessage += 'Cart service not found.';
				} else if(jqXHR.status === 500) {
					errorMessage += 'Internal server error.';
				} else {
					errorMessage += 'Please try again later.';
				}
				
				showNotification(errorMessage);
			})
			.always(function() {
				// Remove loading overlay
				loadingOverlay.fadeOut('fast', function() { $(this).remove(); });
			});
		}

		// Add click handler for add to cart buttons in product list
		$(document).on('click', '.btn_view', function(e) {
			e.preventDefault();
			const productId = $(this).closest('a').attr('href').split('=')[1];
			if(!productId) {
				showNotification('Invalid product ID');
				return;
			}
			addToCart(productId);
		});

		// Add click handler for add to cart button in modal
		$(document).on('click', '.add-to-cart-btn', function() {
			const productId = $(this).data('product-id');
			const hasUnits = $(this).data('has-units');
			const quantity = parseInt($('#quick-view-quantity').val()) || 1;
			let unitId = null;
			
			if(!productId) {
				showNotification('Invalid product ID');
				return;
			}
			
			if(quantity < 1) {
				showNotification('Please enter a valid quantity');
				return;
			}
			
			// Check unit selection if product has units
			if(hasUnits) {
				unitId = $('input[name="unitRadio"]:checked').val();
				if(!unitId) {
					showNotification('Please select a unit for this product');
					return;
				}
			}
			
			addToCart(productId, quantity, unitId);
		});
		</script>

	</body>

</html>