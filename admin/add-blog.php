<?php
include 'dbconnection.php';

// Set up alert messages
$successMessage = '';
$errorMessage = '';

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate inputs
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $excerpt = trim($_POST['excerpt']);
    $author = trim($_POST['author']);
    $status = $_POST['status'] ?? 'published';
    
    // Basic validation
    $errors = [];
    if (empty($title)) {
        $errors[] = 'Title is required';
    }
    if (empty($content)) {
        $errors[] = 'Content is required';
    }
    
    // If no errors, proceed with saving
    if (empty($errors)) {
        try {
            // Only use mysqli, remove PDO code
            if ($conn instanceof mysqli) {
                // For mysqli, start transaction
                $conn->autocommit(FALSE);
                
                // Insert blog post
                $stmt = $conn->prepare("
                    INSERT INTO blogs (title, content, excerpt, author, status) 
                    VALUES (?, ?, ?, ?, ?)
                ");
                
                $stmt->bind_param("sssss", $title, $content, $excerpt, $author, $status);
                $stmt->execute();
                
                $blog_id = $conn->insert_id;
                
                // Process and upload images
                $uploadDirectory = 'uploads/blog/';
                
                // Create directory if it doesn't exist
                if (!file_exists($uploadDirectory)) {
                    mkdir($uploadDirectory, 0777, true);
                }
                
                // Handle multiple image uploads
                if (!empty($_FILES['images']['name'][0])) {
                    $featured_image_index = $_POST['featured_image'] ?? 0;
                    
                    $totalFiles = count($_FILES['images']['name']);
                    
                    for ($i = 0; $i < $totalFiles; $i++) {
                        // Check if the current file was properly uploaded
                        if ($_FILES['images']['error'][$i] === UPLOAD_ERR_OK) {
                            $tempFile = $_FILES['images']['tmp_name'][$i];
                            $fileName = time() . '_' . $_FILES['images']['name'][$i];
                            $targetFile = $uploadDirectory . $fileName;
                            
                            // Move uploaded file
                            if (move_uploaded_file($tempFile, $targetFile)) {
                                // Set is_featured based on selected featured image
                                $is_featured = ($i == $featured_image_index) ? 1 : 0;
                                
                                // Insert image info into database
                                $imgStmt = $conn->prepare("
                                    INSERT INTO blog_images (blog_id, image_path, is_featured)
                                    VALUES (?, ?, ?)
                                ");
                                
                                $imgStmt->bind_param("isi", $blog_id, $targetFile, $is_featured);
                                $imgStmt->execute();
                                $imgStmt->close();
                            } else {
                                $errors[] = "Failed to upload image " . ($i + 1);
                            }
                        } else {
                            $errors[] = "Error with image " . ($i + 1) . ": " . $_FILES['images']['error'][$i];
                        }
                    }
                }
                
                // Commit transaction
                if (empty($errors)) {
                    $conn->commit();
                    // Set success message
                    $successMessage = "Blog created successfully!";
                    // Redirect with alert
                    echo "<script>
                            alert('$successMessage');
                            window.location.href = 'blog.php'; 
                          </script>";
                    exit(); // Exit after redirect
                } else {
                    $conn->rollback();
                    $errorMessage = "Failed to create blog due to image upload errors.";
                }
                
                $stmt->close();
            } else {
                throw new Exception("Unsupported database connection type. Please use MySQLi.");
            }
            
        } catch (Exception $e) {
            // Rollback transaction on error
            if ($conn instanceof mysqli) {
                $conn->rollback();
            }
            $errorMessage = "Database error: " . $e->getMessage();
        }
    } else {
        $errorMessage = "Please fix the form errors before submitting.";
    }
}
?>


<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
    <!-- Basic Page Needs -->
    <meta charset="utf-8">
    <title>Add New Blog - Remos Admin</title>

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
    
    <!-- Rich Text Editor -->
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '#content',
            height: 400,
            plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
            toolbar_mode: 'floating',
        });
    </script>
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
                                    <h3>Add New Blog Post</h3>
                                    <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                                        <li>
                                            <a href="index.php"><div class="text-tiny">Dashboard</div></a>
                                        </li>
                                        <li>
                                            <i class="icon-chevron-right"></i>
                                        </li>
                                        <li>
                                            <a href="blog.php"><div class="text-tiny">Blog Management</div></a>
                                        </li>
                                        <li>
                                            <i class="icon-chevron-right"></i>
                                        </li>
                                        <li>
                                            <div class="text-tiny">Add New Blog</div>
                                        </li>
                                    </ul>
                                </div>
                                
                                <!-- Alert messages -->
                                <?php if (!empty($successMessage)): ?>
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>Success!</strong> <?php echo $successMessage; ?>
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
                                
                                <?php if (!empty($errors)): ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Error!</strong>
                                    <ul>
                                        <?php foreach ($errors as $error): ?>
                                        <li><?php echo $error; ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <?php endif; ?>
                                
                                <!-- add-blog-form -->
                                <div class="wg-box">
                                    <form class="form-new-product form-style-1" method="POST" enctype="multipart/form-data">
                                        <fieldset class="name">
                                            <div class="body-title">Blog Title *</div>
                                            <input class="flex-grow" type="text" placeholder="Enter blog title" name="title" value="<?php echo isset($title) ? htmlspecialchars($title) : ''; ?>" required>
                                        </fieldset>
                                        
                                        <fieldset class="name">
                                            <div class="body-title">Author</div>
                                            <input class="flex-grow" type="text" placeholder="Enter author name" name="author" value="<?php echo isset($author) ? htmlspecialchars($author) : ''; ?>">
                                        </fieldset>
                                        
                                        <fieldset class="name">
                                            <div class="body-title">Status</div>
                                            <select name="status" class="flex-grow">
                                                <option value="published" <?php echo (isset($status) && $status === 'published') ? 'selected' : ''; ?>>Published</option>
                                                <option value="draft" <?php echo (isset($status) && $status === 'draft') ? 'selected' : ''; ?>>Draft</option>
                                            </select>
                                        </fieldset>
                                        
                                        <fieldset class="name">
                                            <div class="body-title">Description</div>
                                            <textarea class="flex-grow" name="excerpt" placeholder="Enter short description" rows="3"><?php echo isset($excerpt) ? htmlspecialchars($excerpt) : ''; ?></textarea>
                                        </fieldset>
                                        
                                        <fieldset class="name">
                                            <div class="body-title">Content *</div>
                                            <textarea  class="flex-grow" name="content"><?php echo isset($content) ? htmlspecialchars($content) : ''; ?></textarea>
                                        </fieldset>
                                        
                                        <fieldset class="name">
                                            <div class="body-title">Images</div>
                                            <div class="image-upload-container">
                                                <div class="upload-btn-wrapper">
                                                    <button class="btn">Choose Images</button>
                                                    <input type="file" name="images[]" id="image-upload" multiple accept="image/*">
                                                </div>
                                                <div class="image-preview-container" id="image-preview-container"></div>
                                            </div>
                                            <div class="featured-image-selection" id="featured-image-selection" style="margin-top: 10px; display: none;">
                                                <div class="body-title">Select Featured Image:</div>
                                                <select name="featured_image" id="featured-image-select">
                                                    <!-- Options will be added dynamically via JavaScript -->
                                                </select>
                                            </div>
                                        </fieldset>
                                        
                                        <div class="bot">
                                            <div></div>
                                            <div class="button-group">
                                                <a href="blog.php" class="tf-button btn-secondary w208">Cancel</a>
                                                <button class="tf-button w208" type="submit">Save Blog</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- /add-blog-form -->
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
    <script src="js/main.js"></script>
    
    <style>
        .image-upload-container {
            margin-top: 10px;
        }
        .upload-btn-wrapper {
            position: relative;
            overflow: hidden;
            display: inline-block;
        }
        .btn {
            border: 2px solid gray;
            color: gray;
            background-color: white;
            padding: 8px 20px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
        }
        .upload-btn-wrapper input[type=file] {
            font-size: 100px;
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
        }
        .image-preview-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 15px;
        }
        .image-preview {
            width: 150px;
            height: 150px;
            border: 1px solid #ddd;
            border-radius: 4px;
            overflow: hidden;
            position: relative;
        }
        .image-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .delete-image {
            position: absolute;
            top: 5px;
            right: 5px;
            background: rgba(255, 0, 0, 0.7);
            color: white;
            border: none;
            border-radius: 50%;
            width: 25px;
            height: 25px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .featured-badge {
            position: absolute;
            top: 5px;
            left: 5px;
            background: rgba(0, 128, 0, 0.7);
            color: white;
            padding: 2px 5px;
            border-radius: 3px;
            font-size: 12px;
        }
        .button-group {
            display: flex;
            gap: 10px;
        }
        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }
        .alert {
            margin-bottom: 20px;
        }
    </style>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Image preview functionality
            const imageUpload = document.getElementById('image-upload');
            const previewContainer = document.getElementById('image-preview-container');
            const featuredImageSelection = document.getElementById('featured-image-selection');
            const featuredImageSelect = document.getElementById('featured-image-select');
            let imageFiles = [];
            
            imageUpload.addEventListener('change', function(e) {
                // Clear preview if needed
                if (imageFiles.length === 0) {
                    previewContainer.innerHTML = '';
                }
                
                // Add new files to array
                Array.from(e.target.files).forEach(file => {
                    imageFiles.push(file);
                });
                
                // Update preview
                updateImagePreviews();
            });
            
            function updateImagePreviews() {
                previewContainer.innerHTML = '';
                featuredImageSelect.innerHTML = '';
                
                if (imageFiles.length > 0) {
                    featuredImageSelection.style.display = 'block';
                    
                    imageFiles.forEach((file, index) => {
                        const reader = new FileReader();
                        
                        reader.onload = function(e) {
                            // Create preview element
                            const preview = document.createElement('div');
                            preview.className = 'image-preview';
                            preview.innerHTML = `
                                <img src="${e.target.result}" alt="Preview">
                                <button type="button" class="delete-image" data-index="${index}">×</button>
                            `;
                            previewContainer.appendChild(preview);
                            
                            // Add option to featured image select
                            const option = document.createElement('option');
                            option.value = index;
                            option.textContent = `Image ${index + 1}`;
                            featuredImageSelect.appendChild(option);
                            
                            // Add click handler for delete button
                            preview.querySelector('.delete-image').addEventListener('click', function() {
                                const index = parseInt(this.getAttribute('data-index'));
                                imageFiles.splice(index, 1);
                                updateImagePreviews();
                            });
                        };
                        
                        reader.readAsDataURL(file);
                    });
                } else {
                    featuredImageSelection.style.display = 'none';
                }
            }
            
            // Auto-hide alerts after 5 seconds
            setTimeout(function() {
                let alerts = document.querySelectorAll('.alert');
                alerts.forEach(function(alert) {
                    $(alert).alert('close');
                });
            }, 5000);
        });
    </script>
</body>
</html>