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

$reviews_table_with_names = "";

$payload = "SELECT * FROM reviews_table_with_names";
$result = mysqli_query($link, $payload);

// Display reviews table with course name and tutor name

if (mysqli_num_rows($result) > 0) {
	$reviews_table_with_names .= "<table><caption>Reviews Table</caption><tr><th>Review ID</th><th>Appointment ID</th><th>Course Name</th><th>Tutor ID</th><th>Tutor First Name</th><th>Tutor Last Name</th><th>Rating</th><th>Content</th><th>Date & Time</th></tr>";
	while ($row = mysqli_fetch_assoc($result)) {
		$reviews_table_with_names .= "<tr><td>".$row["review_id"]."</td><td>".$row["app_id"]."</td><td>".$row["course_name"]."</td><td>".$row["tutor_id"]."</td><td>".$row["tutor_fname"]."</td><td>".$row["tutor_lname"]."</td><td>".$row["num_stars"]."</td><td>".$row["content"]."</td><td>".$row["review_date_time"]."</td></tr>";
	}
	$reviews_table_with_names .= "</table>";
} else {
	$reviews_table_with_names .= "<p><b>There are currently no reviews for any tutors.</b></p>";
}

// ADD REVIEW
// Get appointment ids (only finished ones) from appointment table, prevent an appointment from having multiple reviews
$payload = "SELECT app_id FROM appointments WHERE app_id NOT IN (SELECT app_id FROM reviews) AND status = 0";
$appointment_ids = mysqli_query($link, $payload);

if (isset($_POST['submit_review'])) {
    $app_id = mysqli_real_escape_string($link, $_POST['appointment_id']);
    $tutor_rating = mysqli_real_escape_string($link, $_POST['tutor_rating']);
    $comment = mysqli_real_escape_string($link, $_POST['comments']);

    $error = false;
    $error_msg = "";

    if (!$error) {
        $payload = "INSERT INTO reviews (user_id,app_id,num_stars,content) VALUES ('".$_SESSION['user_id']."','$app_id','$tutor_rating','$comment')";
		
        if (mysqli_query($link, $payload)) {
            echo '<script>alert("Successfully added review")</script>';
        }

        header('Location: adminReview.php');
    }
}

// UPDATE REVIEW
$payload = "SELECT review_id FROM reviews";
$update_review_ids = mysqli_query($link, $payload);

if (isset($_POST['update_review_id'])) {
    $update_review_id = mysqli_real_escape_string($link, $_POST['select_review_update_id']);
    $update_rating = mysqli_real_escape_string($link, $_POST['update_rating']);
    $update_comments = mysqli_real_escape_string($link, $_POST['update_comments']);

    $error = false;
    $error_msg = "";

    if (!$error) {
        $payload = "UPDATE reviews SET num_stars = '$update_rating', content = '$update_comments' WHERE review_id = '$update_review_id'";

        if (mysqli_query($link, $payload)) {
            echo '<script>alert("Successfully updated review")</script>';
        }

        header('Location: adminReview.php');
    }
}

// DELETE REVIEW
$payload = "SELECT review_id FROM reviews";
$review_ids = mysqli_query($link, $payload);

if (isset($_POST['delete_review_id'])) {
	$to_delete_id = mysqli_real_escape_string($link, $_POST['select_review_id']);
	
	$payload = "DELETE FROM reviews WHERE review_id = '$to_delete_id'";
	$execute = mysqli_query($link, $payload);
	
	header('Location: adminReview.php');
}

mysqli_close($link);

?>