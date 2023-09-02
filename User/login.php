<?php
include("../_dbConnect.php");


$message = ""; // To store login messages

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $emailOrId = $_POST['email_or_id'];
    $password = $_POST['password'];

    // Check if the email or ID exists in the database
    $query = "SELECT * FROM users WHERE email = '$emailOrId' OR userid = '$emailOrId'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        if ($password === $row['password']) {
            $message = "Login successful!";
        } else {
            $message = "Incorrect password.";
        }
    } else {
        $message = "Account does not exist.";
    }
}

mysqli_close($conn);
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="logins.css">
</head>
<body>

<header>
        <img src="path_to_your_logo.png" alt="Logo">
        <nav>
            <a href="home.php">Home</a>
            <a href="about.php">About</a>
            <a href="contact.php">Contact</a>
        </nav>
    </header>

    <h1>Please Login Here</h1>

    <form action="login.php" method="post">
        <br>
        <label for="email_or_id">Enter Email or ID</label>
        <input type="text" placeholder="Email or ID" name="email_or_id" required>

        <label for="password">Enter Password</label>
        <input type="password" placeholder="Password" name="password" required>
        
        <button type="submit">Login</button>
        <br>
        <a href="frgtpass.php" style="font-weight: 200; text-decoration:none; color:blue;">Forgot Password?</a>
        <br>   
        <a href="reg.php" style="font-weight: 200; text-decoration:none; color:blue;">Don't have an account?</a>
        <br>
    </form>

    <?php echo $message; ?>

    <footer>
        &copy; <?php echo date("Y"); ?> Your Website. All rights reserved.
    </footer>
</body>
</html>