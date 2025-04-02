<?php
// Include database connection
include('dbconnection.php');

// Get main category from request
if(isset($_GET['main_category'])) {
    $main_category = mysqli_real_escape_string($conn, $_GET['main_category']);
    
    // Fetch subcategories for the given main category
    $query = "SELECT DISTINCT subcategory FROM categories WHERE main_category = '$main_category' ORDER BY subcategory";
    $result = mysqli_query($conn, $query);
    
    $subcategories = [];
    
    while($row = mysqli_fetch_assoc($result)) {
        $subcategories[] = $row['subcategory'];
    }
    
    // Return as JSON
    header('Content-Type: application/json');
    echo json_encode($subcategories);
} else {
    // Return empty array if no main category provided
    header('Content-Type: application/json');
    echo json_encode([]);
}
?>