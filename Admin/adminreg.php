<?php
include("../_dbConnect.php");
$randomNumber = (string)mt_rand(100, 999);

if (isset($_POST['Submit'])) {
    $adminID = substr($_POST["AdminName"], 0, 4) . $randomNumber;
    $adminName = $_POST["AdminName"];
    $adminEmail = $_POST["AdminEmail"];
    $adminPhoneNo = $_POST["AdminPhoneNo"];
    $adminPassword = $_POST["AdminPassword"];
    $adminConfirmPassword = $_POST["AdminConfirmPassword"];

    if ($adminPassword !== $adminConfirmPassword) {
        $errorMsg = "Passwords do not match.";
    } else {
        // Check if admin email or phone number already exists
        $checkQuery = "SELECT * FROM adminreg WHERE ademail = '$adminEmail' OR adphno = '$adminPhoneNo'";
        $result = mysqli_query($conn, $checkQuery);

        if (mysqli_num_rows($result) > 0) {
            $errorMsg = "Admin with this email or phone number already exists.";
        } else {
            // Use prepared statement to insert admin data
            $stmt = $conn->prepare("INSERT INTO adminreg (adid, adname, ademail, adphno, adpassword) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $adminID, $adminName, $adminEmail, $adminPhoneNo, $adminPassword);

            if ($stmt->execute()) {
                // Redirect after successful registration
                header("location: admin.php");
            } else {
                $errorMsg = "Error: " . $stmt->error;
            }

            $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Admin Registration</title>
    <link rel="stylesheet" type="text/css" href="your-css-file.css">
</head>

<body>

    <div class="container">
        <!-- Display error message if there is one -->
        <?php if (!empty($errorMsg)) : ?>
            <p><?php echo $errorMsg; ?></p>
        <?php endif; ?>
        <form method="post" autocomplete="on">
            <!--Admin Name-->
            <div class="box">
                <label for="AdminName" class="fl fontLabel">Admin Name: </label>
                <div class="new iconBox">
                    <i class="fa fa-user" aria-hidden="true"></i>
                </div>
                <div class="fr">
                    <input type="text" name="AdminName" placeholder="Admin Name" class="textBox" autofocus="on" required>
                </div>
                <div class="clr"></div>
            </div>
            <!--Admin Name-->

            <!--Admin Phone No.-->
            <div class="box">
                <label for="AdminPhoneNo" class="fl fontLabel">Admin Phone No.: </label>
                <div class="fl iconBox"><i class="fa fa-phone-square" aria-hidden="true"></i></div>
                <div class="fr">
                    <input type="text" required name="AdminPhoneNo" maxlength="10" placeholder="Admin Phone No." class="textBox">
                </div>
                <div class="clr"></div>
            </div>
            <!--Admin Phone No.-->

            <!--Admin Email ID-->
            <div class="box">
                <label for="AdminEmail" class="fl fontLabel">Admin Email ID: </label>
                <div class="fl iconBox"><i class="fa fa-envelope" aria-hidden="true"></i></div>
                <div class="fr">
                    <input type="email" required name="AdminEmail" placeholder="Admin Email Id" class="textBox">
                </div>
                <div class="clr"></div>
            </div>
            <!--Admin Email ID-->

            <!--Admin Password-->
            <div class="box">
                <label for="AdminPassword" class="fl fontLabel">Admin Password: </label>
                <div class="fl iconBox"><i class="fa fa-key" aria-hidden="true"></i></div>
                <div class="fr">
                    <input type="Password" required name="AdminPassword" placeholder="Admin Password" class="textBox">
                </div>
                <div class="clr"></div>
            </div>
            <!--Admin Password-->

            <!--Admin Confirm Password-->
            <div class="box">
                <label for="AdminConfirmPassword" class="fl fontLabel">Confirm Password: </label>
                <div class="fl iconBox"><i class="fa fa-key" aria-hidden="true"></i></div>
                <div class="fr">
                    <input type="Password" required name="AdminConfirmPassword" placeholder="Confirm Password" class="textBox">
                </div>
                <div class="clr"></div>
            </div>
            <!--Admin Confirm Password-->

            <!--Submit Button-->
            <div class="box">
                <input type="Submit" name="Submit" class="submit" value="REGISTER">
            </div>
            <!--Submit Button-->

            <!-- Login Button Redirecting to admin.php -->
        <div class="box">
            Already have an account?
            <a href="admin.php">Login</a>
        </div>
        </form>
    </div>

</body>

</html>
