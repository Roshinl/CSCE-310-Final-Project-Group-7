<?php include ('profileEditBackend.php')?>
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

<?php echo $student_table; ?>
</br>
<form method="post" action="profileEdit.php">
	<label>Change your first name here</label>
	<input type="text" required name="fname">
	<button type="submit" class="btn" name="edit_fname">Submit</button>
</form>

<form method="post" action="profileEdit.php">
	<label>Change your last name here</label>
	<input type="text" required name="lname">
	<button type="submit" class="btn" name="edit_lname">Submit</button>
</form>

<form method="post" action="profileEdit.php">
	<label>Change your username here</label>
	<input type="text" required name="username">
	<button type="submit" class="btn" name="edit_username">Submit</button>
</form>

<form method="post" action="profileEdit.php">
	<label>Change your password here</label>
	<input type="text" required name="password">
	<button type="submit" class="btn" name="edit_password">Submit</button>
</form>

<form method="post" action="profileEdit.php">
	<label>Change your email here</label>
	<input type="text" required name="email">
	<button type="submit" class="btn" name="edit_email">Submit</button>
</form>
</br>
</br>
</br>

<!-- ADDING PAYMENT INFORMATION !-->

<?php echo $payment_table; ?>
</br>
<form method="post" action="profileEdit.php">
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

<!-- EDITING DELETING PAYMENT INFORMATION !-->

</br>
</br>
</br>
<form method="post" action="profileEdit.php">
	<label>Select a payment ID to delete</label>
	<select required name = "selected_paymentID">
		<option value = ""></option>
		<?php
			while ($indv_paymentID = mysqli_fetch_array($display_paymentID, MYSQLI_NUM)):;
		?>
		<option value = "<?php echo $indv_paymentID[0];?>">
			<?php 
				echo $indv_paymentID[0]; 
			?>
		</option>
		<?php
			endwhile;
		?>
	</select>
	<input name="delete_payment_id" type="submit" value="Delete" onclick="return confirm('Are you sure?')">
</form>

<!-- DELETE YOUR ACCOUNT !-->

</br>
</br>
</br>
<form method="post" action="profileEdit.php">
	<label>Delete your account by pressing this button</label>
	<input name="delete_account" type="submit" value="Delete" onclick="return confirm('Are you sure?')">
</form>
</br>
</br>

<!-- RETURN TO HOME PAGE !-->

<p>Click here to go back to the home page <a href = "userHomePage.php">Click here</a></p>
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
