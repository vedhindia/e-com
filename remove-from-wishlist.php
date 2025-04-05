<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once 'admin/dbconnection.php';

$response = array('success' => false, 'message' => '');

if (!isset($_SESSION['session_id'])) {
    $response['message'] = 'Session not found';
    echo json_encode($response);
    exit;
}

if (!isset($_POST['wishlist_id'])) {
    $response['message'] = 'Wishlist ID not provided';
    echo json_encode($response);
    exit;
}

$wishlist_id = (int)$_POST['wishlist_id'];
$session_id = $_SESSION['session_id'];

try {
    // Verify the wishlist item belongs to the current session
    $verify_sql = "SELECT id FROM wishlist WHERE id = ? AND session_id = ?";
    $verify_stmt = mysqli_prepare($conn, $verify_sql);
    mysqli_stmt_bind_param($verify_stmt, "is", $wishlist_id, $session_id);
    mysqli_stmt_execute($verify_stmt);
    $verify_result = mysqli_stmt_get_result($verify_stmt);
    
    if (mysqli_num_rows($verify_result) === 0) {
        throw new Exception('Invalid wishlist item');
    }
    
    // Delete the wishlist item
    $delete_sql = "DELETE FROM wishlist WHERE id = ? AND session_id = ?";
    $delete_stmt = mysqli_prepare($conn, $delete_sql);
    mysqli_stmt_bind_param($delete_stmt, "is", $wishlist_id, $session_id);
    
    if (mysqli_stmt_execute($delete_stmt)) {
        $response['success'] = true;
        $response['message'] = 'Item removed from wishlist';
    } else {
        throw new Exception('Error removing item from wishlist');
    }
    
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

header('Content-Type: application/json');
echo json_encode($response); 