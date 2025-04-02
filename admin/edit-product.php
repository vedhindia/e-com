<?php
// Include database connection
include('dbconnection.php');

// Get product ID from URL parameter
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if (!$product_id) {
    // Redirect if no product ID is provided
    echo "<script>
            alert('No product selected for editing');
            window.location.href = 'product-list.php';
          </script>";
    exit();
}

// Fetch main categories
$query = "SELECT DISTINCT main_category FROM categories ORDER BY main_category";
$main_categories = mysqli_query($conn, $query);

// Fetch product data
$product_query = "SELECT * FROM products WHERE id = $product_id";
$product_result = mysqli_query($conn, $product_query);

if (mysqli_num_rows($product_result) == 0) {
    // Redirect if product not found
    echo "<script>
            alert('Product not found');
            window.location.href = 'product-list.php';
          </script>";
    exit();
}

$product = mysqli_fetch_assoc($product_result);

// Fetch product units if any
$units_query = "SELECT * FROM product_units WHERE product_id = $product_id";
$units_result = mysqli_query($conn, $units_query);
$has_units = mysqli_num_rows($units_result) > 0;

// Fetch product price if no units
$price_query = "SELECT price FROM product_prices WHERE product_id = $product_id";
$price_result = mysqli_query($conn, $price_query);
$price_data = mysqli_fetch_assoc($price_result);
$single_price = $price_data ? $price_data['price'] : '';

// Fetch product images
$images_query = "SELECT * FROM product_images WHERE product_id = $product_id";
$images_result = mysqli_query($conn, $images_query);

// Process form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Product details
    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $main_category = mysqli_real_escape_string($conn, $_POST['main_category']);
    $subcategory = mysqli_real_escape_string($conn, $_POST['subcategory']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $availability = mysqli_real_escape_string($conn, $_POST['availability']);
    $weight = mysqli_real_escape_string($conn, $_POST['weight']);
    $dimensions = mysqli_real_escape_string($conn, $_POST['dimensions']);
    $country_origin = mysqli_real_escape_string($conn, $_POST['country_origin']);
    $source_type = mysqli_real_escape_string($conn, $_POST['source_type']);
    $container_type = mysqli_real_escape_string($conn, $_POST['container_type']);
    
    // Unit and price handling
    $has_multiple_units = isset($_POST['has_multiple_units']) ? 1 : 0;
    
    // Update product
    $update_query = "UPDATE products SET 
                    product_name = '$product_name', 
                    main_category = '$main_category', 
                    subcategory = '$subcategory', 
                    description = '$description', 
                    availability = '$availability', 
                    weight = '$weight', 
                    dimensions = '$dimensions', 
                    country_origin = '$country_origin', 
                    source_type = '$source_type', 
                    container_type = '$container_type', 
                    has_multiple_units = '$has_multiple_units'
                    WHERE id = $product_id";
    
    if (mysqli_query($conn, $update_query)) {
        // Handle product units and prices
        if ($has_multiple_units) {
            // Delete existing units
            mysqli_query($conn, "DELETE FROM product_units WHERE product_id = $product_id");
            
            // Add new units
            foreach ($_POST['unit'] as $key => $unit_value) {
                if(empty($unit_value)) continue; // Skip empty entries
                
                $unit = mysqli_real_escape_string($conn, $unit_value);
                $unit_type = mysqli_real_escape_string($conn, $_POST['unit_type'][$key]);
                $price = mysqli_real_escape_string($conn, $_POST['price'][$key]);
                
                $unit_query = "INSERT INTO product_units (product_id, unit_value, unit_type, price) 
                              VALUES ('$product_id', '$unit', '$unit_type', '$price')";
                mysqli_query($conn, $unit_query);
            }
            
            // Delete any single price
            mysqli_query($conn, "DELETE FROM product_prices WHERE product_id = $product_id");
        } else {
            // Delete existing units
            mysqli_query($conn, "DELETE FROM product_units WHERE product_id = $product_id");
            
            // Update or insert single price
            $price = mysqli_real_escape_string($conn, $_POST['single_price']);
            
            // Check if price record exists
            $price_check = mysqli_query($conn, "SELECT id FROM product_prices WHERE product_id = $product_id");
            
            if (mysqli_num_rows($price_check) > 0) {
                mysqli_query($conn, "UPDATE product_prices SET price = '$price' WHERE product_id = $product_id");
            } else {
                mysqli_query($conn, "INSERT INTO product_prices (product_id, price) VALUES ('$product_id', '$price')");
            }
        }
        
        // Handle product images
        // Check if new images were uploaded or if delete_images flag was set
        if ((isset($_FILES['product_images']) && !empty($_FILES['product_images']['name'][0])) || 
            (isset($_POST['delete_images']) && $_POST['delete_images'] == '1')) {
            
            // First, get the current images for potential deletion
            $current_images_query = "SELECT id, image_path FROM product_images WHERE product_id = $product_id";
            $current_images_result = mysqli_query($conn, $current_images_query);
            $current_images = [];
            
            while($img = mysqli_fetch_assoc($current_images_result)) {
                $current_images[] = $img;
            }
            
            // Delete all existing images from database and file system
            foreach($current_images as $img) {
                // Remove the file if it exists
                if(file_exists($img['image_path'])) {
                    unlink($img['image_path']);
                }
            }
            
            // Delete all image records from database
            mysqli_query($conn, "DELETE FROM product_images WHERE product_id = $product_id");
            
            // Now upload and save new images
            if (isset($_FILES['product_images']) && !empty($_FILES['product_images']['name'][0])) {
                $file_count = count($_FILES['product_images']['name']);
                
                for ($i = 0; $i < $file_count; $i++) {
                    // Check if file was uploaded
                    if ($_FILES['product_images']['error'][$i] == 0) {
                        $filename = $_FILES['product_images']['name'][$i];
                        $tmp_name = $_FILES['product_images']['tmp_name'][$i];
                        
                        // Generate unique filename
                        $new_filename = time() . '_' . $i . '_' . $filename;
                        $upload_dir = 'uploads/products/';
                        
                        // Create directory if not exists
                        if (!file_exists($upload_dir)) {
                            mkdir($upload_dir, 0777, true);
                        }
                        
                        // Move uploaded file
                        if (move_uploaded_file($tmp_name, $upload_dir . $new_filename)) {
                            $image_path = $upload_dir . $new_filename;
                            $image_query = "INSERT INTO product_images (product_id, image_path) VALUES ('$product_id', '$image_path')";
                            mysqli_query($conn, $image_query);
                        }
                    }
                }
            }
        }
        
        // JavaScript alert and redirect
        echo "<script>
                alert('Product updated successfully!');
                window.location.href = 'product-list.php';
              </script>";
        exit();
    } else {
        echo "<script>
                alert('Error updating product: " . mysqli_error($conn) . "');
              </script>";
    }
}

// Fetch subcategories for the selected main category
$subcategory_query = "SELECT DISTINCT subcategory FROM categories WHERE main_category = '" . $product['main_category'] . "' ORDER BY subcategory";
$subcategories = mysqli_query($conn, $subcategory_query);
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
                                    <h3>Edit Product</h3>
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
                                                <div class="text-tiny">Ecommerce</div>
                                            </a>
                                        </li>
                                        <li>
                                            <i class="icon-chevron-right"></i>
                                        </li>
                                        <li>
                                            <div class="text-tiny">Edit product</div>
                                        </li>
                                    </ul>
                                </div>

                                <!-- form-edit-product -->
                                <form class="tf-section-2 form-add-product" method="POST" action=""
                                    enctype="multipart/form-data">
                                    <div class="wg-box">
                                        <?php if(isset($success)): ?>
                                        <div class="alert alert-success"><?php echo $success; ?></div>
                                        <?php endif; ?>

                                        <?php if(isset($error)): ?>
                                        <div class="alert alert-danger"><?php echo $error; ?></div>
                                        <?php endif; ?>

                                        <fieldset class="name">
                                            <div class="body-title mb-10">Product name <span class="tf-color-1">*</span>
                                            </div>
                                            <input class="mb-10" type="text" placeholder="Enter product name"
                                                name="product_name" tabindex="0" required
                                                value="<?php echo htmlspecialchars($product['product_name']); ?>">
                                            <div class="text-tiny">Do not exceed 20 characters when entering the product
                                                name.</div>
                                        </fieldset>

                                        <div class="gap22 cols">
                                            <fieldset class="category">
                                                <div class="body-title mb-10">Main Category <span
                                                        class="tf-color-1">*</span></div>
                                                <div class="select">
                                                    <select class="main-category-select" name="main_category" required>
                                                        <option value="">Choose main category</option>
                                                        <?php 
                        mysqli_data_seek($main_categories, 0);
                        while($row = mysqli_fetch_assoc($main_categories)): 
                            $selected = ($row['main_category'] == $product['main_category']) ? 'selected' : '';
                        ?>
                                                        <option
                                                            value="<?php echo htmlspecialchars($row['main_category']); ?>"
                                                            <?php echo $selected; ?>>
                                                            <?php echo htmlspecialchars($row['main_category']); ?>
                                                        </option>
                                                        <?php endwhile; ?>
                                                    </select>
                                                </div>
                                            </fieldset>

                                            <fieldset class="subcategory">
                                                <div class="body-title mb-10">Subcategory <span
                                                        class="tf-color-1">*</span></div>
                                                <div class="select">
                                                    <select class="subcategory-select" name="subcategory" required>
                                                        <option value="">Choose subcategory</option>
                                                        <?php while($row = mysqli_fetch_assoc($subcategories)): 
                            $selected = ($row['subcategory'] == $product['subcategory']) ? 'selected' : '';
                        ?>
                                                        <option
                                                            value="<?php echo htmlspecialchars($row['subcategory']); ?>"
                                                            <?php echo $selected; ?>>
                                                            <?php echo htmlspecialchars($row['subcategory']); ?>
                                                        </option>
                                                        <?php endwhile; ?>
                                                    </select>
                                                </div>
                                            </fieldset>
                                        </div>

                                        <fieldset class="description">
                                            <div class="body-title mb-10">Description <span class="tf-color-1">*</span>
                                            </div>
                                            <textarea class="mb-10" name="description" placeholder="Description"
                                                tabindex="0"
                                                required><?php echo htmlspecialchars($product['description']); ?></textarea>
                                            <div class="text-tiny">Do not exceed 100 characters when entering the
                                                product description.</div>
                                        </fieldset>

                                        <fieldset class="availability">
                                            <div class="body-title mb-10">Availability <span class="tf-color-1">*</span>
                                            </div>
                                            <div class="select">
                                                <select class="" name="availability" required>
                                                    <option value="In Stock"
                                                        <?php echo ($product['availability'] == 'In Stock') ? 'selected' : ''; ?>>
                                                        In Stock</option>
                                                    <option value="Out of Stock"
                                                        <?php echo ($product['availability'] == 'Out of Stock') ? 'selected' : ''; ?>>
                                                        Out of Stock</option>
                                                    <option value="Pre-order"
                                                        <?php echo ($product['availability'] == 'Pre-order') ? 'selected' : ''; ?>>
                                                        Pre-order</option>
                                                </select>
                                            </div>
                                        </fieldset>
                                    </div>

                                    <div class="wg-box">

                                        <fieldset>
                                            <div class="body-title mb-10">Current Images</div>
                                            <div class="current-images mb-16">
                                                <?php 
        if(mysqli_num_rows($images_result) > 0) {
            echo '<div class="image-container" style="display: flex; flex-wrap: wrap; gap: 10px;">';
            while($image = mysqli_fetch_assoc($images_result)) {
                echo '<div class="image-item" style="position: relative;">';
                echo '<img src="' . htmlspecialchars($image['image_path']) . '" style="width: 100px; height: 100px; object-fit: cover;" />';
                echo '<input type="hidden" name="existing_images[]" value="' . $image['id'] . '">';
                echo '</div>';
            }
            echo '</div>';
        } else {
            echo '<p>No images available</p>';
        }
        ?>
                                            </div>

                                            <div class="body-title mb-10">Upload New Images</div>
                                            <div class="checkbox-wrapper mb-10">
                                                <input type="checkbox" id="delete_images" name="delete_images"
                                                    value="1">
                                                <label for="delete_images">Replace all existing images with new
                                                    uploads</label>
                                            </div>
                                            <div class="upload-image mb-16">
                                                <div class="item up-load">
                                                    <label class="uploadfile" for="product_images">
                                                        <span class="icon">
                                                            <i class="icon-upload-cloud"></i>
                                                        </span>
                                                        <span class="text-tiny">Drop your images here or select <span
                                                                class="tf-color">click to browse</span></span>
                                                        <input type="file" id="product_images" name="product_images[]"
                                                            multiple accept="image/*">
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="image-preview" id="imagePreview"></div>
                                            <div class="body-text">You need to add at least 4 images. Pay attention to
                                                the quality of the pictures you add, comply with the background color
                                                standards. Pictures must be in certain dimensions. Notice that the
                                                product shows all the details</div>
                                        </fieldset>
                                        <div class="cols gap22">
                                            <fieldset class="weight">
                                                <div class="body-title mb-10">Product Weight <span
                                                        class="tf-color-1">*</span></div>
                                                <input class="mb-10" type="text" placeholder="Enter product weight"
                                                    name="weight" required
                                                    value="<?php echo htmlspecialchars($product['weight']); ?>">
                                            </fieldset>

                                            <fieldset class="dimensions">
                                                <div class="body-title mb-10">Product Dimensions</div>
                                                <input class="mb-10" type="text" placeholder="Length x Width x Height"
                                                    name="dimensions"
                                                    value="<?php echo htmlspecialchars($product['dimensions']); ?>">
                                            </fieldset>
                                        </div>

                                        <div class="cols gap22">
                                            <fieldset class="origin">
                                                <div class="body-title mb-10">Country of Origin</div>
                                                <input class="mb-10" type="text" placeholder="Enter country of origin"
                                                    name="country_origin"
                                                    value="<?php echo htmlspecialchars($product['country_origin']); ?>">
                                            </fieldset>

                                            <fieldset class="source">
                                                <div class="body-title mb-10">Source Type</div>
                                                <input class="mb-10" type="text" placeholder="Enter source type"
                                                    name="source_type"
                                                    value="<?php echo htmlspecialchars($product['source_type']); ?>">
                                            </fieldset>
                                        </div>

                                        <fieldset class="container">
                                            <div class="body-title mb-10">Container Type</div>
                                            <input class="mb-10" type="text" placeholder="Enter container type"
                                                name="container_type"
                                                value="<?php echo htmlspecialchars($product['container_type']); ?>">
                                        </fieldset>

                                        <fieldset class="unit-price">
                                            <div class="body-title mb-10">Unit & Price</div>
                                            <div class="checkbox-wrapper mb-10">
                                                <input type="checkbox" id="has_multiple_units" name="has_multiple_units"
                                                    <?php echo ($product['has_multiple_units'] || $has_units) ? 'checked' : ''; ?>>
                                                <label for="has_multiple_units">Product has multiple units/sizes</label>
                                            </div>

                                            <div id="single-price-container"
                                                <?php echo ($product['has_multiple_units'] || $has_units) ? 'style="display: none;"' : ''; ?>>
                                                <div class="cols gap22">
                                                    <fieldset class="price">
                                                        <div class="body-title mb-10">Price <span
                                                                class="tf-color-1">*</span></div>
                                                        <input class="mb-10" type="number" step="0.01"
                                                            placeholder="Enter price" name="single_price"
                                                            <?php echo (!$product['has_multiple_units'] && !$has_units) ? 'required' : ''; ?>
                                                            value="<?php echo htmlspecialchars($single_price); ?>">
                                                    </fieldset>
                                                </div>
                                            </div>

                                            <div id="multiple-units-container"
                                                <?php echo (!$product['has_multiple_units'] && !$has_units) ? 'style="display: none;"' : ''; ?>>
                                                <div id="unit-price-fields">
                                                    <?php 
                    if ($has_units) {
                        while ($unit = mysqli_fetch_assoc($units_result)) {
                    ?>
                                                    <div class="unit-price-row">
                                                        <div class="cols gap22">
                                                            <fieldset class="unit">
                                                                <div class="body-title mb-10">Unit Value <span
                                                                        class="tf-color-1">*</span></div>
                                                                <input class="mb-10" type="number" step="0.01"
                                                                    placeholder="Enter unit value" name="unit[]"
                                                                    value="<?php echo htmlspecialchars($unit['unit_value']); ?>"
                                                                    required>
                                                            </fieldset>

                                                            <fieldset class="unit-type">
                                                                <div class="body-title mb-10">Unit Type <span
                                                                        class="tf-color-1">*</span></div>
                                                                <div class="select">
                                                                    <select name="unit_type[]">
                                                                        <option value="ml"
                                                                            <?php echo ($unit['unit_type'] == 'ml') ? 'selected' : ''; ?>>
                                                                            ml</option>
                                                                        <option value="litre"
                                                                            <?php echo ($unit['unit_type'] == 'litre') ? 'selected' : ''; ?>>
                                                                            litre</option>
                                                                        <option value="gram"
                                                                            <?php echo ($unit['unit_type'] == 'gram') ? 'selected' : ''; ?>>
                                                                            gram</option>
                                                                        <option value="kg"
                                                                            <?php echo ($unit['unit_type'] == 'kg') ? 'selected' : ''; ?>>
                                                                            kg</option>
                                                                        <option value="piece"
                                                                            <?php echo ($unit['unit_type'] == 'piece') ? 'selected' : ''; ?>>
                                                                            piece</option>
                                                                    </select>
                                                                </div>
                                                            </fieldset>

                                                            <fieldset class="price">
                                                                <div class="body-title mb-10">Price <span
                                                                        class="tf-color-1">*</span></div>
                                                                <input class="mb-10" type="number" step="0.01"
                                                                    placeholder="Enter price" name="price[]"
                                                                    value="<?php echo htmlspecialchars($unit['price']); ?>"
                                                                    required>
                                                            </fieldset>
                                                        </div>
                                                        <button type="button"
                                                            class="remove-unit-btn tf-button style-2">Remove</button>
                                                    </div>
                                                    <?php 
                        }
                    } else {
                    ?>
                                                    <div class="unit-price-row">
                                                        <div class="cols gap22">
                                                            <fieldset class="unit">
                                                                <div class="body-title mb-10">Unit Value <span
                                                                        class="tf-color-1">*</span></div>
                                                                <input class="mb-10" type="number" step="0.01"
                                                                    placeholder="Enter unit value" name="unit[]">
                                                            </fieldset>

                                                            <fieldset class="unit-type">
                                                                <div class="body-title mb-10">Unit Type <span
                                                                        class="tf-color-1">*</span></div>
                                                                <div class="select">
                                                                    <select name="unit_type[]">
                                                                        <option value="ml">ml</option>
                                                                        <option value="litre">litre</option>
                                                                        <option value="gram">gram</option>
                                                                        <option value="kg">kg</option>
                                                                        <option value="piece">piece</option>
                                                                    </select>
                                                                </div>
                                                            </fieldset>

                                                            <fieldset class="price">
                                                                <div class="body-title mb-10">Price <span
                                                                        class="tf-color-1">*</span></div>
                                                                <input class="mb-10" type="number" step="0.01"
                                                                    placeholder="Enter price" name="price[]">
                                                            </fieldset>
                                                        </div>
                                                        <button type="button"
                                                            class="remove-unit-btn tf-button style-2">Remove</button>
                                                    </div>
                                                    <?php } ?>
                                                </div>

                                                <button type="button" class="add-unit-btn tf-button style-1 mb-10">Add
                                                    Another Unit</button>
                                            </div>
                                        </fieldset>

                                        <div class="cols gap10">
                                            <button class="tf-button w-full" type="submit">Update product</button>
                                            <button class="tf-button style-1 w-full" type="submit" name="save_draft"
                                                value="1">Save as draft</button>
                                            <a href="product-list.php" class="tf-button style-2 w-full">Cancel</a>
                                        </div>
                                    </div>
                                </form>

                                <script>
                                // Script for automatically loading subcategories and other functionality
                                document.addEventListener('DOMContentLoaded', function() {
                                    // Main category change event
                                    document.querySelector('.main-category-select').addEventListener('change',
                                        function() {
                                            loadSubcategories(this.value);
                                        });

                                    function loadSubcategories(mainCategory) {
                                        const subcategorySelect = document.querySelector('.subcategory-select');

                                        // Clear current options
                                        subcategorySelect.innerHTML =
                                            '<option value="">Loading subcategories...</option>';

                                        if (mainCategory) {
                                            // AJAX request to get subcategories
                                            const xhr = new XMLHttpRequest();
                                            xhr.open('GET', 'get-subcategories.php?main_category=' +
                                                encodeURIComponent(mainCategory), true);

                                            xhr.onload = function() {
                                                if (this.status === 200) {
                                                    const subcategories = JSON.parse(this.responseText);

                                                    subcategorySelect.innerHTML =
                                                    ''; // Clear the loading message

                                                    if (subcategories.length > 0) {
                                                        // Add option for each subcategory
                                                        for (let i = 0; i < subcategories.length; i++) {
                                                            const option = document.createElement('option');
                                                            option.value = subcategories[i];
                                                            option.textContent = subcategories[i];
                                                            subcategorySelect.appendChild(option);
                                                        }
                                                    } else {
                                                        // No subcategories found
                                                        const option = document.createElement('option');
                                                        option.value = "";
                                                        option.textContent = "No subcategories available";
                                                        subcategorySelect.appendChild(option);
                                                    }

                                                    // Trigger change event to update any dependent fields
                                                    const event = new Event('change');
                                                    subcategorySelect.dispatchEvent(event);
                                                }
                                            };

                                            xhr.send();
                                        }
                                    }

                                    // Multiple units toggle
                                    const hasMultipleUnits = document.getElementById('has_multiple_units');
                                    const singlePriceContainer = document.getElementById(
                                        'single-price-container');
                                    const multipleUnitsContainer = document.getElementById(
                                        'multiple-units-container');

                                    hasMultipleUnits.addEventListener('change', function() {
                                        if (this.checked) {
                                            singlePriceContainer.style.display = 'none';
                                            multipleUnitsContainer.style.display = 'block';

                                            // Make first unit row required
                                            const firstUnitRow = document.querySelector(
                                                '.unit-price-row');
                                            if (firstUnitRow) {
                                                firstUnitRow.querySelectorAll('input').forEach(
                                                input => {
                                                    input.setAttribute('required', 'required');
                                                });
                                            }

                                            // Remove required from single price
                                            document.querySelector('input[name="single_price"]')
                                                .removeAttribute('required');
                                        } else {
                                            singlePriceContainer.style.display = 'block';
                                            multipleUnitsContainer.style.display = 'none';

                                            // Make single price required
                                            document.querySelector('input[name="single_price"]')
                                                .setAttribute('required', 'required');

                                            // Remove required from all unit rows
                                            document.querySelectorAll('.unit-price-row input').forEach(
                                                input => {
                                                    input.removeAttribute('required');
                                                });
                                        }
                                    });

                                    // Add another unit row
                                    document.querySelector('.add-unit-btn').addEventListener('click',
                                function() {
                                        const unitPriceFields = document.getElementById(
                                            'unit-price-fields');
                                        const newRow = document.querySelector('.unit-price-row')
                                            .cloneNode(true);

                                        // Clear input values
                                        newRow.querySelectorAll('input').forEach(input => {
                                            input.value = '';
                                            if (hasMultipleUnits.checked) {
                                                input.setAttribute('required', 'required');
                                            }
                                        });

                                        // Add event listener to remove button
                                        newRow.querySelector('.remove-unit-btn').addEventListener(
                                            'click',
                                            function() {
                                                unitPriceFields.removeChild(newRow);
                                            });

                                        unitPriceFields.appendChild(newRow);
                                    });

                                    // Remove unit row (for existing rows)
                                    document.querySelectorAll('.remove-unit-btn').forEach(button => {
                                        button.addEventListener('click', function() {
                                            const unitPriceRows = document.querySelectorAll(
                                                '.unit-price-row');
                                            if (unitPriceRows.length > 1) {
                                                this.closest('.unit-price-row').remove();
                                            }
                                        });
                                    });

                                    // Image preview
                                    document.getElementById('product_images').addEventListener('change',
                                        function(e) {
                                            const imagePreview = document.getElementById('imagePreview');
                                            imagePreview.innerHTML = '';

                                            // Automatically check the delete_images checkbox when new images are selected
                                            document.getElementById('delete_images').checked = true;

                                            if (this.files) {
                                                const files = Array.from(this.files);

                                                files.forEach(file => {
                                                    if (!file.type.match('image.*')) {
                                                        return;
                                                    }

                                                    const reader = new FileReader();

                                                    reader.onload = function(e) {
                                                        const imgContainer = document
                                                            .createElement('div');
                                                        imgContainer.className =
                                                            'preview-image-container';

                                                        const img = document.createElement(
                                                            'img');
                                                        img.src = e.target.result;
                                                        img.className = 'preview-image';
                                                        img.style.maxWidth = '100px';
                                                        img.style.maxHeight = '100px';
                                                        img.style.margin = '5px';

                                                        imgContainer.appendChild(img);
                                                        imagePreview.appendChild(imgContainer);
                                                    };

                                                    reader.readAsDataURL(file);
                                                });
                                            }
                                        });
                                });
                                </script>

                            </div>
                            <!-- /main-content-wrap -->
                        </div>
                        <!-- /main-content-wrap -->
                        <!-- bottom-page -->
                        <div class="bottom-page">
                            <div class="body-text">Copyright © 2024 Remos. Design with</div>
                            <i class="icon-heart"></i>
                            <div class="body-text">by <a
                                    href="https://themeforest.net/user/themesflat/portfolio">Themesflat</a> All rights
                                reserved.</div>
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