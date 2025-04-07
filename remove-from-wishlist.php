<?php
session_start();
include 'admin/dbconnection.php';
include 'check-auth.php';

// Require login for this action
requireLogin();

// Initialize response array
$response = array(
    'success' => false,
    'message' => ''
);

// Check if wishlist_id is provided
if (!isset($_POST['wishlist_id'])) {
    $response['message'] = 'Wishlist ID is required';
    echo json_encode($response);
    exit();
}

$wishlist_id = mysqli_real_escape_string($conn, $_POST['wishlist_id']);
$user_id = $_SESSION['user_id'];

try {
    // Verify the wishlist item belongs to the current session
    $check_query = "SELECT id FROM wishlist WHERE id = ? AND user_id = ?";
    $stmt = mysqli_prepare($conn, $check_query);
    mysqli_stmt_bind_param($stmt, "is", $wishlist_id, $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 0) {
        $response['message'] = 'Invalid wishlist item';
        echo json_encode($response);
        exit();
    }

    // Delete the wishlist item
    $delete_query = "DELETE FROM wishlist WHERE id = ? AND user_id = ?";
    $stmt = mysqli_prepare($conn, $delete_query);
    mysqli_stmt_bind_param($stmt, "is", $wishlist_id, $user_id);
    
    if (mysqli_stmt_execute($stmt)) {
        $response['success'] = true;
        $response['message'] = 'Item removed from wishlist successfully';
    } else {
        $response['message'] = 'Failed to remove item from wishlist: ' . mysqli_error($conn);
    }

} catch (Exception $e) {
    $response['message'] = 'An error occurred: ' . $e->getMessage();
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);
?> 