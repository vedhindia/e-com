<?php
session_start();
session_unset();
session_destroy();

// Redirect to login page with a logout success message
header("Location: login.php?logout=success");
exit();
?>
