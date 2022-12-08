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

// VIEWING COURSE
$courses_table = "";
$payload = "SELECT * FROM courses";
$result = mysqli_query($link, $payload);

if (mysqli_num_rows($result) > 0) {
    $courses_table .= "<table><caption>List of Courses</caption><tr><td><b>Course ID</b></td><td><b>Course Name</b></td><td><b>Course Number</b></td><td><b>Course Description</b></td></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        $courses_table .= "<tr><td>".$row["course_id"]."</td><td>".$row["course_name"]."</td><td>".$row["course_num"]."</td><td>".$row["course_desc"]."</td></tr>";
    }
    $courses_table .= "</table>"; 
} else {
    $courses_table .= "<p><b>There are currently no courses available.</b></p>";
}

// CREATING COURSE
$payload = "SELECT course_id FROM courses WHERE course_id NOT IN (SELECT course_id FROM cart) AND status = 0";
$course_ids = mysqli_query($link, $payload);

if (isset($_POST['add_course'])) {
    $courseName = mysqli_real_escape_string($link, $_POST['courseName']);
	$courseNum = mysqli_real_escape_string($link, $_POST['courseNum']);
	$courseDesc = mysqli_real_escape_string($link, $_POST['courseDesc']);
    
    $error = false;
    $error_msg = "Error with adding courses";

    if (!$error) {
        $payload = "INSERT INTO courses (course_id, courseName, courseNum, courseDesc) VALUES ('".$_SESSION['user_id']."','$course_id', '$courseName', '$courseNum', '$courseDesc')";

        if (mysqli_query($link, $payload)) {
            echo '<script>alert("Successfully added course")</script>';
        }

        header('Location: adminCourses.php');
    }
}

// EDITING COURSE
if (isset($_POST['edit_course'])) {
    $edited_courseName = mysqli_real_escape_string($link, $_POST['edited_courseName']);
	$edited_courseNum = mysqli_real_escape_string($link, $_POST['edited_courseNum']);
	$edited_courseDesc = mysqli_real_escape_string($link, $_POST['edited_courseDesc']);
    
    $error = false;
    $error_msg = "Error with adding courses";

    if (!$error) {
        $payload = "INSERT INTO courses (course_id, edited_courseName, edited_courseNum, edited_courseDesc) VALUES ('".$_SESSION['user_id']."','$course_id', '$edited_courseName', '$edited_courseNum', '$edited_courseDesc')";

        if (mysqli_query($link, $payload)) {
            echo '<script>alert("Successfully edited course")</script>';
        }

        header('Location: adminCourses.php');
    }
}

// DELETING COURSE
$payload = "SELECT course_id FROM courses";
$course_ids = mysqli_query($link, $payload);

if (isset($_POST['delete_course_id'])) {
	$to_delete_id = mysqli_real_escape_string($link, $_POST['select_course_id']);
	
	$payload = "DELETE FROM courses WHERE course_id = '$to_delete_id'";
	$execute = mysqli_query($link, $payload);
	
	header('Location: adminCourses.php');
}

// PRINT TABLES

mysqli_close($link);

?>
