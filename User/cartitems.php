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

// Handle quantity updates
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_quantity'])) {
    $proid = $_POST['proid'];
    $quantity = $_POST['quantity'];

    if ($_POST['update_quantity'] === '+') {
        // Increment quantity
        $quantity++;
    } elseif ($_POST['update_quantity'] === '-') {
        // Decrement quantity (if not already 1)
        if ($quantity > 1) {
            $quantity--;
        }
    }

    // Update the quantity in the database
    $update_query = "UPDATE cart SET quan = ? WHERE userid = ? AND proid = ?";
    $update_stmt = mysqli_prepare($conn, $update_query);
    $update_stmt->bind_param('iss', $quantity, $user_id, $proid);

    if ($update_stmt->execute()) {
        // Quantity updated successfully
        header("location: cartitems.php");
        exit();
    }
}

// Handle item deletion
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_item'])) {
    $proid = $_POST['proid'];

    // Delete the item from the cart
    $delete_query = "DELETE FROM cart WHERE userid = ? AND proid = ?";
    $delete_stmt = mysqli_prepare($conn, $delete_query);
    $delete_stmt->bind_param('ss', $user_id, $proid);

    if ($delete_stmt->execute()) {
        // Item deleted successfully
        header("location: cartitems.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="cartitems.css"> <!-- Add your CSS file here -->
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="../WSPage/contact.php">Contact Us</a></li>
                <li><a href="../WSPage/about.php">About Us</a></li>
                <li><a href="profile.php"><img src="">Profile</a></li>
                <li><a href="cartitems.php">Cart</a></li>
                <li><a href="logout.php">Log Out</a></li>
            </ul>
        </nav>
    </header>

    <section class="cart-items">
        <h2>Cart Items</h2>

        <?php
        // Check if there are any items in the cart
        if ($result->num_rows > 0) {
            // Display cart items using a loop
            $total = 0;
            while ($row = $result->fetch_assoc()) {
                echo '<div class="cart-item">';
                echo '<p> <img src="' . $row['proimage'] . '"></p>';
                echo '<h2>' . $row['brand'] . '</h2>';
                echo '<h3>' . $row['name'] . '</h3>';
                echo '<p>Price: ₹' . $row['price'] . '</p>';
                echo '<form method="post">';
                echo '<p>Quantity: <span id="quantity_' . $row['proid'] . '">' . $row['quan'] . '</span> ';

                // Plus button (+)
                echo '<button type="submit" name="update_quantity" value="+" class="cart-button">+</button> ';

                // Minus button (-)
                echo '<button type="submit" name="update_quantity" value="-" class="cart-button">-</button> ';

                // Delete button
                echo '<button type="submit" name="delete_item" class="cart-button">Remove</button></p>';
                
                // Hidden inputs to pass data
                echo '<input type="hidden" name="proid" value="' . $row['proid'] . '">';
                echo '<input type="hidden" name="quantity" value="' . $row['quan'] . '">';
                echo '</form>';

                echo '<p>Total: ₹' . ($row['price'] * $row['quan']) . '</p>';
                $total += ($row['price'] * $row['quan']);
                echo '</div>';
            }
            echo "<h1>Total Cart Price: ₹" . $total . "</h1>";
            if ($result->num_rows > 0) {
                // Display the "Buy Now" button if the cart is not empty
                echo '<form action="payment.php" method="get">';
                echo '<input type="hidden" name="total_price" value="' . $total . '">';
                echo '<button type="submit" name="buy_now" class="buy-now-button">Buy Now</button>';
                echo '</form>';
            } else {
                // Display a message if the cart is empty
                echo '<p class="empty-cart-message">Your cart is empty. You cannot proceed to payment.</p>';
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
