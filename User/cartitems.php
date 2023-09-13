<?php
include("../_dbConnect.php");

if (!isset($_SESSION['user_id'])) {
    // Redirect the user to the login page if they are not logged in
    header("location: login.php");
    exit();
}

// Retrieve user-specific information
$user_id = $_SESSION['user_id'];
$name = $_SESSION['name'];
$email = $_SESSION['email'];

$sql = "SELECT p.proimage, ci.proid, p.name, p.brand, p.price, ci.quan FROM cart ci
        JOIN product p ON ci.proid = p.proid
        WHERE ci.userid = ?";
$stmt = mysqli_prepare($conn, $sql);
$stmt->bind_param('s', $user_id);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="styles.css"> <!-- Add your CSS file here -->
</head>
<body>
    <header>
        <h1>Your Shopping Cart</h1>
        <nav>
            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
        </nav>
    </header>

    <section class="cart-items">
        <h2>Cart Items</h2>

        <?php
        // Check if there are any items in the cart
        if ($result->num_rows > 0) {
            // Display cart items using a loop
            $total=0;
            while ($row = $result->fetch_assoc()) {
                echo '<div class="cart-item">';
                echo '<p> <img src="'.$row['proimage'].'"></p>';
                echo '<h2>' . $row['brand'] . '</h2>';
                echo '<h3>' . $row['name'] . '</h3>';
                echo '<p>Price: ₹' . $row['price'] . '</p>';
                echo '<p>Quantity: ' . $row['quan'] . '</p>';
                echo '<p>Total: ₹' . ($row['price'] * $row['quan']) . '</p>';
                $total += ($row['price'] * $row['quan']);
                // You can add a "Remove" button here to remove items from the cart
                echo '</div>';
                echo "<h1>Total Cart Price: ₹".$total."</h1>";
            }
        } else {
            echo 'Your cart is empty.';
        }
        ?>
    </section>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Mobile Store</p>
    </footer>
</body>
</html>
