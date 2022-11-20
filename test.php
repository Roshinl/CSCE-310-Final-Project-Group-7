<?php include ('loginRegBackend.php')?>
<!DOCTYPE html>
<html>
<body><head>Logged in or something idk</head>
<?php echo "<p>Logged in as: " . $_SESSION["username"] . "</p>";?>
<form method="post" action="login.php">
<button type="submit" class="btn" name="signout">Signout</button>
</form>
<p>Go here if you're an admin lol <a href ="adminAppointment.php">Click here</a></p>
</body>
</html>