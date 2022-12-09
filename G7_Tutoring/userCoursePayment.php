<?php include ('userCoursesBackend.php')?>
<!DOCTYPE html>
<html>
<style>
table, th, td {
  border: 1px solid;
}
</style>
<head><title>Payment</title></head>
<body>
    <?php echo "<p>Logged in as: " . $_SESSION["username"] . "</p>";?>
    <p style="text-align:center; font-size: 30px"><b>Checkout/Order Summary</b></p>

    </br>

    <?php echo $cart_table; ?>

    </br>
    </br>
    </br>

    <form method="post" action="userCourses.php">
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
	    <input name="checkout" type="submit" value="Pay" onclick="return confirm('Pay for courses?')">
    </form>
</body>

<!-- PREVENT RESUBMIT FORM FROM SHOWING UP !-->

<script>
if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
</script>

</html>