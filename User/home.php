<?php
// Include your database connection code here

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

echo $name;

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mobile Store</title>
    <link rel="stylesheet" href="styles.css"> <!-- Add your CSS file here -->
</head>
<body>
    <header>
        <h1>Welcome to Mobile Store</h1>
        <nav>
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="cart.php">Cart</a></li> <!-- Link to your shopping cart page -->
                <li><a href="#">Contact</a></li>
            </ul>
        </nav>
    </header>

    <section class="featured-products">
        <h2>Featured Products</h2>

        <?php

        // SQL query to retrieve product details

        $sql = "SELECT proid, name, price, quan, brand, proimage FROM product";

        // Execute the query
        $result = $mysqli->query($sql);

        // Check if there are any results
        if ($result->num_rows > 0) {
            // Output each product's details
            while ($row = $result->fetch_assoc()) {
                echo '<div class="product">';
                echo '<img src="' . $row['proimage'] . '" alt="' . $row['name'] . '">';
                echo '<h3>' . $row['name'] . '</h3>';
                echo '<p>Price: $' . $row['price'] . '</p>';
                echo '<p>Available Quantity: ' . $row['quan'] . '</p>';
                echo '<p>Brand: ' . $row['brand'] . '</p>';
                echo '<a href="../User/addToCart.php?product_id=' . $row['proid'] . '">Add to Cart</a>';
                echo '</div>';
            }
        } else {
            echo 'No products found.';
        }

        // Close the database connection
        // $mysqli->close();
        ?>
    </section>

    <section class="about-us">
        <h2>About Us</h2>
        <p>We offer a wide range of mobile phones and accessories. Shop with us for the latest smartphones at great prices.</p>
    </section>

    <footer>
        <p>&copy; 2023 Mobile Store</p>
    </footer>
</body>
</html>
