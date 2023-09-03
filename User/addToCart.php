<?php
include("../_dbConnect.php");

// Validate and sanitize user input
$product_id = filter_input(INPUT_GET, 'product_id', FILTER_VALIDATE_INT);

if ($product_id === false) {
    die('Invalid input');
}

// Check if the product is already in the user's cart
$cart_id = $_SESSION['cart_id'];
$sql = "SELECT quan FROM cartitems WHERE cartid = ? AND productid = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param('ii', $cart_id, $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    // Product is not in the cart, insert it
    $sql = "INSERT INTO cartitems (cartid, productid, quan) VALUES (?, ?, 1)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('ii', $cart_id, $product_id);
    $stmt->execute();
} else {
    // Product is in the cart, update quantity
    $row = $result->fetch_assoc();
    $new_quantity = $row['quan'] + 1;

    $sql = "UPDATE cartitems SET quan = ? WHERE cartid = ? AND productid = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('iii', $new_quantity, $cart_id, $product_id);
    $stmt->execute();
}

// Redirect back to the product page with a success message or to another appropriate location
header('Location: home.php?added_to_cart=true');
?>
