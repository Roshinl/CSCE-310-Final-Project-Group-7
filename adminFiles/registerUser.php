<?php include ('loginRegBackend.php')?>
<!DOCTYPE html>
<html>
<head><title>Register</title></head>
<body>
<head>REGISTER</head>
<form method="post" action="register.php">
	<label>Username</label>
	<input type="text" required name="username">
	
	</br>
	<label>Password</label>
	<input type="text" required name="password">
	
	</br>
	<label>First name</label>
	<input type="text" required name="fname">
	
	</br>
	<label>Last name</label>
	<input type="text" required name="lname">
	
	</br>
	<label>Email</label>
	<input type="text" required name="email">
	
	</br>
	<button type="submit" class="btn" name="register_user">Register</button>
</form>
</br>
</br>
</body>

<!-- PREVENTS ANNOYING RESUBMIT FORM MESSAGE FROM SHOWING UP -->
<script>
if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
</script>

</html>
