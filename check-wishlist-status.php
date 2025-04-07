<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'admin/dbconnection.php';
include 'check-auth.php';

// Initialize response array
$response = array(
    'success' => false,
    'in_wishlist' => false,
    'message' => ''
);

// Check if product_id is provided
if (!isset($_POST['product_id'])) {
    $response['message'] = 'Product ID is required';
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}

$product_id = mysqli_real_escape_string($conn, $_POST['product_id']);
$user_id = user_id();

try {
    // Check if product exists in wishlist
    $sql = "SELECT id FROM wishlist WHERE product_id = ? AND user_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "is", $product_id, $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    $response['success'] = true;
    $response['in_wishlist'] = mysqli_num_rows($result) > 0;
    $response['message'] = $response['in_wishlist'] ? 'Product is in wishlist' : 'Product is not in wishlist';
    
} catch (Exception $e) {
    $response['message'] = 'An error occurred: ' . $e->getMessage();
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);
?> 