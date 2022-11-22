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
</form>
</body>
</html>