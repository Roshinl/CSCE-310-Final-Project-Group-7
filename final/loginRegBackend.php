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

// SIGNING OUT

if (isset($_POST['signout'])) {
	// Resets the session, IE: username and id associated with that session is cleared
	session_reset();
	
	// Reloads the page essentially, ensuring everything is updated / recently pulled from DB
	header('Location: login.php');
}

// REGISTERING AS A NEW STUDENT

if (isset($_POST['register_student'])) {
	$username = mysqli_real_escape_string($link, $_POST['username']);
	$password = mysqli_real_escape_string($link, $_POST['password']);
	$fname = mysqli_real_escape_string($link, $_POST['fname']);
	$lname = mysqli_real_escape_string($link, $_POST['lname']);
	$email = mysqli_real_escape_string($link, $_POST['email']);

	$error = False;
	$errorMessage = "";
	
	if (!ctype_alpha($fname)) {
		$errorMessage .= "Sorry, your first name is invalid\\n";
		$error = True;
	}
	if (!ctype_alpha($lname)) {
		$errorMessage .= "Sorry, your last name is invalid\\n";
		$error = True;
	}
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		// checks to see if the email is in email format
		$errorMessage .= "Sorry, your email is invalid\\n";
		$error = True;
	}
	
	if ($error) {
		// duplicate error message here in order to prevent redundant SQL query on already invalid input
		echo '<script type="text/javascript">
		   window.onload = function () { alert("'.$errorMessage.'"); } 
			</script>';
	}
	
	$payload = "SELECT * FROM user WHERE username = '$username' OR email = '$email' LIMIT 1";
	$execute = mysqli_query($link, $payload);
	$result = mysqli_fetch_assoc($execute);

	// CHECK IF THE USERNAME OR EMAIL IS TAKEN ALREADY
	
	if ($result) 
	{
		if ($result['username'] == $username)
		{
			$errorMessage .= "Sorry, this username already exists\\n";
			$error = True;
		}
		if ($result['email'] == $email)
		{
			$errorMessage .= "Sorry, this email already exists\\n";
			$error = True;
		}
	}
	
	if ($error) {
		echo '<script type="text/javascript">
		   window.onload = function () { alert("'.$errorMessage.'"); } 
			</script>';
	}
	
	else
	{
		$payload = "INSERT INTO user (username, password, user_fname, user_lname, email, is_tutor) VALUES('$username',
		'$password','$fname','$lname','$email', 0)";
		
		// Gives error description if insert query did not work
		if (!mysqli_query($link, $payload))
		{
			echo("Error description: " . mysqli_error($link));
		}
		
		header('Location: registerUser.php');
	}
}



// REGISTERING AS A NEW TUTOR

if (isset($_POST['register_tutor'])) {
	$username = mysqli_real_escape_string($link, $_POST['username']);
	$password = mysqli_real_escape_string($link, $_POST['password']);
	$fname = mysqli_real_escape_string($link, $_POST['fname']);
	$lname = mysqli_real_escape_string($link, $_POST['lname']);
	$email = mysqli_real_escape_string($link, $_POST['email']);
	// $isAdmin = mysqli_real_escape_string($link, $_POST['isAdmin']);

	// print_r($isAdmin);

	// if ($isAdmin == "Yes"){
	// 	$isAdmin = 1;
	// }
	// else{
	// 	$isAdmin = 0;
	// }



	$error = False;
	$errorMessage = "";
	
	if (!ctype_alpha($fname)) {
		$errorMessage .= "Sorry, your first name is invalid\\n";
		$error = True;
	}
	if (!ctype_alpha($lname)) {
		$errorMessage .= "Sorry, your last name is invalid\\n";
		$error = True;
	}
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		// checks to see if the email is in email format
		$errorMessage .= "Sorry, your email is invalid\\n";
		$error = True;
	}
	
	if ($error) {
		// duplicate error message here in order to prevent redundant SQL query on already invalid input
		echo '<script type="text/javascript">
		   window.onload = function () { alert("'.$errorMessage.'"); } 
			</script>';
	}
	
	$payload = "SELECT * FROM user WHERE username = '$username' OR email = '$email' LIMIT 1";
	$execute = mysqli_query($link, $payload);
	$result = mysqli_fetch_assoc($execute);

	// CHECK IF THE USERNAME OR EMAIL IS TAKEN ALREADY
	
	if ($result) 
	{
		if ($result['username'] == $username)
		{
			$errorMessage .= "Sorry, this username already exists\\n";
			$error = True;
		}
		if ($result['email'] == $email)
		{
			$errorMessage .= "Sorry, this email already exists\\n";
			$error = True;
		}
	}
	
	
	if ($error) {
		echo '<script type="text/javascript">
		   window.onload = function () { alert("'.$errorMessage.'"); } 
			</script>';
	}
	
	else
	{
		$payload = "INSERT INTO user (username, password, user_fname, user_lname, email, is_tutor) VALUES('$username',
		'$password','$fname','$lname','$email', 1)";
		
		
		// Gives error description if insert query did not work
		if (!mysqli_query($link, $payload))
		{
			echo("Error description: " . mysqli_error($link));
		}
		// if ($isAdmin){
			
		// 	//finding the user_id for the new username and adding them as an admin in the tutor table
		// 	$query = "SELECT user_id FROM user WHERE username = '$username' LIMIT 1";
		// 	$result = mysqli_query($link, $query);
		// 	$student_id = mysqli_fetch_assoc($result)["user_id"];
		// 	$payload = "UPDATE tutor SET is_admin='1' WHERE user_id='$student_id'";
			
		// 	if (!mysqli_query($link, $payload))
		// {
		// 	echo("Error description: " . mysqli_error($link));
		// }
		// }
		header('Location: registerUser.php');
	}
}

// REGISTERING A NEW ADMIN

if (isset($_POST['register_admin'])) {
	$username = mysqli_real_escape_string($link, $_POST['username']);
	$password = mysqli_real_escape_string($link, $_POST['password']);
	$fname = mysqli_real_escape_string($link, $_POST['fname']);
	$lname = mysqli_real_escape_string($link, $_POST['lname']);
	$email = mysqli_real_escape_string($link, $_POST['email']);

	$error = False;
	$errorMessage = "";
	
	if (!ctype_alpha($fname)) {
		$errorMessage .= "Sorry, your first name is invalid\\n";
		$error = True;
	}
	if (!ctype_alpha($lname)) {
		$errorMessage .= "Sorry, your last name is invalid\\n";
		$error = True;
	}
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		// checks to see if the email is in email format
		$errorMessage .= "Sorry, your email is invalid\\n";
		$error = True;
	}
	
	if ($error) {
		// duplicate error message here in order to prevent redundant SQL query on already invalid input
		echo '<script type="text/javascript">
		   window.onload = function () { alert("'.$errorMessage.'"); } 
			</script>';
	}
	
	$payload = "SELECT * FROM user WHERE username = '$username' OR email = '$email' LIMIT 1";
	$execute = mysqli_query($link, $payload);
	$result = mysqli_fetch_assoc($execute);

	// CHECK IF THE USERNAME OR EMAIL IS TAKEN ALREADY
	
	if ($result) 
	{
		if ($result['username'] == $username)
		{
			$errorMessage .= "Sorry, this username already exists\\n";
			$error = True;
		}
		if ($result['email'] == $email)
		{
			$errorMessage .= "Sorry, this email already exists\\n";
			$error = True;
		}
	}
	
	if ($error) {
		echo '<script type="text/javascript">
		   window.onload = function () { alert("'.$errorMessage.'"); } 
			</script>';
	}
	
	else
	{
		$payload = "INSERT INTO user (username, password, user_fname, user_lname, email, is_tutor) VALUES('$username',
		'$password','$fname','$lname','$email', 2)";
		
		// Gives error description if insert query did not work
		if (!mysqli_query($link, $payload))
		{
			echo("Error description: " . mysqli_error($link));
		}
		
		header('Location: registerUser.php');
	}
}

// REGISTERING AS A NEW USER

if (isset($_POST['register_user'])) {
	$username = mysqli_real_escape_string($link, $_POST['username']);
	$password = mysqli_real_escape_string($link, $_POST['password']);
	$fname = mysqli_real_escape_string($link, $_POST['fname']);
	$lname = mysqli_real_escape_string($link, $_POST['lname']);
	$email = mysqli_real_escape_string($link, $_POST['email']);
	
	$error = False;
	$errorMessage = "";
	
	// CHECK IF FIRST NAME, LAST NAME, AND EMAIL ARE VALID
	
	if (!ctype_alpha($fname)) {
		$errorMessage .= "Sorry, your first name is invalid\\n";
		$error = True;
	}
	if (!ctype_alpha($lname)) {
		$errorMessage .= "Sorry, your last name is invalid\\n";
		$error = True;
	}
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		// checks to see if the email is in email format
		$errorMessage .= "Sorry, your email is invalid\\n";
		$error = True;
	}
	
	if ($error) {
		// duplicate error message here in order to prevent redundant SQL query on already invalid input
		echo '<script type="text/javascript">
		   window.onload = function () { alert("'.$errorMessage.'"); } 
			</script>';
	}
	
	$payload = "SELECT * FROM user WHERE username = '$username' OR email = '$email' LIMIT 1";
	$execute = mysqli_query($link, $payload);
	$result = mysqli_fetch_assoc($execute);
	
	// CHECK IF THE USERNAME OR EMAIL IS TAKEN ALREADY
	
	if ($result) 
	{
		if ($result['username'] == $username)
		{
			$errorMessage .= "Sorry, this username already exists\\n";
			$error = True;
		}
		if ($result['email'] == $email)
		{
			$errorMessage .= "Sorry, this email already exists\\n";
			$error = True;
		}
	}
	
	if ($error) {
		echo '<script type="text/javascript">
		   window.onload = function () { alert("'.$errorMessage.'"); } 
			</script>';
	}
	
	else
	{
		$payload = "INSERT INTO user (username, password, user_fname, user_lname, email, is_tutor) VALUES('$username',
		'$password','$fname','$lname','$email', 0)";
		
		// Gives error description if insert query did not work
		if (!mysqli_query($link, $payload))
		{
			echo("Error description: " . mysqli_error($link));
		}
		
		// Since user_id is auto incremented / generated, we need to get the new user_id associated with this user
		// Set session's user_id and username, allows for login information to carry across all links
		$payload = "SELECT user_id FROM user WHERE username = '$username'";
		$execute = mysqli_query($link, $payload);
		$result = mysqli_fetch_assoc($execute);
		
		$_SESSION['username'] = $username;
		$_SESSION['user_id'] = $result["user_id"];
		header('Location: userHomePage.php');
	}
}

// LOGGING IN AS EXISTING USER

if (isset($_POST['login_user'])) {
	$username = mysqli_real_escape_string($link, $_POST['username']);
	$password = mysqli_real_escape_string($link, $_POST['password']);
	
	$payload = "SELECT user_id, is_tutor FROM user WHERE username = '$username' AND password = '$password' LIMIT 1";
	$execute = mysqli_query($link, $payload);
	$result = mysqli_fetch_assoc($execute);
	
	if ($result)
	{
		$_SESSION['username'] = $username;
		$_SESSION['user_id'] = $result["user_id"];
		
		if ($result["is_tutor"] == 2)
		{
			header('Location: adminHomePage.php');
		}
		else
		{
			header('Location: userHomePage.php');
		}
	}
	else
	{
		echo '<script type="text/javascript">
	   window.onload = function () { alert("Sorry, this username or username/password combination does not exist"); } 
		</script>';	
	}
}

mysqli_close($link);

?>