<?php
include_once 'admin/dbconnection.php';

if(isset($_GET['id'])) {
    $product_id = mysqli_real_escape_string($conn, $_GET['id']);
    
    // Get product details including images and prices
    $sql = "SELECT p.*, 
            GROUP_CONCAT(DISTINCT pi.image_path) as images,
            MIN(pu.price) as min_unit_price,
            pp.price as regular_price
            FROM products p 
            LEFT JOIN product_images pi ON p.id = pi.product_id
            LEFT JOIN product_units pu ON p.id = pu.product_id
            LEFT JOIN product_prices pp ON p.id = pp.product_id
            WHERE p.id = '$product_id'
            GROUP BY p.id";
            
    $result = mysqli_query($conn, $sql);
    
    if($result && mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);
        
        // Get all units if product has multiple units
        $units = array();
        if($product['has_multiple_units']) {
            $units_sql = "SELECT * FROM product_units WHERE product_id = '$product_id'";
            $units_result = mysqli_query($conn, $units_sql);
            while($unit = mysqli_fetch_assoc($units_result)) {
                $units[] = $unit;
            }
        }
        
        // Format image paths
        $images = $product['images'] ? explode(',', $product['images']) : array();
        $formatted_images = array();
        foreach($images as $image) {
            $formatted_images[] = 'admin/' . $image;
        }
        
        // Determine price
        $price = isset($product['regular_price']) ? $product['regular_price'] : $product['min_unit_price'];
        $discount_price = $price * 0.85; // 15% discount
        
        $response = array(
            'success' => true,
            'product' => array(
                'id' => $product['id'],
                'name' => $product['product_name'],
                'description' => $product['description'],
                'availability' => $product['availability'],
                'weight' => $product['weight'],
                'dimensions' => $product['dimensions'],
                'country_origin' => $product['country_origin'],
                'price' => number_format($price, 2),
                'discount_price' => number_format($discount_price, 2),
                'images' => $formatted_images,
                'has_multiple_units' => $product['has_multiple_units'],
                'units' => $units
            )
        );
    } else {
        $response = array('success' => false, 'message' => 'Product not found');
    }
} else {
    $response = array('success' => false, 'message' => 'Product ID not provided');
}

header('Content-Type: application/json');
echo json_encode($response);
?> 