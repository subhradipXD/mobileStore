<?php
include("../_dbConnect.php");
include("reCAPTCHA.php");

$message = ""; // To store login messages

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $emailOrId = $_POST['email_or_id'];
    $password = $_POST['password'];

    $secretKey = $reCAP; // Make sure $reCAP is defined in your reCAPTCHA.php file
    $responseKey = $_POST['g-recaptcha-response']; // Fix the variable name here
    $userIP = $_SERVER['REMOTE_ADDR'];
    $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$responseKey&remoteip=$userIP";

    $response = file_get_contents($url);
    $response = json_decode($response);

    if ($response->success) {
        // Check if the email or ID exists in the adminreg table
        $query = "SELECT * FROM adminreg WHERE ademail = '$emailOrId' OR adid = '$emailOrId'";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            if ($password === $row['adpassword']) {
                // Store admin information in session
                session_start(); // Start the session if not already started
                $_SESSION['admin_id'] = $row['adid'];
                $_SESSION['admin_email'] = $row['ademail'];

                // Redirect to the admin home page after successful login
                header("location: product.php");
                exit(); // Make sure to exit to prevent further code execution
            } else {
                $message = "Incorrect password.";
            }
        } else {
            $message = "Admin account does not exist.";
        }
    } else {
        echo "CAPTCHA Failed!";
    }
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" type="text/css" href="logins.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body>
    <header>
        <img src="path_to_your_logo.png" alt="Logo">
        <nav>
            <a href="admin_home.php">Admin Home</a>
            <a href="admin_dashboard.php">Admin Dashboard</a>
            <a href="admin_contact.php">Admin Contact</a>
        </nav>
    </header>

    <h1>Admin Login</h1>

    <form action="" method="post"> <!-- Removed the action attribute -->
        <br>
        <label for="email_or_id">Enter Email or ID</label>
        <input type="text" placeholder="Email or ID" name="email_or_id" required>

        <label for="password">Enter Password</label>
        <input type="password" placeholder="Password" name="password" required>

        <div class="g-recaptcha" data-sitekey="6LegHPcnAAAAAMQEyuMAjp3eBKJJmaXLRyBAii3g"></div>

        <button type="submit">Login</button>
        <br>
    </form>

    <?php echo $message; ?>

    <footer>
        &copy; <?php echo date("Y"); ?> Your Website. All rights reserved.
    </footer>
</body>

</html>
