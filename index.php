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
    <div id="preloader">
        <div class="preloader"><span></span><span></span></div>
    </div>


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


        <!-- ======================== Banner Start ==================== -->
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="d-block w-100" src="assets/img/banner-4.png" alt="First slide">
                    <div class="carousel-caption banner_caption light">
                        <h4>Get <span class="theme-cl">Free Deliver</span> Your Order At Home</h4>
                        <p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia
                            consequuntur magni dolores.</p>
                        <a href="search-sidebar.html" class="btn btn-theme">Order Now</a>
                    </div>
                </div>

                <div class="carousel-item">
                    <img class="d-block w-100" src="assets/img/banner-5.png" alt="First slide">
                    <div class="carousel-caption banner_caption light">
                        <h4>Get <span class="theme-cl">Fresh</span> Fruits & Vegetables </h4>
                        <p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia
                            consequuntur magni dolores.</p>
                        <a href="search-sidebar.html" class="btn btn-theme">Order Now</a>
                    </div>
                </div>

                <div class="carousel-item">
                    <img class="d-block w-100" src="assets/img/banner-6.png" alt="First slide">
                    <div class="carousel-caption banner_caption">
                        <h4>Fresh Fruits in <span class="theme-cl">Your City</span> with Free Deliver</h4>
                        <p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia
                            consequuntur magni dolores.</p>
                        <a href="search-sidebar.html" class="btn btn-theme">Order Now</a>
                    </div>
                </div>

            </div>

            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
        <!-- ======================== Banner End ==================== -->

        <!-- ======================== Choose Category Start ==================== -->
        <section class="pt-5 pb-5">
            <div class="container">

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="owl-carousel category-slider owl-theme">

                            <!-- Single Item -->
                            <div class="item">
                                <div class="woo_category_box border_style rounded">
                                    <div class="woo_cat_thumb">
                                        <a href="search-sidebar.html"><img src="assets/img/c-1.png" class="img-fluid"
                                                alt="" /></a>
                                    </div>
                                    <div class="woo_cat_caption">
                                        <h4><a href="search-sidebar.html">Fresh Vegetables</a></h4>
                                    </div>
                                </div>
                            </div>

                            <!-- Single Item -->
                            <div class="item">
                                <div class="woo_category_box border_style rounded">
                                    <div class="woo_cat_thumb">
                                        <a href="search-sidebar.html"><img src="assets/img/c-3.png" class="img-fluid"
                                                alt="" /></a>
                                    </div>
                                    <div class="woo_cat_caption">
                                        <h4><a href="search-sidebar.html">Dairy & Eggs</a></h4>
                                    </div>
                                </div>
                            </div>

                            <!-- Single Item -->
                            <div class="item">
                                <div class="woo_category_box border_style rounded">
                                    <div class="woo_cat_thumb">
                                        <a href="search-sidebar.html"><img src="assets/img/c-3.png" class="img-fluid"
                                                alt="" /></a>
                                    </div>
                                    <div class="woo_cat_caption">
                                        <h4><a href="search-sidebar.html">Beverages</a></h4>
                                    </div>
                                </div>
                            </div>

                            <!-- Single Item -->
                            <div class="item">
                                <div class="woo_category_box border_style rounded">
                                    <div class="woo_cat_thumb">
                                        <a href="search-sidebar.html"><img src="assets/img/c-4.png" class="img-fluid"
                                                alt="" /></a>
                                    </div>
                                    <div class="woo_cat_caption">
                                        <h4><a href="search-sidebar.html">Meat & Seafood</a></h4>
                                    </div>
                                </div>
                            </div>

                            <!-- Single Item -->
                            <div class="item">
                                <div class="woo_category_box border_style rounded">
                                    <div class="woo_cat_thumb">
                                        <a href="search-sidebar.html"><img src="assets/img/c-5.png" class="img-fluid"
                                                alt="" /></a>
                                    </div>
                                    <div class="woo_cat_caption">
                                        <h4><a href="search-sidebar.html">Fruits</a></h4>
                                    </div>
                                </div>
                            </div>

                            <!-- Single Item -->
                            <div class="item">
                                <div class="woo_category_box border_style rounded">
                                    <div class="woo_cat_thumb">
                                        <a href="search-sidebar.html"><img src="assets/img/c-6.png" class="img-fluid"
                                                alt="" /></a>
                                    </div>
                                    <div class="woo_cat_caption">
                                        <h4><a href="search-sidebar.html">Grocery & Staples</a></h4>
                                    </div>
                                </div>
                            </div>

                            <!-- Single Item -->
                            <div class="item">
                                <div class="woo_category_box border_style rounded">
                                    <div class="woo_cat_thumb">
                                        <a href="search-sidebar.html"><img src="assets/img/c-7.png" class="img-fluid"
                                                alt="" /></a>
                                    </div>
                                    <div class="woo_cat_caption">
                                        <h4><a href="search-sidebar.html">Snacks</a></h4>
                                    </div>
                                </div>
                            </div>

                            <!-- Single Item -->
                            <div class="item">
                                <div class="woo_category_box border_style rounded">
                                    <div class="woo_cat_thumb">
                                        <a href="search-sidebar.html"><img src="assets/img/c-8.png" class="img-fluid"
                                                alt="" /></a>
                                    </div>
                                    <div class="woo_cat_caption">
                                        <h4><a href="search-sidebar.html">Pets care</a></h4>
                                    </div>
                                </div>
                            </div>

                            <!-- Single Item -->
                            <div class="item">
                                <div class="woo_category_box border_style rounded">
                                    <div class="woo_cat_thumb">
                                        <a href="search-sidebar.html"><img src="assets/img/c-9.png" class="img-fluid"
                                                alt="" /></a>
                                    </div>
                                    <div class="woo_cat_caption">
                                        <h4><a href="search-sidebar.html">Electornics</a></h4>
                                    </div>
                                </div>
                            </div>

                            <!-- Single Item -->
                            <div class="item">
                                <div class="woo_category_box border_style rounded">
                                    <div class="woo_cat_thumb">
                                        <a href="search-sidebar.html"><img src="assets/img/c-10.png" class="img-fluid"
                                                alt="" /></a>
                                    </div>
                                    <div class="woo_cat_caption">
                                        <h4><a href="search-sidebar.html">Home Care</a></h4>
                                    </div>
                                </div>
                            </div>

                            <!-- Single Item -->
                            <div class="item">
                                <div class="woo_category_box border_style rounded">
                                    <div class="woo_cat_thumb">
                                        <a href="search-sidebar.html"><img src="assets/img/c-12.png" class="img-fluid"
                                                alt="" /></a>
                                    </div>
                                    <div class="woo_cat_caption">
                                        <h4><a href="search-sidebar.html">Noodles & Sauces</a></h4>
                                    </div>
                                </div>
                            </div>

                            <!-- Single Item -->
                            <div class="item">
                                <div class="woo_category_box border_style rounded">
                                    <div class="woo_cat_thumb">
                                        <a href="search-sidebar.html"><img src="assets/img/c-11.png" class="img-fluid"
                                                alt="" /></a>
                                    </div>
                                    <div class="woo_cat_caption">
                                        <h4><a href="search-sidebar.html">Dry Snacks</a></h4>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </section>
        <div class="clearfix"></div>
        <!-- ======================== Choose Category End ==================== -->

        <!-- ======================== Fresh Vegetables Start ==================== -->
        <section class="pt-0">
            <div class="container">

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="sec-heading-flex pl-2 pr-2">
                            <div class="sec-heading-flex-one">
                                <h2>Fresh Vegetables</h2>
                            </div>
                            <div class="sec-heading-flex-last">
                                <a href="search-sidebar.html" class="btn btn-theme">View More<i
                                        class="ti-arrow-right ml-2"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="owl-carousel products-slider owl-theme">

                            <!-- Single Item -->
                            <div class="item">
                                <div class="woo_product_grid">
                                    <span class="woo_pr_tag hot">Hot</span>
                                    <div class="woo_product_thumb">
                                        <img src="assets/img/vegetables/1.png" class="img-fluid" alt="" />
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
                                            <h4 class="woo_pro_title"><a href="detail-1.html">Accumsan Tree Fusce</a>
                                            </h4>
                                        </div>
                                        <div class="woo_price">
                                            <h6>$72.47<span class="less_price">$112.10</span></h6>
                                        </div>
                                    </div>
                                    <div class="woo_product_cart hover">
                                        <ul>
                                            <li><a href="javascript:void(0);" data-toggle="modal"
                                                    data-target="#viewproduct-over" class="woo_cart_btn btn_cart"><i
                                                        class="ti-eye"></i></a></li>
                                            <li><a href="add-to-cart.html" class="woo_cart_btn btn_view"><i
                                                        class="ti-shopping-cart"></i></a></li>
                                            <li><a href="wishlist.html" class="woo_cart_btn btn_save"><i
                                                        class="ti-heart"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Single Item -->
                            <div class="item">
                                <div class="woo_product_grid">
                                    <div class="woo_product_thumb">
                                        <img src="assets/img/vegetables/2.png" class="img-fluid" alt="" />
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
                                            <h4 class="woo_pro_title"><a href="detail-1.html">Accumsan Tree Fusce</a>
                                            </h4>
                                        </div>
                                        <div class="woo_price">
                                            <h6>$72.47<span class="less_price">$112.10</span></h6>
                                        </div>
                                    </div>
                                    <div class="woo_product_cart hover">
                                        <ul>
                                            <li><a href="javascript:void(0);" data-toggle="modal"
                                                    data-target="#viewproduct-over" class="woo_cart_btn btn_cart"><i
                                                        class="ti-eye"></i></a></li>
                                            <li><a href="add-to-cart.html" class="woo_cart_btn btn_view"><i
                                                        class="ti-shopping-cart"></i></a></li>
                                            <li><a href="wishlist.html" class="woo_cart_btn btn_save"><i
                                                        class="ti-heart"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Single Item -->
                            <div class="item">
                                <div class="woo_product_grid">
                                    <span class="woo_pr_tag new">New</span>
                                    <div class="woo_product_thumb">
                                        <img src="assets/img/vegetables/3.png" class="img-fluid" alt="" />
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
                                            <h4 class="woo_pro_title"><a href="detail-1.html">Accumsan Tree Fusce</a>
                                            </h4>
                                        </div>
                                        <div class="woo_price">
                                            <h6>$72.47<span class="less_price">$112.10</span></h6>
                                        </div>
                                    </div>
                                    <div class="woo_product_cart hover">
                                        <ul>
                                            <li><a href="javascript:void(0);" data-toggle="modal"
                                                    data-target="#viewproduct-over" class="woo_cart_btn btn_cart"><i
                                                        class="ti-eye"></i></a></li>
                                            <li><a href="add-to-cart.html" class="woo_cart_btn btn_view"><i
                                                        class="ti-shopping-cart"></i></a></li>
                                            <li><a href="wishlist.html" class="woo_cart_btn btn_save"><i
                                                        class="ti-heart"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Single Item -->
                            <div class="item">
                                <div class="woo_product_grid">
                                    <span class="woo_offer_sell">Save 20% Off</span>
                                    <div class="woo_product_thumb">
                                        <img src="assets/img/vegetables/4.png" class="img-fluid" alt="" />
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
                                            <h4 class="woo_pro_title"><a href="detail-1.html">Accumsan Tree Fusce</a>
                                            </h4>
                                        </div>
                                        <div class="woo_price">
                                            <h6>$72.47<span class="less_price">$112.10</span></h6>
                                        </div>
                                    </div>
                                    <div class="woo_product_cart hover">
                                        <ul>
                                            <li><a href="javascript:void(0);" data-toggle="modal"
                                                    data-target="#viewproduct-over" class="woo_cart_btn btn_cart"><i
                                                        class="ti-eye"></i></a></li>
                                            <li><a href="add-to-cart.html" class="woo_cart_btn btn_view"><i
                                                        class="ti-shopping-cart"></i></a></li>
                                            <li><a href="wishlist.html" class="woo_cart_btn btn_save"><i
                                                        class="ti-heart"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Single Item -->
                            <div class="item">
                                <div class="woo_product_grid">
                                    <span class="woo_pr_tag hot">Hot</span>
                                    <div class="woo_product_thumb">
                                        <img src="assets/img/vegetables/5.png" class="img-fluid" alt="" />
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
                                            <h4 class="woo_pro_title"><a href="detail-1.html">Accumsan Tree Fusce</a>
                                            </h4>
                                        </div>
                                        <div class="woo_price">
                                            <h6>$72.47<span class="less_price">$112.10</span></h6>
                                        </div>
                                    </div>
                                    <div class="woo_product_cart hover">
                                        <ul>
                                            <li><a href="javascript:void(0);" data-toggle="modal"
                                                    data-target="#viewproduct-over" class="woo_cart_btn btn_cart"><i
                                                        class="ti-eye"></i></a></li>
                                            <li><a href="add-to-cart.html" class="woo_cart_btn btn_view"><i
                                                        class="ti-shopping-cart"></i></a></li>
                                            <li><a href="wishlist.html" class="woo_cart_btn btn_save"><i
                                                        class="ti-heart"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Single Item -->
                            <div class="item">
                                <div class="woo_product_grid">
                                    <div class="woo_product_thumb">
                                        <img src="assets/img/vegetables/6.png" class="img-fluid" alt="" />
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
                                            <h4 class="woo_pro_title"><a href="detail-1.html">Accumsan Tree Fusce</a>
                                            </h4>
                                        </div>
                                        <div class="woo_price">
                                            <h6>$72.47<span class="less_price">$112.10</span></h6>
                                        </div>
                                    </div>
                                    <div class="woo_product_cart hover">
                                        <ul>
                                            <li><a href="javascript:void(0);" data-toggle="modal"
                                                    data-target="#viewproduct-over" class="woo_cart_btn btn_cart"><i
                                                        class="ti-eye"></i></a></li>
                                            <li><a href="add-to-cart.html" class="woo_cart_btn btn_view"><i
                                                        class="ti-shopping-cart"></i></a></li>
                                            <li><a href="wishlist.html" class="woo_cart_btn btn_save"><i
                                                        class="ti-heart"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Single Item -->
                            <div class="item">
                                <div class="woo_product_grid">
                                    <span class="woo_pr_tag hot">Hot</span>
                                    <div class="woo_product_thumb">
                                        <img src="assets/img/vegetables/7.png" class="img-fluid" alt="" />
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
                                            <h4 class="woo_pro_title"><a href="detail-1.html">Accumsan Tree Fusce</a>
                                            </h4>
                                        </div>
                                        <div class="woo_price">
                                            <h6>$72.47<span class="less_price">$112.10</span></h6>
                                        </div>
                                    </div>
                                    <div class="woo_product_cart hover">
                                        <ul>
                                            <li><a href="javascript:void(0);" data-toggle="modal"
                                                    data-target="#viewproduct-over" class="woo_cart_btn btn_cart"><i
                                                        class="ti-eye"></i></a></li>
                                            <li><a href="add-to-cart.html" class="woo_cart_btn btn_view"><i
                                                        class="ti-shopping-cart"></i></a></li>
                                            <li><a href="wishlist.html" class="woo_cart_btn btn_save"><i
                                                        class="ti-heart"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Single Item -->
                            <div class="item">
                                <div class="woo_product_grid">
                                    <span class="woo_pr_tag new">New</span>
                                    <div class="woo_product_thumb">
                                        <img src="assets/img/vegetables/8.png" class="img-fluid" alt="" />
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
                                            <h4 class="woo_pro_title"><a href="detail-1.html">Accumsan Tree Fusce</a>
                                            </h4>
                                        </div>
                                        <div class="woo_price">
                                            <h6>$72.47<span class="less_price">$112.10</span></h6>
                                        </div>
                                    </div>
                                    <div class="woo_product_cart hover">
                                        <ul>
                                            <li><a href="javascript:void(0);" data-toggle="modal"
                                                    data-target="#viewproduct-over" class="woo_cart_btn btn_cart"><i
                                                        class="ti-eye"></i></a></li>
                                            <li><a href="add-to-cart.html" class="woo_cart_btn btn_view"><i
                                                        class="ti-shopping-cart"></i></a></li>
                                            <li><a href="wishlist.html" class="woo_cart_btn btn_save"><i
                                                        class="ti-heart"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="clearfix"></div>
        <!-- ======================== Fresh Vegetables End ==================== -->

        <!-- ======================== Fresh & Fast Fruits Start ==================== -->
        <section class="pt-0">
            <div class="container">

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="sec-heading-flex pl-2 pr-2">
                            <div class="sec-heading-flex-one">
                                <h2>Fresh & Fast Fruits</h2>
                            </div>
                            <div class="sec-heading-flex-last">
                                <a href="search-sidebar.html" class="btn btn-theme">View More<i
                                        class="ti-arrow-right ml-2"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="owl-carousel products-slider owl-theme">

                            <!-- Single Item -->
                            <div class="item">
                                <div class="woo_product_grid">
                                    <div class="woo_product_thumb">
                                        <img src="assets/img/fruits/1.png" class="img-fluid" alt="" />
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
                                            <h4 class="woo_pro_title"><a href="detail-1.html">Accumsan Tree Fusce</a>
                                            </h4>
                                        </div>
                                        <div class="woo_price">
                                            <h6>$72.47<span class="less_price">$112.10</span></h6>
                                        </div>
                                    </div>
                                    <div class="woo_product_cart hover">
                                        <ul>
                                            <li><a href="javascript:void(0);" data-toggle="modal"
                                                    data-target="#viewproduct-over" class="woo_cart_btn btn_cart"><i
                                                        class="ti-eye"></i></a></li>
                                            <li><a href="add-to-cart.html" class="woo_cart_btn btn_view"><i
                                                        class="ti-shopping-cart"></i></a></li>
                                            <li><a href="wishlist.html" class="woo_cart_btn btn_save"><i
                                                        class="ti-heart"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Single Item -->
                            <div class="item">
                                <div class="woo_product_grid">
                                    <span class="woo_pr_tag hot">Hot</span>
                                    <div class="woo_product_thumb">
                                        <img src="assets/img/fruits/2.png" class="img-fluid" alt="" />
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
                                            <h4 class="woo_pro_title"><a href="detail-1.html">Accumsan Tree Fusce</a>
                                            </h4>
                                        </div>
                                        <div class="woo_price">
                                            <h6>$72.47<span class="less_price">$112.10</span></h6>
                                        </div>
                                    </div>
                                    <div class="woo_product_cart hover">
                                        <ul>
                                            <li><a href="javascript:void(0);" data-toggle="modal"
                                                    data-target="#viewproduct-over" class="woo_cart_btn btn_cart"><i
                                                        class="ti-eye"></i></a></li>
                                            <li><a href="add-to-cart.html" class="woo_cart_btn btn_view"><i
                                                        class="ti-shopping-cart"></i></a></li>
                                            <li><a href="wishlist.html" class="woo_cart_btn btn_save"><i
                                                        class="ti-heart"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Single Item -->
                            <div class="item">
                                <div class="woo_product_grid">
                                    <div class="woo_product_thumb">
                                        <img src="assets/img/fruits/3.png" class="img-fluid" alt="" />
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
                                            <h4 class="woo_pro_title"><a href="detail-1.html">Accumsan Tree Fusce</a>
                                            </h4>
                                        </div>
                                        <div class="woo_price">
                                            <h6>$72.47<span class="less_price">$112.10</span></h6>
                                        </div>
                                    </div>
                                    <div class="woo_product_cart hover">
                                        <ul>
                                            <li><a href="javascript:void(0);" data-toggle="modal"
                                                    data-target="#viewproduct-over" class="woo_cart_btn btn_cart"><i
                                                        class="ti-eye"></i></a></li>
                                            <li><a href="add-to-cart.html" class="woo_cart_btn btn_view"><i
                                                        class="ti-shopping-cart"></i></a></li>
                                            <li><a href="wishlist.html" class="woo_cart_btn btn_save"><i
                                                        class="ti-heart"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Single Item -->
                            <div class="item">
                                <div class="woo_product_grid">
                                    <span class="woo_pr_tag new">New</span>
                                    <div class="woo_product_thumb">
                                        <img src="assets/img/fruits/4.png" class="img-fluid" alt="" />
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
                                            <h4 class="woo_pro_title"><a href="detail-1.html">Accumsan Tree Fusce</a>
                                            </h4>
                                        </div>
                                        <div class="woo_price">
                                            <h6>$72.47<span class="less_price">$112.10</span></h6>
                                        </div>
                                    </div>
                                    <div class="woo_product_cart hover">
                                        <ul>
                                            <li><a href="javascript:void(0);" data-toggle="modal"
                                                    data-target="#viewproduct-over" class="woo_cart_btn btn_cart"><i
                                                        class="ti-eye"></i></a></li>
                                            <li><a href="add-to-cart.html" class="woo_cart_btn btn_view"><i
                                                        class="ti-shopping-cart"></i></a></li>
                                            <li><a href="wishlist.html" class="woo_cart_btn btn_save"><i
                                                        class="ti-heart"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Single Item -->
                            <div class="item">
                                <div class="woo_product_grid">
                                    <div class="woo_product_thumb">
                                        <img src="assets/img/fruits/5.png" class="img-fluid" alt="" />
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
                                            <h4 class="woo_pro_title"><a href="detail-1.html">Accumsan Tree Fusce</a>
                                            </h4>
                                        </div>
                                        <div class="woo_price">
                                            <h6>$72.47<span class="less_price">$112.10</span></h6>
                                        </div>
                                    </div>
                                    <div class="woo_product_cart hover">
                                        <ul>
                                            <li><a href="javascript:void(0);" data-toggle="modal"
                                                    data-target="#viewproduct-over" class="woo_cart_btn btn_cart"><i
                                                        class="ti-eye"></i></a></li>
                                            <li><a href="add-to-cart.html" class="woo_cart_btn btn_view"><i
                                                        class="ti-shopping-cart"></i></a></li>
                                            <li><a href="wishlist.html" class="woo_cart_btn btn_save"><i
                                                        class="ti-heart"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Single Item -->
                            <div class="item">
                                <div class="woo_product_grid">
                                    <span class="woo_pr_tag hot">Hot</span>
                                    <div class="woo_product_thumb">
                                        <img src="assets/img/fruits/6.png" class="img-fluid" alt="" />
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
                                            <h4 class="woo_pro_title"><a href="detail-1.html">Accumsan Tree Fusce</a>
                                            </h4>
                                        </div>
                                        <div class="woo_price">
                                            <h6>$72.47<span class="less_price">$112.10</span></h6>
                                        </div>
                                    </div>
                                    <div class="woo_product_cart hover">
                                        <ul>
                                            <li><a href="javascript:void(0);" data-toggle="modal"
                                                    data-target="#viewproduct-over" class="woo_cart_btn btn_cart"><i
                                                        class="ti-eye"></i></a></li>
                                            <li><a href="add-to-cart.html" class="woo_cart_btn btn_view"><i
                                                        class="ti-shopping-cart"></i></a></li>
                                            <li><a href="wishlist.html" class="woo_cart_btn btn_save"><i
                                                        class="ti-heart"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Single Item -->
                            <div class="item">
                                <div class="woo_product_grid">
                                    <div class="woo_product_thumb">
                                        <img src="assets/img/fruits/7.png" class="img-fluid" alt="" />
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
                                            <h4 class="woo_pro_title"><a href="detail-1.html">Accumsan Tree Fusce</a>
                                            </h4>
                                        </div>
                                        <div class="woo_price">
                                            <h6>$72.47<span class="less_price">$112.10</span></h6>
                                        </div>
                                    </div>
                                    <div class="woo_product_cart hover">
                                        <ul>
                                            <li><a href="javascript:void(0);" data-toggle="modal"
                                                    data-target="#viewproduct-over" class="woo_cart_btn btn_cart"><i
                                                        class="ti-eye"></i></a></li>
                                            <li><a href="add-to-cart.html" class="woo_cart_btn btn_view"><i
                                                        class="ti-shopping-cart"></i></a></li>
                                            <li><a href="wishlist.html" class="woo_cart_btn btn_save"><i
                                                        class="ti-heart"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Single Item -->
                            <div class="item">
                                <div class="woo_product_grid">
                                    <span class="woo_offer_sell">Save 10% Off</span>
                                    <div class="woo_product_thumb">
                                        <img src="assets/img/fruits/8.png" class="img-fluid" alt="" />
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
                                            <h4 class="woo_pro_title"><a href="detail-1.html">Accumsan Tree Fusce</a>
                                            </h4>
                                        </div>
                                        <div class="woo_price">
                                            <h6>$72.47<span class="less_price">$112.10</span></h6>
                                        </div>
                                    </div>
                                    <div class="woo_product_cart hover">
                                        <ul>
                                            <li><a href="javascript:void(0);" data-toggle="modal"
                                                    data-target="#viewproduct-over" class="woo_cart_btn btn_cart"><i
                                                        class="ti-eye"></i></a></li>
                                            <li><a href="add-to-cart.html" class="woo_cart_btn btn_view"><i
                                                        class="ti-shopping-cart"></i></a></li>
                                            <li><a href="wishlist.html" class="woo_cart_btn btn_save"><i
                                                        class="ti-heart"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="clearfix"></div>
        <!-- ======================== Fresh & Fast Fruits End ==================== -->

        <!-- ======================== Offer Banner Start ==================== -->
        <section class="offer-banner-wrap gray">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="owl-carousel banner-offers owl-theme">

                            <!-- Single Item -->
                            <div class="item">
                                <div class="offer_item">
                                    <div class="offer_item_thumb">
                                        <div class="offer-overlay"></div>
                                        <img src="assets/img/offer-1.jpg" alt="">
                                    </div>
                                    <div class="offer_caption">
                                        <div class="offer_bottom_caption">
                                            <p>10% Off</p>
                                            <div class="offer_title">Good Deals in Your City</div>
                                            <span>Save 10% on All Fruits</span>
                                        </div>
                                        <a href="search-sidebar.html" class="btn offer_box_btn">Explore Now</a>
                                    </div>
                                </div>
                            </div>

                            <!-- Single Item -->
                            <div class="item">
                                <div class="offer_item">
                                    <div class="offer_item_thumb">
                                        <div class="offer-overlay"></div>
                                        <img src="assets/img/offer-2.jpg" alt="">
                                    </div>
                                    <div class="offer_caption">
                                        <div class="offer_bottom_caption">
                                            <p>25% Off</p>
                                            <div class="offer_title">Good Offer on First Time</div>
                                            <span>Save 25% on Fresh Vegetables</span>
                                        </div>
                                        <a href="search-sidebar.html" class="btn offer_box_btn">Explore Now</a>
                                    </div>
                                </div>
                            </div>

                            <!-- Single Item -->
                            <div class="item">
                                <div class="offer_item">
                                    <div class="offer_item_thumb">
                                        <div class="offer-overlay"></div>
                                        <img src="assets/img/offer-3.jpg" alt="">
                                    </div>
                                    <div class="offer_caption">
                                        <div class="offer_bottom_caption">
                                            <p>30% Off</p>
                                            <div class="offer_title">Super Market Deals</div>
                                            <span>Save 30% on Eggs & Dairy</span>
                                        </div>
                                        <a href="search-sidebar.html" class="btn offer_box_btn">Explore Now</a>
                                    </div>
                                </div>
                            </div>

                            <!-- Single Item -->
                            <div class="item">
                                <div class="offer_item">
                                    <div class="offer_item_thumb">
                                        <div class="offer-overlay"></div>
                                        <img src="assets/img/offer-4.jpg" alt="">
                                    </div>
                                    <div class="offer_caption">
                                        <div class="offer_bottom_caption">
                                            <p>15% Off</p>
                                            <div class="offer_title">Better Offer for You</div>
                                            <span>Save More Thank 15%</span>
                                        </div>
                                        <a href="search-sidebar.html" class="btn offer_box_btn">Explore Now</a>
                                    </div>
                                </div>
                            </div>

                            <!-- Single Item -->
                            <div class="item">
                                <div class="offer_item">
                                    <div class="offer_item_thumb">
                                        <div class="offer-overlay"></div>
                                        <img src="assets/img/offer-5.jpg" alt="">
                                    </div>
                                    <div class="offer_caption">
                                        <div class="offer_bottom_caption">
                                            <p>40% Off</p>
                                            <div class="offer_title">Super Market Deals</div>
                                            <span>40% Off on All Dry Foods</span>
                                        </div>
                                        <a href="search-sidebar.html" class="btn offer_box_btn">Explore Now</a>
                                    </div>
                                </div>
                            </div>

                            <!-- Single Item -->
                            <div class="item">
                                <div class="offer_item">
                                    <div class="offer_item_thumb">
                                        <div class="offer-overlay"></div>
                                        <img src="assets/img/offer-6.jpg" alt="">
                                    </div>
                                    <div class="offer_caption">
                                        <div class="offer_bottom_caption">
                                            <p>15% Off</p>
                                            <div class="offer_title">Better Offer for You</div>
                                            <span>Drinking is Goodness for Health</span>
                                        </div>
                                        <a href="search-sidebar.html" class="btn offer_box_btn">Explore Now</a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="clearfix"></div>
        <!-- ======================== Offer Banner End ==================== -->

        <!-- ======================== Fresh Vegetables & Fruits Start ==================== -->
        <section class="">
            <div class="container">

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="sec-heading-flex pl-2 pr-2">
                            <div class="sec-heading-flex-one">
                                <h2>Added new Products</h2>
                            </div>
                            <div class="sec-heading-flex-last">
                                <a href="search-sidebar.html" class="btn btn-theme">View More<i
                                        class="ti-arrow-right ml-2"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="owl-carousel products-slider owl-theme">

                            <!-- Single Item -->
                            <div class="item">
                                <div class="woo_product_grid">
                                    <span class="woo_pr_tag hot">Hot</span>
                                    <div class="woo_product_thumb">
                                        <img src="assets/img/grocery/1.png" class="img-fluid" alt="" />
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
                                            <h4 class="woo_pro_title"><a href="detail-1.html">Accumsan Tree Fusce</a>
                                            </h4>
                                        </div>
                                        <div class="woo_price">
                                            <h6>$72.47<span class="less_price">$112.10</span></h6>
                                        </div>
                                    </div>
                                    <div class="woo_product_cart hover">
                                        <ul>
                                            <li><a href="javascript:void(0);" data-toggle="modal"
                                                    data-target="#viewproduct-over" class="woo_cart_btn btn_cart"><i
                                                        class="ti-eye"></i></a></li>
                                            <li><a href="add-to-cart.html" class="woo_cart_btn btn_view"><i
                                                        class="ti-shopping-cart"></i></a></li>
                                            <li><a href="wishlist.html" class="woo_cart_btn btn_save"><i
                                                        class="ti-heart"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Single Item -->
                            <div class="item">
                                <div class="woo_product_grid">
                                    <div class="woo_product_thumb">
                                        <img src="assets/img/grocery/2.png" class="img-fluid" alt="" />
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
                                            <h4 class="woo_pro_title"><a href="detail-1.html">Accumsan Tree Fusce</a>
                                            </h4>
                                        </div>
                                        <div class="woo_price">
                                            <h6>$72.47<span class="less_price">$112.10</span></h6>
                                        </div>
                                    </div>
                                    <div class="woo_product_cart hover">
                                        <ul>
                                            <li><a href="javascript:void(0);" data-toggle="modal"
                                                    data-target="#viewproduct-over" class="woo_cart_btn btn_cart"><i
                                                        class="ti-eye"></i></a></li>
                                            <li><a href="add-to-cart.html" class="woo_cart_btn btn_view"><i
                                                        class="ti-shopping-cart"></i></a></li>
                                            <li><a href="wishlist.html" class="woo_cart_btn btn_save"><i
                                                        class="ti-heart"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Single Item -->
                            <div class="item">
                                <div class="woo_product_grid">
                                    <span class="woo_pr_tag new">New</span>
                                    <div class="woo_product_thumb">
                                        <img src="assets/img/grocery/3.png" class="img-fluid" alt="" />
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
                                            <h4 class="woo_pro_title"><a href="detail-1.html">Accumsan Tree Fusce</a>
                                            </h4>
                                        </div>
                                        <div class="woo_price">
                                            <h6>$72.47<span class="less_price">$112.10</span></h6>
                                        </div>
                                    </div>
                                    <div class="woo_product_cart hover">
                                        <ul>
                                            <li><a href="javascript:void(0);" data-toggle="modal"
                                                    data-target="#viewproduct-over" class="woo_cart_btn btn_cart"><i
                                                        class="ti-eye"></i></a></li>
                                            <li><a href="add-to-cart.html" class="woo_cart_btn btn_view"><i
                                                        class="ti-shopping-cart"></i></a></li>
                                            <li><a href="wishlist.html" class="woo_cart_btn btn_save"><i
                                                        class="ti-heart"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Single Item -->
                            <div class="item">
                                <div class="woo_product_grid">
                                    <div class="woo_product_thumb">
                                        <img src="assets/img/grocery/4.png" class="img-fluid" alt="" />
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
                                            <h4 class="woo_pro_title"><a href="detail-1.html">Accumsan Tree Fusce</a>
                                            </h4>
                                        </div>
                                        <div class="woo_price">
                                            <h6>$72.47<span class="less_price">$112.10</span></h6>
                                        </div>
                                    </div>
                                    <div class="woo_product_cart hover">
                                        <ul>
                                            <li><a href="javascript:void(0);" data-toggle="modal"
                                                    data-target="#viewproduct-over" class="woo_cart_btn btn_cart"><i
                                                        class="ti-eye"></i></a></li>
                                            <li><a href="add-to-cart.html" class="woo_cart_btn btn_view"><i
                                                        class="ti-shopping-cart"></i></a></li>
                                            <li><a href="wishlist.html" class="woo_cart_btn btn_save"><i
                                                        class="ti-heart"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Single Item -->
                            <div class="item">
                                <div class="woo_product_grid">
                                    <span class="woo_offer_sell">Save 10% Off</span>
                                    <div class="woo_product_thumb">
                                        <img src="assets/img/grocery/5.png" class="img-fluid" alt="" />
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
                                            <h4 class="woo_pro_title"><a href="detail-1.html">Accumsan Tree Fusce</a>
                                            </h4>
                                        </div>
                                        <div class="woo_price">
                                            <h6>$72.47<span class="less_price">$112.10</span></h6>
                                        </div>
                                    </div>
                                    <div class="woo_product_cart hover">
                                        <ul>
                                            <li><a href="javascript:void(0);" data-toggle="modal"
                                                    data-target="#viewproduct-over" class="woo_cart_btn btn_cart"><i
                                                        class="ti-eye"></i></a></li>
                                            <li><a href="add-to-cart.html" class="woo_cart_btn btn_view"><i
                                                        class="ti-shopping-cart"></i></a></li>
                                            <li><a href="wishlist.html" class="woo_cart_btn btn_save"><i
                                                        class="ti-heart"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Single Item -->
                            <div class="item">
                                <div class="woo_product_grid">
                                    <span class="woo_pr_tag hot">Hot</span>
                                    <div class="woo_product_thumb">
                                        <img src="assets/img/grocery/6.png" class="img-fluid" alt="" />
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
                                            <h4 class="woo_pro_title"><a href="detail-1.html">Accumsan Tree Fusce</a>
                                            </h4>
                                        </div>
                                        <div class="woo_price">
                                            <h6>$72.47<span class="less_price">$112.10</span></h6>
                                        </div>
                                    </div>
                                    <div class="woo_product_cart hover">
                                        <ul>
                                            <li><a href="javascript:void(0);" data-toggle="modal"
                                                    data-target="#viewproduct-over" class="woo_cart_btn btn_cart"><i
                                                        class="ti-eye"></i></a></li>
                                            <li><a href="add-to-cart.html" class="woo_cart_btn btn_view"><i
                                                        class="ti-shopping-cart"></i></a></li>
                                            <li><a href="wishlist.html" class="woo_cart_btn btn_save"><i
                                                        class="ti-heart"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Single Item -->
                            <div class="item">
                                <div class="woo_product_grid">
                                    <div class="woo_product_thumb">
                                        <img src="assets/img/grocery/7.png" class="img-fluid" alt="" />
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
                                            <h4 class="woo_pro_title"><a href="detail-1.html">Accumsan Tree Fusce</a>
                                            </h4>
                                        </div>
                                        <div class="woo_price">
                                            <h6>$72.47<span class="less_price">$112.10</span></h6>
                                        </div>
                                    </div>
                                    <div class="woo_product_cart hover">
                                        <ul>
                                            <li><a href="javascript:void(0);" data-toggle="modal"
                                                    data-target="#viewproduct-over" class="woo_cart_btn btn_cart"><i
                                                        class="ti-eye"></i></a></li>
                                            <li><a href="add-to-cart.html" class="woo_cart_btn btn_view"><i
                                                        class="ti-shopping-cart"></i></a></li>
                                            <li><a href="wishlist.html" class="woo_cart_btn btn_save"><i
                                                        class="ti-heart"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Single Item -->
                            <div class="item">
                                <div class="woo_product_grid">
                                    <span class="woo_pr_tag new">New</span>
                                    <div class="woo_product_thumb">
                                        <img src="assets/img/grocery/8.png" class="img-fluid" alt="" />
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
                                            <h4 class="woo_pro_title"><a href="detail-1.html">Accumsan Tree Fusce</a>
                                            </h4>
                                        </div>
                                        <div class="woo_price">
                                            <h6>$72.47<span class="less_price">$112.10</span></h6>
                                        </div>
                                    </div>
                                    <div class="woo_product_cart hover">
                                        <ul>
                                            <li><a href="javascript:void(0);" data-toggle="modal"
                                                    data-target="#viewproduct-over" class="woo_cart_btn btn_cart"><i
                                                        class="ti-eye"></i></a></li>
                                            <li><a href="add-to-cart.html" class="woo_cart_btn btn_view"><i
                                                        class="ti-shopping-cart"></i></a></li>
                                            <li><a href="wishlist.html" class="woo_cart_btn btn_save"><i
                                                        class="ti-heart"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="clearfix"></div>
        <!-- ======================== Fresh Vegetables & Fruits End ==================== -->

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
                                        <button class="btn search_btn" type="button"><i
                                                class="fas fa-arrow-alt-circle-right"></i></button>
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
        <div class="w3-ch-sideBar w3-bar-block w3-card-2 w3-animate-right" style="display:none;right:0;" id="rightMenu">
            <div class="rightMenu-scroll">
                <h4 class="cart_heading">Your cart</h4>
                <button onclick="closeRightMenu()" class="w3-bar-item w3-button w3-large"><i
                        class="ti-close"></i></button>
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
        <!-- cart -->

        <!-- Product View -->
        <div class="modal fade" id="viewproduct-over" tabindex="-1" role="dialog" aria-labelledby="add-payment"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content" id="view-product">
                    <span class="mod-close" data-dismiss="modal" aria-hidden="true"><i class="ti-close"></i></span>
                    <div class="modal-body">
                        <div class="row align-items-center">

                            <div class="col-lg-6 col-md-12 col-sm-12">
                                <div class="sp-wrap">
                                    <img src="assets/img/detail/detail-6.png" class="img-fluid rounded" alt="">
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-12 col-sm-12">
                                <div class="woo_pr_detail">

                                    <div class="woo_cats_wrps">
                                        <a href="#" class="woo_pr_cats">Casual Shirt</a>
                                        <span class="woo_pr_trending">Trending</span>
                                    </div>
                                    <h2 class="woo_pr_title">Fresh Green Pineapple</h2>

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
                                        <p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit,
                                            sed quia consequuntur magni dolores voluptatem quia voluptas sit aspernatur.
                                        </p>
                                    </div>

                                    <div class="woo_pr_color flex_inline_center mb-3">
                                        <div class="woo_pr_varient">
                                            <h6>Size:</h6>
                                        </div>
                                        <div class="woo_colors_list pl-3">
                                            <div class="custom-varient custom-size">
                                                <input type="radio" class="custom-control-input" name="sizeRadio"
                                                    id="sizeRadioOne" value="5" data-toggle="form-caption"
                                                    data-target="#sizeCaption">
                                                <label class="custom-control-label" for="sizeRadioOne">SM</label>
                                            </div>
                                            <div class="custom-varient custom-size">
                                                <input type="radio" class="custom-control-input" name="sizeRadio"
                                                    id="sizeRadioTwo" value="6" data-toggle="form-caption"
                                                    data-target="#sizeCaption">
                                                <label class="custom-control-label" for="sizeRadioTwo">M</label>
                                            </div>
                                            <div class="custom-varient custom-size">
                                                <input type="radio" class="custom-control-input" name="sizeRadio"
                                                    id="sizeRadioThree" value="6.6" data-toggle="form-caption"
                                                    data-target="#sizeCaption">
                                                <label class="custom-control-label" for="sizeRadioThree">L</label>
                                            </div>
                                            <div class="custom-varient custom-size">
                                                <input type="radio" class="custom-control-input" name="sizeRadio"
                                                    id="sizeRadioFour" value="7" data-toggle="form-caption"
                                                    data-target="#sizeCaption" checked>
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
                                                <input type="radio" class="custom-control-input" name="colorRadio"
                                                    id="red" value="5" data-toggle="form-caption"
                                                    data-target="#colorCaption">
                                                <label class="custom-control-label" for="red">5</label>
                                            </div>
                                            <div class="custom-varient custom-color green">
                                                <input type="radio" class="custom-control-input" name="colorRadio"
                                                    id="green" value="6" data-toggle="form-caption"
                                                    data-target="#colorCaption">
                                                <label class="custom-control-label" for="green">6</label>
                                            </div>
                                            <div class="custom-varient custom-color purple">
                                                <input type="radio" class="custom-control-input" name="colorRadio"
                                                    id="purple" value="6.6" data-toggle="form-caption"
                                                    data-target="#colorCaption" checked>
                                                <label class="custom-control-label" for="purple">6.5</label>
                                            </div>
                                            <div class="custom-varient custom-color yellow">
                                                <input type="radio" class="custom-control-input" name="colorRadio"
                                                    id="yellow" value="7" data-toggle="form-caption"
                                                    data-target="#colorCaption">
                                                <label class="custom-control-label" for="yellow">7</label>
                                            </div>
                                            <div class="custom-varient custom-color blue">
                                                <input type="radio" class="custom-control-input" name="colorRadio"
                                                    id="blue" value="6" data-toggle="form-caption"
                                                    data-target="#colorCaption">
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
                                            <button type="submit" class="btn btn-block btn-dark mb-2">Add to Cart <i
                                                    class="ti-shopping-cart-full ml-2"></i></button>
                                        </div>
                                        <div class="col-12 col-lg-auto">
                                            <button class="btn btn-gray btn-block mb-2" data-toggle="button">Wishlist <i
                                                    class="ti-heart ml-2"></i></button>
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
    <!-- ============================================================== -->
    <!-- This page plugins -->
    <!-- ============================================================== -->

    <script>
    function openRightMenu() {
        document.getElementById("rightMenu").style.display = "block";
    }

    function closeRightMenu() {
        document.getElementById("rightMenu").style.display = "none";
    }
    </script>

</body>

</html>