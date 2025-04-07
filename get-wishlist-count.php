<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once 'admin/dbconnection.php';

$response = array('success' => false, 'wishlist_count' => 0);

if (isset($_SESSION['session_id'])) {
    $session_id = $_SESSION['session_id'];
    
    try {
        $sql = "SELECT COUNT(*) as count FROM wishlist WHERE session_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $session_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        
        $response['success'] = true;
        $response['wishlist_count'] = (int)$row['count'];
    } catch (Exception $e) {
        $response['message'] = $e->getMessage();
    }
}

header('Content-Type: application/json');
echo json_encode($response); 