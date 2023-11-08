<?php
include("../_dbConnect.php");

include("reCAPTCHA.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $emailOrId = $_POST['email_or_id'];
    $password = $_POST['password'];

    $secretKey = $reCAP;
    $resposnseKey = $_POST['g-recaptcha-response'];
    $UserIP = $_SERVER['REMOTE_ADDR'];
    $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$resposnseKey&remoteip=$UserIP";

    $response = file_get_contents($url);
    $response = json_decode($response);

    if ($response->success) {

        // Check if the email or ID exists in the database
        $query = "SELECT * FROM users WHERE email = '$emailOrId' OR userid = '$emailOrId'";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            if ($password === $row['password']) {
                // Store user information in session
                $_SESSION['user_id'] = $row['userid'];
                $_SESSION['name'] = $row['name'];
                $_SESSION['email'] = $row['email'];

                // Create a unique cart for the user (if it doesn't exist)
                if (!isset($_SESSION['cart_id'])) {
                    // Generate a unique cart ID for the user (e.g., user's ID + current timestamp)
                    $cart_id = $row['userid'] . '_' . time();

                    // Store the cart ID in the session
                    $_SESSION['cart_id'] = $cart_id;
                }

                // Redirect to the user's home page
                header("location: home.php");
                exit(); // Make sure to exit after redirecting
            } else {
                $errorMessage = "Incorrect password.";
            }
        } else {
            $errorMessage = "Account does not exist";
        }
    } else {
        echo "CAPTCHA Failed!";
    }
}

mysqli_close($conn);
?>

<!-- ... HTML for the login form ... -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        .error-message {
            text-align: center;
            color: red;
            font-weight: bold;
            margin-top: 10px;
        }

        /* Add the following styles for positioning the error message */
        .error-message {
            position: absolute;
            bottom: 10px;
            left: 50%;
            transform: translateX(-50%);
            width: 100%;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="logins.css">

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <script>
        function validateLoginForm() {
            var emailOrId = document.forms["loginForm"]["email_or_id"].value;
            var password = document.forms["loginForm"]["password"].value;

            if (emailOrId.trim() === "") {
                alert("Please enter your email or ID");
                return false;
            }

            if (password.trim() === "") {
                alert("Please enter your password");
                return false;
            }

            return true;
        }
    </script>

</head>

<body>

    <header>
        <nav>
            <a href="home.php">Home</a>
            <a href="../WSPage/about.php">About</a>
            <a href="../WSPage/contact.php">Contact</a>
        </nav>
        <img src="logo\2.png" alt="Logo" class="image">
    </header>

    <h1>Please Login Here</h1>

    <form action="login.php" method="post" onsubmit="return validateLoginForm()" name="loginForm">
        <br>
        <label for="email_or_id">Enter Email or ID</label>
        <input type="text" placeholder="Email or ID" name="email_or_id" required>

        <label for="password">Enter Password</label>
        <input type="password" placeholder="Password" name="password" required>

        <div class="g-recaptcha" data-sitekey="6LegHPcnAAAAAMQEyuMAjp3eBKJJmaXLRyBAii3g"></div>

        <button type="submit">Login</button>
        <br>
        <div class="error-message">
            <?php
            if (isset($errorMessage)) {
                echo $errorMessage;
            }
            ?>
        </div>
        <br>
        <a href="reg.php" style="font-weight: 200; text-decoration:none; color:blue;">Don't have an account? Register Here</a>
        <br>
    </form>

    <footer>
        &copy; <?php echo date("Y"); ?> Your Website. All rights reserved.
    </footer>
</body>

</html>