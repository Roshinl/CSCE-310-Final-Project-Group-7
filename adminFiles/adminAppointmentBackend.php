<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

session_start();

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'root');
define('DB_NAME', 'group7');

$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

// DISPLAYS ALL STUDENTS FOR ADMIN

// PASSES IN THE LINK AND THE PAYLOAD. 0 = Student table, 1 = tutor, 2 = course, 3 = Appointments
$payload = "SELECT * FROM user WHERE is_tutor = 0";
$student_table = print_table(0, $link, $payload);

// DISPLAYS ALL TUTORS FOR ADMIN

$payload = "SELECT user.user_id, user.user_fname, user.user_lname, user.username, user.password, user.email, tutor.rate, tutor.review_avrg FROM user INNER JOIN tutor ON user.user_id = tutor.user_id";
$tutor_table = print_table(1, $link, $payload);


// DISPLAYS ALL COURSES FOR SELECTION

$payload = "SELECT * FROM courses";
$course_table = print_table(2, $link, $payload);

// DISPLAYS ALL APPOINTMENTS FOR ADMIN TO SEE

$payload = "SELECT * FROM appointments_table_with_names"; // Uses a view that has 3 inner joins to display course names and the user names
$appointments_table = print_table(3, $link, $payload);

// DISPLAYS THE STUDENT OPTIONS FOR THE DROP DOWN (DYNAMIC)

$payload = "SELECT username FROM user WHERE is_tutor = 0";
$student_options = mysqli_query($link, $payload);

// DISPLAYS THE TUTOR OPTIONS FOR THE DROP DOWN

$payload = "SELECT username FROM user WHERE is_tutor = 1";
$tutor_options = mysqli_query($link, $payload);

// DISPLAYS THE COURSE OPTIONS FOR THE DROP DOWN

$payload = "SELECT course_id FROM courses";
$course_options = mysqli_query($link, $payload);

// DISPLAYS THE APPOINTMENT ID OPTIONS FOR THE DROP DOWN
$payload = "SELECT app_id FROM appointments";
$appointment_ids = mysqli_query($link, $payload);

// LIST OF VALID TIMES FOR USERS TO CHOOSE FROM

$valid_times = array("09:00:00", "10:00:00", "11:00:00", "12:00:00", "13:00:00", "14:00:00", "15:00:00", "16:00:00", "17:00:00");

// SORTING STUDENT TABLE

if (isset($_POST['student_table_order'])) {
	$order_by = $_POST['student_table'];
	$payload = "SELECT * FROM user WHERE is_tutor = 0";
	// switch case decides which ORDER BY to append to the payload, which we send to for execution at the end
	switch ($order_by) {
		case 0:
			$payload .= " ORDER BY user_id";
		break;
		case 1:
			$payload .= " ORDER BY user_fname";
		break;
		case 2:
			$payload .= " ORDER BY user_lname";
		break;
		case 3:
			$payload .= " ORDER BY username";
		break;
		case 4:
			$payload .= " ORDER BY password";
		break;
		case 5:
			$payload .= " ORDER BY email";
		break;
		default:
			$payload .= "";
	}
	$student_table = print_table(0, $link, $payload);
}

// SORTING TUTOR TABLE

if (isset($_POST['tutor_table_order'])) {
	$order_by = $_POST['tutor_table'];
	$payload = "SELECT user.user_id, user.user_fname, user.user_lname, user.username, user.password, user.email, tutor.rate, tutor.review_avrg FROM user 
			INNER JOIN tutor ON user.user_id = tutor.user_id";
	switch ($order_by) {
		case 0:
			$payload .= " ORDER BY user_id";
		break;
		case 1:
			$payload .= " ORDER BY user_fname";
		break;
		case 2:
			$payload .= " ORDER BY user_lname";
		break;
		case 3:
			$payload .= " ORDER BY username";
		break;
		case 4:
			$payload .= " ORDER BY password";
		break;
		case 5:
			$payload .= " ORDER BY email";
		break;
		case 6:
			$payload .= " ORDER BY rate";
		break;
		case 7:
			$payload .= " ORDER BY review_avrg";
		break;
		default:
			$payload .= "";
	}
	$tutor_table = print_table(1, $link, $payload);
}

// SORTING COURSES TABLE

if (isset($_POST['course_table_order'])) {
	$order_by = $_POST['course_table'];
	$payload = "SELECT * FROM courses";
	switch ($order_by) {
		case 0:
			$payload .= " ORDER BY course_id";
		break;
		case 1:
			$payload .= " ORDER BY course_name";
		break;
		case 2:
			$payload .= " ORDER BY course_num";
		break;
		case 3:
			$payload .= " ORDER BY course_desc";
		break;
		default:
			$payload .= "";
	}
	$course_table = print_table(2, $link, $payload);
}

// SORTING APPOINTMENTS TABLE

if (isset($_POST['appt_table_order'])) {
	$order_by = $_POST['appt_table'];
	$payload = "SELECT * FROM appointments_table_with_names";
	switch ($order_by) {
		case 0:
			$payload .= " ORDER BY app_id";
		break;
		case 1:
			$payload .= " ORDER BY course_id";
		break;
		case 2:
			$payload .= " ORDER BY course_name";
		break;
		case 3:
			$payload .= " ORDER BY tutor_id";
		break;
		case 4:
			$payload .= " ORDER BY tutor_username";
		break;
		case 5:
			$payload .= " ORDER BY student_id";
		break;
		case 6:
			$payload .= " ORDER BY student_username";
		break;
		case 7:
			$payload .= " ORDER BY appoint_date";
		break;
		case 8:
			$payload .= " ORDER BY appoint_start_time";
		break;
		case 9:
			$payload .= " ORDER BY appoint_end_time";
		break;
		case 10:
			$payload .= " ORDER BY status";
		break;
		default:
			$payload .= "";
	}
	$appointments_table = print_table(3, $link, $payload);
}

// CREATING APPOINTMENT

if (isset($_POST['create_appointment'])) {
	$student_username = mysqli_real_escape_string($link, $_POST['student_username']);
	$tutor_username = mysqli_real_escape_string($link, $_POST['tutor_username']);
	$course_id = mysqli_real_escape_string($link, $_POST['course_id']);
	$appointment_date = date('Y-m-d', strtotime($_POST['appointment_date']));
	$start_time = date('H:i:s', strtotime($_POST['start_time']));
	$end_time = date('H:i:s', strtotime($_POST['end_time']));
	
	$error = False;
	$errorMessage = "";
	
	// CHECK IF TIME IS VALID
	// Unix time must be used in order to compare time
	
	$unix_start_time = strtotime($start_time);
	$unix_end_time = strtotime($end_time);
	
	if ($unix_start_time >= $unix_end_time)
	{
		echo '<script type="text/javascript">
		   window.onload = function () { alert("Sorry, your end time cannot be equal or less than your start time"); } 
			</script>';	
		$error = True;
	}
	
	// CHECK IF DATE IS CHOSEN IS BEFORE CURRENT DAY
	
	if (strtotime($appointment_date) <= strtotime('now'))
	{
		echo '<script type="text/javascript">
		   window.onload = function () { alert("Sorry, your appointment date cannot be before today"); } 
			</script>';	
		$error = True;
	}
	
	// Fetches tutor's id
	$payload = "SELECT user_id FROM user WHERE username = '$tutor_username' LIMIT 1";
	$result = mysqli_query($link, $payload);
	$tutor_id = mysqli_fetch_assoc($result)["user_id"];
	
	// Fetches user's id
	$payload = "SELECT user_id FROM user WHERE username = '$student_username' LIMIT 1";
	$result = mysqli_query($link, $payload);
	$student_id = mysqli_fetch_assoc($result)["user_id"];
	
	// CHECK IF TUTOR HAS AN APPOINTMENT ON THE SAME DAY WITH CONFLICTING TIMES
	// Conditions for failure:
	// Same date && appointment exists on that date already &&
	// (start_time > existing_start_time && start_time < existing_end_time) || << starts after existing and before it ends
	// (start_time < existing_start_time && end_time > existing_end_time) || << envelops
	// (end_time > existing_start_time && end_time < existing_end_time) << end after existing starts and before it ends
	
	$payload = "SELECT appoint_start_time, appoint_end_time FROM appointments WHERE tutor_id = '$tutor_id' AND appoint_date = '$appointment_date'";
	$result = mysqli_query($link, $payload);
	
	// Tutor has appointment on that date already, check for time conflict
	if (mysqli_num_rows($result) > 0) {
		while ($row = mysqli_fetch_assoc($result)) {
			$existing_start_time = strtotime($row["appoint_start_time"]);
			$existing_end_time = strtotime($row["appoint_end_time"]);
			
			if ($unix_start_time > $existing_start_time && $unix_start_time < $existing_end_time)
			{
				$error = True;
			}
			else if ($unix_start_time < $existing_start_time && $unix_end_time > $existing_end_time)
			{
				$error = True;
			}
			else if ($unix_end_time > $existing_start_time && $unix_end_time < $existing_end_time)
			{
				$error = True;
			}
			
			if ($error)
			{
				echo '<script type="text/javascript">
			   window.onload = function () { alert("Sorry, the tutor has a conflicting appointment at your selected time"); } 
				</script>';	
				break;
			}
		}
	}
	
	// CHECK IF STUDENT HAS AN APPOINTMENT ON THE SAME DAY WITH CONFLICTING TIMES
	// Conditions for failure:
	// Same date && appointment exists on that date already &&
	// (start_time > existing_start_time && start_time < existing_end_time) || << starts after existing and before it ends
	// (start_time < existing_start_time && end_time > existing_end_time) || << envelops
	// (end_time > existing_start_time && end_time < existing_end_time) << end after existing starts and before it ends
	
	$payload = "SELECT appoint_start_time, appoint_end_time FROM appointments WHERE student_id = '$student_id' AND appoint_date = '$appointment_date'";
	$result = mysqli_query($link, $payload);
	
	// Student has appointment on that date already, check for time conflict
	if (mysqli_num_rows($result) > 0) {
		while ($row = mysqli_fetch_assoc($result)) {
			$existing_start_time = strtotime($row["appoint_start_time"]);
			$existing_end_time = strtotime($row["appoint_end_time"]);
			
			if ($unix_start_time > $existing_start_time && $unix_start_time < $existing_end_time)
			{
				$error = True;
			}
			else if ($unix_start_time < $existing_start_time && $unix_end_time > $existing_end_time)
			{
				$error = True;
			}
			else if ($unix_end_time > $existing_start_time && $unix_end_time < $existing_end_time)
			{
				$error = True;
			}
			
			if ($error)
			{
				echo '<script type="text/javascript">
			   window.onload = function () { alert("Sorry, you have a conflicting appointment at the selected time"); } 
				</script>';	
				break;
			}
		}
	}
	
	if (!$error)
	{
		$payload = "INSERT INTO appointments (course_id, tutor_id, student_id, appoint_date, appoint_start_time, 
		appoint_end_time) VALUES ('$course_id', '$tutor_id', '$student_id', '$appointment_date', '$start_time', '$end_time')";
		
		if (!mysqli_query($link, $payload))
		{
			echo("Error description: " . mysqli_error($link));
		}
		
		header('Location: adminAppointment.php');
	}
	
}

// EDITING APPOINTMENT

if (isset($_POST['edit_appointment'])) {
	$app_id = mysqli_real_escape_string($link, $_POST['selected_appointment_id']);
	$appointment_date = date('Y-m-d', strtotime($_POST['new_date']));
	$start_time_string = mysqli_real_escape_string($link, $_POST['new_start_time']);
	$end_time_string = mysqli_real_escape_string($link, $_POST['new_end_time']);
	$start_time = date('H:i:s', strtotime($start_time_string));
	$end_time = date('H:i:s', strtotime($end_time_string));
	$status = mysqli_real_escape_string($link, $_POST['new_status']);
	
	$error = False;
	$errorMessage = "";
	
	$payload = "SELECT tutor_id, student_id, appoint_date, appoint_start_time, appoint_end_time, status FROM appointments WHERE app_id = '$app_id'";
	$result = mysqli_query($link, $payload); 
	
	$row = mysqli_fetch_assoc($result);
				
	// SETS THE DEFAULT VALUE FOR EACH ENTRY IF NOTHING IS ENTERED
	
	// Date default value, means user didn't enter anything for date
	// Set date to what is already in DB
	if ($appointment_date == "1970-01-01") {
		$appointment_date = $row["appoint_date"];
	}
	
	// If the inputted start time was an empty string, then it defaults to midnight. Thus, we want to check against empty string
	// You could also check the start_time against midnight, since midnight is not a valid input
	if ($start_time_string == "") {
		$start_time = date('H:i:s', strtotime($row["appoint_start_time"]));
	}
	else {
		$start_time = date('H:i:s', strtotime($_POST['new_start_time']));
	}
	
	// Same logic as above
	if ($end_time_string == "") {
		$end_time = date('H:i:s', strtotime($row["appoint_end_time"]));
	}
	else {
		$end_time = date('H:i:s', strtotime($_POST['new_end_time']));
	}
	
	if ($status == "") {
		$status = $row["status"];
	}
	
	$tutor_id = $row["tutor_id"];
	$student_id = $row["student_id"];
	
	// CHECK IF DATE IS VALID
	
	$unix_start_time = strtotime($start_time);
	$unix_end_time = strtotime($end_time);
	
	if ($unix_start_time >= $unix_end_time)
	{
		echo '<script type="text/javascript">
		   window.onload = function () { alert("Sorry, your end time cannot be equal or less than your start time"); } 
			</script>';	
		$error = True;
	}
	
	// CHECK IF DATE IS BEFORE THE CURRENT DATE
	
	if (strtotime($appointment_date) <= strtotime('now'))
	{
		echo '<script type="text/javascript">
		   window.onload = function () { alert("Sorry, your appointment date cannot be before today"); } 
			</script>';	
		$error = True;
	}
	
	// CHECK IF TUTOR HAS AN APPOINTMENT ON THE SAME DAY WITH CONFLICTING TIMES
	// Conditions for failure:
	// Same date && appointment exists on that date already &&
	// (start_time > existing_start_time && start_time < existing_end_time) || << starts after existing and before it ends
	// (start_time < existing_start_time && end_time > existing_end_time) || << envelops
	// (end_time > existing_start_time && end_time < existing_end_time) << end after existing starts and before it ends
	
	$payload = "SELECT appoint_start_time, appoint_end_time FROM appointments WHERE tutor_id = '$tutor_id' AND appoint_date = '$appointment_date' AND app_id != '$app_id'";
	$result = mysqli_query($link, $payload);
	
	// Tutor has appointment on that date already, check for time conflict
	if (mysqli_num_rows($result) > 0) {
		while ($row = mysqli_fetch_assoc($result)) {
			$existing_start_time = strtotime($row["appoint_start_time"]);
			$existing_end_time = strtotime($row["appoint_end_time"]);
			
			if ($unix_start_time > $existing_start_time && $unix_start_time < $existing_end_time)
			{
				$error = True;
			}
			else if ($unix_start_time < $existing_start_time && $unix_end_time > $existing_end_time)
			{
				$error = True;
			}
			else if ($unix_end_time > $existing_start_time && $unix_end_time < $existing_end_time)
			{
				$error = True;
			}
			
			if ($error)
			{
				echo '<script type="text/javascript">
			   window.onload = function () { alert("Sorry, the tutor has a conflicting appointment at your selected time"); } 
				</script>';	
				break;
			}
		}
	}
	
	// CHECK IF STUDENT HAS AN APPOINTMENT ON THE SAME DAY WITH CONFLICTING TIMES
	// Conditions for failure:
	// Same date && appointment exists on that date already &&
	// (start_time > existing_start_time && start_time < existing_end_time) || << starts after existing and before it ends
	// (start_time < existing_start_time && end_time > existing_end_time) || << envelops
	// (end_time > existing_start_time && end_time < existing_end_time) << end after existing starts and before it ends
	
	$payload = "SELECT appoint_start_time, appoint_end_time FROM appointments WHERE student_id = '$student_id' AND appoint_date = '$appointment_date' AND app_id != '$app_id'";
	$result = mysqli_query($link, $payload);
	
	// Student has appointment on that date already, check for time conflict
	if (mysqli_num_rows($result) > 0) {
		while ($row = mysqli_fetch_assoc($result)) {
			$existing_start_time = strtotime($row["appoint_start_time"]);
			$existing_end_time = strtotime($row["appoint_end_time"]);
			
			if ($unix_start_time > $existing_start_time && $unix_start_time < $existing_end_time)
			{
				$error = True;
			}
			else if ($unix_start_time < $existing_start_time && $unix_end_time > $existing_end_time)
			{
				$error = True;
			}
			else if ($unix_end_time > $existing_start_time && $unix_end_time < $existing_end_time)
			{
				$error = True;
			}
			
			if ($error)
			{
				echo '<script type="text/javascript">
			   window.onload = function () { alert("Sorry, you have a conflicting appointment at the selected time"); } 
				</script>';	
				break;
			}
		}
	}
	
	if (!$error)
	{
		$payload = "UPDATE appointments SET appoint_date = '$appointment_date', appoint_start_time = '$start_time', appoint_end_time = '$end_time', status = '$status' WHERE app_id = '$app_id'";
		$result = mysqli_query($link, $payload);
		
		header('Location: adminAppointment.php');
	}
	
}


if (isset($_POST['delete_appointment_id'])) {
	$to_delete_id = mysqli_real_escape_string($link, $_POST['selected_appointment_id']);
	
	$payload = "DELETE FROM appointments WHERE app_id = '$to_delete_id'";
	$execute = mysqli_query($link, $payload);
	
	header('Location: adminAppointment.php');
}

function print_table($type, $link, $payload) {
	$table = "";
	// Type: 0 = Student table, 1 = Tutor table, 2 = Course table, 3 = Appointment table
	// Since all the tables have different column headings, the switch case decides which one to use based on the table type that was passed in
	switch ($type) {
		case 0:
			$table .= "<table><caption>Student table</caption><tr><th>User ID</th><th>Student name</th><th>Student username</th><th>Student password</th><th>Student email</th></tr>";
		break;
		case 1:
			$table .= "<table><caption>Tutor table</caption><tr><th>Tutor ID</th><th>Tutor name</th><th>Tutor username</th><th>Tutor password</th><th>Tutor email</th><th>Tutor rate</th><th>Tutor review average</th></tr>";
		break;
		case 2:
			$table .= "<table><caption>Courses table</caption><tr><th>Course ID</th><th>Course name</th><th>Course number</th><th>Course description</th></tr>";
		break;
		case 3:
			$table .= "<table><caption>Appointments table</caption><tr><th>Appointment ID</th><th>Course ID</th><th>Course name</th><th>Tutor ID</th><th>Tutor username</th><th>Student ID</th><th>Student username</th><th>Appointment date</th>
			<th>Start time</th><th>End time</th><th>Status</th></tr>";
		break;
		default:
			$table .= "<table><caption>Appointments table</caption><tr><th>Appointment ID</th><th>Course ID</th><th>Course name</th><th>Tutor ID</th><th>Tutor username</th><th>Student ID</th><th>Student username</th><th>Appointment date</th>
			<th>Start time</th><th>End time</th><th>Status</th></tr>";
	}
	
	$result = mysqli_query($link, $payload);

	if (mysqli_num_rows($result) > 0) {
		while ($row = mysqli_fetch_assoc($result)) {
			// Since the column sizes are different and have different attribute names, if else decides the attribute names (and number of columns) to use depending on the type that was passed in
			if ($type == 0) {
				$table .= "<tr><td>".$row["user_id"]."</td><td>".$row["user_fname"]." ".$row["user_lname"]."</td><td>".$row["username"]."</td><td>".$row["password"]."</td><td>".$row["email"]."</td></tr>";
			}
			else if ($type == 1) {
				$table .= "<tr><td>".$row["user_id"]."</td><td>".$row["user_fname"]." ".$row["user_lname"]."</td><td>".$row["username"]."</td><td>".$row["password"]."</td><td>".$row["email"]."</td><td>".$row["rate"]."</td><td>".$row["review_avrg"]."</td></tr>";
			}
			else if ($type == 2) {
				$table .= "<tr><td>".$row["course_id"]."</td><td>".$row["course_name"]."</td><td>".$row["course_num"]."</td><td>".$row["course_desc"]."</td></tr>";
			}
			else if ($type == 3) {
				$table .= "<tr><td>".$row["app_id"]."</td><td>".$row["course_id"]."</td><td>".$row["course_name"]."</td><td>".$row["tutor_id"]."</td><td>".$row["tutor_username"]."</td><td>".$row["student_id"]."</td><td>".$row["student_username"]."</td>
				<td>".$row["appoint_date"]."</td><td>".$row["appoint_start_time"]."</td><td>".$row["appoint_end_time"]."</td><td>".$row["status"]."</td></tr>";
			}
		}
		$table .= "</table>";
	}
	else 
	{
		$table .= "</table>";
		$table .= "<p>0 results</p>";
	}
	return $table;
}

mysqli_close($link);

?>
