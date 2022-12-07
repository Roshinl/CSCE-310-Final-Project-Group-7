<?php include ('userProfileEditBackend.php')?>
<!DOCTYPE html>
<html>
<style>
table, th, td {
  border: 1px solid;
}
</style>

<body>
<?php echo "<p>Logged in as: " . $_SESSION["username"] . "</p>";?>

<!-- EDITING USER PROFILE AND DETAILS !-->

<?php echo $user_table; ?>

</br>
<!-- DROPDOWN FOR USERS -->
<h1> Update User's Profile </h1>

<form method="post" action="userProfileEdit.php">
<label>  Select a User ID Profile to Update:</label>
    
<select name="availUser">
    <option value=""> --Select a User ID-- </option>
    <?php 
            foreach($availableUsers as $eachUser){
                echo "<option value='$eachUser'> $eachUser </option>";
            }
            ?>
    </select> 

	<label>Change  first name here</label>
	<input type="text" required name="fname">
	<button type="submit" class="btn" name="edit_fname">Submit</button>
</form>

<br><br>
<form method="post" action="userProfileEdit.php">
<label>  Select a User ID Profile to Update:</label>
    
<select name="availUser">
    <option value=""> --Select a User ID-- </option>
    <?php 
            foreach($availableUsers as $eachUser){
                echo "<option value='$eachUser'> $eachUser </option>";
            }
            ?>
    </select> 
	<label>Change  last name here</label>
	<input type="text" required name="lname">
	<button type="submit" class="btn" name="edit_lname">Submit</button>
</form>

<br><br>
<form method="post" action="userProfileEdit.php">
<label>  Select a User ID Profile to Update:</label>
    
<select name="availUser">
    <option value=""> --Select a User ID-- </option>
    <?php 
            foreach($availableUsers as $eachUser){
                echo "<option value='$eachUser'> $eachUser </option>";
            }
            ?>
    </select> 
	<label>Change  username here</label>
	<input type="text" required name="username">
	<button type="submit" class="btn" name="edit_username">Submit</button>
</form>


<br><br>
<form method="post" action="userProfileEdit.php">
<label>  Select a User ID Profile to Update:</label>
    
<select name="availUser">
    <option value=""> --Select a User ID-- </option>
    <?php 
            foreach($availableUsers as $eachUser){
                echo "<option value='$eachUser'> $eachUser </option>";
            }
            ?>
    </select> 
	<label>Change  password here</label>
	<input type="text" required name="password">
	<button type="submit" class="btn" name="edit_password">Submit</button>
</form>


<br><br>
<form method="post" action="userProfileEdit.php">
<label>  Select a User ID Profile to Update:</label>
    
<select name="availUser">
    <option value=""> --Select a User ID-- </option>
    <?php 
            foreach($availableUsers as $eachUser){
                echo "<option value='$eachUser'> $eachUser </option>";
            }
            ?>
    </select> 
	<label>Change  email here</label>
	<input type="text" required name="email">
	<button type="submit" class="btn" name="edit_email">Submit</button>
</form>

<br><br>
<!-- ADDING PAYMENT INFORMATION !-->
<?php echo $student_payment_table; ?>

</br>
<h1> Add Payment Information </h1>
<form method="post" action="userProfileEdit.php">
	<label>  Select a User ID Profile to Update:</label>
	<select name="availUser">
		<option value=""> --Select a User ID-- </option>
		<?php 
				foreach($availableStudents as $eachStudent){
					echo "<option value='$eachStudent'> $eachStudent </option>";
				}
				?>
		</select> 
	<br>
	<label>Card Type</label>
	<select required name = "card_type">
		<option value = ""></option>
		<option value = "VISA">VISA</option>
		<option value = "Mastercard">Mastercard</option>
		<option value = "American Express">American Express</option>
		<option value = "Discover">Discover</option>
	</select>
	
	</br>
	<label>Card number</label>
	<input type="text" required name="card_num">
	
	</br>
	<label>CVV</label>
	<input type="text" required name="cvv">
	
	</br>
	<label>Zip code</label>
	<input type="text" required name="zip_code">
	
	</br>
	<label>Expiry date</label>
	<input type = "date" required name = "exp_date">
	
	</br>
	<button type="submit" class="btn" name="add_payment">Add payment information</button>
</form>


<!--DELETING PAYMENT INFORMATION  !-->
<h1> Delete Payment Information </h1>
<?php echo $payment_table; ?>
<br>
<form method="post" action="userProfileEdit.php">
	<label>  Select a User ID Profile to View Their Payment Methods:</label>
	<select name="availUser">
		<option value=""> --Select a User ID-- </option>
		<?php 
				foreach($availableStudents as $eachStudent){
					echo "<option value='$eachStudent'> $eachStudent </option>";
				}
				?>
		</select> 
	<button type="submit" class="btn" name="view_payment">View payment information</button>

	<br>
<!-- </form> -->

<!-- <form method="post" action="userProfileEdit.php"> -->
	<label>Type in a payment ID to delete for this user</label>
	<input type="text" name="chosen_payment_id">
	<input name="delete_payment_id" type="submit" value="Delete" onclick="return confirm('Are you sure?')">
</form>


<!-- DELETE USERS ACCOUNT ! -->
<h1> Delete User's Account </h1>

<form method="post" action="userProfileEdit.php">
	
<label>  Select a User ID Profile to Delete:</label>
    
	<select name="availUser">
		<option value=""> --Select a User ID-- </option>
		<?php 
				foreach($availableUsers as $eachUser){
					echo "<option value='$eachUser'> $eachUser </option>";
				}
				?>
		</select> 

	<label>Delete their account by pressing this button</label>
	<input name="delete_account" type="submit" value="Delete" onclick="return confirm('Are you sure?')">
</form>
<br>
<br>
<br>

<!-- RETURN TO HOME PAGE !-->

<p>Click here to go back to the home page <a href = "adminHomePage.php">Click here</a></p>
<form method="post" action="login.php">
	<button type="submit" class="btn" name="signout">Signout</button>
</form>
</body>

<!-- PREVENTS ANNOYING RESUBMIT FORM MESSAGE FROM SHOWING UP -->
<script>
if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
</script>

</html>
