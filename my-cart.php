<?php
session_start();
include 'admin/dbconnection.php';
include 'check-auth.php';

// Require login for this page
requireLogin();

// Function to get cart items with details
function getCartItems($conn, $user_id) {
    $items = array();
    $total = 0;
    
    $sql = "SELECT c.*, p.product_name, p.description, pi.image_path, 
            COALESCE(pu.price, pp.price) as unit_price,
            COALESCE(pu.unit_value, '') as unit_value,
            COALESCE(pu.unit_type, '') as unit_type
            FROM cart c
            LEFT JOIN products p ON c.product_id = p.id
            LEFT JOIN product_units pu ON c.unit_id = pu.id
            LEFT JOIN product_prices pp ON c.product_id = pp.product_id
            LEFT JOIN (
                SELECT product_id, MIN(image_path) as image_path
                FROM product_images
                GROUP BY product_id
            ) pi ON p.id = pi.product_id
            WHERE c.user_id = ?";
            
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $user_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        while ($row = mysqli_fetch_assoc($result)) {
            $row['subtotal'] = $row['unit_price'] * $row['quantity'];
            $total += $row['subtotal'];
            $items[] = $row;
        }
    }
    
    return array('items' => $items, 'total' => $total);
}

// Get cart items
$cart_data = isset($_SESSION['user_id']) ? getCartItems($conn, $_SESSION['user_id']) : array('items' => array(), 'total' => 0);
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
			<?php include 'header.php' ?>
			<!-- End Navigation -->
			<div class="clearfix"></div>
			<!-- ============================================================== -->
			<!-- Top header  -->
			<!-- ============================================================== -->
			
			<!-- =========================== Breadcrumbs =================================== -->
			<div class="breadcrumbs_wrap gray">
				<div class="container">
					<div class="row align-items-center">
						
						<div class="col-lg-12 col-md-12 col-sm-12 col-12">
							<div class="text-center">
								<h2 class="breadcrumbs_title">Add To Cart</h2>
								<nav aria-label="breadcrumb">
								  <ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="#"><i class="ti-home"></i></a></li>
									<li class="breadcrumb-item"><a href="#">Shop</a></li>
									<li class="breadcrumb-item active" aria-current="page">Add To cart</li>
								  </ol>
								</nav>
							</div>
						</div>
						
					</div>
				</div>
			</div>
			<!-- =========================== Breadcrumbs =================================== -->
			
			<!-- =========================== Add To Cart =================================== -->
			<section>
				<div class="container">
					<div class="row">
						
						<div class="col-lg-8 col-md-12 col-sm-12 col-12">
							<div class="table-responsive">
								<table class="table">
									<thead>
										<tr>
											<th scope="col">Product</th>
											<th scope="col">Price</th>
											<th scope="col">Quantity</th>
											<th scope="col">Total</th>
										</tr>
									</thead>
									<tbody>
										<?php if (!empty($cart_data['items'])): ?>
											<?php foreach ($cart_data['items'] as $item): ?>
												<tr>
													<td>
														<div class="tbl_cart_product">
															<div class="tbl_cart_product_thumb">
																<img src="<?php echo !empty($item['image_path']) ? 'admin/' . $item['image_path'] : 'assets/img/product/1.jpg'; ?>" 
																	 class="img-fluid" alt="<?php echo htmlspecialchars($item['product_name']); ?>" />
															</div>
															<div class="tbl_cart_product_caption">
																<h5 class="tbl_pr_title"><?php echo htmlspecialchars($item['product_name']); ?></h5>
																<?php if (!empty($item['unit_value']) && !empty($item['unit_type'])): ?>
																	<span class="tbl_pr_quality theme-cl">
																		<?php echo htmlspecialchars($item['unit_value'] . ' ' . $item['unit_type']); ?>
																	</span>
																<?php endif; ?>
															</div>
														</div>
													</td>
													<td>
														<h4 class="tbl_org_price">₹<?php echo number_format($item['unit_price'], 2); ?></h4>
													</td>
													<td>
														<input type="number" class="form-control tbl_quan" 
															   value="<?php echo $item['quantity']; ?>" 
															   min="1"
															   data-cart-id="<?php echo $item['id']; ?>" />
													</td>
													<td>
														<div class="tbl_pr_action">
															<h5 class="tbl_total_price">₹<?php echo number_format($item['subtotal'], 2); ?></h5>
															<a href="#" class="tbl_remove" data-cart-id="<?php echo $item['id']; ?>">
																<i class="ti-close"></i>
															</a>
														</div>
													</td>
												</tr>
											<?php endforeach; ?>
										<?php else: ?>
											<tr>
												<td colspan="4" class="text-center">
													<p>Your cart is empty</p>
													<a href="index.php" class="btn btn-theme">Continue Shopping</a>
												</td>
											</tr>
										<?php endif; ?>
									</tbody>
								</table>
							</div>
							
							<?php if (!empty($cart_data['items'])): ?>
								<!-- Coupon Box -->
								<div class="row align-items-end justify-content-between mb-10 mb-md-0">
									<div class="col-12 col-md-7">
										<!-- Coupon -->
										<form class="mb-7 mb-md-0">
											<div class="col">
												<label class="font-size-sm font-weight-bold">Coupon code:</label>
											</div>
											<div class="row form-row">
												<div class="col">
													<input class="form-control form-control-sm" type="text" placeholder="Enter coupon code*">
												</div>
												<div class="col-auto">
													<button class="btn btn-dark" type="submit">Apply</button>
												</div>
											</div>
										</form>
									</div>
									
									<div class="col-12 col-md-auto m-full">
										<button class="btn btn-outline-dark" id="update-cart">Update Cart</button>
									</div>
								</div>
							<?php endif; ?>
						</div>
						
						<div class="col-lg-4 col-md-12 col-sm-12 col-12">
							<div class="cart_detail_box mb-4">
								<div class="card-body">
									<ul class="list-group list-group-sm list-group-flush-y list-group-flush-x">
										<li class="list-group-item d-flex">
											<h5 class="mb-0">Order Summary</h5>
										</li>
										<li class="list-group-item d-flex">
											<span>Subtotal</span> 
											<span class="ml-auto font-size-sm">₹<?php echo number_format($cart_data['total'], 2); ?></span>
										</li>
										<li class="list-group-item d-flex">
											<span>Tax</span> 
											<span class="ml-auto font-size-sm">₹0.00</span>
										</li>
										<li class="list-group-item d-flex font-size-lg font-weight-bold">
											<span>Total</span> 
											<span class="ml-auto font-size-sm">₹<?php echo number_format($cart_data['total'], 2); ?></span>
										</li>
										<li class="list-group-item font-size-sm text-center text-gray-500">
											Shipping cost calculated at Checkout *
										</li>
									</ul>
								</div>
							</div>
							<a class="btn btn-block btn-dark mb-2" href="checkout.php">Proceed to Checkout</a>
							<a class="px-0 text-body" href="index.php"><i class="ti-back-left mr-2"></i> Continue Shopping</a>
						</div>
						
						
					</div>
				</div>
			</section>
			<!-- =========================== Add To Cart =================================== -->
			
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
			<?php include 'footer.php' ?>
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

		<script>
		$(document).ready(function() {
			// Update quantity
			$('.tbl_quan').on('change', function() {
				const cartId = $(this).data('cart-id');
				const quantity = $(this).val();
				
				if (quantity < 1) {
					$(this).val(1);
					return;
				}
				
				$.ajax({
					url: 'update-cart-quantity.php',
					type: 'POST',
					data: {
						cart_id: cartId,
						quantity: quantity
					},
					dataType: 'json',
					success: function(response) {
						if (response.success) {
							// Reload the page to show updated totals
							location.reload();
						} else {
							alert(response.message || 'Error updating quantity');
						}
					},
					error: function() {
						alert('Error updating quantity');
					}
				});
			});
			
			// Remove item from cart
			$('.tbl_remove').on('click', function(e) {
				e.preventDefault();
				const cartId = $(this).data('cart-id');
				
				if (confirm('Are you sure you want to remove this item?')) {
					$.ajax({
						url: 'remove-cart-item.php',
						type: 'POST',
						data: {
							cart_id: cartId
						},
						dataType: 'json',
						success: function(response) {
							if (response.success) {
								location.reload();
							} else {
								alert(response.message || 'Error removing item');
							}
						},
						error: function() {
							alert('Error removing item');
						}
					});
				}
			});
			
			// Update cart button
			$('#update-cart').on('click', function() {
				location.reload();
			});
		});
		</script>

	</body>

</html>