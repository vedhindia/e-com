<?php
session_start();
include_once 'admin/dbconnection.php';

$response = array('success' => false, 'message' => '');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cart_id']) && isset($_POST['quantity'])) {
    $cart_id = intval($_POST['cart_id']);
    $quantity = intval($_POST['quantity']);
    
    if ($quantity < 1) {
        $response['message'] = 'Quantity must be at least 1';
    } else {
        try {
            $sql = "UPDATE cart SET quantity = ? WHERE id = ? AND session_id = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "iis", $quantity, $cart_id, $_SESSION['session_id']);
            
            if (mysqli_stmt_execute($stmt)) {
                $response['success'] = true;
                $response['message'] = 'Quantity updated successfully';
            } else {
                $response['message'] = 'Error updating quantity';
            }
        } catch (Exception $e) {
            $response['message'] = 'Error: ' . $e->getMessage();
        }
    }
} else {
    $response['message'] = 'Invalid request';
}

header('Content-Type: application/json');
echo json_encode($response); 