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

// CHANGING PROFILE FIELDS

if (isset($_POST['edit_fname'])) {
	$fname = mysqli_real_escape_string($link, $_POST['fname']);
	
	if (!ctype_alpha($fname)) {
		$errorMessage .= "Sorry, your first name is invalid\\n";
		$error = True;
	}
	
	if (!$error) {
		$payload = "UPDATE user SET user_fname = '$fname' WHERE user_id = '".$_SESSION['user_id']."'";
		$execute = mysqli_query($link, $payload);
		header('Location: adminProfileEdit.php');
	}
}

if (isset($_POST['edit_lname'])) {
	$lname = mysqli_real_escape_string($link, $_POST['lname']);
	
	if (!ctype_alpha($lname)) {
		$errorMessage .= "Sorry, your last name is invalid\\n";
		$error = True;
	}
	
	if (!$error) {
		$payload = "UPDATE user SET user_lname = '$lname' WHERE user_id = '".$_SESSION['user_id']."'";
		$execute = mysqli_query($link, $payload);
		header('Location: adminProfileEdit.php');
	}
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
		header('Location: adminProfileEdit.php');
	}
	
}

if (isset($_POST['edit_password'])) {
	$password = mysqli_real_escape_string($link, $_POST['password']);
	$payload = "UPDATE user SET password = '$password' WHERE user_id = '".$_SESSION['user_id']."'";
	$execute = mysqli_query($link, $payload);
	header('Location: adminProfileEdit.php');
}

if (isset($_POST['edit_email'])) {
	$email = mysqli_real_escape_string($link, $_POST['email']);
	
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		// checks to see if the email is in email format
		$errorMessage .= "Sorry, your email is invalid\\n";
		$error = True;
	}
	
	if (!$error) {
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
			header('Location: adminProfileEdit.php');
		}
	}
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
