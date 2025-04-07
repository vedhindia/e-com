<?php
session_start();
include_once 'dbconnection.php';
if (empty($_SESSION['admin_session'])) {
    header('Location:login.php');
}


// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $main_category = $conn->real_escape_string($_POST['main_category']);

    // Insert query
    $sql = "INSERT INTO categories (main_category) VALUES ('$main_category')";

    if ($conn->query($sql) === TRUE) {
        // Redirect with success message
        echo "<script>
                alert('Category added successfully!');
                window.location.href='subcategories.php';
              </script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close connection
$conn->close();
?>
