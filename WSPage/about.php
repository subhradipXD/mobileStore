<?php
require("../_dbConnect.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Your Mobile Store</title>
    <link rel="stylesheet" href="about.css"> <!-- Add your CSS file here -->
    
</head>
<body>
    <header>
        <!-- Include your website's header or navigation bar here -->
        <!-- Example: -->
        <nav>
            <ul>
                <li><a href="../User/home.php">Home</a></li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="contact.php">Contact Us</a></li>
                <li><a href="../User/profile.php">Profile</a></li>
                <li><a href="../User/cart.php">Cart</a></li>
                <li><a href="../User/logout.php">Log Out</a></li>
            </ul>
        </nav>
    </header>

    <section>
        <h1>About Us</h1>
        <p>Welcome to Your Mobile Store, your one-stop destination for the latest and greatest mobile devices. We are dedicated to providing you with the best mobile shopping experience.</p>
        <p>Our mission is to offer a wide selection of high-quality mobile phones and accessories at competitive prices. We understand the importance of staying connected in today's fast-paced world, and we strive to make the latest technology accessible to everyone.</p>
        <p>At Your Mobile Store, we believe in customer satisfaction above all else. Our team of experts is here to assist you in finding the perfect mobile device that suits your needs. Whether you're looking for a flagship smartphone, a budget-friendly option, or accessories to enhance your mobile experience, we've got you covered.</p>
        <p>Thank you for choosing Your Mobile Store for all your mobile shopping needs. We look forward to serving you and helping you stay connected with the world.</p>
    </section>

    <footer>
        <!-- Include your website's footer here -->
        <!-- Example: -->
        <div class="footer-content">
            <p>&copy; <?php echo date("Y"); ?> Your Mobile Store</p>
            <ul>
                <li><a href="#">Privacy Policy</a></li>
                <li><a href="#">Terms of Service</a></li>
            </ul>
        </div>
    </footer>
</body>
</html>
