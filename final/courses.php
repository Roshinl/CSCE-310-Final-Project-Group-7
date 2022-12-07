<?php include ('coursesBackend.php')?>
<!DOCTYPE html>
<html>
<style>
table, th, td {
  border: 1px solid;
}
</style>
<head><title>Courses</title></head>
<body>
    <?php echo "<p>Logged in as: " . $_SESSION["username"] . "</p>";?>

    <?php echo $courses_table; ?>

    </br>
    </br>

    <p><b>Courses I currently have appointments scheduled for:</b></p>

    <?php echo $courses_registered_table; ?>

    </br>
    </br>

    <p><b>Add courses to your shopping cart here:</b></p>

    <form method="post" action="courses.php">
        <label>Add course by ID</label>
        <select required name="add_id">
            <option value=""></option>
            <?php
                while ($course_id = mysqli_fetch_array($course_ids, MYSQLI_NUM)):;
            ?>
            <option value="<?php echo $course_id[0]?>">
                <?php echo $course_id[0]?>
            </option>
            <?php
                endwhile;
            ?>
        </select>
        <input name="add_course_id" type="submit" value="Add Course" onclick="return confirm('Add course to cart?')">
    </form>

    </br>

    <p><b>Delete courses from your shopping cart here:</b></p>

    <form method="post" action="courses.php">
        <label>Select which course to delete</label>
        <select required name="delete_id">
        <option value=""></option>
            <?php
                while ($delete_course_id = mysqli_fetch_array($delete_course_ids, MYSQLI_NUM)):;
            ?>
            <option value="<?php echo $delete_course_id[0]?>">
                <?php echo $delete_course_id[0]?>
            </option>
            <?php
                endwhile;
            ?>
        </select>
        <input name="delete_course_id" type="submit" value="Delete Course" onclick="return confirm('Delete course from cart?')">
    </form>

    </br>
    </br>

    <?php echo $cart_table; ?>

    </br>
    </br>

    <form method="post" action="coursePayment.php">
        <input type="submit" value="Checkout" name="go_to_checkout">
    </form>

    </br>
    </br>

    <p>
	
	<p>Click here to go back to the home page <a href = "userHomePage.php">Click here</a></p>
</body>

<!-- PREVENT RESUBMIT FORM FROM SHOWING UP !-->

<script>
if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
</script>

</html>