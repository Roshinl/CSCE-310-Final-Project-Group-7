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
	echo "<p>button pressed</p>";
	session_reset();
	echo "<p>Reset session</p>";
	header('Location: login.php');
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
	
	$payload = "SELECT * FROM user WHERE username = '$username' OR email = '$email' LIMIT 1";
	$execute = mysqli_query($link, $payload);
	$testUser = mysqli_fetch_assoc($execute);

	if ($testUser) 
	{
		if ($testUser['username'] == $username)
		{
			$errorMessage .= "Sorry, this username already exists\\n";
			$error = True;
		}
		if ($testUser['email'] == $email)
		{
			$errorMessage .= "Sorry, this email already exists\\n";
			$error = True;
		}
	}
	
	echo '<script type="text/javascript">
		   window.onload = function () { alert("'.$errorMessage.'"); } 
			</script>';
	
	if (!$error)
	{
		$payload = "INSERT INTO user (username, password, user_fname, user_lname, email, is_tutor) VALUES('$username',
		'$password','$fname','$lname','$email', 0)";
		
		if (!mysqli_query($link, $payload))
		{
			echo("Error description: " . mysqli_error($link));
		}
		
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
	
	$payload = "SELECT user_id FROM user WHERE username = '$username' AND password = '$password' LIMIT 1";
	$execute = mysqli_query($link, $payload);
	$testUser = mysqli_fetch_assoc($execute);
	
	if ($testUser)
	{
		$_SESSION['username'] = $username;
		$_SESSION['user_id'] = $testUser["user_id"];
		header('Location: userHomePage.php');
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
