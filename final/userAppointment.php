<?php include('appointmentBackend.php'); 

// print_r(sizeof($availableCourses));
// print_r($availableCourses['course_name']);
// print_r($bookedAppointments);

 ?>

<!DOCTYPE html>

<style>
table, th, td {
  border: 1px solid;
}
</style>

<html>
<head><title>Appointments</title></head>
<body>
<head>USER APPOINTMENTS</head>

<?php echo "<p>Logged in as: " . $_SESSION["username"] . "</p>";?>

<h1>Create An Appointment Here:</h1>

<?php echo $course_table; ?>
</br>
</br>
<?php echo $tutor_table; ?>
</br>

<!-- DROPDOWN FOR COURSES -->
<p> Select An Available Course: </p>
<form method="post" action="userAppointment.php">
<select name="availCourses" id="availCourses">
<option value=""> --Select a Course-- </option>

<?php 
        foreach($availableCourses as $eachCourse){
            echo "<option value='$eachCourse'> $eachCourse </option>";
        }
        ?>
</select> 
<!-- <input type="submit" name="add_appointment" value="Submit Appointment"> -->
<!-- </form> -->
<br>


<!-- <?php print_r($selectedCourse); ?> -->


<!-- DROPDOWN FOR TUTOR -->
<p> Select An Available Tutor: </p>
<!-- <form method="post" action="userAppointment.php"> -->
<select name="availTutor">
<option value=""> --Select a Tutor-- </option>

<?php 
        foreach($availableTutors as $eachTutor){
            echo "<option value='$eachTutor'> $eachTutor </option>";
        }
        ?>
</select> 
<!-- </form> -->
<br>


<!-- DROPDOWN FOR DATE -->
<p> Select An Available Date: </p>
<input type = "date" name = "availDate">

<!-- <form method="post" action="userAppointment.php"> -->
<!-- <select name="availDate">
<option value=""> --Select a Date-- </option>

<?php 
        foreach($availableDates as $eachDate){
            echo "<option value='$eachDate'> $eachDate </option>";
        }
        ?>
</select>  -->
<!-- </form> -->
<br>



<!-- DROPDOWN FOR START TIME --> 
<p> Select An Available Start Time: </p>
<!-- <form method="post" action="userAppointment.php"> -->
<select name="availStartTime">
<option value=""> --Select a Start Time-- </option>
		<?php
			$i = 0;
			while ($i < 9):;
		?>
		<option value = "<?php echo $valid_times[$i]; ?>">
			<?php
				echo $valid_times[$i];
				$i++;
			?>
		</option>
		<?php
			endwhile;
		?>

<!-- 
<?php 
        foreach($availableStartTimes as $eachStartTime){
            echo "<option value='$eachStartTime'> $eachStartTime </option>";
        }
        ?> -->
</select> 
<!-- </form> -->
<br>


<!-- DROPDOWN FOR END TIME --> 
<p> Select An Available End Time: </p>
<!-- <form method="post" action="userAppointment.php"> -->
<select name="availEndTime">
<option value=""> --Select a End Time-- </option>
<?php
			$i = 0;
			while ($i < 9):;
		?>
		<option value = "<?php echo $valid_times[$i]; ?>">
			<?php
				echo $valid_times[$i];
				$i++;
			?>
		</option>
		<?php
			endwhile;
		?>


<!-- <?php 
        foreach($availableEndTimes as $eachEndTime){
            echo "<option value='$eachEndTime'> $eachEndTime </option>";
        }
        ?> -->
</select> 
<!-- </form> -->
<br><br>

<button type="submit" class="btn" name="add_appointment">Add appointment</button>



<h1> View Your Appointments Here: </h1>
<?php echo $users_appointments_table; ?>



<!-- DROPDOWN FOR UPDATING APPOINTMENTS --> 

<h1> Update Your Appointment Here: </h1>
<p1> Select an Appointment to Update: </p> 

<form method="post" action="userAppointment.php">
<select name="apptToUpdate">
<?php 
        foreach($bookedAppointments as $thisAppt){
            echo "<option value='$thisAppt'> $thisAppt </option>";
        }
        ?>
</select> 

</form>

<p> Update Date: </p> 
<input type = "date" name = "updatedDate">
<button type="submit" class="btn" name="update_date">Update Date</button>


 <p> Update Start Time: </p>

<select name="newStartTime">
<option value=""> --Choose a New Start Time-- </option>
		<?php
			$i = 0;
			while ($i < 9):;
		?>
		<option value = "<?php echo $valid_times[$i]; ?>">
			<?php
				echo $valid_times[$i];
				$i++;
			?>
		</option>
		<?php
			endwhile;
		?>
</select>


<p> Update End Time: </p>

<select name="newEndTime">
<option value=""> --Choose a End Start Time-- </option>
		<?php
			$i = 0;
			while ($i < 9):;
		?>
		<option value = "<?php echo $valid_times[$i]; ?>">
			<?php
				echo $valid_times[$i];
				$i++;
			?>
		</option>
		<?php
			endwhile;
		?>
</select>
<button type="submit" class="btn" name="update_times">Update Times</button>





<h1> Delete Your Appointment Here: </h1>

<!-- DROPDOWN FOR DELETING APPOINTMENTS --> 
<p> Select An Appointment To Delete: </p>
<form method="post" action="userAppointment.php">
<select name="apptToDelete">
<?php 
        // Iterating through the product array
        foreach($bookedAppointments as $thisAppt){
            echo "<option value='$thisAppt'> $thisAppt </option>";
        }
        ?>
</select> 
<input name="delete_appointment" type="submit" value="Delete">

</form>
<br>
<!-- <button type="submit" class="btn" name="delete_appointment">Delete appointment</button> -->


<p>Click here to go back to the home page <a href = "userHomePage.php">Click here</a></p>

</body>
<script>
if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
</script>

</html>
