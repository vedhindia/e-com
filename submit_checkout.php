<?php
session_start();
include("admin/dbconnection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $company = mysqli_real_escape_string($conn, $_POST['company']);
    $country = mysqli_real_escape_string($conn, $_POST['country']);
    $address1 = mysqli_real_escape_string($conn, $_POST['address1']);
    $address2 = mysqli_real_escape_string($conn, $_POST['address2']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $zip = mysqli_real_escape_string($conn, $_POST['zip']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $order_notes = mysqli_real_escape_string($conn, $_POST['order_notes']);

    $subtotal = floatval($_POST['Subtotal']);
    $tax = floatval($_POST['Tax']);
    $shipping = floatval($_POST['Shipping']);
    $total = floatval($_POST['Total']);
    $user_id = intval($_POST['user_id']);
    $product_id = intval($_POST['product_id']);

    $query = "INSERT INTO orders 
    (user_id, product_id, first_name, last_name, email, company, country, address1, address2, city, zip, phone, order_notes, subtotal, tax, shipping, total, payment_status) 
    VALUES 
    ('$user_id', '$product_id', '$first_name', '$last_name', '$email', '$company', '$country', '$address1', '$address2', '$city', '$zip', '$phone', '$order_notes', '$subtotal', '$tax', '$shipping', '$total', 'Pending')";

    if (mysqli_query($conn, $query)) {
        $_SESSION['total_payable'] = $total;
        header("Location: pay.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "Invalid Request!";
}
