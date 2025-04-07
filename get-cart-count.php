<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once 'admin/dbconnection.php';

$response = array('success' => false, 'cart_count' => 0);

if (isset($_SESSION['session_id'])) {
    try {
        $sql = "SELECT COUNT(DISTINCT product_id) as count FROM cart WHERE session_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $_SESSION['session_id']);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        
        $response['success'] = true;
        $response['cart_count'] = $row['count'] ?? 0;
    } catch (Exception $e) {
        $response['message'] = 'Error getting cart count';
    }
}

header('Content-Type: application/json');
echo json_encode($response);
?> 