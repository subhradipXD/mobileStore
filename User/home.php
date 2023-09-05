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

    // Query to fetch products from the database
    $sql = "SELECT * FROM product";
    $result = mysqli_query($conn, $sql);

    ?>

<!DOCTYPE html>
<html lang="en">
<!-- ... rest of your HTML code ... -->


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mobile Store</title>
    <link rel="stylesheet" href="home.css"> <!-- Add your CSS file here -->
</head>

<body>
    <header>
        <div id="navbar">
        <nav>
            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="../WSPage/contact.php">Contact</a></li>
                <li><a href="../WSPage/about.php">About Us</a></li>
                <li><a href="profile.php"><img src="">Profile</a></li>
                <li><a href="cartitems.php">Cart</a></li> <!-- Link to your shopping cart page -->
                <li><a href="logout.php">Log Out</a></li>
            </ul>
        </nav>
        </div>
        <img src="logo\1.png" alt="Logo" class="image">
        <h1>Welcome to Mobile Book</h1>
    </header>
    <h2 id="fp">Featured Products</h2>
    <section class="featured-products">

        <?php
        // Check if there are any products in the database
        if (mysqli_num_rows($result) > 0) {
            // Output each product's details using a loop
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="product">';
                echo '<img src="' . $row['proimage'] . '" alt="' . $row['name'] . '">';
                echo '<h3>' . $row['name'] . '</h3>';
                echo '<p>Brand: ' . $row['brand'] . '</p>';

                if ($row['quan'] > 0) {
                    // Product is in stock, display price and add to cart button
                    echo '<p>Price: ₹' . $row['price'] . '</p>';
                    echo '<form action="cart.php" method="get">';
                    echo '<input type="hidden" name="product_id" value="' . $row['proid'] . '">';
                    echo '<button type="submit">Add to Cart</button>';
                    echo '</form>';
                } else {
                    // Product is out of stock
                    echo '<p>Out of Stock</p>';
                }

                echo '</div>';
            }
        } else {
            echo 'No products found.';
        }
        ?>
    </section>

    <section class="about-us">
        <a href="../WSPage/about.php"><h2>About Us</h2></a>
        <p>We offer a wide range of mobile phones and accessories. Shop with us for the latest smartphones at great prices.</p>
    </section>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Mobile Store</p>
    </footer>
</body>

</html>