<?php
session_start();
include_once 'dbconnection.php';

// Check if user is logged in
if (empty($_SESSION['admin_session'])) {
    header('Location: login.php');
    exit;
}

$id = $_GET['id'];

// Start transaction for data integrity
mysqli_begin_transaction($conn);

try {
    // First, delete associated subcategories (handle reference integrity)
    $delete_subcategories = "DELETE FROM subcategories WHERE category_id = ?";
    $stmt = mysqli_prepare($conn, $delete_subcategories);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);

    // Now delete the category using prepared statement
    $delete_query = "DELETE FROM categories WHERE id = ?";
    $stmt = mysqli_prepare($conn, $delete_query);
    mysqli_stmt_bind_param($stmt, "i", $id);

    if (mysqli_stmt_execute($stmt)) {
        // Commit the transaction
        mysqli_commit($conn);

        // JavaScript alert for successful deletion
        echo "<script>
                alert('Category deleted successfully!');
                window.location.href = 'category-list.php';
              </script>";
        exit;
    } else {
        // Something went wrong
        throw new Exception(mysqli_error($conn));
    }
} catch (Exception $e) {
    // Rollback the transaction
    mysqli_rollback($conn);

    // Error - redirect with error message
    header("Location: category-list.php?error=delete_failed&message=" . urlencode($e->getMessage()));
    exit;
}
?>
