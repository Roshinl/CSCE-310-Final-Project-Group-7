<?php include ('userReviewBackend.php')?>
<!DOCTYPE html>
<html>
<style>
table, th, td {
  border: 1px solid;
}
</style>
<head><title>Reviews</title></head>
<body>
  <?php echo "<p>Logged in as: " . $_SESSION["username"] . "</p>";?>

  <!-- VIEW ALL REVIEWS !-->
  <?php echo $reviews_table; ?>
  <!-- <? //php echo $reviews_table_with_names; ?> -->
  </br></br>
    
  <!-- CREATE + ADD REVIEW !-->
  <p><b>Make a new review:</b></p>
  <form method="post" action="userReview.php">
        <!-- SELECT CORRESPONDING APPOINTMENT FOR REVIEW !-->
        <label>Select an appointment to write your review for<label>
        <select required name = "appointment_id">
            <option value=""> --Select a Appointment ID-- </option>
              <?php while ($appointment_id = mysqli_fetch_array($appointment_ids, MYSQLI_NUM)):; ?>
            <option value="<?php echo $appointment_id[0]?>">
              <?php echo $appointment_id[0]?>
            </option>
            <?php endwhile; ?>
        </select>
        </br>

        <!-- RATE TUTOR OUT OF 5 STARS !-->
        <label>Rate the tutor from 0 (poor) to 5 (excellent)</label>
        <select required name = "tutor_rating">
            <option value=""></option>
            <option value="0">0</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
        </select>

        </br>
        <label>Write a comment:</label>
        <input type="text" name="comments">
        </br>

        <input name="submit_review" type="submit" value="Submit Review" onclick="return confirm('Submit review?')">
    </form>

  <!-- UPDATE / EDIT REVIEWS !-->
  <p><b>Edit review:</b></p>
  <form method="post" action="userReview.php">
    <!-- SELECT REVIEW !-->
    <label>Select a review to update</label>
        
    <select name="selected_update_review_id">
        <option value=""> --Select a Review ID-- </option>
          <?php while ($update_reviewID = mysqli_fetch_array($update_review_ids, MYSQLI_NUM)):; ?>
        <option value = "<?php echo $update_reviewID[0];?>">
          <?php echo $update_reviewID[0]; ?>
        </option>
        <?php endwhile; ?>
    </select> 
    </br>

    <!-- EDIT COURSE RATING !-->
    <label>Update course rating</label>
    <select required name = "update_rating">
        <option value=""></option>
        <option value="0">0</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
    </select>
    </br>

    <!-- EDIT COMMENTS !-->
    <label>Update comments</label>
    <input type="text" name="update_comments">
    </br>

    <input name="update_review_id" type="submit" value="Update Review" onclick="return confirm('Update selection?')">
  </form>

  <!-- DELETING REVIEW !--> 
  <p><b>Delete review:</b></p>
    <form method="post" action="userReview.php">
	    <label>Select a review to delete</label>
	    <select required name = "selected_review_id">
		    <option value = ""></option>
		      <?php while ($indv_reviewID = mysqli_fetch_array($review_ids, MYSQLI_NUM)):; ?>
		    <option value = "<?php echo $indv_reviewID[0];?>">
			  <?php echo $indv_reviewID[0]; ?>
		    </option>
		    <?php endwhile; ?>
	    </select>
	    <input name="delete_review_id" type="submit" value="Delete Review" onclick="return confirm('Are you sure?')">
    </form>

  <!-- RETURN TO HOME PAGE !-->

  <p>Click here to go back to the home page <a href = "userHomePage.php">Click here</a></p>
  <!--
  <form method="post" action="login.php">
    <button type="submit" class="btn" name="signout">Signout</button>
  </form>
  -->
</body>

<!-- PREVENTS ANNOYING RESUBMIT FORM MESSAGE FROM SHOWING UP -->
<script>
if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
</script>

</html>
