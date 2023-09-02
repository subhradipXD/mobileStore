<?php
// Include your database connection code here
include("../_dbConnect.php");

// Validate and sanitize user input
$product_id = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
$quantity = filter_input(INPUT_POST, 'quantity', FILTER_VALIDATE_INT);

if ($product_id === false || $quantity === false) {
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
    $sql = "INSERT INTO cartitems (cartid, productid, quan) VALUES (?, ?, ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('iii', $cart_id, $product_id, $quantity);
    $stmt->execute();
} else {
    // Product is in the cart, update quantity
    $row = $result->fetch_assoc();
    $new_quantity = $row['quan'] + $quantity;

    $sql = "UPDATE cartitems SET quan = ? WHERE cartid = ? AND productid = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('iii', $new_quantity, $cart_id, $product_id);
    $stmt->execute();
}

// Redirect back to the product page with a success message or to another appropriate location
header('Location: ../WSPage/home.php?added_to_cart=true');
?>
