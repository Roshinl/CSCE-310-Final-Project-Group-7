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

$reviews_table = "";
//$reviews_table_with_names = "";
$availableApps = array();

// DISPLAY REVIEWS TABLE
$payload = "SELECT * FROM reviews_table_with_names WHERE user_id = '".$_SESSION['user_id']."'";
$result = mysqli_query($link, $payload);

if (mysqli_num_rows($result) > 0) {
    $reviews_table .= "<table><caption>List of Reviews</caption><tr><td><b>Review ID</b></td><td><b>Appointment ID</b></td><td><b>User ID</b></td><td><b>Content</b></td><td><b>Number of Stars</b></td><td><b>Date and Time</b></td><td><b>Tutor ID</b></td><td><b>Tutor name</b></td><td><b>Course name</b></td></td>";
    //$reviews_table_with_names .= "<table><caption>Reviews Table</caption><tr><th>Review ID</th><th>Appointment ID</th><th>Course Name</th><th>Tutor ID</th><th>Tutor First Name</th><th>Tutor Last Name</th><th>Rating</th><th>Content</th><td><b>Date</b></td><td><b>Time</b></td></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        $reviews_table .= "<tr><td>".$row["review_id"]."</td><td>".$row["app_id"]."</td><td>".$row["user_id"]."</td><td>".$row["content"]."</td><td>".$row["num_stars"]."</td><td>".$row["review_date_time"]."</td><td>".$row["tutor_id"]."</td><td>".$row["tutor_fname"]." ".$row["tutor_lname"]."</td><td>".$row["course_name"]."</td></tr>";
        //$reviews_table_with_names .= "<tr><td>".$row["review_id"]."</td><td>".$row["app_id"]."</td><td>".$row["course_name"]."</td><td>".$row["tutor_id"]."</td><td>".$row["tutor_fname"]."</td><td>".$row["tutor_lname"]."</td><td>".$row["num_stars"]."</td><td>".$row["content"]."</td><td>".$row["review_date"]."</td><td>".$row["review_time"]."</td></tr>";
        $availableApps[] = $row["app_id"];
    }
    $reviews_table .= "</table>"; 
    //$reviews_table_with_names .= "</table>";
} else {
    $reviews_table .= "<p><b>There are currently no reviews available.</b></p>";
}

// CREATE NEW REVIEW
$payload = "SELECT app_id FROM appointments WHERE app_id NOT IN (SELECT app_id FROM reviews) AND status = 0";
$appointment_ids = mysqli_query($link, $payload);

if (isset($_POST['submit_review'])) {
    $app_id = mysqli_real_escape_string($link, $_POST['appointment_id']);
    $tutor_rating = mysqli_real_escape_string($link, $_POST['tutor_rating']);
    $comment = mysqli_real_escape_string($link, $_POST['comments']);

    $error = false;
    $error_msg = "";

    if (!$error) {
        $payload = "INSERT INTO `reviews` (`user_id`,`app_id`,`num_stars`,`content`) VALUES ('".$_SESSION['user_id']."','$app_id','$tutor_rating','$comment')";

        if (!mysqli_query($link, $payload))
		{
			echo("Error description: " . mysqli_error($link));
		}

        header('Location: userReview.php');
    }
}

// EDIT REVIEW
$payload = "SELECT review_id FROM reviews WHERE user_id = '".$_SESSION['user_id']."'";
$update_review_ids = mysqli_query($link, $payload);

if (isset($_POST['update_review_id'])) {
    $update_review_id = mysqli_real_escape_string($link, $_POST['selected_update_review_id']);
    $update_rating = mysqli_real_escape_string($link, $_POST['update_rating']);
    $update_comments = mysqli_real_escape_string($link, $_POST['update_comments']);

    $error = false;
    $error_msg = "";

    if (!$error) {
        $payload = "UPDATE reviews SET num_stars = '$update_rating', content = '$update_comments' WHERE review_id = '$update_review_id'";
		mysqli_query($link, $payload);

        header('Location: userReview.php');
    }
}

// DELETE REVIEW
$payload = "SELECT review_id FROM reviews WHERE user_id = '".$_SESSION['user_id']."'";
$review_ids = mysqli_query($link, $payload);

if (isset($_POST['delete_review_id'])) {
	$to_delete_id = mysqli_real_escape_string($link, $_POST['select_review_id']);
	
	$payload = "DELETE FROM reviews WHERE review_id = '$to_delete_id'";
	$execute = mysqli_query($link, $payload);
	
	header('Location: userReview.php');
}

mysqli_close($link);

?>
