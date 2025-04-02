<?php
// Include database connection
include('dbconnection.php');

// Check if ID is provided
if(!isset($_GET['id']) || empty($_GET['id'])) {
    // Redirect to category list with error message
    header("Location: category-list.php?error=no_id");
    exit;
}

$id = mysqli_real_escape_string($conn, $_GET['id']);

// Get category details for logging or confirmation (optional)
$query = "SELECT * FROM categories WHERE id = '$id'";
$result = mysqli_query($conn, $query);

if(mysqli_num_rows($result) == 0) {
    // Category doesn't exist
    header("Location: category-list.php?error=not_found");
    exit;
}

$category = mysqli_fetch_assoc($result);

// Delete the category
$delete_query = "DELETE FROM categories WHERE id = '$id'";

if(mysqli_query($conn, $delete_query)) {
    // Success - redirect with success message
    header("Location: category-list.php?success=deleted");
    exit;
} else {
    // Error - redirect with error message
    header("Location: category-list.php?error=delete_failed&message=" . urlencode(mysqli_error($conn)));
    exit;
}
?>