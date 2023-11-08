<?php
// Include database connection code here
// include("../_dbConnect.php");

// session_start(); // Start the session if it hasn't been started already

if (!isset($_SESSION['user_id'])) {
    // Redirect the user to the login page if they are not logged in
    header("location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$prod_id = $_GET['product_id'];
// Check if a cart already exists for the user
$cartQuery = "SELECT quan FROM cart WHERE userid = '$user_id' and proid='$prod_id'";

$result = mysqli_query($conn, $cartQuery);

if (mysqli_num_rows($result) > 0) {

    // If a cart already exists, retrieve the cart ID
    $row = mysqli_fetch_assoc($result);

    $quan = $row['quan'] + 1;
    $updateQ = "update cart set quan = '$quan' where userid = '$user_id' and proid='$prod_id'";
} else {
    // Insert the cart ID and user ID into the cart table
    $updateQ = "INSERT INTO cart (userid, proid) VALUES ('$user_id', '$prod_id')";
}
if (mysqli_query($conn, $updateQ)) {
    // The cart has been created successfully, now you can proceed with adding products to the cart
    header("location:home.php");
    exit();
} else {
    echo 'Error creating the cart.';
}
