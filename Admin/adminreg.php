<?php
include("../_dbConnect.php");
$randomNumber = (string)mt_rand(100, 999);

if (isset($_POST['Submit'])) {
    $adminID = mt_rand(100, 999);
    $adminName = $_POST["AdminName"];
    $adminEmail = $_POST["AdminEmail"];
    $adminPhoneNo = $_POST["AdminPhoneNo"];
    $adminPassword = $_POST["AdminPassword"];
    $adminConfirmPassword = $_POST["AdminConfirmPassword"];

    if ($adminPassword !== $adminConfirmPassword) {
        echo "Passwords do not match.";
        exit;
    }

    // Check if admin email or phone number already exists
    $checkQuery = "SELECT * FROM adminreg WHERE ademail = '$adminEmail' OR adphno = '$adminPhoneNo'";
    $result = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($result) > 0) {
        echo "Admin with this email or phone number already exists.";
        exit;
    }

    $adminID = substr($adminName, 0, 4) . $randomNumber;

    // Use prepared statement to insert admin data
    $stmt = $conn->prepare("INSERT INTO adminreg (adid, adname, ademail, adphno, adpassword) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $adminID, $adminName, $adminEmail, $adminPhoneNo, $adminPassword);

    if ($stmt->execute()) {
        echo "Admin registration successful";
        
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Admin Registration</title>
</head>

<body>

    <div class="container">
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
        </form>
    </div>

</body>

</html>
