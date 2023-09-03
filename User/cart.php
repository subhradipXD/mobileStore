<?php
// Include database connection code here
include("../_dbConnect.php");

// session_start(); // Start the session if it hasn't been started already

if (!isset($_SESSION['user_id'])) {
    // Redirect the user to the login page if they are not logged in
    header("location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Generate a random cart ID
$randomNumber = (string)mt_rand(100, 999);
$cart_id = $user_id . $randomNumber;

// Insert the cart ID and user ID into the cart table
$cartQuery = "INSERT INTO cart (cartid, userid) VALUES ('$cart_id', '$user_id')";

if (mysqli_query($conn, $cartQuery)) {
    // The cart has been created successfully, now you can proceed with adding products to the cart.
    echo '<form action="addToCart.php" method="get">';
} else {
    echo 'Error creating the cart.';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

</body>

</html>