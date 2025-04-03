<?php
include 'dbconnection.php';

// Initialize variables
$search = '';
$limit = isset($_GET['show']) ? (int)$_GET['show'] : 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Handle search
if (isset($_GET['search'])) {
    $search = trim($_GET['search']);
}

// Prepare query for blogs
$query = "SELECT b.*, (SELECT image_path FROM blog_images WHERE blog_id = b.id AND is_featured = 1 LIMIT 1) AS featured_image 
          FROM blogs b WHERE 1=1";

// Add search condition if search is provided
if (!empty($search)) {
    $search = "%$search%";
    $query .= " AND (b.title LIKE ? OR b.content LIKE ? OR b.author LIKE ?)";
}

// Add pagination
$query .= " ORDER BY b.created_at DESC LIMIT ? OFFSET ?";

// Count total records (for pagination)
$countQuery = "SELECT COUNT(*) as total FROM blogs WHERE 1=1";
if (!empty($search)) {
    $countQuery .= " AND (title LIKE ? OR content LIKE ? OR author LIKE ?)";
}

// Prepare and execute count query
$countStmt = $conn->prepare($countQuery);
if (!empty($search)) {
    $countStmt->bind_param("sss", $search, $search, $search);
}
$countStmt->execute();
$totalResult = $countStmt->get_result();
$totalRow = $totalResult->fetch_assoc();
$totalRecords = $totalRow['total'];
$totalPages = ceil($totalRecords / $limit);

// Prepare and execute main query
$stmt = $conn->prepare($query);
if (!empty($search)) {
    $stmt->bind_param("sssii", $search, $search, $search, $limit, $offset);
} else {
    $stmt->bind_param("ii", $limit, $offset);
}
$stmt->execute();
$result = $stmt->get_result();

// Handle blog deletion if requested
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $blog_id = (int)$_GET['delete'];
    
    // Start transaction
    $conn->begin_transaction();
    
    try {
        // Delete associated images from file system
        $imgQuery = "SELECT image_path FROM blog_images WHERE blog_id = ?";
        $imgStmt = $conn->prepare($imgQuery);
        $imgStmt->bind_param("i", $blog_id);
        $imgStmt->execute();
        $imgResult = $imgStmt->get_result();
        
        while ($img = $imgResult->fetch_assoc()) {
            if (file_exists($img['image_path'])) {
                unlink($img['image_path']);
            }
        }
        
        // Delete images from database
        $delImgStmt = $conn->prepare("DELETE FROM blog_images WHERE blog_id = ?");
        $delImgStmt->bind_param("i", $blog_id);
        $delImgStmt->execute();
        
        // Delete blog post
        $delBlogStmt = $conn->prepare("DELETE FROM blogs WHERE id = ?");
        $delBlogStmt->bind_param("i", $blog_id);
        $delBlogStmt->execute();
        
        // Commit transaction
        $conn->commit();
        
        // Redirect to prevent refresh issues
        header("Location: blog.php?deleted=success");
        exit();
    } catch (Exception $e) {
        // Rollback on error
        $conn->rollback();
        $errorMessage = "Failed to delete blog: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">

<head>
    <!-- Basic Page Needs -->
    <meta charset="utf-8">
    <!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->
    <title>Blog Management - Remos Admin</title>

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
                                    <h3>Blog Management</h3>
                                    <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                                        <li>
                                            <a href="index.php">
                                                <div class="text-tiny">Dashboard</div>
                                            </a>
                                        </li>
                                        <li>
                                            <i class="icon-chevron-right"></i>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <div class="text-tiny">Blog Management</div>
                                            </a>
                                        </li>
                                        <li>
                                            <i class="icon-chevron-right"></i>
                                        </li>
                                        <li>
                                            <div class="text-tiny">All Blogs</div>
                                        </li>
                                    </ul>
                                </div>

                                <?php if (isset($_GET['deleted']) && $_GET['deleted'] == 'success'): ?>
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>Success!</strong> Blog post has been deleted successfully.
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <?php endif; ?>

                                <?php if (!empty($errorMessage)): ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Error!</strong> <?php echo $errorMessage; ?>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <?php endif; ?>

                                <!-- all-blogs -->
                                <div class="wg-box">
                                    <div class="flex items-center justify-between gap10 flex-wrap">
                                        <div class="wg-filter flex-grow">
                                            <div class="show">
                                                <div class="text-tiny">Showing</div>
                                                <div class="select">
                                                    <select class=""
                                                        onchange="window.location.href='blog.php?show='+this.value+'&search=<?php echo urlencode($search); ?>'">
                                                        <option value="10"
                                                            <?php echo $limit == 10 ? 'selected' : ''; ?>>10</option>
                                                        <option value="20"
                                                            <?php echo $limit == 20 ? 'selected' : ''; ?>>20</option>
                                                        <option value="30"
                                                            <?php echo $limit == 30 ? 'selected' : ''; ?>>30</option>
                                                    </select>
                                                </div>
                                                <div class="text-tiny">entries</div>
                                            </div>
                                            <form class="form-search" method="GET" action="blog.php">
                                                <fieldset class="name">
                                                    <input type="text" placeholder="Search here..." name="search"
                                                        value="<?php echo htmlspecialchars($search); ?>">
                                                </fieldset>
                                                <div class="button-submit">
                                                    <button class="" type="submit"><i class="icon-search"></i></button>
                                                </div>
                                            </form>
                                        </div>
                                        <a class="tf-button style-1 w208" href="add-blog.php"><i
                                                class="icon-plus"></i>Add new</a>
                                    </div>
                                    <div class="wg-table table-all-blogs">
                                        <ul class="table-title flex gap20 mb-14">
                                            <li>
                                                <div class="body-title">Image</div>
                                            </li>
                                            <li>
                                                <div class="body-title">Title</div>
                                            </li>
                                            <li>
                                                <div class="body-title">Author</div>
                                            </li>
                                            <li>
                                                <div class="body-title">Status</div>
                                            </li>
                                            <li>
                                                <div class="body-title">Date</div>
                                            </li>
                                            <li>
                                                <div class="body-title">Action</div>
                                            </li>
                                        </ul>
                                        <ul class="flex flex-column">
                                            <?php if ($result->num_rows > 0): ?>
                                            <?php while ($blog = $result->fetch_assoc()): ?>
                                            <li class="blog-item flex items-center justify-between gap20">
                                                <div class="image">
                                                    <?php if (!empty($blog['featured_image'])): ?>
                                                    <img src="<?php echo htmlspecialchars($blog['featured_image']); ?>"
                                                        alt="<?php echo htmlspecialchars($blog['title']); ?>"
                                                        style="width: 60px; height: 60px; object-fit: cover;">
                                                    <?php else: ?>
                                                    <img src="images/no-image.png" alt="No Image"
                                                        style="width: 60px; height: 60px; object-fit: cover;">
                                                    <?php endif; ?>
                                                </div>
                                                <div class="name">
                                                    <div class="body-title-2">
                                                        <?php echo htmlspecialchars($blog['title']); ?></div>
                                                </div>
                                                <div class="body-text"><?php echo htmlspecialchars($blog['author']); ?>
                                                </div>
                                                <div class="status">
                                                    <span
                                                        class="btn-status <?php echo $blog['status'] == 'published' ? 'active' : 'draft'; ?>">
                                                        <?php echo ucfirst($blog['status']); ?>
                                                    </span>
                                                </div>
                                                <div class="body-text">
                                                    <?php echo date('M d, Y', strtotime($blog['created_at'] ?? 'now')); ?>
                                                </div>
                                                <div class="list-icon-function">
                                                    <a href="view-blog.php?id=<?php echo $blog['id']; ?>"
                                                        class="item eye">
                                                        <i class="icon-eye"></i>
                                                    </a>
                                                    <a href="edit-blog.php?id=<?php echo $blog['id']; ?>"
                                                        class="item edit">
                                                        <i class="icon-edit-3"></i>
                                                    </a>
                                                    <a href="javascript:void(0);"
                                                        onclick="confirmDelete(<?= $blog['id']; ?>)" class="item trash">
                                                        <i class="icon-trash-2"></i>
                                                    </a>

                                                    <script>
                                                    function confirmDelete(id) {
                                                        if (confirm(
                                                                "Are you sure you want to delete this blog? This action cannot be undone."
                                                            )) {
                                                            window.location.href = "delete-blog.php?id=" + id;
                                                        }
                                                    }
                                                    </script>

                                                </div>
                                            </li>
                                            <?php endwhile; ?>
                                            <?php else: ?>
                                            <li class="blog-item flex items-center justify-center">
                                                <div class="body-text">No blogs found</div>
                                            </li>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                    <div class="divider"></div>
                                    <div class="flex items-center justify-between flex-wrap gap10">
                                        <div class="text-tiny">Showing <?php echo min($totalRecords, $limit); ?> of
                                            <?php echo $totalRecords; ?> entries</div>
                                        <ul class="wg-pagination">
                                            <li <?php if ($page <= 1) echo 'class="disabled"'; ?>>
                                                <a
                                                    href="<?php echo $page > 1 ? "blog.php?page=".($page-1)."&show=$limit&search=".urlencode($search) : "#"; ?>">
                                                    <i class="icon-chevron-left"></i>
                                                </a>
                                            </li>
                                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                            <li <?php if ($i == $page) echo 'class="active"'; ?>>
                                                <a
                                                    href="blog.php?page=<?php echo $i; ?>&show=<?php echo $limit; ?>&search=<?php echo urlencode($search); ?>">
                                                    <?php echo $i; ?>
                                                </a>
                                            </li>
                                            <?php endfor; ?>
                                            <li <?php if ($page >= $totalPages) echo 'class="disabled"'; ?>>
                                                <a
                                                    href="<?php echo $page < $totalPages ? "blog.php?page=".($page+1)."&show=$limit&search=".urlencode($search) : "#"; ?>">
                                                    <i class="icon-chevron-right"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- /all-blogs -->
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

    <style>
    .image img {
        border-radius: 5px;
    }

    .btn-status {
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
    }

    .btn-status.active {
        background-color: #25c19c;
        color: white;
    }

    .btn-status.draft {
        background-color: #ffba53;
        color: white;
    }

    .disabled {
        pointer-events: none;
        opacity: 0.6;
    }

    .alert {
        margin-bottom: 20px;
    }
    </style>

    <script>
    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        let alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            $(alert).alert('close');
        });
    }, 5000);
    </script>
</body>

</html>