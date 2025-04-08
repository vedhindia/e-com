<?php
session_start();
include 'admin/dbconnection.php';
include 'check-auth.php';

requireLogin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: my-cart.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch cart items with unit prices
$sql = "SELECT c.*, COALESCE(pu.price, pp.price) AS unit_price
        FROM cart c
        LEFT JOIN product_units pu ON c.unit_id = pu.id
        LEFT JOIN product_prices pp ON c.product_id = pp.product_id
        WHERE c.user_id = ?";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$product_ids = [];
mysqli_begin_transaction($conn);

try {
    $insert_sql = "INSERT INTO checkout (user_id, product_id, quantity, unit_price, total_price)
                   VALUES (?, ?, ?, ?, ?)";
    $insert_stmt = mysqli_prepare($conn, $insert_sql);

    while ($row = mysqli_fetch_assoc($result)) {
        $total_price = $row['quantity'] * $row['unit_price'];
        $product_ids[] = $row['product_id'];

        mysqli_stmt_bind_param($insert_stmt, "iiidd", 
            $user_id, 
            $row['product_id'], 
            $row['quantity'], 
            $row['unit_price'], 
            $total_price
        );
        mysqli_stmt_execute($insert_stmt);
    }

    mysqli_commit($conn);

    // Redirect to billing page with product IDs
    $product_ids_str = implode(',', $product_ids);
    header("Location: billing.php?products=$product_ids_str");
    exit();

} catch (Exception $e) {
    mysqli_rollback($conn);
    $_SESSION['error'] = "Checkout failed: " . $e->getMessage();
    header("Location: my-cart.php");
    exit();
}
?>
