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


$courses_table = "";

// DISPLAY COURSES TABLE
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

$courses_registered_table = "";

// DISPLAY COURSES STUDENT HAS AN APPOINTMENT FOR
$payload = "SELECT DISTINCT course_id, course_name FROM appointments_table_with_names WHERE (`status` = 1 OR `status` = 2) AND student_id = '".$_SESSION['user_id']."'";
$result = mysqli_query($link, $payload);

if (mysqli_num_rows($result) > 0) {
    $courses_registered_table .= "<table><caption>Registered Courses</caption><tr><td><b>Course ID</b></td><td><b>Course Name</b></td></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        $courses_registered_table .= "<tr><td>".$row["course_id"]."</td><td>".$row["course_name"]."</td></tr>";
    }
    $courses_registered_table .= "</table>";
} else {
    $courses_registered_table .= "<p><b>You are currently not registered for any courses.</b></p>";
}

// GET COURSE IDS FOR DROP DOWN
$payload = "SELECT DISTINCT course_id FROM appointments WHERE `status` = 2 AND course_id NOT IN (SELECT course_id from cart WHERE user_id = '".$_SESSION['user_id']."') AND student_id = '".$_SESSION['user_id']."'";
$course_ids = mysqli_query($link, $payload);

// ADD COURSES TO CART
if (isset($_POST['add_course_id'])) {
    $add_id = mysqli_real_escape_string($link, $_POST['add_id']);

    $error = false;
    $error_msg = "";

    if (!$error) {
        $payload = "INSERT INTO cart (`user_id`,`course_id`) VALUES ('".$_SESSION['user_id']."','$add_id')";
    
        if (mysqli_query($link, $payload)) {
            echo '<script>alert("Successfully added course to cart")</script>';
        }

        header('Location: courses.php');
    }
}

// DELETE COURSES FROM CART
$payload = "SELECT course_id FROM cart WHERE user_id = '".$_SESSION['user_id']."'";
$delete_course_ids = mysqli_query($link, $payload);

if (isset($_POST['delete_course_id'])) {
    $delete_id = mysqli_real_escape_string($link, $_POST['delete_id']);

    $error = false;
    $error_msg = "";

    if (!$error) {
        $payload = "DELETE FROM cart WHERE course_id = '$delete_id'";

        if (mysqli_query($link, $payload)) {
            echo '<script>alert("Successfully deleted course to cart")</script>';
        }

        header('Location: courses.php');
    }
}

// DISPLAY CART
$cart_table = "";

$payload = "SELECT course_id, course_name, course_num FROM user_cart WHERE user_id = '".$_SESSION['user_id']."'";
$result = mysqli_query($link, $payload);

if (mysqli_num_rows($result) > 0) {
    $cart_table .= "<table><caption>My cart</caption><tr><td><b>Course ID</b></td><td><b>Course Name</b></td><td><b>Course Number</b></td></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        $cart_table .= "<tr><td>".$row["course_id"]."</td><td>".$row["course_name"]."</td><td>".$row["course_num"]."</td></tr>";
    }
    $cart_table .= "</table>";
} else {
    $cart_table .= "<p><b>You currently have no courses in your cart.</b></p>";
}

// PROCEED TO CHECKOUT
if (isset($_POST['go_to_checkout'])) {
    $payload = "SELECT * FROM cart WHERE user_id = '".$_SESSION['user_id']."'";
    $execute = mysqli_query($link, $payload);

    if (mysqli_num_rows($execute) > 0) { // checks if shopping cart is empty or not; user is taken to checkout window if their cart isn't empty
        header('Location: coursePayment.php');
    } else {
        header('Location: courses.php');
    }
}

// PAY FOR COURSE(S)
if (isset($_POST['checkout'])) {
	$card_type = mysqli_real_escape_string($link, $_POST['card_type']);
	$card_num = mysqli_real_escape_string($link, $_POST['card_num']);
	$cvv = mysqli_real_escape_string($link, $_POST['cvv']);
	$zip_code = mysqli_real_escape_string($link, $_POST['zip_code']);
	$expiry = date('Y-m-d', strtotime($_POST['exp_date'])); // date converts the string into ready-to-insert SQL
	
	$error = False;
	
	$errorMessage = "";
	
	if (!is_numeric($card_num)) // checks if the card number is a number
	{
		$errorMessage.="Card number must be digits\\n";
		$error = True;
	}
	if (!is_numeric($cvv))
	{
		$errorMessage.="CVV must be digits\\n";
		$error = True;
	}
	if (!is_numeric($zip_code))
	{
		$errorMessage.="Zip code must be digits\\n";
		$error = True;
	}

    if (strtotime('now') > strtotime($expiry)) { // checks if card is past its expiration date
        $errorMessage.="Card has expired, please use a different payment method.\\n";	
		$error = True;
    }
	
	if ($error) {
		echo '<script type="text/javascript">
			   window.onload = function () { alert("'.$errorMessage.'"); } 
				</script>';
	}
	
	else 
	{
		$payload = "SELECT * FROM payment_info WHERE card_num = '$card_num' AND card_type = '$card_type' AND CVV = '$cvv' AND zip_code = '$zip_code' AND exp_date = '$expiry' AND user_id = '".$_SESSION['user_id']."'";
		$execute = mysqli_query($link, $payload);
	
		if (mysqli_num_rows($execute) > 0) { // check that payment method matches one of the user's existing methods
			$update_status = "UPDATE appointments SET `status` = 1 WHERE course_id IN (SELECT course_id FROM cart) AND student_id = '".$_SESSION['user_id']."'"; // update status to indicate appointments for the course have been paid for
            $empty_cart = "DELETE FROM cart WHERE user_id = '".$_SESSION['user_id']."'"; // empty user's cart

            if (!mysqli_query($link, $update_status)) {
                echo("Error description: " . mysqli_error($link));
            }

            if (!mysqli_query($link, $empty_cart)) {
                echo("Error description: " . mysqli_error($link));
            }
            
		    header('Location: courses.php');
		} 

        else { // if not, user can't pay for courses
            echo '<script type="text/javascript">
			   window.onload = function () { alert("Payment method does not exist, please try again."); } 
				</script>';
            header('Location: coursePayment.php');
        }
	}
	
}

mysqli_close($link);

?>