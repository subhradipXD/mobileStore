<?php
include("../_dbConnect.php");

// Initialize error message
$errorMsg = "";

// Generate a random 3-digit number
$randomNumber = (string) mt_rand(100, 999);

if (isset($_POST['Submit'])) {
	$name = $_POST["Name"];
	$email = $_POST["email"];
	$phoneNo = $_POST["phoneNo"];
	$address = $_POST["address"];
	$dob = $_POST["DOB"];
	$password = $_POST["password"];
	$confirmPassword = $_POST["confirmPassword"]; // Added field for confirm password

	// Handle profile picture upload
	// $profilePicture = ""; // Initialize with a default blank image

	// if (isset($_FILES['profilePicture']) && $_FILES['profilePicture']['error'] === UPLOAD_ERR_OK) {
	//     $uploadDir = "profile_pictures/"; // Directory to store uploaded profile pictures
	//     $uploadedFile = $_FILES['profilePicture']['tmp_name'];
	//     $fileExtension = pathinfo($_FILES['profilePicture']['name'], PATHINFO_EXTENSION);
	//     $profilePicture = $userID . "." . $fileExtension; // Unique file name based on user ID

	//     // Move the uploaded file to the desired directory
	//     if (move_uploaded_file($uploadedFile, $uploadDir . $profilePicture)) {
	//         // File uploaded successfully, now you can store $profilePicture in the database
	//     } else {
	//         $errorMsg = "Error uploading profile picture.";
	//     }
	// }

	if ($password !== $confirmPassword) {
		$errorMsg = "Passwords do not match.";
	} else {
		$checkQuery = "SELECT * FROM users WHERE email = '$email' OR phno = '$phoneNo'";
		$result = mysqli_query($conn, $checkQuery);

		if (mysqli_num_rows($result) > 0) {
			$errorMsg = "Email or phone number already exists.";
		} else {
			// Generate user ID
			$userID = substr($name, 0, 4) . $randomNumber;

			// Use prepared statement to insert data
			$stmt = $conn->prepare("INSERT INTO users (userid, name, email, phno, address, dob, password) VALUES (?, ?, ?, ?, ?, ?, ?)");
			$stmt->bind_param("sssssss", $userID, $name, $email, $phoneNo, $address, $dob, $password);

			if ($stmt->execute()) {
				// Redirect after successful registration
				header("location: login.php");
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
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>UserRegistration</title>
	<link rel="stylesheet" type="text/css" href="reg.css">

</head>

<body>

	<header id="head">
		<nav>
			<ul>
				<li><a href="../WSPage/index.php">Home</a></li>
				<li><a href="../WSPage/contact.php">Contact</a></li>
				<li><a href="../WSPage/about.php">About Us</a></li>
			</ul>
		</nav>
		<img src="logo\1.png" alt="Logo" class="image">
		<h1>Welcome to Mobile Book</h1>

	</header>

	<div class="container">
		<!-- Display error message if there is one -->
		<?php if (!empty($errorMsg)) : ?>
			<p><?php echo $errorMsg; ?></p>
		<?php endif; ?>
		<form method="post" autocomplete="on">
			<!--Name-->
			<div class="box">
				<label for="Name" class="fl fontLabel"> Name: </label>
				<div class="new iconBox">
					<i class="fa fa-user" aria-hidden="true"></i>
				</div>
				<div class="fr">
					<input type="text" name="Name" placeholder="Name" class="textBox" autofocus="on" required>
				</div>
				<div class="clr"></div>
			</div>
			<!--Name-->

			<!-- Add this input field for profile picture upload
			<div class="box">
				<label for="profilePicture" class="fl fontLabel"> Profile Picture: </label>
				<div class="fl iconBox"><i class="fa fa-image" aria-hidden="true"></i></div>
				<div class="fr">
					<input type="file" name="profilePicture" accept="image/*">
				</div>
				<div class="clr"></div>
			</div> -->
			<!-- End of profile picture upload field -->


			<!--- Phone No.---->
			<div class="box">
				<label for="phone" class="fl fontLabel"> Phone No.: </label>
				<div class="fl iconBox"><i class="fa fa-phone-square" aria-hidden="true"></i></div>
				<div class="fr">
					<input type="text" required name="phoneNo" maxlength="10" placeholder="Phone No." class="textBox">
				</div>
				<div class="clr"></div>
			</div>
			<!---Phone No.---->


			<!---Email ID---->
			<div class="box">
				<label for="email" class="fl fontLabel"> Email ID: </label>
				<div class="fl iconBox"><i class="fa fa-envelope" aria-hidden="true"></i></div>
				<div class="fr">
					<input type="email" required name="email" placeholder="Email Id" class="textBox">
				</div>
				<div class="clr"></div>
			</div>
			<!--Email ID----->

			<!---Address---->
			<div class="box">
				<label for="address" class="fl fontLabel"> Address: </label>
				<div class="fl iconBox"><i class="fa fa-envelope" aria-hidden="true"></i></div>
				<div class="fr">
					<input type="address" required name="address" placeholder="address" class="textBox">
				</div>
				<div class="clr"></div>
			</div>
			<!--Address----->

			<!---DOB---->
			<div class="box">
				<label for="DOB" class="fl fontLabel"> DOB: </label>
				<div class="fl iconBox"><i class="fa fa-envelope" aria-hidden="true"></i></div>
				<div class="fr">
					<input type="date" required name="DOB" placeholder="Date of Birth" class="textBox">
				</div>
				<div class="clr"></div>
			</div>
			<!--Email ID----->

			<!---Password------>
			<div class="box">
				<label for="password" class="fl fontLabel"> Password: </label>
				<div class="fl iconBox"><i class="fa fa-key" aria-hidden="true"></i></div>
				<div class="fr">
					<input type="Password" required name="password" placeholder="Password" class="textBox">
				</div>
				<div class="clr"></div>
			</div>
			<!---Password---->

			<!---Password------>
			<div class="box">
				<label for="password" class="fl fontLabel">Confirm Password: </label>
				<div class="fl iconBox"><i class="fa fa-key" aria-hidden="true"></i></div>
				<div class="fr">
					<input type="Password" required name="confirmPassword" placeholder="Password" class="textBox">
				</div>
				<div class="clr"></div>
			</div>
			<!---Password---->

			<!---Submit Button------>
			<div class="box">
				<input type="Submit" name="Submit" class="submit" value="SUBMIT">
			</div>
			<!---Submit Button----->

			<div class="box">
				<button><a href="login.php">LOG IN</a></button>
			</div>
		</form>
	</div>
	<!--Body of Form ends--->

	<footer>
    &copy; <?php echo date("Y"); ?> Your Website. All rights reserved.
</footer>
</body>

</html>