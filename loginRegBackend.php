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

if (isset($_POST['signout'])) {
	echo "<p>button pressed</p>";
	session_reset();
	echo "<p>Reset session</p>";
	header('Location: login.php');
}

if (isset($_POST['register_user'])) {
	$username = mysqli_real_escape_string($link, $_POST['username']);
	$password = mysqli_real_escape_string($link, $_POST['password']);
	$fname = mysqli_real_escape_string($link, $_POST['fname']);
	$lname = mysqli_real_escape_string($link, $_POST['lname']);
	$email = mysqli_real_escape_string($link, $_POST['email']);
	
	$error = False;
	
	if (empty($username)) 
	{
		echo "<p>Username required</p>";
		$error = True;
	}
	if (empty($password)) 
	{
		echo "<p>Password required</p>";
		$error = True;
	}
	if (empty($fname)) 
	{
		echo "<p>First name required</p>";
		$error = True;
	}
	if (empty($lname)) 
	{
		echo "<p>Last name required</p>";
		$error = True;
	}
	if (empty($email)) 
	{
		echo "<p>Email required</p>";
		$error = True;
	}
	
	$payload = "SELECT * FROM student WHERE student_username = '$username' OR student_email = '$email' LIMIT 1";
	$execute = mysqli_query($link, $payload);
	$testUser = mysqli_fetch_assoc($execute);
	
	if ($testUser) 
	{
		if ($testUser['student_username'] == $username)
		{
			echo "<p>This username already exists</p>";
			$error = True;
		}
		if ($testUser['student_email'] == $email)
		{
			echo "<p>This email already exists</p>"; 
			$error = True;
		}
	}
	if (!$error)
	{
		$payload = "INSERT INTO student (student_username, student_password, student_fname, student_lname, student_email) VALUES('$username',
		'$password','$fname','$lname','$email')";
		
		if (!mysqli_query($link, $payload))
		{
			echo("Error description: " . mysqli_error($link));
		}
		$_SESSION['username'] = $username;
		header('Location: test.php');
	}
}

if (isset($_POST['login_user'])) {
	$username = mysqli_real_escape_string($link, $_POST['username']);
	$password = mysqli_real_escape_string($link, $_POST['password']);
	
	if (empty($username)) 
	{
		echo "<p>Username required</p>";
		$error = True;
	}
	if (empty($password)) 
	{
		echo "<p>Password required</p>";
		$error = True;
	}
	
	$payload = "SELECT * FROM student WHERE student_username = '$username' AND student_password = '$password' LIMIT 1";
	$execute = mysqli_query($link, $payload);
	$testUser = mysqli_fetch_assoc($execute);
	
	if ($testUser)
	{
		$_SESSION['username'] = $username;
		header('Location: test.php');
	}
	else
	{
		echo "<p>Sorry, this username or username/password combination does not exist</p>";
	}
}

mysqli_close($link);

?>