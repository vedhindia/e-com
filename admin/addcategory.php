<?php
// Include database connection
include 'dbconnection.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $main_category = $conn->real_escape_string($_POST['main_category']);
    $subcategory = $conn->real_escape_string($_POST['subcategory']);

    // Insert query
    $sql = "INSERT INTO categories (main_category, subcategory) VALUES ('$main_category', '$subcategory')";

    if ($conn->query($sql) === TRUE) {
        // Redirect with success message
        echo "<script>
                alert('Category added successfully!');
                window.location.href='category-list.php';
              </script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close connection
$conn->close();
?>
