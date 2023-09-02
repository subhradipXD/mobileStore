<?php
include("../_dbConnect.php");

// Generate a random 3-digit number
$randomNumber = (string)mt_rand(100, 999);

if(isset($_POST['Submit']))
{
    $name = $_POST["Name"];
    $email = $_POST["email"];
    $phoneNo = $_POST["phoneNo"];
    $address = $_POST["address"];
    $dob = $_POST["DOB"];
    $gender = $_POST["Gender"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirmPassword"]; // Added field for confirm password

    if ($password !== $confirmPassword) {
        echo "Passwords do not match.";
        exit;
    }

	$checkQuery = "SELECT * FROM users WHERE email = '$email' OR phno = '$phoneNo'";
    $result = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($result) > 0) {
        echo "Email or phone number already exists.";
        exit;
    }

    // Generate user ID
    $userID = substr($name, 0, 4) . $randomNumber;

	echo $userID;


    // Use prepared statement to insert data
    $stmt = $conn->prepare("INSERT INTO users (userid, name, email, phno, address, dob, password) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $userID, $name, $email, $phoneNo, $address, $dob, $password);

    if ($stmt->execute()) {
        echo "New record created successfully";
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
	<title>Form</title>
</head>

<body>

	<div class="container">
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

			<!---Phone No.------>
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

            <!---Gender----->
    		<div class="box radio">
          <label for="gender" class="fl fontLabel"> Gender: </label>
    				<input type="radio" name="Gender" value="Male" required> Male &nbsp; &nbsp; &nbsp; &nbsp;
    				<input type="radio" name="Gender" value="Female" required> Female
    		</div>
    		<!---Gender--->


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
		</form>
	</div>
	<!--Body of Form ends--->
</body>
</html>