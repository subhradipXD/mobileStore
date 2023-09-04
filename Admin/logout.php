<?php
include("../_dbConnect.php");

// Check if the admin is logged in
if (isset($_SESSION['admin_id'])) {
    // Unset all session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Redirect to the admin login page
    header("location: admin.php"); // Replace 'admin.php' with the actual login page URL
    exit();
} else {
    // If the admin is not logged in, simply redirect to the admin login page
    header("location: admin.php"); // Replace 'admin.php' with the actual login page URL
    exit();
}
?>