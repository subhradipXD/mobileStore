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

// You can also query additional user information from the database if needed
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Mobile Store</title>
    <link rel="stylesheet" href="profile.css"> <!-- Add your CSS file here -->
</head>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Mobile Store</title>
    <link rel="stylesheet" href="profile.css"> 
</head>

<body>
    <header>
        
        <nav>
            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="../WSPage/contact.php">Contact</a></li>
                <li><a href="../WSPage/about.php">About Us</a></li>
                <li><a href="profile.php"><img src="">Profile</a></li>
                <li><a href="cartitems.php">Cart</a></li>
                <li><a href="logout.php">Log Out</a></li>
            </ul>
        </nav>

        <h1>Welcome to Your Profile</h1>
    </header>

    <section class="user-profile">
        <h2>Your Profile Information</h2>
        <p>User ID: <?php echo $user_id; ?></p>
        <p>Name: <?php echo $name; ?></p>
        <p>Email: <?php echo $email; ?></p>

        <!-- Display user's profile picture
        <?php
        // Assuming you have a column named 'profile_pic' to store the profile picture in the database
        // $sql = "SELECT propic FROM users WHERE userid = $user_id";
        // $result = mysqli_query($conn, $sql);

        // if ($result && mysqli_num_rows($result) > 0) {
        //     $row = mysqli_fetch_assoc($result);
        //     $profilePicData = $row['propic'];
        //     if (!empty($profilePicData)) {
        //         $profilePicBase64 = base64_encode($profilePicData);
        //         $profilePicSrc = "data:image/jpeg;base64," . $profilePicBase64;
        //         echo '<img src="' . $profilePicSrc . '" alt="Profile Picture">';
        //     } else {
        //         echo '<p>No profile picture available.</p>';
        //     }
        // } else {
        //     echo '<p>Error fetching profile picture.</p>';
        // }
        ?> -->
    </section>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Mobile Store</p>
    </footer>
</body>

</html>
