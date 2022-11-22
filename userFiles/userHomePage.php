<?php include ('loginRegBackend.php')?>
<!DOCTYPE html>
<html>
<body>
<?php echo "<p>Logged in as: " . $_SESSION["username"] . "</p>";?>
<form method="post" action="login.php">
<button type="submit" class="btn" name="signout">Signout</button>
</form>
<p>Click here to edit your profile settings <a href = "profileEdit.php">Click here</a></p>
<p>Click here to set up your appointments (change link in future) <a href ="adminAppointment.php">Click here</a></p>
</body>
</html>

<!-- TODO: implement updating profile, deleting profile. 
Admin appointments: View all appointments, select an appointment, update/modify it.
Think about how admin can create an appointment.
 -->
