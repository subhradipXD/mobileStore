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
	<script>
		function validateForm() {
			var name = document.forms["registrationForm"]["Name"].value;
			var phoneNo = document.forms["registrationForm"]["phoneNo"].value;
			var email = document.forms["registrationForm"]["email"].value;
			var address = document.forms["registrationForm"]["address"].value;
			var dob = document.forms["registrationForm"]["DOB"].value;
			var password = document.forms["registrationForm"]["password"].value;
			var confirmPassword = document.forms["registrationForm"]["confirmPassword"].value;

			if (name == "") {
				alert("Name must be filled out");
				return false;
			}

			if (phoneNo == "" || isNaN(phoneNo) || phoneNo.length != 10) {
				alert("Please enter a valid 10-digit phone number");
				return false;
			}

			// Email validation using regular expression
			var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
			if (!emailRegex.test(email)) {
				alert("Please enter a valid email address");
				return false;
			}

			// Additional email validation (optional)
			if (email.length > 50) {
				alert("Email address is too long");
				return false;
			}

			// Add address validation if needed

			if (dob == "") {
				alert("Date of Birth must be filled out");
				return false;
			}

			// Password validation
			var passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{6,}$/;
			if (!passwordRegex.test(password)) {
				alert("Password must be at least 6 characters long and include at least one lowercase letter, one uppercase letter, and one digit");
				return false;
			}

			if (password !== confirmPassword) {
				alert("Passwords do not match");
				return false;
			}

			return true;
		}
	</script>
</head>


<body>

	<header id="head">
		<nav>
			<ul>
				<li><a href="home.php">Home</a></li>
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
		<form method="post" autocomplete="on" name="registrationForm" onsubmit="return validateForm()">
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