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

$payload = "SELECT student_id, student_fname, student_lname, student_username, student_password, student_email FROM student WHERE student_id = '".$_SESSION['student_id']."'";
$result = mysqli_query($link, $payload);

if (mysqli_num_rows($result) > 0) {
	$row = mysqli_fetch_assoc($result);
	$student_table .= "<table><tr><th>Your name</th><th>Your username</th><th>Your password</th><th>Your email</th></tr>";
	$student_table .= "<tr><td>".$row["student_fname"]." ".$row["student_lname"]."</td><td>".$row["student_username"]."</td><td>".$row["student_password"]."</td><td>".$row["student_email"]."</td></tr>";
	$student_table .= "</table>";
}
else 
{
	$student_table .= "<table><tr><th>Student name</th><th>Student username</th><th>Student password</th><th>Student email</th></tr></table>";
	$student_table .= "<p>0 results</p>";
}

// DISPLAYS THE PAYMENT TABLE

$payment_table = "";

$payload = "SELECT payment_id, card_type, card_num, CVV, zip_code, exp_date FROM payment_info WHERE student_id = '".$_SESSION['student_id']."'";
$result = mysqli_query($link, $payload);

if (mysqli_num_rows($result) > 0) {
	$payment_table .= "<table><tr><th>Payment ID</th><th>Card type</th><th>Card number</th><th>CVV</th><th>Zip code</th><th>Expiry date</th></tr>";
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

$payload = "SELECT payment_id FROM payment_info WHERE student_id = '".$_SESSION['student_id']."'";
$display_paymentID = mysqli_query($link, $payload);

// CHANGING PROFILE FIELDS

if (isset($_POST['edit_fname'])) {
	$fname = mysqli_real_escape_string($link, $_POST['fname']);
	$payload = "UPDATE student SET student_fname = '$fname' WHERE student_id = '".$_SESSION['student_id']."'";
	$execute = mysqli_query($link, $payload);
	header('Location: profileEdit.php');
}

if (isset($_POST['edit_lname'])) {
	$lname = mysqli_real_escape_string($link, $_POST['lname']);
	$payload = "UPDATE student SET student_lname = '$lname' WHERE student_id = '".$_SESSION['student_id']."'";
	$execute = mysqli_query($link, $payload);
	header('Location: profileEdit.php');
}

if (isset($_POST['edit_username'])) {
	$username = mysqli_real_escape_string($link, $_POST['username']);
	$payload = "UPDATE student SET student_username = '$username' WHERE student_id = '".$_SESSION['student_id']."'";
	$execute = mysqli_query($link, $payload);
	$_SESSION['username'] = $username;
	header('Location: profileEdit.php');
	
}

if (isset($_POST['edit_password'])) {
	$password = mysqli_real_escape_string($link, $_POST['password']);
	$payload = "UPDATE student SET student_password = '$password' WHERE student_id = '".$_SESSION['student_id']."'";
	$execute = mysqli_query($link, $payload);
	header('Location: profileEdit.php');
}

if (isset($_POST['edit_email'])) {
	$email = mysqli_real_escape_string($link, $_POST['email']);
	$payload = "UPDATE student SET student_email = '$email' WHERE student_id = '".$_SESSION['student_id']."'";
	$execute = mysqli_query($link, $payload);
	header('Location: profileEdit.php');
}

// ADDING PAYMENT INFORMATION

if (isset($_POST['add_payment'])) {
	$card_type = mysqli_real_escape_string($link, $_POST['card_type']);
	$card_num = mysqli_real_escape_string($link, $_POST['card_num']);
	$cvv = mysqli_real_escape_string($link, $_POST['cvv']);
	$zip_code = mysqli_real_escape_string($link, $_POST['zip_code']);
	$expiry = date('Y-m-d', strtotime($_POST['exp_date']));
	
	$error = False;
	
	$errorMessage = "";
	
	if (!is_numeric($card_num) && !empty($card_num))
	{
		$errorMessage.="Card number must be digits\\n";
		$error = True;
	}
	if (!is_numeric($cvv) && !empty($cvv))
	{
		$errorMessage.="CVV must be digits\\n";
		$error = True;
	}
	if (!is_numeric($zip_code) && !empty($zip_code))
	{
		$errorMessage.="Zip code must be digits\\n";
		$error = True;
	}
	
	echo '<script type="text/javascript">
		   window.onload = function () { alert("'.$errorMessage.'"); } 
			</script>';
	
	if (!$error)
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
		$payload = "INSERT INTO payment_info (student_id, card_type, card_num, CVV, zip_code, exp_date) VALUES('".$_SESSION['student_id']."',
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
	
	header('Location: profileEdit.php');
}

// DELETING ACCOUNT

if (isset($_POST['delete_account'])) {
	$payload = "DELETE FROM student WHERE student_id = '".$_SESSION['student_id']."'";
	$execute = mysqli_query($link, $payload);
	
	session_reset();
	echo "<p>Reset session</p>";
	header('Location: login.php');
}

mysqli_close($link);

?>
