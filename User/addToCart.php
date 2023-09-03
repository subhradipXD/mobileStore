<?php
include("../_dbConnect.php");

// Validate and sanitize user input
$product_id = filter_var($_GET['product_id'], FILTER_SANITIZE_STRING);

if ($product_id === false) {
    die('Invalid input');
}

// Check if the product is already in the user's cart
$cart_id = $_SESSION['cart_id'];

// Check if the product exists in the database
$sql = "SELECT * FROM products WHERE ProductID = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 's', $product_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) === 0) {
    die('Product not found in the database.');
}

// Check if the user's cart already contains this product
$sql = "SELECT * FROM cartitems WHERE CartID = ? AND ProductID = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'ss', $cart_id, $product_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) === 0) {
    // Product is not in the cart, insert it
    $sql = "INSERT INTO cartitems (CartID, ProductID, Quantity) VALUES (?, ?, 1)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'ss', $cart_id, $product_id);
    mysqli_stmt_execute($stmt);
} else {
    // Product is in the cart, update quantity
    $row = mysqli_fetch_assoc($result);
    $new_quantity = $row['Quantity'] + 1;

    $sql = "UPDATE cartitems SET Quantity = ? WHERE CartID = ? AND ProductID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'iss', $new_quantity, $cart_id, $product_id);
    mysqli_stmt_execute($stmt);
}

// Redirect back to the product page with a success message or to another appropriate location
header('Location: home.php?added_to_cart=true');
?>
