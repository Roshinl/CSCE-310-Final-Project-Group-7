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

$html = "";

$payload = "SELECT student_id FROM student";
$allStudentID = mysqli_query($link, $payload);

if (isset($_POST['view_student'])) {
	$payload = "SELECT student_id, student_fname, student_lname, student_username, student_email FROM student";
	$result = mysqli_query($link, $payload);
	if (mysqli_num_rows($result) > 0) {
		$html .= "<table><tr><th>Student ID</th><th>Student name</th><th>Student username</th><th>Student email</th></tr>";
		while ($row = mysqli_fetch_assoc($result)) {
			$html .= "<tr><td>".$row["student_id"]."</td><td>".$row["student_fname"]." ".$row["student_lname"]."</td><td>".$row["student_username"]."</td><td>".$row["student_email"]."</td></tr>";
		}
		$html .= "</table>";
	}
	else 
	{
		$html .= "<p>0 results";
	}
}

if (isset($_POST['submit']))
{
	$student_id = $_POST['submit'];
	header('Location: adminAppointment.php');
}
mysqli_close($link);
?>