<?php
session_start();
include_once 'admin/dbconnection.php';

$response = array('success' => false);

if(isset($_POST['item_key'])) {
    $item_key = $_POST['item_key'];
    
    if(isset($_SESSION['cart'][$item_key])) {
        // Remove item from cart
        unset($_SESSION['cart'][$item_key]);
        
        $response['success'] = true;
        $response['message'] = 'Item removed from cart successfully';
        $response['cart_count'] = count($_SESSION['cart']);
    } else {
        $response['message'] = 'Item not found in cart';
    }
} else {
    $response['message'] = 'Invalid request';
}

header('Content-Type: application/json');
echo json_encode($response);
?> 