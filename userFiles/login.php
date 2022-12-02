<?php include ('loginRegBackend.php')?>
<!DOCTYPE html>
<html>
<head><title>Login</title></head>
<body>
<head>LOGIN</head>
<form method="post" action="login.php">
	<label>Username</label>
	<input type="text" required name="username">
	
	</br>
	<label>Password</label>
	<input type="text" required name="password">
	
	</br>
	<button type="submit" class="btn" name="login_user">Login</button>
	
	</br>
	</br>
	<p>Register here if you don't have an account: <a href ="register.php">Register</a></p>
	<p>Temporary admin link: <a href = "adminHomePage.php">Admin</a></p>
</form>
</body>

<!-- PREVENTS ANNOYING RESUBMIT FORM MESSAGE FROM SHOWING UP -->
<script>
if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
</script>

</html>
