<?php include ('adminProfileEditBackend.php')?>
<!DOCTYPE html>
<html>
<style>
table, th, td {
  border: 1px solid;
}
</style>

<body>
<?php echo "<p>Logged in as: " . $_SESSION["username"] . "</p>";?>

<!-- EDITING USER PROFILE AND DETAILS !-->

<?php echo $student_table; ?>

</br>
<form method="post" action="adminProfileEdit.php">
	<label>Change your first name here</label>
	<input type="text" required name="fname">
	<button type="submit" class="btn" name="edit_fname">Submit</button>
</form>

<form method="post" action="adminProfileEdit.php">
	<label>Change your last name here</label>
	<input type="text" required name="lname">
	<button type="submit" class="btn" name="edit_lname">Submit</button>
</form>

<form method="post" action="adminProfileEdit.php">
	<label>Change your username here</label>
	<input type="text" required name="username">
	<button type="submit" class="btn" name="edit_username">Submit</button>
</form>

<form method="post" action="adminProfileEdit.php">
	<label>Change your password here</label>
	<input type="text" required name="password">
	<button type="submit" class="btn" name="edit_password">Submit</button>
</form>

<form method="post" action="adminProfileEdit.php">
	<label>Change your email here</label>
	<input type="text" required name="email">
	<button type="submit" class="btn" name="edit_email">Submit</button>
</form>


<!-- DELETE YOUR ACCOUNT !-->

</br>
</br>
</br>
<form method="post" action="adminProfileEdit.php">
	<label>Delete your account by pressing this button</label>
	<input name="delete_account" type="submit" value="Delete" onclick="return confirm('Are you sure?')">
</form>
</br>
</br>

<!-- RETURN TO HOME PAGE !-->

<p>Click here to go back to the home page <a href = "adminHomePage.php">Click here</a></p>
<form method="post" action="login.php">
	<button type="submit" class="btn" name="signout">Signout</button>
</form>
</body>

<!-- PREVENTS ANNOYING RESUBMIT FORM MESSAGE FROM SHOWING UP -->
<script>
if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
</script>

</html>
