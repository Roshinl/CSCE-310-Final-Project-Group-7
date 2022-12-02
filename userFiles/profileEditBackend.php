<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

session_start();

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'root');
define('DB_NAME', 'group7');

$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

// DISPLAYS THE STUDENT TABLE

$student_table = "";

$payload = "SELECT user_id, user_fname, user_lname, username, password, email FROM user WHERE user_id = '".$_SESSION['user_id']."'";
$result = mysqli_query($link, $payload);

if (mysqli_num_rows($result) > 0) {
	$row = mysqli_fetch_assoc($result);
	$student_table .= "<table><caption>Your profile details</caption><tr><th>Your name</th><th>Your username</th><th>Your password</th><th>Your email</th></tr>";
	$student_table .= "<tr><td>".$row["user_fname"]." ".$row["user_lname"]."</td><td>".$row["username"]."</td><td>".$row["password"]."</td><td>".$row["email"]."</td></tr>";
	$student_table .= "</table>";
}
else 
{
	$student_table .= "<table><tr><th>Student name</th><th>Student username</th><th>Student password</th><th>Student email</th></tr></table>";
	$student_table .= "<p>0 results</p>";
}

// DISPLAYS THE PAYMENT TABLE

$payment_table = ""; // append HTML code to this string. The HTML will then run this code and display the table

$payload = "SELECT payment_id, card_type, card_num, CVV, zip_code, exp_date FROM payment_info WHERE user_id = '".$_SESSION['user_id']."'";
$result = mysqli_query($link, $payload);

if (mysqli_num_rows($result) > 0) {
	$payment_table .= "<table><caption>Your payment information</caption><tr><th>Payment ID</th><th>Card type</th><th>Card number</th><th>CVV</th><th>Zip code</th><th>Expiry date</th></tr>";
	while ($row = mysqli_fetch_assoc($result)) {
		$payment_table .= "<tr><td>".$row["payment_id"]."</td><td>".$row["card_type"]."</td><td>".$row["card_num"]."</td><td>".$row["CVV"]."</td><td>".$row["zip_code"]."</td><td>".$row["exp_date"]."</td></tr>";
	}
	$payment_table .= "</table>";
}
else 
{
	$payment_table .= "<table><tr><th>Payment ID</th><th>Card type</th><th>Card number</th><th>CVV</th><th>Zip code</th><th>Expiry date</th></tr></table>";
	$payment_table .= "<p>0 results</p>";
}

// DISPLAY PAYMENT IDS FOR DROP DOWN (DYNAMIC)

$payload = "SELECT payment_id FROM payment_info WHERE user_id = '".$_SESSION['user_id']."'";
$display_paymentID = mysqli_query($link, $payload); // this is passed to HTML, which loops + prints the information

// CHANGING PROFILE FIELDS

if (isset($_POST['edit_fname'])) {
	$fname = mysqli_real_escape_string($link, $_POST['fname']);
	$payload = "UPDATE user SET user_fname = '$fname' WHERE user_id = '".$_SESSION['user_id']."'";
	$execute = mysqli_query($link, $payload);
	header('Location: profileEdit.php');
}

if (isset($_POST['edit_lname'])) {
	$lname = mysqli_real_escape_string($link, $_POST['lname']);
	$payload = "UPDATE user SET user_lname = '$lname' WHERE user_id = '".$_SESSION['user_id']."'";
	$execute = mysqli_query($link, $payload);
	header('Location: profileEdit.php');
}

if (isset($_POST['edit_username'])) {
	$username = mysqli_real_escape_string($link, $_POST['username']);
	
	$payload = "SELECT * FROM user WHERE username = '$username' LIMIT 1";
	$execute = mysqli_query($link, $payload);
	$result = mysqli_fetch_assoc($execute);
	
	$errorMessage = "";

	if ($result) // if the query returned any rows
	{
		if ($result['username'] == $username)
		{
			$errorMessage .= "Sorry, this username already exists\\n";
			echo '<script type="text/javascript">
		   window.onload = function () { alert("'.$errorMessage.'"); } 
			</script>';
		}
	}
	else
	{
		$payload = "UPDATE user SET username = '$username' WHERE user_id = '".$_SESSION['user_id']."'";
		$execute = mysqli_query($link, $payload);
		$_SESSION['username'] = $username; // Update the username to the new username
		header('Location: profileEdit.php');
	}
	
}

if (isset($_POST['edit_password'])) {
	$password = mysqli_real_escape_string($link, $_POST['password']);
	$payload = "UPDATE user SET password = '$password' WHERE user_id = '".$_SESSION['user_id']."'";
	$execute = mysqli_query($link, $payload);
	header('Location: profileEdit.php');
}

if (isset($_POST['edit_email'])) {
	$email = mysqli_real_escape_string($link, $_POST['email']);
	
	$payload = "SELECT * FROM user WHERE email = '$email' LIMIT 1";
	$execute = mysqli_query($link, $payload);
	$result = mysqli_fetch_assoc($execute);
	
	$errorMessage = "";

	if ($result) 
	{
		if ($result['email'] == $email)
		{
			$errorMessage .= "Sorry, this email already exists\\n";
			echo '<script type="text/javascript">
		   window.onload = function () { alert("'.$errorMessage.'"); } 
			</script>';
		}
	}
	else
	{
		$payload = "UPDATE user SET email = '$email' WHERE user_id = '".$_SESSION['user_id']."'";
		$execute = mysqli_query($link, $payload);
		header('Location: profileEdit.php');
	}
}

// ADDING PAYMENT INFORMATION

if (isset($_POST['add_payment'])) {
	$card_type = mysqli_real_escape_string($link, $_POST['card_type']);
	$card_num = mysqli_real_escape_string($link, $_POST['card_num']);
	$cvv = mysqli_real_escape_string($link, $_POST['cvv']);
	$zip_code = mysqli_real_escape_string($link, $_POST['zip_code']);
	$expiry = date('Y-m-d', strtotime($_POST['exp_date'])); // date converts the string into ready-to-insert SQL
	
	$error = False;
	
	$errorMessage = "";
	
	if (!is_numeric($card_num)) // checks if the card number is a number
	{
		$errorMessage.="Card number must be digits\\n";
		$error = True;
	}
	if (!is_numeric($cvv))
	{
		$errorMessage.="CVV must be digits\\n";
		$error = True;
	}
	if (!is_numeric($zip_code))
	{
		$errorMessage.="Zip code must be digits\\n";
		$error = True;
	}
	
	if ($error) {
		echo '<script type="text/javascript">
			   window.onload = function () { alert("'.$errorMessage.'"); } 
				</script>';
	}
	
	else
	{
		$payload = "SELECT * FROM payment_info WHERE card_num = '$card_num'";
		$execute = mysqli_query($link, $payload);
	
		if (mysqli_num_rows($execute) > 0) 
		{
			echo '<script type="text/javascript">
		   window.onload = function () { alert("Sorry, this card number already exists"); } 
			</script>';	
			$error = True;
		}
	}
	
	if (!$error)
	{
		$payload = "INSERT INTO payment_info (user_id, card_type, card_num, CVV, zip_code, exp_date) VALUES('".$_SESSION['user_id']."',
		'$card_type','$card_num','$cvv','$zip_code','$expiry')";

		if (!mysqli_query($link, $payload))
		{
			echo("Error description: " . mysqli_error($link));
		}
		
		header('Location: profileEdit.php');
	}
}

// DELETING PAYMENT ID

if (isset($_POST['delete_payment_id'])) {
	$to_delete_id = mysqli_real_escape_string($link, $_POST['selected_paymentID']);
	
	$payload = "DELETE FROM payment_info WHERE payment_id = '$to_delete_id'";
	$execute = mysqli_query($link, $payload);
	
	$payload = "SELECT payment_id, card_type, card_num, CVV, zip_code, exp_date FROM payment_info WHERE user_id = '".$_SESSION['user_id']."'";
	$result = mysqli_query($link, $payload);
	
	// Checks if the user has any payment information left, if they don't, we set their has_payment to 0
	if (mysqli_num_rows($result) <= 0)
	{
		$payload = "UPDATE student SET has_payment = 0 WHERE user_id = '".$_SESSION['user_id']."'";
		$execute = mysqli_query($link, $payload);
	}
	
	header('Location: profileEdit.php');
}

// DELETING ACCOUNT

if (isset($_POST['delete_account'])) {
	$payload = "DELETE FROM user WHERE user_id = '".$_SESSION['user_id']."'";
	$execute = mysqli_query($link, $payload);
	
	session_reset(); // resets session (so username and id aren't carried over)
	
	header('Location: login.php');
}

mysqli_close($link);

?>
