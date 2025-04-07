<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once 'admin/dbconnection.php';

$response = array('success' => false, 'in_wishlist' => false);

if (isset($_GET['product_id']) && isset($_SESSION['session_id'])) {
    $product_id = intval($_GET['product_id']);
    $session_id = $_SESSION['session_id'];

    try {
        $sql = "SELECT id FROM wishlist WHERE product_id = ? AND session_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "is", $product_id, $session_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        $response['success'] = true;
        $response['in_wishlist'] = mysqli_num_rows($result) > 0;
    } catch (Exception $e) {
        $response['message'] = $e->getMessage();
    }
}

header('Content-Type: application/json');
echo json_encode($response); 