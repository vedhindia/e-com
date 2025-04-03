<?php
include 'dbconnection.php'; // Include database connection

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // First, delete associated images from the blog_images table
    $stmt1 = $conn->prepare("DELETE FROM blog_images WHERE blog_id = ?");
    $stmt1->bind_param("i", $id);
    $stmt1->execute();
    $stmt1->close();

    // Then, delete the blog post from blogs table
    $stmt2 = $conn->prepare("DELETE FROM blogs WHERE id = ?");
    $stmt2->bind_param("i", $id);

    if ($stmt2->execute()) {
        echo "<script>
                alert('Blog deleted successfully!');
                window.location.href = 'blog.php';
              </script>";
    } else {
        echo "<script>
                alert('Error deleting blog. Please try again.');
                window.location.href = 'blog.php';
              </script>";
    }

    $stmt2->close();
} else {
    echo "<script>
            alert('Invalid blog ID.');
            window.location.href = 'blog.php';
          </script>";
}

$conn->close();
?>
