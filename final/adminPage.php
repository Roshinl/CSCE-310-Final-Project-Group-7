<?php include ('adminPageBackend.php')?>
<!DOCTYPE html>
<html>
<body><head>Hello admin</head>
<?php echo "<p>Logged in as: " . $_SESSION["username"] . "</p>";?>
<form method = "POST">
	<label>Select a student ID to view their appointments</label>
	<select name = "Student">
		<?php
			while ($student = mysqli_fetch_array($allStudentID, MYSQLI_NUM)):;
		?>
		<option value = "<?php echo $student[0];?>">
			<?php echo $student[0];?>
		</option>
		<?php endwhile;
		?>
	</select>
	<input type = "submit" value = "submit" name ="submit">
</form>
</br>
<p>View all the students in the database</p>
<form method = "POST" action="adminPage.php">
	<button type="submit" class="btn" name="view_student">View all students</button>
</form>
<?php echo $html ?>
<form method="post" action="login.php">
<button type="submit" class="btn" name="signout">Signout</button>
</form>
</body>
</html>