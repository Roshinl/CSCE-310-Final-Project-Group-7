
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

function checkValidDate($appointment_date){
	$error = False;

	if (strtotime($appointment_date) <= strtotime('now'))
	    {
	        echo '<script type="text/javascript">
	        window.onload = function () { alert("Sorry, your appointment date cannot be before today."); } 
	            </script>';	
	        $error = True;
	    }
		return $error;
}

function checkValidTime($unix_start_time, $unix_end_time){
	$error = False;

	if ($unix_start_time >= $unix_end_time)
	{
		echo '<script type="text/javascript">
		   window.onload = function () { alert("Sorry, your end time cannot be equal or less than your start time"); } 
			</script>';	
		$error = True;
	}
}

function checkValidDateTime($appointment_date, $unix_start_time, $unix_end_time){
	//CHECK FOR VALID TIMES
	$error = False;

	if ($unix_start_time >= $unix_end_time)
	{
		echo '<script type="text/javascript">
		   window.onload = function () { alert("Sorry, your end time cannot be equal or less than your start time"); } 
			</script>';	
		$error = True;
	}


    // CHECK IF DATE IS CHOSEN IS BEFORE CURRENT DAY
	echo "got to function";
    if (strtotime($appointment_date) <= strtotime('now'))
    {
        echo '<script type="text/javascript">
        window.onload = function () { alert("Sorry, your appointment date cannot be before today."); } 
            </script>';	
        $error = True;
    }
	return $error;
}


// CURRENT USERNAME AND STUDENT_ID
$student_username = $_SESSION["username"];
$query = "SELECT user_id FROM user WHERE username = '$student_username' LIMIT 1";
$result = mysqli_query($link, $query);//geting student_if from current student logged in
$student_id = mysqli_fetch_assoc($result)["user_id"];


// DISPLAYING TABLES FOR USERS - TABLE
$tutor_table = "";

$payload = "SELECT user.user_id, user.user_fname, user.user_lname, user.username, user.password, user.email, tutor.rate, tutor.review_avrg FROM user INNER JOIN tutor ON user.user_id = tutor.user_id";
$result = mysqli_query($link, $payload);

if (mysqli_num_rows($result) > 0) {
	$tutor_table .= "<table><caption>Tutor table</caption><tr><th>Tutor ID</th><th>Tutor name</th><th>Tutor username</th><th>Tutor password</th><th>Tutor email</th><th>Tutor rate</th><th>Tutor review average</th></tr>";
	while ($row = mysqli_fetch_assoc($result)) {
		$tutor_table .= "<tr><td>".$row["user_id"]."</td><td>".$row["user_fname"]." ".$row["user_lname"]."</td><td>".$row["username"]."</td><td>".$row["password"]."</td><td>".$row["email"]."</td><td>".$row["rate"]."</td><td>".$row["review_avrg"]."</td></tr>";
	}
	$tutor_table .= "</table>";
}
else 
{
	$tutor_table .= "<table><caption>Tutor table</caption><tr><th>Tutor ID</th><th>Tutor name</th><th>Tutor username</th><th>Tutor password</th><th>Tutor email</th><th>Tutor rate</th><th>Tutor review average</th></tr>";
	$tutor_table .= "<p>0 results</p>";
}

// DISPLAYS ALL COURSES FOR SELECTION - TABLE

$course_table = "";

$payload = "SELECT * FROM courses";
$result = mysqli_query($link, $payload);

if (mysqli_num_rows($result) > 0) {
	$course_table .= "<table><caption>Courses table</caption><tr><th>Course ID</th><th>Course name</th><th>Course number</th><th>Course description</th></tr>";
	while ($row = mysqli_fetch_assoc($result)) {
		$course_table .= "<tr><td>".$row["course_id"]."</td><td>".$row["course_name"]."</td><td>".$row["course_num"]."</td><td>".$row["course_desc"]."</td></tr>";
	}
	$course_table .= "</table>";
}
else 
{
	$course_table .= "<table><caption>Courses table</caption><tr><th>Course ID</th><th>Course name</th><th>Course number</th><th>Course description</th></tr>";
	$course_table .= "<p>0 results</p>";
}

// DISPLAYS THE CURRENT USERS' APPOINTMENTS FOR VIEWING - TABLE
$users_appointments_table = "";

$query = "SELECT * FROM appointments WHERE student_id='$student_id'";
$result = mysqli_query($link, $query);


if (mysqli_num_rows($result) > 0) {
    $users_appointments_table .= "<table><caption>Appointments table</caption><tr><th>App ID</th><th>Course ID</th><th>Tutor ID</th><th>Student ID</th><th>Appointment Date</th><th>Start Time</th><th>End Time</th><th>Status</th></tr>";

	while ($row = mysqli_fetch_assoc($result)) {
		$users_appointments_table .= "<tr>  <td>".$row["app_id"]."</td> <td>".$row["course_id"]."</td> <td> ".$row["tutor_id"]."</td> <td>".$row["student_id"]."</td> <td>".$row["appoint_date"]."</td> <td>".$row["appoint_start_time"]."</td> <td>".$row["appoint_end_time"]."</td> <td>".$row["status"]."</td></tr>";
	}
	$users_appointments_table .= "</table>";
}
else //no appointments for this user
{
    $users_appointments_table .= "<table><caption>Appointments table</caption><tr><th>App ID</th><th>Course ID</th><th>Tutor ID</th><th>Student ID</th><th>Appointment Date</th><th>Start Time</th><th>End Time</th><th>Status</th></tr>";
	$users_appointments_table .= "<p>0 results</p>";
}



// GET ALL COURSES FOR DROPDOWN
$query = "SELECT course_name FROM courses";
$availableCourses = array();

if ($stmt = mysqli_prepare($link, $query)) {
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $name);
    while (mysqli_stmt_fetch($stmt)) {
        $availableCourses[] = $name;  // write this to an array
    }

    mysqli_stmt_close($stmt);
}

//GET ALL TUTORS FOR DROPDOWN
$query = "SELECT username FROM user WHERE is_tutor=1";
$availableTutors = array();

if ($stmt = mysqli_prepare($link, $query)) {
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $name);
    while (mysqli_stmt_fetch($stmt)) {
        $availableTutors[] = $name;  // write this to an array
    }
    mysqli_stmt_close($stmt);
}

//GET ALL DATES FOR DROPDOWN -> this should be any date

$query = "SELECT appoint_date FROM appointments";
$availableDates = array();

if ($stmt = mysqli_prepare($link, $query)) {
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $name);
    while (mysqli_stmt_fetch($stmt)) {
        $availableDates[] = $name;  // write this to an array
    }
    mysqli_stmt_close($stmt);
}

//GET ALL END and START TIMES FOR DROPDOWN -> this should be any time from 9-5

$valid_times = array("09:00:00", "10:00:00", "11:00:00", "12:00:00", "13:00:00", "14:00:00", "15:00:00", "16:00:00", "17:00:00");


//GET ALL APPOINTMENTS FOR THE USER TO CHOOSE FOR DELETION
$student_username = $_SESSION["username"];

$query = "SELECT app_id,appoint_date,appoint_start_time FROM appointments WHERE student_id='$student_id'";
//TO DO - account for when user doesn't have any appointments (just blank rn)

$bookedAppointments = array();


if ($stmt = mysqli_prepare($link, $query)) {
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $id, $date, $time);
    while (mysqli_stmt_fetch($stmt)) {
        $string =  "App ID: $id, Date: $date, Start Time: $time";
        $bookedAppointments[] = $string;  // write this to an array
    }
    mysqli_stmt_close($stmt);
}


//not using this function right now
function checkTutorConlicts($tutor_id, $appointment_date, $unix_start_time, $unix_end_time){
	print_r("-----------------------------------------------");
	print_r($tutor_id);
	print_r($appointment_date);

	$payload = "SELECT appoint_start_time, appoint_end_time FROM appointments WHERE tutor_id = '$tutor_id' AND appoint_date = '$appointment_date'";
	$result = mysqli_query($link, $payload);
	
	// Tutor has appointment on that date already, check for time conflict
	if (mysqli_num_rows($result) > 0) {
		while ($row = mysqli_fetch_assoc($result)) {
			$existing_start_time = strtotime($row["appoint_start_time"]);
			$existing_end_time = strtotime($row["appoint_end_time"]);
			
			if ($unix_start_time >= $existing_start_time && $unix_start_time <= $existing_end_time)
			{
				$error = True;
			}
			else if ($unix_start_time <= $existing_start_time && $unix_end_time >= $existing_end_time)
			{
				$error = True;
			}
			else if ($unix_end_time >= $existing_start_time && $unix_end_time <= $existing_end_time)
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
}

// ADDING APPOINTMENT FOR USER
if (isset($_POST['add_appointment'])) { 
    echo ("Got to appt backend!");

    $tutor = mysqli_real_escape_string($link, $_POST['availTutor']);
    $appointment_date = date('Y-m-d', strtotime($_POST['availDate']));
    $start_time = date('H:i:s', strtotime($_POST['availStartTime']));
	$end_time = date('H:i:s', strtotime($_POST['availEndTime']));    $student = $_SESSION["username"];
    $course_name = mysqli_real_escape_string($link, $_POST['availCourses']);

    //geting course_id from chosen course_name
    $query = "SELECT course_id FROM courses WHERE course_name = '$course_name' LIMIT 1";
	$result = mysqli_query($link, $query);
	$course_id = mysqli_fetch_assoc($result)["course_id"];

     //geting tutor_id from chosen tutor_name
     $query = "SELECT user_id FROM user WHERE username = '$tutor' LIMIT 1";
     $result = mysqli_query($link, $query);
     $tutor_id = mysqli_fetch_assoc($result)["user_id"];
	

    // CHECK IF TIME IS VALID
	$unix_start_time = strtotime($start_time);
	$unix_end_time = strtotime($end_time);
	
	// CHECK IF DATE IS CHOSEN IS BEFORE CURRENT DAY
	$error = checkValidDateTime($appointment_date, $unix_start_time, $unix_end_time);
	
// CHECK IF TUTOR HAS AN APPOINTMENT ON THE SAME DAY WITH CONFLICTING TIMES
	// Conditions for failure:
	// Same date && appointment exists on that date already &&
	// (start_time >= existing_start_time && start_time <= existing_end_time) || << starts after existing and before it ends
	// (start_time <= existing_start_time && end_time >= existing_end_time) || << envelops
	// (end_time >= existing_start_time && end_time <= existing_end_time) << end after existing starts and before it ends
	// $error = checkTutorConlicts($tutor_id, $appointment_date, $unix_start_time, $unix_end_time);

	$payload = "SELECT appoint_start_time, appoint_end_time FROM appointments WHERE tutor_id = '$tutor_id' AND appoint_date = '$appointment_date'";
	$result = mysqli_query($link, $payload);
	
	// Tutor has appointment on that date already, check for time conflict
	if (mysqli_num_rows($result) > 0) {
		while ($row = mysqli_fetch_assoc($result)) {
			$existing_start_time = strtotime($row["appoint_start_time"]);
			$existing_end_time = strtotime($row["appoint_end_time"]);
			
			if ($unix_start_time >= $existing_start_time && $unix_start_time <= $existing_end_time)
			{
				$error = True;
			}
			else if ($unix_start_time <= $existing_start_time && $unix_end_time >= $existing_end_time)
			{
				$error = True;
			}
			else if ($unix_end_time >= $existing_start_time && $unix_end_time <= $existing_end_time)
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
	// (start_time >= existing_start_time && start_time <= existing_end_time) || << starts after existing and before it ends
	// (start_time <= existing_start_time && end_time >= existing_end_time) || << envelops
	// (end_time >= existing_start_time && end_time <= existing_end_time) << end after existing starts and before it ends
	
	$payload = "SELECT appoint_start_time, appoint_end_time FROM appointments WHERE student_id = '$student_id' AND appoint_date = '$appointment_date'";
	$result = mysqli_query($link, $payload);
	
	// Student has appointment on that date already, check for time conflict
	if (mysqli_num_rows($result) > 0) {
		while ($row = mysqli_fetch_assoc($result)) {
			$existing_start_time = strtotime($row["appoint_start_time"]);
			$existing_end_time = strtotime($row["appoint_end_time"]);
			
			if ($unix_start_time >= $existing_start_time && $unix_start_time <= $existing_end_time)
			{
				$error = True;
			}
			else if ($unix_start_time <= $existing_start_time && $unix_end_time >= $existing_end_time)
			{
				$error = True;
			}
			else if ($unix_end_time >= $existing_start_time && $unix_end_time <= $existing_end_time)
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
	
	if (!$error) //if no errors, insert into DB
	{
		$payload = "INSERT INTO appointments (course_id, tutor_id, student_id, appoint_date, appoint_start_time, 
		appoint_end_time) VALUES ('$course_id', '$tutor_id', '$student_id', '$appointment_date', '$start_time', '$end_time')";
		
		if (!mysqli_query($link, $payload))
		{
			echo("Error description: " . mysqli_error($link));
		}
		
		header('Location: userAppointment.php');
	}
   
}

// UPDATING APPOINTMENT DATE FOR USER
if (isset($_POST['update_date'])) { 

	print_r("got to update function------");
    $apptToUpdate = mysqli_real_escape_string($link, $_POST['apptToUpdate']);
    $updatedDate = mysqli_real_escape_string($link, $_POST['updatedDate']);
    // $appointment_date = date('Y-m-d', strtotime($_POST['availDate']));

    //getting the appointment id:
    $index = strpos($apptToUpdate, "date");
    $length = $index-10;
    $app_id = substr($apptToUpdate, 8, $length);

    //get all other details for appointment from app_id -  TODO 
    $query = "SELECT * from appointments WHERE app_id='$app_id'";
    $result = mysqli_query($link, $query);
	
	if ($stmt = mysqli_prepare($link, $query)) {
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $app_id, $course_id, $tutor_id, $student_id, $appointment_date, $start_time, $end_time, $status);
		while (mysqli_stmt_fetch($stmt)) {}
		mysqli_stmt_close($stmt);
	}

	// print("App ID-----------: ");
	// print_r($app_id);
	// print("Tutor ID---------------: ");
	// print_r($tutor_id);
	// print("Date: ------------ ");
	// print($appointment_date);
	// print("Start Time-------------------: ");
	// print_r($start_time);
	// print("End Time-------------------: ");
	// print_r($end_time);

    //check if date is before current date
	// print_r($updatedDate);
   	$error = checkValidDate($updatedDate);

	$unix_start_time = strtotime($start_time);
	$unix_end_time = strtotime($end_time);
	
	
// CHECK IF TUTOR HAS AN APPOINTMENT ON THE SAME DAY WITH CONFLICTING TIMES
	$payload = "SELECT appoint_start_time, appoint_end_time FROM appointments WHERE tutor_id = '$tutor_id' AND appoint_date = '$updatedDate'";
	$result = mysqli_query($link, $payload);
	
	// Tutor has appointment on that date already, check for time conflict
	if (mysqli_num_rows($result) > 0) {
		while ($row = mysqli_fetch_assoc($result)) {
			$existing_start_time = strtotime($row["appoint_start_time"]);
			$existing_end_time = strtotime($row["appoint_end_time"]);
			
			if ($unix_start_time >= $existing_start_time && $unix_start_time <= $existing_end_time)
			{
				$error = True;
			}
			else if ($unix_start_time <= $existing_start_time && $unix_end_time >= $existing_end_time)
			{
				$error = True;
			}
			else if ($unix_end_time >= $existing_start_time && $unix_end_time <= $existing_end_time)
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
	$payload = "SELECT appoint_start_time, appoint_end_time FROM appointments WHERE student_id = '$student_id' AND appoint_date = '$updatedDate'";
	$result = mysqli_query($link, $payload);
	
	// Student has appointment on that date already, check for time conflict
	if (mysqli_num_rows($result) > 0) {
		while ($row = mysqli_fetch_assoc($result)) {
			$existing_start_time = strtotime($row["appoint_start_time"]);
			$existing_end_time = strtotime($row["appoint_end_time"]);
			
			if ($unix_start_time >= $existing_start_time && $unix_start_time <= $existing_end_time)
			{
				$error = True;
			}
			else if ($unix_start_time <= $existing_start_time && $unix_end_time >= $existing_end_time)
			{
				$error = True;
			}
			else if ($unix_end_time >= $existing_start_time && $unix_end_time <= $existing_end_time)
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


	if (!$error) //if no errors, insert into DB
	{
		echo "no errors, about to udpate DB";
		$payload = "UPDATE appointments SET appoint_date='$updatedDate' WHERE app_id='$app_id'";
		
		if (!mysqli_query($link, $payload))
		{
			echo("Error description: " . mysqli_error($link));
		}
		
		// header('Location: userAppointment.php');
	}
}

//UPDATING APPOINTMENT START TIME FOR USER
if (isset($_POST['update_start_time'])) { 

	print_r("got to update function------");
    $apptToUpdate = mysqli_real_escape_string($link, $_POST['apptToUpdate']);
    $updatedDate = mysqli_real_escape_string($link, $_POST['updatedDate']);
    // $appointment_date = date('Y-m-d', strtotime($_POST['availDate']));

}
// DELETING APPOINTMENT FOR USER
if (isset($_POST['delete_appointment'])) { 
    echo ("Got to delete appt backend!");
    $apptToDelete = mysqli_real_escape_string($link, $_POST['apptToDelete']);

    //getting the appointment id:
    $index = strpos($apptToDelete, "date");
    $length = $index-10;
    $app_id = substr($apptToDelete, 8, $length);
    print_r($app_id);

    $query = "DELETE FROM appointments WHERE app_id = '$app_id'";
	$execute = mysqli_query($link, $query);

    header('Location: userAppointment.php');
}




/* close connection */
mysqli_close($link);

?>
