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
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mobile Store</title>
    <link rel="stylesheet" href="home.css"> <!-- Add your CSS file here -->
    <style>
        * {
            box-sizing: border-box
        }

        body {
            font-family: Verdana, sans-serif;
            margin: 0
        }

        .mySlides {
            display: none
        }

        img {
            vertical-align: middle;
        }

        /* Slideshow container */
        .slideshow-container {
            max-width: 1000px;
            position: relative;
            margin: auto;
        }

        /* Next & previous buttons */
        .prev,
        .next {
            cursor: pointer;
            position: absolute;
            top: 50%;
            width: auto;
            padding: 16px;
            margin-top: -22px;
            color: white;
            font-weight: bold;
            font-size: 18px;
            transition: 0.6s ease;
            border-radius: 0 3px 3px 0;
            user-select: none;
        }

        /* Position the "next button" to the right */
        .next {
            right: 0;
            border-radius: 3px 0 0 3px;
        }

        /* On hover, add a black background color with a little bit see-through */
        .prev:hover,
        .next:hover {
            background-color: rgba(0, 0, 0, 0.8);
        }

        /* Caption text */
        .text {
            color: #f2f2f2;
            font-size: 15px;
            padding: 8px 12px;
            position: absolute;
            bottom: 8px;
            width: 100%;
            text-align: center;
        }

        /* Number text (1/3 etc) */
        .numbertext {
            color: #f2f2f2;
            font-size: 12px;
            padding: 8px 12px;
            position: absolute;
            top: 0;
        }

        /* The dots/bullets/indicators */
        .dot {
            cursor: pointer;
            height: 15px;
            width: 15px;
            margin: 0 2px;
            background-color: #bbb;
            border-radius: 50%;
            display: inline-block;
            transition: background-color 0.6s ease;
        }

        .active,
        .dot:hover {
            background-color: #717171;
        }

        /* Fading animation */
        .fade {
            animation-name: fade;
            animation-duration: 1.5s;
        }

        @keyframes fade {
            from {
                opacity: .4
            }

            to {
                opacity: 1
            }
        }

        /* On smaller screens, decrease text size */
        @media only screen and (max-width: 300px) {

            .prev,
            .next,
            .text {
                font-size: 11px
            }
        }
    </style>

</head>

<body>
    <header>
        <div id="navbar">
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
        </div>
        <img src="logo\1.png" alt="Logo" class="image">
        <h1>Welcome to Mobile Book</h1>
    </header>
    <div class="slideshow-container">

        <div class="mySlides fade">
            <div class="numbertext">1 / 2</div>
            <img src="..\Admin\productImages\banner\Banner1.png" style="width:100%">
            <div class="text"><b>Buy Now</b></div>
        </div>

        <div class="mySlides fade">
            <div class="numbertext">2 / 2</div>
            <img src="..\Admin\productImages\banner\Banner2.png" style="width:100%">
            <div class="text"><b>Buy Now</b></div>
        </div>

        <a class="prev" onclick="plusSlides(-1)">❮</a>
        <a class="next" onclick="plusSlides(1)">❯</a>

    </div>
    <br>

    <div style="text-align:center">
        <span class="dot" onclick="currentSlide(1)"></span>
        <span class="dot" onclick="currentSlide(2)"></span>
    </div>

    <script>
        let slideIndex = 1;
        showSlides(slideIndex);

        function plusSlides(n) {
            showSlides(slideIndex += n);
        }

        function currentSlide(n) {
            showSlides(slideIndex = n);
        }

        function showSlides(n) {
            let i;
            let slides = document.getElementsByClassName("mySlides");
            let dots = document.getElementsByClassName("dot");
            if (n > slides.length) {
                slideIndex = 1
            }
            if (n < 1) {
                slideIndex = slides.length
            }
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
            }
            slides[slideIndex - 1].style.display = "block";
            dots[slideIndex - 1].className += " active";
        }
    </script>

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
                    $pid = $row['proid'];
                    $quary = "select * from cart where userid = '$user_id' and proid = '$pid'";
                    $res = mysqli_query($conn, $quary);
                    if (mysqli_num_rows($res) == 0) {
                        echo '<form action="cart.php" method="get">';
                        echo '<input type="hidden" name="product_id" value="' . $row['proid'] . '">';
                        echo '<button type="submit">Add to Cart</button>';
                        echo '</form>';
                    } else {
                        echo "<p style='color:red;'>Added</p>";
                    }
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
        <a href="../WSPage/about.php">
            <h2>About Us</h2>
        </a>
        <p>We offer a wide range of mobile phones and accessories. Shop with us for the latest smartphones at great prices.</p>
    </section>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Mobile Store</p>
    </footer>

    
</body>

</html>