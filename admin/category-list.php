<?php
// Include database connection
include('dbconnection.php');

// Initialize search variable
$search = '';
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
    $query = "SELECT * FROM categories WHERE main_category LIKE '%$search%' OR subcategory LIKE '%$search%' ORDER BY id DESC";
} else {
    $query = "SELECT * FROM categories ORDER BY id DESC";
}

$result = mysqli_query($conn, $query);

// Pagination variables
$entries_per_page = isset($_GET['entries']) ? (int)$_GET['entries'] : 10;
$total_entries = mysqli_num_rows($result);
$total_pages = ceil($total_entries / $entries_per_page);
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$current_page = max(1, min($current_page, $total_pages));
$offset = ($current_page - 1) * $entries_per_page;

// Modify query to include pagination
$query .= " LIMIT $offset, $entries_per_page";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">

<head>
    <!-- Basic Page Needs -->
    <meta charset="utf-8">
    <!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->
    <title>Remos eCommerce Admin Dashboard HTML Template</title>

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
<style>
 .table-title1
  {
    background-color: rgb(237, 241, 245);
    padding: 10px;
    gap:200px;
 
 }
 .wg-table.table-all-category .product-item > .flex > div:first-child {
    width: 260px;
    flex-shrink: 0;
}
.wg-table.table-all-category .product-item > .flex > div {
    width: 40%;
}
.wg-table.table-all-category > * {
    min-width: 850px;
}
</style>
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
                                    <h3>All category</h3>
                                    <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                                        <li>
                                            <a href="index-2.html">
                                                <div class="text-tiny">Dashboard</div>
                                            </a>
                                        </li>
                                        <li>
                                            <i class="icon-chevron-right"></i>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <div class="text-tiny">Category</div>
                                            </a>
                                        </li>
                                        <li>
                                            <i class="icon-chevron-right"></i>
                                        </li>
                                        <li>
                                            <div class="text-tiny">All category</div>
                                        </li>
                                    </ul>
                                </div>
                                <!-- all-category -->
                                <div class="wg-box">
                                    <div class="flex items-center justify-between gap10 flex-wrap">
                                        <div class="wg-filter flex-grow">
                                            <div class="show">
                                                <div class="text-tiny">Showing</div>
                                                <div class="select">
                                                    <select class="" onchange="window.location.href='?entries='+this.value+'&search=<?php echo $search; ?>'">
                                                        <option value="10" <?php echo $entries_per_page == 10 ? 'selected' : ''; ?>>10</option>
                                                        <option value="20" <?php echo $entries_per_page == 20 ? 'selected' : ''; ?>>20</option>
                                                        <option value="30" <?php echo $entries_per_page == 30 ? 'selected' : ''; ?>>30</option>
                                                    </select>
                                                </div>
                                                <div class="text-tiny">entries</div>
                                            </div>
                                            <form class="form-search" method="GET" action="">
                                                <fieldset class="name">
                                                    <input type="text" placeholder="Search here..." class="" name="search" value="<?php echo htmlspecialchars($search); ?>" tabindex="2" aria-required="true">
                                                </fieldset>
                                                <div class="button-submit">
                                                    <button class="" type="submit"><i class="icon-search"></i></button>
                                                </div>
                                            </form>
                                        </div>
                                        <a class="tf-button style-1 w208" href="new-category.php"><i class="icon-plus"></i>Add new</a>
                                    </div>
                                    <div class="wg-table table-all-category">
                                        <ul class="table-title1 flex gap mb-14">
                                            <li>
                                                <div class="body-title">Sr No.</div>
                                            </li>
                                            <li>
                                                <div class="body-title">Main Category</div>
                                            </li>
                                            <li>
                                                <div class="body-title">Subcategory</div>
                                            </li>
                                            <li>
                                                <div class="body-title">Action</div>
                                            </li>
                                        </ul>
                                        <ul class="flex flex-column">
                                            <?php
                                            $sr_no = $offset + 1;
                                            while ($row = mysqli_fetch_assoc($result)) { ?>
                                                <li class="product-item gap14">
                                                    <div class="flex items-center flex-grow">
                                                        <div class="sr-number">
                                                            <span class="body-title-2"><?php echo $sr_no++; ?></span>
                                                        </div>
                                                        <div class="name">
                                                            <a href="#" class="body-title-2"><?php echo htmlspecialchars($row['main_category']); ?></a>
                                                        </div>
                                                        <div class="name">
                                                            <a href="#" class="body-title-2"><?php echo htmlspecialchars($row['subcategory']); ?></a>
                                                        </div>
                                                        <div class="list-icon-function">
                                                            <div class="item edit"><a href="edit-category.php?id=<?php echo $row['id']; ?>"><i class="icon-edit-3"></i></a></div>
                                                            <div class="item trash"><a href="delete-category.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?');"><i class="icon-trash-2"></i></a></div>
                                                        </div>
                                                    </div>
                                                </li>
                                            <?php } ?>
                                            <?php if (mysqli_num_rows($result) == 0): ?>
                                                <li class="product-item gap14">
                                                    <div class="flex items-center justify-center gap20 flex-grow">
                                                        <div class="name">
                                                            <span class="body-title-2">No categories found</span>
                                                        </div>
                                                    </div>
                                                </li>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                    <div class="divider"></div>
                                    <div class="flex items-center justify-between flex-wrap gap10">
                                        <div class="text-tiny">Showing <?php echo min($entries_per_page, $total_entries); ?> of <?php echo $total_entries; ?> entries</div>
                                        <ul class="wg-pagination">
                                            <li>
                                                <a href="?page=<?php echo max(1, $current_page - 1); ?>&entries=<?php echo $entries_per_page; ?>&search=<?php echo $search; ?>"><i class="icon-chevron-left"></i></a>
                                            </li>
                                            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                                <li <?php echo $i == $current_page ? 'class="active"' : ''; ?>>
                                                    <a href="?page=<?php echo $i; ?>&entries=<?php echo $entries_per_page; ?>&search=<?php echo $search; ?>"><?php echo $i; ?></a>
                                                </li>
                                            <?php endfor; ?>
                                            <li>
                                                <a href="?page=<?php echo min($total_pages, $current_page + 1); ?>&entries=<?php echo $entries_per_page; ?>&search=<?php echo $search; ?>"><i class="icon-chevron-right"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- /all-category -->
                            </div>
                            <!-- /main-content-wrap -->
                        </div>

                        <!-- /main-content-wrap -->
                        <!-- bottom-page -->
                        <div class="bottom-page">
                            <div class="body-text">Copyright © 2025 Iskcon Ravet. Design</div>
                           
                            <div class="body-text">by <a href="https://designzfactory.in/">designzfactory</a> All rights reserved.</div>
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

</body>

</html>