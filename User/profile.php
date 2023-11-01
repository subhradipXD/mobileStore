<?php
// Prevent caching of this page
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

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

// Update User Information
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_user'])) {
    $new_name = $_POST['new_name'];
    $new_email = $_POST['new_email'];

    // Calculate the new user ID based on the first 4 letters of the new name
    $new_user_id = substr($new_name, 0, 4);

    // Retrieve the last 3 numbers of the previous user ID
    $last_4_numbers = substr($user_id, -3);

    // Concatenate the new user ID with the last 4 numbers of the previous user ID
    $new_user_id .= $last_4_numbers;

    // Query to update user information and user ID
    $update_query = "UPDATE users SET name = '$new_name', email = '$new_email', userid = '$new_user_id' WHERE userid = '$user_id'";


    if (mysqli_query($conn, $update_query)) {
        // User information and user ID updated successfully
        $name = $new_name; // Update the name
        $email = $new_email; // Update the email
        $user_id = $new_user_id; // Update the user ID

        // Update the session variables with the new data
        $_SESSION['name'] = $new_name;
        $_SESSION['email'] = $new_email;
        $_SESSION['user_id'] = $new_user_id;

        // Redirect to the profile page with the updated information
        header("location: profile.php");
        exit();
    } else {
        // Handle the database update error
        echo "User information update failed: " . mysqli_error($conn);
    }
}

// Update Password
$password_update_message = ""; // Initialize an empty message

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_password'])) {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];

    if ($old_password == $new_password) {
        // If old and new passwords are the same, display a message
        $password_update_message = "Old and new passwords are the same. No changes made.";
    } else {
        // Verify the old password before updating
        $check_password_query = "SELECT password FROM users WHERE userid = '$user_id'";
        $result = mysqli_query($conn, $check_password_query);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $stored_password = $row['password'];

            // Verify the old password
            if ($old_password == $stored_password) {
                // Old password matches, update the password
                $update_password_query = "UPDATE users SET password = '$new_password' WHERE userid = '$user_id'";

                if (mysqli_query($conn, $update_password_query)) {
                    // Password updated successfully
                    $password_update_message = "Password updated successfully."; // Set the success message
                } else {
                    // Handle the database update error
                    $password_update_message = "Password update failed: " . mysqli_error($conn);
                }
            } else {
                // Old password doesn't match
                $password_update_message = "Old password is incorrect. Please try again.";
            }
        } else {
            // Handle the database query error
            $password_update_message = "Error checking old password: " . mysqli_error($conn);
        }
    }
}



// Delete Account
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_account'])) {
    $confirm_delete = $_POST['confirm_delete'];

    if ($confirm_delete === 'DELETE') {

        $delete_query = "DELETE FROM users WHERE userid = '$user_id'";

        if (mysqli_query($conn, $delete_query)) {
            session_destroy(); // Destroy the user's session
            header("location: ../WSPage/index.php"); // Redirect to a confirmation page
            exit();
        } else {
            // Handle the database deletion error
            echo "Account deletion failed: " . mysqli_error($conn);
        }

    } else {
        // Display an error message indicating that the confirmation text is incorrect
        echo "Confirmation text is incorrect.";
    }
}
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
                <li><a href="../WSPage/contact.php">Contact Us</a></li>
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

    </section>

    <section class="update-user">
    <h2>Update User Information</h2>
    <form action="" method="post">
        <label for="new_name">New Name:</label>
        <input type="text" name="new_name" value="<?php echo $name; ?>" required>

        <label for="new_email">New Email:</label>
        <input type="email" name="new_email" value="<?php echo $email; ?>" required>

        <label for="old_password">Old Password:</label>
        <input type="password" name="old_password" required>

        <label for="new_password">New Password:</label>
        <input type="password" name="new_password" required>

        <button type="submit" name="update_user">Update User Info</button>
        <button type="submit" name="update_password">Update Password</button>
    </form>
    <!-- Display the password update message -->
    <div class="update-message"><?php echo $password_update_message; ?></div>
</section>



    <section class="account-delete">
        <h2>Delete Account</h2>
        <p>WARNING: Deleting your account is irreversible and will result in the loss of all your data.</p>
        <form action="" method="post">
            <label for="confirm_delete">To confirm, please type "DELETE" in all caps:</label>
            <input type="text" name="confirm_delete" required>

            <button type="submit" name="delete_account">Delete Account</button>
        </form>
    </section>


    <footer>
        <p>&copy; <?php echo date("Y"); ?> Mobile Store</p>
    </footer>
</body>

</html>