<?php
session_start();
include 'admin/dbconnection.php';

if(isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);
    
    if($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if(password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['first_name'] . ' ' . $user['last_name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['success'] = "Login successful!";
            header("Location: index.php");
        } else {
            $_SESSION['error'] = "Invalid password!";
            header("Location: login-signup.php");
        }
    } else {
        $_SESSION['error'] = "Email not found!";
        header("Location: login-signup.php");
    }
}
?> 