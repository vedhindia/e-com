<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once 'admin/dbconnection.php';

$response = array('success' => false, 'message' => '');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    if (!isset($_SESSION['user_id'])) {
        $_SESSION['user_id'] = user_id();
    }

    $product_id = intval($_POST['product_id']);
    $user_id = $_SESSION['user_id'];

    try {
        // First, verify that the product exists
        $check_product_sql = "SELECT id FROM products WHERE id = ?";
        $check_product_stmt = mysqli_prepare($conn, $check_product_sql);
        mysqli_stmt_bind_param($check_product_stmt, "i", $product_id);
        mysqli_stmt_execute($check_product_stmt);
        $product_result = mysqli_stmt_get_result($check_product_stmt);

        if (mysqli_num_rows($product_result) === 0) {
            $response['message'] = 'Product not found';
        } else {
            // Check if product is already in wishlist
            $check_wishlist_sql = "SELECT id FROM wishlist WHERE product_id = ? AND user_id = ?";
            $check_wishlist_stmt = mysqli_prepare($conn, $check_wishlist_sql);
            mysqli_stmt_bind_param($check_wishlist_stmt, "is", $product_id, $user_id);
            mysqli_stmt_execute($check_wishlist_stmt);
            $wishlist_result = mysqli_stmt_get_result($check_wishlist_stmt);

            if (mysqli_num_rows($wishlist_result) > 0) {
                $response['message'] = 'Product already in wishlist';
            } else {
                // Add to wishlist
                $sql = "INSERT INTO wishlist (product_id, user_id) VALUES (?, ?)";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "is", $product_id, $user_id);
                
                if (mysqli_stmt_execute($stmt)) {
                    $response['success'] = true;
                    $response['message'] = 'Product added to wishlist';
                } else {
                    throw new Exception('Error adding to wishlist: ' . mysqli_error($conn));
                }
            }
        }
    } catch (Exception $e) {
        $response['message'] = $e->getMessage();
    }
} else {
    $response['message'] = 'Invalid request';
}

header('Content-Type: application/json');
echo json_encode($response);
?> 