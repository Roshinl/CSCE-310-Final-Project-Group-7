<?php session_start();?>
<!DOCTYPE html>
<html>
<body>
<?php echo "<p>Logged in as: " . $_SESSION["username"] . "</p>";?>
<form method="post" action="login.php">
<button type="submit" class="btn" name="signout">Signout</button>
</form>
<p>Click here to edit your profile settings <a href = "profileEdit.php">Click here</a></p>
<p>Click here to manage all appointments <a href ="adminAppointment.php">Click here</a></p>
</body>
</html>