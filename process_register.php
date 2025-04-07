<?php
session_start();
include 'admin/dbconnection.php';

if(isset($_POST['register'])) {
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);
    $newsletter = isset($_POST['newsletter']) ? 1 : 0;
    
    // Validate password match
    if($password !== $confirm_password) {
        $_SESSION['error'] = "Passwords do not match!";
        header("Location: login-signup.php");
        exit();
    }
    
    // Check if email exists
    $check_email = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($check_email);
    
    if($result->num_rows > 0) {
        $_SESSION['error'] = "Email already exists!";
        header("Location: login-signup.php");
        exit();
    }
    
    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Insert new user
    $sql = "INSERT INTO users (first_name, last_name, email, password, newsletter, created_at) 
            VALUES ('$first_name', '$last_name', '$email', '$hashed_password', $newsletter, CURRENT_TIMESTAMP)";
    
    if($conn->query($sql)) {
        $_SESSION['success'] = "Registration successful! Please login.";
        header("Location: login-signup.php");
    } else {
        $_SESSION['error'] = "Registration failed: " . $conn->error;
        header("Location: login-signup.php");
    }
}
?> 