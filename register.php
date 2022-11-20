<?php include ('loginRegBackend.php')?>
<!DOCTYPE html>
<html>
<head><title>Register</title></head>
<body>
<head>REGISTER</head>
<form method="post" action="register.php">
<label>Username</label>
<input type="text" name="username">
<label>Password</label>
<input type="text" name="password">
<label>First name</label>
<input type="text" name="fname">
<label>Last name</label>
<input type="text" name="lname">
<label>Email</label>
<input type="text" name="email">
<button type="submit" class="btn" name="register_user">Register</button>
</br>
</br>
<p>Already have an account? Login here: <a href ="login.php">Login</a></p>
</form>
</body>
</html>