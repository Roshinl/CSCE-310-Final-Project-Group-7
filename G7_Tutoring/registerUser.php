<?php include ('loginRegBackend.php')?>
<!DOCTYPE html>
<html>
<head><title>Register</title></head>
<body>
<head>REGISTER A STUDENT HERE</head>
<form method="post" action="registerUser.php">
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
	<button type="submit" class="btn" name="register_student">Register</button>
</form>

<br><br>

<head>REGISTER A TUTOR HERE</head>
<form method="post" action="registerUser.php">
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

	<!-- <label>  Is this tutor an admin? </label>
    
	<select name="isAdmin">
		<option value="Yes"> Yes  </option>
		<option value="No"> No  </option>

	</select>  -->

	<br>
	<button type="submit" class="btn" name="register_tutor">Register</button>

</form>
</br>
</br>

<head>REGISTER AN ADMIN HERE</head>
<form method="post" action="registerUser.php">
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

	<!-- <label>  Is this tutor an admin? </label>
    
	<select name="isAdmin">
		<option value="Yes"> Yes  </option>
		<option value="No"> No  </option>

	</select>  -->

	<br>
	<button type="submit" class="btn" name="register_admin">Register</button>

</form>
</br>
</br>

<p>Click here to go back to the home page <a href = "adminHomePage.php">Click here</a></p>

</body>

<!-- PREVENTS ANNOYING RESUBMIT FORM MESSAGE FROM SHOWING UP -->
<script>
if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
</script>

</html>
