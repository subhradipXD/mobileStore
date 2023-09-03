<?php

$randomNumber = (string)mt_rand(100, 999);

$user_id = $_SESSION['user_id'];

$cart_id = $user_id.$randomNumber;

$cartQuery = "INSERT INTO cart (cartid, userid) VALUES ('$cart_id', '$user_id')";

$result = mysqli_query($conn, $cartQuery);

if($result){
    echo '<form action="addToCart.php" method="get">';
}
?>