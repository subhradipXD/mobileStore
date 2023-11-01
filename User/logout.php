<?php
include("../_dbConnect.php");

// Start or resume the existing session
// session_start();

// Check if the user is already logged out
if (!isset($_SESSION['user_id'])) {
    // Redirect the user to the login page if they are not logged in
    header("location: login.php");
    exit();
}
session_unset();

// Destroy the session data to log the user out
session_destroy();

// Redirect the user to the login page after logging out
header("location: home.php");
exit();
