<?php
session_start();
include("admin/dbconnection.php");

// Insert payment with status 'pending'
if (isset($_POST['user_id'], $_POST['amount']) && !isset($_POST['payment_id'])) {
    $user_id = $_POST['user_id'];
    $amount = $_POST['amount'];
    $added_on = date('Y-m-d H:i:s');

    // Use prepared statement for security
    $stmt = $conn->prepare("INSERT INTO payment (user_id, amount, payment_status, added_on) VALUES (?, ?, 'pending', ?)");
    $stmt->bind_param("ids", $user_id, $amount, $added_on);
    
    if ($stmt->execute()) {
        $_SESSION['OID'] = $stmt->insert_id;

        // Clear cart after payment record inserted
        $delete = "DELETE FROM cart WHERE user_id = ?";
        $stmtDelete = $conn->prepare($delete);
        $stmtDelete->bind_param("i", $user_id);
        $stmtDelete->execute();
        $stmtDelete->close();
    }

    $stmt->close();
}

// Update payment status to complete after payment success
if (isset($_POST['payment_id']) && isset($_SESSION['OID'])) {
    $payment_id = $_POST['payment_id'];
    $order_id = $_SESSION['OID'];

    $update = "UPDATE payment SET payment_status='complete', payment_id=? WHERE id=?";
    $stmtUpdate = $conn->prepare($update);
    $stmtUpdate->bind_param("si", $payment_id, $order_id);
    $stmtUpdate->execute();
    $stmtUpdate->close();

    unset($_SESSION['OID']);
}

$conn->close();
?>
