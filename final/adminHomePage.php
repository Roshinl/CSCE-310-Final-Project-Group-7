<?php include ('loginRegBackend.php');?>
<!DOCTYPE html>
<html>
<body style="text-align:center;">
	<br><br>
    <img src="g7-logo.jpg" title="G7 Tutoring Logo" alt="logo" />
	<h1 style="color:#3CB371;">G7 TUTORING</h1>
	<h3>Welcome! Your place to work smarter, not harder.</h3>
<?php echo "<p>Logged in as: " . $_SESSION["username"] . "</p>";?>
<form method="post" action="login.php">
<button type="submit" class="btn" name="signout">Signout</button>
</form>
<p>Click here to edit your profile settings <a href = "adminProfileEdit.php">Click here</a></p>
<p>Click here to register a user account <a href="registerUser.php">Click here </a></p>
<p>Click here to update a user account profile <a href="userProfileEdit.php">Click here </a></p>
<p>Click here to manage all appointments <a href ="adminAppointment.php">Click here</a></p>
<p>Click here to manage all reviews <a href ="adminReview.php">Click here</a></p>
<p>Click here to manage all courses <a href ="adminCourses.php">Click here</a></p>

</body>
</html>
