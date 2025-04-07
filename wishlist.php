<?php
session_start();
include 'admin/dbconnection.php';
include 'check-auth.php';

// Require login for this page
requireLogin();
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
	
    <body class="grocery-theme light">
	
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
			<?php include 'header.php'; ?>
			<!-- End Navigation -->
			<div class="clearfix"></div>
			<!-- ============================================================== -->
			<!-- Top header  -->
			<!-- ============================================================== -->
			
			<!-- =========================== Breadcrumbs =================================== -->
			<div class="breadcrumbs_wrap dark">
				<div class="container">
					<div class="row align-items-center">
						
						<div class="col-lg-12 col-md-12 col-sm-12">
							<div class="text-center">
								<h2 class="breadcrumbs_title">My Wishlist</h2>
								<nav aria-label="breadcrumb">
								  <ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.php"><i class="ti-home"></i></a></li>
									<li class="breadcrumb-item active" aria-current="page">Wishlist</li>
								  </ol>
								</nav>
							</div>
						</div>
						
					</div>
				</div>
			</div>
			<!-- =========================== Breadcrumbs =================================== -->
			
			
			<!-- =========================== My Wishlist =================================== -->
			<section class="gray">
				<div class="container">
					<div class="row">
					
						<div class="col-lg-4 col-md-3">
							<nav class="dashboard-nav mb-10 mb-md-0">
							  <div class="list-group list-group-sm list-group-strong list-group-flush-x">
								<a class="list-group-item list-group-item-action dropright-toggle" href="order.html">
								  My Order
								</a>
								<a class="list-group-item list-group-item-action dropright-toggle" href="order-history.html">
								  Order History
								</a>
								<a class="list-group-item list-group-item-action dropright-toggle" href="order-tracking.html">
								  Order Tracking
								</a>
								<a class="list-group-item list-group-item-action dropright-toggle active" href="wishlist.php">
								  Wishlist
								</a>
								<a class="list-group-item list-group-item-action dropright-toggle" href="account-info.html">
								  Account Settings
								</a>
								<a class="list-group-item list-group-item-action dropright-toggle" href="payment-methode.html">
								  Payment Methods
								</a>
								<a class="list-group-item list-group-item-action dropright-toggle" href="logout.php">
								  Logout
								</a>
							  </div>
							</nav>
						</div>
						
						<div class="col-lg-8 col-md-9">
    <div class="row">
	<?php
    $user_id = $_SESSION['user_id'];
	$sql = "SELECT p.*, w.id as wishlist_id, 
       GROUP_CONCAT(DISTINCT pi.image_path) as images,
       COALESCE(MIN(pu.price), IFNULL(pp.price, 0)) as product_price,
       IFNULL(pp.price, 0) as original_price,
       p.product_name as name
FROM wishlist w
JOIN products p ON w.product_id = p.id
LEFT JOIN product_images pi ON p.id = pi.product_id
LEFT JOIN product_units pu ON p.id = pu.product_id
LEFT JOIN product_prices pp ON p.id = pp.product_id
WHERE w.user_id = ?
GROUP BY p.id";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
        if (mysqli_num_rows($result) > 0) {
            while ($item = mysqli_fetch_assoc($result)) {
                $images = explode(',', $item['images']);
                $main_image = !empty($images[0]) ? 'admin/' . $images[0] : 'assets/img/no-image.jpg';
                $original_price = $item['original_price'] > $item['product_price'] ? $item['original_price'] : ($item['product_price'] + 100);
                ?>
                <!-- Single Item -->
                <div class="col-lg-6 col-md-6 col-sm-6" id="wishlist-item-<?php echo $item['wishlist_id']; ?>">
                    <div class="woo_product_grid no-hover">
                        <span class="woo_pr_tag hot">Hot</span>
                        <div class="woo_product_thumb">
                            <img src="<?php echo $main_image; ?>" class="img-fluid" alt="<?php echo htmlspecialchars($item['name']); ?>" />
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
                                <h4 class="woo_pro_title"><a href="product-detail.php?id=<?php echo $item['id']; ?>"><?php echo htmlspecialchars($item['name']); ?></a></h4>
                            </div>
                            <div class="woo_price">
                                <h6>₹<?php echo number_format($item['product_price'], 2); ?><span class="less_price">₹<?php echo number_format($original_price, 2); ?></span></h6>
                            </div>
                        </div>
                        <div class="woo_product_cart">
                            <ul>
                                <li>
                                    <a href="javascript:void(0);" onclick="addToCart(<?php echo $item['id']; ?>)" class="woo_cart_btn btn_cart" title="Add to Cart">
                                        <i class="ti-shopping-cart"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" onclick="removeFromWishlist(<?php echo $item['wishlist_id']; ?>)" class="btn_save" title="Remove from Wishlist">
                                        <i class="ti-trash"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            ?>
            <div class="text-center">
                <div class="alert alert-info">
                    <h4>Your wishlist is empty</h4>
                    <p>Browse our products and add items to your wishlist</p>
                    <a href="index.php" class="btn btn-theme">Continue Shopping</a>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>
						
					</div>
				</div>
			</section>
			<!-- =========================== My Wishlist =================================== -->

			<script>
			// Enhanced JavaScript for better interactions
			document.addEventListener('DOMContentLoaded', function() {
				// Add smooth scroll behavior
				document.querySelectorAll('a[href^="#"]').forEach(anchor => {
					anchor.addEventListener('click', function (e) {
						e.preventDefault();
						document.querySelector(this.getAttribute('href')).scrollIntoView({
							behavior: 'smooth'
						});
					});
				});

				// Add to Cart functionality
				window.addToCart = function(productId) {
					$.ajax({
						url: 'add-to-cart.php',
						type: 'POST',
						data: { 
							product_id: productId,
							quantity: 1
						},
						dataType: 'json',
						success: function(response) {
							if (response.success) {
								showNotification('Product added to cart successfully', 'success');
								// Update cart count if needed
								if (response.cart_count) {
									$('.cart-count').text(response.cart_count);
								}
							} else {
								showNotification(response.message || 'Failed to add product to cart', 'error');
							}
						},
						error: function(xhr, status, error) {
							console.error('Error:', error);
							showNotification('Error adding product to cart', 'error');
						}
					});
				};

				// Remove from Wishlist functionality
				window.removeFromWishlist = function(wishlistId) {
					if (confirm('Are you sure you want to remove this item from your wishlist?')) {
						$.ajax({
							url: 'remove-from-wishlist.php',
							type: 'POST',
							data: { 
								wishlist_id: wishlistId
							},
							dataType: 'json',
							success: function(response) {
								if (response.success) {
									showNotification('Item removed from wishlist', 'success');
									// Remove the item from the DOM
									$('#wishlist-item-' + wishlistId).fadeOut(300, function() {
										$(this).remove();
										// Check if wishlist is empty
										if ($('.woo_product_grid').length === 0) {
											location.reload();
										}
									});
								} else {
									showNotification(response.message || 'Failed to remove item', 'error');
								}
							},
							error: function(xhr, status, error) {
								console.error('Error:', error);
								showNotification('Error removing item from wishlist', 'error');
							}
						});
					}
				};

				// Enhanced notification system
				window.showNotification = function(message, type) {
					const notification = document.createElement('div');
					notification.className = `notification ${type}`;
					notification.textContent = message;
					document.body.appendChild(notification);
					
					// Add animation
					notification.style.animation = 'slideIn 0.3s ease-out';
					
					setTimeout(() => {
						notification.style.animation = 'slideOut 0.3s ease-out';
						setTimeout(() => notification.remove(), 300);
					}, 3000);
				};

				// Add animation for product cards
				document.querySelectorAll('.woo_product_grid').forEach(card => {
					card.style.opacity = '0';
					card.style.transform = 'translateY(20px)';
					card.style.transition = 'all 0.5s ease';
					
					setTimeout(() => {
						card.style.opacity = '1';
						card.style.transform = 'translateY(0)';
					}, 100);
				});
			});

			// Add CSS for notifications
			const style = document.createElement('style');
			style.textContent = `
				.notification {
					position: fixed;
					top: 20px;
					right: 20px;
					padding: 15px 25px;
					border-radius: 5px;
					color: white;
					z-index: 9999;
					box-shadow: 0 2px 10px rgba(0,0,0,0.1);
				}

				.notification.success {
					background-color: #28a745;
				}

				.notification.error {
					background-color: #dc3545;
				}

				@keyframes slideIn {
					from {
						transform: translateX(100%);
						opacity: 0;
					}
					to {
						transform: translateX(0);
						opacity: 1;
					}
				}

				@keyframes slideOut {
					from {
						transform: translateX(0);
						opacity: 1;
					}
					to {
						transform: translateX(100%);
						opacity: 0;
					}
				}
			`;
			document.head.appendChild(style);
			</script>

			<style>
			/* Enhanced Wishlist Styles */
			.woo_product_grid {
				background: #fff;
				border-radius: 10px;
				box-shadow: 0 2px 15px rgba(0,0,0,0.1);
				transition: all 0.3s ease;
				margin-bottom: 30px;
				overflow: hidden;
				position: relative;
			}

			.woo_product_grid.no-hover {
				box-shadow: none;
				border: 1px solid #eee;
			}

			.woo_product_thumb {
				position: relative;
				overflow: hidden;
				padding-top: 100%;
				background: #f9f9f9;
			}

			.woo_product_thumb img {
				position: absolute;
				top: 0;
				left: 0;
				width: 100%;
				height: 100%;
				object-fit: contain;
			}

			.woo_product_caption {
				padding: 20px;
				text-align: center;
				border-top: 1px solid #eee;
			}

			.woo_rate {
				margin-bottom: 10px;
			}

			.woo_rate .fa-star {
				color: #ffc107;
				font-size: 14px;
			}

			.woo_rate .fa-star.filled {
				color: #ffc107;
			}

			.woo_pro_title {
				font-size: 16px;
				margin-bottom: 10px;
				min-height: 40px;
			}

			.woo_pro_title a {
				color: #333;
				text-decoration: none;
				transition: color 0.3s ease;
			}

			.woo_pro_title a:hover {
				color: #007bff;
			}

			.woo_price h6 {
				color: #28a745;
				font-size: 18px;
				font-weight: 600;
				margin: 0;
				display: flex;
				align-items: center;
				justify-content: center;
				gap: 10px;
			}

			.woo_price .less_price {
				color: #6c757d;
				text-decoration: line-through;
				font-size: 14px;
				font-weight: normal;
			}

			.woo_product_cart {
				position: absolute;
				bottom: 0;
				left: 0;
				right: 0;
				background: rgba(255,255,255,0.95);
				padding: 10px;
				opacity: 0;
				visibility: hidden;
				transform: translateY(10px);
				transition: all 0.3s ease;
			}

			.woo_product_grid:hover .woo_product_cart {
				opacity: 1;
				visibility: visible;
				transform: translateY(0);
			}

			.woo_product_cart ul {
				list-style: none;
				padding: 0;
				margin: 0;
				display: flex;
				justify-content: center;
				gap: 10px;
			}

			.woo_product_cart li {
				margin: 0;
			}

			.woo_product_cart li a {
				width: 35px;
				height: 35px;
				display: flex;
				align-items: center;
				justify-content: center;
				border-radius: 50%;
				color: #fff;
				font-size: 16px;
				transition: all 0.3s ease;
				box-shadow: 0 2px 10px rgba(0,0,0,0.1);
			}

			.woo_cart_btn {
				background: #00aeff !important;
			}

			.woo_cart_btn:hover {
				background: #0056b3 !important;
				transform: translateY(-2px);
			}

			.btn_save {
				background: #ff4c3b !important;
			}

			.btn_save:hover {
				background: #c82333 !important;
				transform: translateY(-2px);
			}

			.woo_pr_tag {
				position: absolute;
				top: 15px;
				left: 15px;
				z-index: 2;
				padding: 4px 15px;
				border-radius: 50px;
				font-size: 12px;
				font-weight: 500;
				text-transform: uppercase;
				letter-spacing: 0.5px;
			}

			.woo_pr_tag.hot {
				background: #ff4c3b;
				color: #fff;
			}

			/* Add a quick-view button */
			.quick-view {
				position: absolute;
				top: 15px;
				right: 15px;
				z-index: 2;
				background: #fff;
				color: #333;
				width: 35px;
				height: 35px;
				border-radius: 50%;
				display: flex;
				align-items: center;
				justify-content: center;
				box-shadow: 0 2px 10px rgba(0,0,0,0.1);
				opacity: 0;
				visibility: hidden;
				transform: translateY(-10px);
				transition: all 0.3s ease;
			}

			.woo_product_grid:hover .quick-view {
				opacity: 1;
				visibility: visible;
				transform: translateY(0);
			}

			/* Add a cart button that's always visible */
			.cart-button {
				position: absolute;
				right: 15px;
				bottom: 15px;
				background: #00aeff;
				color: #fff;
				width: 35px;
				height: 35px;
				border-radius: 50%;
				display: flex;
				align-items: center;
				justify-content: center;
				box-shadow: 0 2px 10px rgba(0,0,0,0.1);
				transition: all 0.3s ease;
				z-index: 2;
			}

			.cart-button:hover {
				background: #0056b3;
				transform: translateY(-2px);
			}

			/* Empty Wishlist Message */
			.alert-info {
				background: #f8f9fa;
				border: none;
				border-radius: 10px;
				padding: 30px;
				box-shadow: 0 2px 15px rgba(0,0,0,0.1);
			}

			.alert-info h4 {
				color: #333;
				margin-bottom: 15px;
			}

			.alert-info p {
				color: #666;
				margin-bottom: 20px;
			}

			.btn-theme {
				background: #007bff;
				color: #fff;
				padding: 10px 25px;
				border-radius: 5px;
				transition: all 0.3s ease;
			}

			.btn-theme:hover {
				background: #0056b3;
				transform: translateY(-2px);
				color: #fff;
			}

			/* Responsive Adjustments */
			@media (max-width: 991px) {
				.woo_product_grid {
					margin-bottom: 20px;
				}
				
				.woo_product_caption {
					padding: 15px;
				}
			}

			@media (max-width: 767px) {
				.woo_product_thumb {
					padding-top: 100%;
				}
				
				.woo_pro_title {
					font-size: 14px;
					min-height: 35px;
				}
				
				.woo_price h6 {
					font-size: 16px;
				}
			}

			/* Animation for Empty State */
			@keyframes fadeIn {
				from {
					opacity: 0;
					transform: translateY(20px);
				}
				to {
					opacity: 1;
					transform: translateY(0);
				}
			}

			.alert-info {
				animation: fadeIn 0.5s ease-out;
			}
			</style>

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
			<?php include 'footer.php'; ?>
			<!-- ============================ Footer End ================================== -->
			
			<!-- cart -->
			<!-- Switcher Start -->
			<div class="w3-ch-sideBar w3-bar-block w3-card-2 w3-animate-right"  style="display:none;right:0;" id="rightMenu">
				<div class="rightMenu-scroll">
					<h4 class="cart_heading">Your cart</h4>
					<button onclick="closeRightMenu()" class="w3-bar-item w3-button w3-large"><i class="ti-close"></i></button>
					<div class="right-ch-sideBar" id="side-scroll">
						
						<div class="cart_select_items">
							<!-- Single Item -->
							<div class="cart_selected_single">
								<div class="cart_selected_single_thumb">
									<a href="#"><img src="assets/img/product.jpg" class="img-fluid" alt="" /></a>
								</div>
								<div class="cart_selected_single_caption">
									<h4 class="product_title">Mahik Book pro</h4>
									<span class="numberof_item">$15x2</span>
									<a href="#" class="text-danger">Remove</a>
								</div>
							</div>
							<!-- Single Item -->
							<div class="cart_selected_single">
								<div class="cart_selected_single_thumb">
									<a href="#"><img src="assets/img/product.jpg" class="img-fluid" alt="" /></a>
								</div>
								<div class="cart_selected_single_caption">
									<h4 class="product_title">Mahik Book pro</h4>
									<span class="numberof_item">$15x2</span>
									<a href="#" class="text-danger">Remove</a>
								</div>
							</div>
							<!-- Single Item -->
							<div class="cart_selected_single">
								<div class="cart_selected_single_thumb">
									<a href="#"><img src="assets/img/product.jpg" class="img-fluid" alt="" /></a>
								</div>
								<div class="cart_selected_single_caption">
									<h4 class="product_title">Mahik Book pro</h4>
									<span class="numberof_item">$15x2</span>
									<a href="#" class="text-danger">Remove</a>
								</div>
							</div>
						</div>
						
						<div class="cart_subtotal">
							<h6>Subtotal<span class="theme-cl">$120.47</span></h6>
						</div>
						
						<div class="cart_action">
							<ul>
								<li><a href="#" class="btn btn-go-cart btn-theme">View/Edit Cart</a></li>
								<li><a href="#" class="btn btn-checkout">Checkout Now</a></li>
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
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content" id="view-product">
						<span class="mod-close" data-dismiss="modal" aria-hidden="true"><i class="ti-close"></i></span>
						<div class="modal-body">
							<div class="row align-items-center">
					
						<div class="col-lg-6 col-md-12 col-sm-12">
								<div class="sp-wrap">
									<img src="assets/img/detail/detail-1.png" class="img-fluid rounded" alt="">
								</div>
							</div>
							
							<div class="col-lg-6 col-md-12 col-sm-12">
								<div class="woo_pr_detail">
									
									<div class="woo_cats_wrps">
										<a href="#" class="woo_pr_cats">Casual Shirt</a>
										<span class="woo_pr_trending">Trending</span>
									</div>
									<h2 class="woo_pr_title">Profeshional Casual Shirt</h2>
									
									<div class="woo_pr_reviews">
										<div class="woo_pr_rating">
											<i class="fa fa-star filled"></i>
											<i class="fa fa-star filled"></i>
											<i class="fa fa-star filled"></i>
											<i class="fa fa-star filled"></i>
											<i class="fa fa-star"></i>
											<span class="woo_ave_rat">4.8</span>
										</div>
										<div class="woo_pr_total_reviews">
											<a href="#">(124 Reviews)</a>
										</div>
									</div>
									
									<div class="woo_pr_price">
										<div class="woo_pr_offer_price">
											<h3>$149<sup>.00</sup><span class="org_price">$199<sup>.99</sup></span></h3>
										</div>
									</div>
									
									<div class="woo_pr_short_desc">
										<p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores voluptatem quia voluptas sit aspernatur.</p>
									</div>
									
									<div class="woo_pr_color flex_inline_center mb-3">
										<div class="woo_pr_varient">
											<h6>Size:</h6>
										</div>
										<div class="woo_colors_list pl-3">
											<div class="custom-varient custom-size">
												<input type="radio" class="custom-control-input" name="sizeRadio" id="sizeRadioOne" value="5" data-toggle="form-caption" data-target="#sizeCaption">
												<label class="custom-control-label" for="sizeRadioOne">SM</label>
											</div>
											<div class="custom-varient custom-size">
												<input type="radio" class="custom-control-input" name="sizeRadio" id="sizeRadioTwo" value="6" data-toggle="form-caption" data-target="#sizeCaption">
												<label class="custom-control-label" for="sizeRadioTwo">M</label>
											</div>
											<div class="custom-varient custom-size">
												<input type="radio" class="custom-control-input" name="sizeRadio" id="sizeRadioThree" value="6.6" data-toggle="form-caption" data-target="#sizeCaption">
												<label class="custom-control-label" for="sizeRadioThree">L</label>
											</div>
											<div class="custom-varient custom-size">
												<input type="radio" class="custom-control-input" name="sizeRadio" id="sizeRadioFour" value="7" data-toggle="form-caption" data-target="#sizeCaption" checked>
												<label class="custom-control-label" for="sizeRadioFour">XL</label>
											</div>
										</div>
									</div>
									
									<div class="woo_pr_color flex_inline_center mb-3">
										<div class="woo_pr_varient">
											<h6>Color:</h6>
										</div>
										<div class="woo_colors_list pl-3">
											<div class="custom-varient custom-color red">
												<input type="radio" class="custom-control-input" name="colorRadio" id="red" value="5" data-toggle="form-caption" data-target="#colorCaption">
												<label class="custom-control-label" for="red">5</label>
											</div>
											<div class="custom-varient custom-color green">
												<input type="radio" class="custom-control-input" name="colorRadio" id="green" value="6" data-toggle="form-caption" data-target="#colorCaption">
												<label class="custom-control-label" for="green">6</label>
											</div>
											<div class="custom-varient custom-color purple">
												<input type="radio" class="custom-control-input" name="colorRadio" id="purple" value="6.6" data-toggle="form-caption" data-target="#colorCaption" checked>
												<label class="custom-control-label" for="purple">6.5</label>
											</div>
											<div class="custom-varient custom-color yellow">
												<input type="radio" class="custom-control-input" name="colorRadio" id="yellow" value="7" data-toggle="form-caption" data-target="#colorCaption">
												<label class="custom-control-label" for="yellow">7</label>
											</div>
											<div class="custom-varient custom-color blue">
												<input type="radio" class="custom-control-input" name="colorRadio" id="blue" value="6" data-toggle="form-caption" data-target="#colorCaption">
												<label class="custom-control-label" for="blue">7.5</label>
											</div>
										</div>
									</div>
									
									<div class="woo_btn_action">
										<div class="col-12 col-lg-auto">
											<input type="number" class="form-control mb-2 full-width" value="1" />
										</div>
									</div>
									
									<div class="woo_btn_action">
										<div class="col-12 col-lg-auto">
											<button type="submit" class="btn btn-block btn-dark mb-2">Add to Cart <i class="ti-shopping-cart-full ml-2"></i></button>
										</div>
										<div class="col-12 col-lg-auto">
											<button class="btn btn-gray btn-block mb-2" data-toggle="button">Wishlist <i class="ti-heart ml-2"></i></button>
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
		
		<script>
			function openRightMenu() {
				document.getElementById("rightMenu").style.display = "block";
			}
			function closeRightMenu() {
				document.getElementById("rightMenu").style.display = "none";
			}
		</script>
		
		<script>
			function openLeftMenu() {
				document.getElementById("leftMenu").style.display = "block";
			}
			function closeLeftMenu() {
				document.getElementById("leftMenu").style.display = "none";
			}
		</script>

		<!-- ============================================================== -->
		<!-- This page plugins -->
		<!-- ============================================================== -->

	</body>

</html>