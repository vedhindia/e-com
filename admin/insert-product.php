<?php
session_start();
include_once 'dbconnection.php';
if (empty($_SESSION['admin_session'])) {
    header('Location:login.php');
}


// Fetch main categories
$query = "SELECT DISTINCT main_category FROM categories ORDER BY main_category";
$main_categories = mysqli_query($conn, $query);

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
    
    // Insert product
    $insert_query = "INSERT INTO products (product_name, main_category, subcategory, 
                    description, availability, weight, dimensions, country_origin, 
                    source_type, container_type, has_multiple_units) 
                    VALUES ('$product_name', '$main_category', '$subcategory', 
                    '$description', '$availability', '$weight', '$dimensions', 
                    '$country_origin', '$source_type', '$container_type', '$has_multiple_units')";
    
    if (mysqli_query($conn, $insert_query)) {
        $product_id = mysqli_insert_id($conn);
        
        // Handle product units and prices
        if ($has_multiple_units) {
            foreach ($_POST['unit'] as $key => $unit_value) {
                $unit = mysqli_real_escape_string($conn, $unit_value);
                $unit_type = mysqli_real_escape_string($conn, $_POST['unit_type'][$key]);
                $price = mysqli_real_escape_string($conn, $_POST['price'][$key]);
                
                $unit_query = "INSERT INTO product_units (product_id, unit_value, unit_type, price) 
                              VALUES ('$product_id', '$unit', '$unit_type', '$price')";
                mysqli_query($conn, $unit_query);
            }
        } else {
            $price = mysqli_real_escape_string($conn, $_POST['single_price']);
            $price_query = "INSERT INTO product_prices (product_id, price) VALUES ('$product_id', '$price')";
            mysqli_query($conn, $price_query);
        }
        
        // Handle product images
        if (isset($_FILES['product_images'])) {
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
        
        // JavaScript alert and redirect
        echo "<script>
                alert('Product added successfully!');
                window.location.href = 'product-list.html';
              </script>";
        exit();
    } else {
        echo "<script>
                alert('Error adding product: " . mysqli_error($conn) . "');
              </script>";
    }
}
?>
