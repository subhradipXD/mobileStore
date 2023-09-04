<?php
// Include database connection code here
include("../_dbConnect.php");

echo "Reached Cart.php";


// session_start(); // Start the session if it hasn't been started already

if (!isset($_SESSION['user_id'])) {
    // Redirect the user to the login page if they are not logged in
    header("location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Check if a cart already exists for the user
$cartQuery = "SELECT cartid FROM cart WHERE userid = '$user_id'";
$result = mysqli_query($conn, $cartQuery);

if (mysqli_num_rows($result) > 0) {

    // If a cart already exists, retrieve the cart ID
    $row = mysqli_fetch_assoc($result);
    $cart_id = $row['cartid'];
    echo '<form action="addToCart.php" method="GET">';

} else {
    // If a cart doesn't exist, generate a new cart ID
    $randomNumber = (string)mt_rand(100, 999);
    $cart_id = $user_id . $randomNumber;

    // Insert the cart ID and user ID into the cart table
    $insertCartQuery = "INSERT INTO cart (cartid, userid) VALUES ('$cart_id', '$user_id')";

    if (mysqli_query($conn, $insertCartQuery)) {
        // The cart has been created successfully, now you can proceed with adding products to the cart.
        echo '<form action="addToCart.php" method="GET">';
    } else {
        echo 'Error creating the cart.';
    }
}
