<?php include ('adminAppointmentBackend.php')?>
<!DOCTYPE html>
<html>
<style>
table, th, td {
  border: 1px solid;
}
caption {
	font-weight: bold;
}
</style>

<body>
<?php echo "<p>Logged in as: " . $_SESSION["username"] . "</p>";?>

<p>Select a user and a tutor below to create an appointment along with a time.</p> 
<p>Tutors are available from 9AM to 5PM.</p>

</br>
</br>
<!-- Radio buttons used to choose how to sort the table !-->
<form method="post" action="adminAppointment.php">
	<label>Sort Student table</label>
	</br>

	<input type="radio" id="student1" name="student_table" value="0">
	<label for="student1">Order by ID</label>
	
	<input type="radio" id="student2" name="student_table" value="1">
	<label for="student2">Order by first name</label>
	
	<input type="radio" id="student2" name="student_table" value="2">
	<label for="student2">Order by last name</label>

	<input type="radio" id="student3" name="student_table" value="3">
	<label for="student3">Order by username</label>

	<input type="radio" id="student4" name="student_table" value="4">
	<label for="student4">Order by password</label>

	<input type="radio" id="student5" name="student_table" value="5">
	<label for="student5">Order by email</label>
	
	</br>
	<button type="submit" class="btn" name="student_table_order">Submit</button>
</form>
<?php echo $student_table; ?>

</br>
</br>
<form method="post" action="adminAppointment.php">
	<label>Sort Tutor table</label>
	</br>

	<input type="radio" id="tutor1" name="tutor_table" value="0">
	<label for="tutor1">Order by ID</label>
	
	<input type="radio" id="tutor2" name="tutor_table" value="1">
	<label for="tutor2">Order by first name</label>
	
	<input type="radio" id="tutor3" name="tutor_table" value="2">
	<label for="tutor3">Order by last name</label>

	<input type="radio" id="tutor4" name="tutor_table" value="3">
	<label for="tutor4">Order by username</label>

	<input type="radio" id="tutor5" name="tutor_table" value="4">
	<label for="tutor5">Order by password</label>

	<input type="radio" id="tutor6" name="tutor_table" value="5">
	<label for="tutor6">Order by email</label>
	
	<input type="radio" id="tutor7" name="tutor_table" value="6">
	<label for="tutor7">Order by rate</label>
	
	<input type="radio" id="tutor8" name="tutor_table" value="7">
	<label for="tutor8">Order by review average</label>
	
	</br>
	<button type="submit" class="btn" name="tutor_table_order">Submit</button>
</form>
<?php echo $tutor_table; ?>

</br>
</br>
<form method="post" action="adminAppointment.php">
	<label>Sort Courses table</label>
	</br>

	<input type="radio" id="course1" name="course_table" value="0">
	<label for="course1">Order by ID</label>
	
	<input type="radio" id="course2" name="course_table" value="1">
	<label for="course2">Order by course name</label>
	
	<input type="radio" id="course3" name="course_table" value="2">
	<label for="course3">Order by course number</label>

	<input type="radio" id="course4" name="course_table" value="3">
	<label for="course4">Order by course description</label>
	
	</br>
	<button type="submit" class="btn" name="course_table_order">Submit</button>
</form>
<?php echo $course_table; ?>

</br>
</br>
<form method="post" action="adminAppointment.php">
	<label>Sort Appointment table</label>
	</br>

	<input type="radio" id="appt1" name="appt_table" value="0">
	<label for="appt1">Order by ID</label>
	
	<input type="radio" id="appt2" name="appt_table" value="1">
	<label for="appt2">Order by course ID</label>
	
	<input type="radio" id="appt3" name="appt_table" value="2">
	<label for="appt3">Order by course name</label>

	<input type="radio" id="appt4" name="appt_table" value="3">
	<label for="appt4">Order by tutor ID</label>

	<input type="radio" id="appt5" name="appt_table" value="4">
	<label for="appt5">Order by tutor username</label>

	<input type="radio" id="appt6" name="appt_table" value="5">
	<label for="appt6">Order by student ID</label>
	
	<input type="radio" id="appt7" name="appt_table" value="6">
	<label for="appt7">Order by student username</label>
	
	<input type="radio" id="appt8" name="appt_table" value="7">
	<label for="appt8">Order by date</label>
	
	<input type="radio" id="appt9" name="appt_table" value="8">
	<label for="appt9">Order by start time</label>
	
	<input type="radio" id="appt10" name="appt_table" value="9">
	<label for="appt10">Order by end time</label>
	
	<input type="radio" id="appt11" name="appt_table" value="10">
	<label for="appt11">Order by status</label>
	
	</br>
	<button type="submit" class="btn" name="appt_table_order">Submit</button>
</form>
<?php echo $appointments_table; ?>

</br>
</br>

<form method="post" action="adminAppointment.php">
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
	
	</br>
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
	<label>Select the appointment that you want to change (Required)</label>
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

	</br>
	<label>Change the date of the appointment</label>
	<input type = "date" name = "new_date">

	</br>
	<label>Change the start time of the appointment</label>
	<select name = "new_start_time">
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
	<label>Change the end time of the appointment</label>
	<select name = "new_end_time">
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
	<label>Change the appointment from ongoing (1) to finished (0)</label>
	<select name = "new_status">
		<option value = ""></option>
		<option value = 0>0</option>
		<option value = 1>1</option>
	</select>
	
	<button type="submit" class="btn" name="edit_appointment">Submit</button>
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
