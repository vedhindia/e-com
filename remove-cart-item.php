<?php
session_start();
include_once 'admin/dbconnection.php';

$response = array('success' => false, 'message' => '');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cart_id'])) {
    try {
        $cart_id = (int)$_POST['cart_id'];
        $user_id = $_SESSION['user_id'];

        // Remove item from cart
        $sql = "DELETE FROM cart WHERE id = ? AND user_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "is", $cart_id, $user_id);
            
            if (mysqli_stmt_execute($stmt)) {
                if (mysqli_stmt_affected_rows($stmt) > 0) {
                    $response['success'] = true;
                    $response['message'] = 'Item removed successfully';
                } else {
                    throw new Exception('Cart item not found');
                }
            } else {
                throw new Exception('Error removing item');
            }
        } else {
            throw new Exception('Error preparing delete query');
        }
    } catch (Exception $e) {
        $response['message'] = $e->getMessage();
    }
} else {
    $response['message'] = 'Invalid request';
}

header('Content-Type: application/json');
echo json_encode($response); 