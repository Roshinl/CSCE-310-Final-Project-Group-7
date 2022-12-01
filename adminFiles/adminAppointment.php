<?php include ('adminAppointmentBackend.php')?>
<!DOCTYPE html>
<html>
<style>
table, th, td {
  border: 1px solid;
}
</style>

<body>
<?php echo "<p>Logged in as: " . $_SESSION["username"] . "</p>";?>

<p>Select a user and a tutor below to create an appointment along with a time.</p> 
<p>Tutors are available from 9AM to 5PM.</p>

<?php echo $student_table; ?>
</br>
</br>
<?php echo $tutor_table; ?>
</br>
</br>
<?php echo $course_table; ?>
</br>
</br>
<?php echo $appointments_table; ?>
</br>
</br>

<form method="post" action="adminAppointment.php">
	<label>Select a student</label>
	<select required name = "student_username">
		<option value = ""></option>
		<?php
			$i = 0;
			while ($student_username = mysqli_fetch_array($student_options, MYSQLI_NUM)):;
		?>
		<option value = "<?php echo $student_username[0]; ?>">
			<?php 
				echo $student_username[0]; 
			?>
		</option>
		<?php 
			endwhile; 
		?>
	</select>
	
	<label>Select a tutor</label>
	<select required name = "tutor_username">
		<option value = ""></option>
		<?php
			$i = 0;
			while ($tutor_username = mysqli_fetch_array($tutor_options, MYSQLI_NUM)):;
		?>
		<option value = "<?php echo $tutor_username[0]; ?>">
			<?php 
				echo $tutor_username[0]; 
			?>
		</option>
		<?php 
			endwhile; 
		?>
	</select>
	
	</br>
	<label>Select a course ID</label>
	<select required name = "course_id">
		<option value = ""></option>
		<?php
			$i = 0;
			while ($course_id = mysqli_fetch_array($course_options, MYSQLI_NUM)):;
		?>
		<option value = "<?php echo $course_id[0]; ?>">
			<?php 
				echo $course_id[0]; 
			?>
		</option>
		<?php 
			endwhile; 
		?>
	</select>
	
	</br>
	<label>Select a day</label>
	<input type = "date" required name = "appointment_date">
	
	</br>
	<label>Select a start time</label>
	<select required name = "start_time">
		<option value = ""></option>
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
	
	<label>Select an end time</label>
	<select required name = "end_time">
		<option value = ""></option>
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
	
	</br>
	<button type="submit" class="btn" name="create_appointment">Create appointment</button>
</form>
</br>
</br>

<!-- PHP FOR EDITING APPOINTMENT !-->
<!-- Note: it makes 0 sense for someone to edit the tutor they want. 
You should just create a new appointment with that tutor. Same goes for the course. The only
editable things should be appointment date/times !-->

<form method="post" action="adminAppointment.php">
	<label>Change the date of the appointment</label>
	<input type = "date" required name = "new_date">
	<button type="submit" class="btn" name="edit_date">Submit</button>
</form>

<form method="post" action="adminAppointment.php">
	<label>Change the start time of the appointment (NOTE: You must also select an end time)</label>
	<select required name = "new_start_time">
		<option value = ""></option>
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
	<label>Change the end time of the appointment</label>
	<select required name = "new_end_time">
		<option value = ""></option>
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
	<button type="submit" class="btn" name="edit_time">Submit</button>
</form>

<form method="post" action="adminAppointment.php">
	<label>Change the appointment from ongoing (1) to finished (0)</label>
	<select required name = "new_status">
		<option value = ""></option>
		<option value = 0>0</option>
		<option value = 1>1</option>
	</select>
	<button type="submit" class="btn" name="edit_status">Submit</button>
</form>

<!-- DELETING AN APPOINTMENT COMPLETELY !-->

</br>
</br>
<form method="post" action="adminAppointment.php">
	<label>Select an appointment ID to delete (NOTE: You will be deleting the record)</label>
	<select required name = "selected_appointment_id">
		<option value = ""></option>
		<?php
			while ($indv_appointmentID = mysqli_fetch_array($appointment_ids, MYSQLI_NUM)):;
		?>
		<option value = "<?php echo $indv_appointmentID[0];?>">
			<?php 
				echo $indv_appointmentID[0]; 
			?>
		</option>
		<?php
			endwhile;
		?>
	</select>
	<input name="delete_appointment_id" type="submit" value="Delete" onclick="return confirm('Are you sure?')">
</form>

<!-- RETURN TO HOME PAGE !-->

<p>Click here to go back to the home page <a href = "adminHomePage.php">Click here</a></p>

<!-- SIGNOUT !--> 
<!--
<form method="post" action="adminAppointment.php">
	<button type="submit" class="btn" name="signout">Signout</button>
</form>
!-->
</body>

<!-- PREVENTS ANNOYING RESUBMIT FORM MESSAGE FROM SHOWING UP -->
<script>
if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
</script>

</html>
