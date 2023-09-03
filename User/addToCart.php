<?php
include("../_dbConnect.php");
echo "Reached addToCart.php";

// Validate and sanitize user input
$product_id = filter_var($_GET['product_id'], FILTER_SANITIZE_STRING);

if ($product_id === false) {
    die('Invalid input');
}

// Check if the user is logged in and has an active cart
// session_start();

if (!isset($_SESSION['user_id']) || !isset($_SESSION['cart_id'])) {
    // Redirect the user to an appropriate page (e.g., the homepage) with an error message
    header('Location: home.php?error=not_logged_in');
    exit();
}

$cart_id = $_SESSION['cart_id'];

// Check if the product exists in the database
$sql = "SELECT * FROM product WHERE proid = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 's', $product_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) === 0) {
    // Product not found in the database, redirect with an error message
    header('Location: home.php?error=product_not_found');
    exit();
}

// Check if the user's cart already contains this product
$sql = "SELECT * FROM cartitems WHERE cartid = ? AND proid = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'ss', $cart_id, $product_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) === 0) {
    // Product is not in the cart, insert it with a quantity of 1
    $sql = "INSERT INTO cartitems (cartid, proid, quan) VALUES (?, ?, 1)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'ss', $cart_id, $product_id);
    mysqli_stmt_execute($stmt);
} else {
    // Product is in the cart, update quantity
    $row = mysqli_fetch_assoc($result);
    $new_quantity = $row['quan'] + 1;

    $sql = "UPDATE cartitems SET quan = ? WHERE cartid = ? AND proid = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'iss', $new_quantity, $cart_id, $product_id);
    mysqli_stmt_execute($stmt);
}

// Redirect back to the product page with a success message or to another appropriate location
header('Location: home.php?added_to_cart=true');
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