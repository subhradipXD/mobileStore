<?php
require("../_dbConnect.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Your Mobile Store</title>
    <style>
        /* Add your CSS styles here for page customization */
    </style>
</head>
<body>
    <header>
        <!-- Include your website's header or navigation bar here -->
        <!-- Example: -->
        <nav>
            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="contact.php">Contact Us</a></li>
            </ul>
        </nav>
    </header>

    <section>
        <h1>Contact Us</h1>
        <p>If you have any questions, feedback, or need assistance, please feel free to contact us. We're here to help!</p>
        <p>You can reach us through the following methods:</p>
        
        <div>
            <h2>Email</h2>
            <p>Email: <a href="mailto:contact@yourmobilestore.com">contact@yourmobilestore.com</a></p>
        </div>

        <div>
            <h2>Phone</h2>
            <p>Customer Support: +1 (123) 456-7890</p>
        </div>

        <div>
            <h2>Address</h2>
            <p>123 Main Street<br>City, State ZIP Code<br>Country</p>
        </div>
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
