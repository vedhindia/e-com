<?php
// Include database connection
include('dbconnection.php');

// Check if request method is POST and ID exists
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $product_id = (int)$_POST['id'];
    
    // Start transaction
    mysqli_begin_transaction($conn);
    
    try {
        // Delete product images
        $image_query = "DELETE FROM product_images WHERE product_id = '$product_id'";
        mysqli_query($conn, $image_query);
        
        // Delete product units
        $units_query = "DELETE FROM product_units WHERE product_id = '$product_id'";
        mysqli_query($conn, $units_query);
        
        // Delete product prices
        $prices_query = "DELETE FROM product_prices WHERE product_id = '$product_id'";
        mysqli_query($conn, $prices_query);
        
        // Delete product
        $product_query = "DELETE FROM products WHERE id = '$product_id'";
        mysqli_query($conn, $product_query);
        
        // Commit transaction
        mysqli_commit($conn);
        
        echo "success";
    } catch (Exception $e) {
        // Rollback transaction on error
        mysqli_rollback($conn);
        echo "error: " . $e->getMessage();
    }
} else {
    echo "error: Invalid request";
}
?>