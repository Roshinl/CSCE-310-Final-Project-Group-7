<?php include ('adminCoursesBackend.php')?>
<!DOCTYPE html>
<html>
<style>
table, th, td {
  border: 1px solid;
}
</style>

<body>
<?php echo "<p>Logged in as: " . $_SESSION["username"] . "</p>";?>

<!-- DISPLAY OF ALL COURSES !-->
<!-- <p><b>VIEW ALL COURSES</b></p> -->
<?php echo $courses_table; ?>
<form method="post" action="adminCourses.php">
    <br><label>Sort Course Table: </label>

    <input type="radio" id="course1" name="courses_table" value="0">
	<label for="course1">Order by Course ID</label>

    <input type="radio" id="course2" name="courses_table" value="0">
	<label for="course2">Order by Course Name</label>

    <input type="radio" id="course3" name="courses_table" value="0">
	<label for="course3">Order by Course Number</label>

    <input type="radio" id="course4" name="courses_table" value="0">
	<label for="course4">Order by Tutor ID</label>

    </br>
	<button type="submit" class="btn" name="course_table_order">Submit</button>
</form>
</br></br>

<!-- CREATE / ADD COURSES + ASSIGN APPOINTMENTS !-->
<p><b>CREATE COURSES</b></p>
<form method="post" action="adminCourses.php">
	<label>Course Name</label>
	<input type="text" required name="courseName"></br>

	<label>Course Number</label>
	<input type="text" required name="courseNum"></br>

	<label>Course Description</label>
	<input type="text" required name="courseDesc"></br>

	<button type="submit" class="btn" name="add_course">Add Course</button>
</form>
</br></br>

<!-- EDIT COURSES !-->
<p><b>EDIT COURSES</b></p>
<form method="post" action="adminCourses.php"> 
    <label>Select the course that you want to change (Required)</label>
	<select required name = "selected_course_id">
		<option value = ""></option>
		<?php
			while ($indv_courseID = mysqli_fetch_array($course_ids, MYSQLI_NUM)):;
		?>
		<option value = "<?php echo $indv_courseID[0];?>">
			<?php 
				echo $indv_courseID[0]; 
			?>
		</option>
		<?php
			endwhile;
		?>
	</select>
    </br>
    
	<label>Change Course Name</label>
	<input type="text" required name="edited_courseName"></br>

	<label>Change Course Number</label>
	<input type="text" required name="edited_courseNum"></br>

	<label>Change Course Description</label>
	<input type="text" required name="edited_courseDesc"></br>

    <button type="submit" class="btn" name="edit_course">Submit</button>
</form>
</br></br>

<!-- DELETING COURSES COMPLETELY !-->
<p><b>DELETE COURSES</b></p>
<form method="post" action="adminCourses.php">
	<label>Select a course ID to delete:</label>
	<select required name = "selected_course_id">
		<option value = ""></option>
		<?php while ($indv_courseID = mysqli_fetch_array($course_ids, MYSQLI_NUM)):; ?>
		<option value = "<?php echo $indv_courseID[0];?>">
			<?php echo $indv_courseID[0]; ?>
		</option>
		<?php endwhile; ?>
	</select>
	<input name="delete_course_id" type="submit" value="Delete" onclick="return confirm('Are you sure?')">
</form>

<!-- RETURN TO HOME PAGE !-->
<p>Click here to go back to the home page <a href = "adminHomePage.php">Click here</a></p>

<!-- SIGNOUT !--> <!--
<form method="post" action="adminCourses.php">
	<button type="submit" class="btn" name="signout">Signout</button>
</form> -->
</body>

<!-- PREVENTS ANNOYING RESUBMIT FORM MESSAGE FROM SHOWING UP -->
<script>
if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
</script>

</html>
