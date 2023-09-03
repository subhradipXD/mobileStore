<?php
include("../_dbConnect.php");

// Validate and sanitize user input
$product_id = filter_var($_GET['product_id'], FILTER_SANITIZE_STRING);
// echo $_GET['product_id'];
echo $product_id;

if ($product_id === false) {
    die('Invalid input');
}

// Check if the product is already in the user's cart
$cart_id = $_SESSION['cart_id'];
$sql = "SELECT quan FROM cartitems WHERE cartid = ? AND proid = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ss', $cart_id, $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    // Product is not in the cart, insert it
    $sql = "INSERT INTO cartitems (cartid, proid, quan) VALUES (?, ?, 1)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $cart_id, $product_id);
    $stmt->execute();
} else {
    // Product is in the cart, update quantity
    $row = $result->fetch_assoc();
    $new_quantity = $row['quan'] + 1;

    $sql = "UPDATE cartitems SET quan = ? WHERE cartid = ? AND proid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('iss', $new_quantity, $cart_id, $product_id);
    $stmt->execute();
}

// Redirect back to the product page with a success message or to another appropriate location
header('Location: home.php?added_to_cart=true');
?>
