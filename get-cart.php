<?php
session_start();
include_once 'admin/dbconnection.php';

$response = array('success' => false);

try {
    $cart_items = array();
    
    if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        foreach($_SESSION['cart'] as $cart_key => $item) {
            // Get product details including image
            $product_id = $item['id'];
            $sql = "SELECT p.*, pi.image_path 
                    FROM products p 
                    LEFT JOIN product_images pi ON p.id = pi.product_id 
                    WHERE p.id = ? 
                    LIMIT 1";
            
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "s", $product_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            
            if($row = mysqli_fetch_assoc($result)) {
                $cart_items[] = array(
                    'cart_key' => $cart_key,
                    'id' => $item['id'],
                    'name' => $item['name'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'image' => $row['image_path'] ?? 'assets/img/default-product.jpg',
                    'unit' => $item['unit']
                );
            }
        }
        
        $response['success'] = true;
        $response['cart_items'] = $cart_items;
    } else {
        $response['success'] = true;
        $response['cart_items'] = array();
    }
} catch(Exception $e) {
    $response['message'] = 'Error retrieving cart items';
}

header('Content-Type: application/json');
echo json_encode($response);
?> 