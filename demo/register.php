<?php #register.php
// This is the registration page for the site.

$page_title = 'Register';
include ('includes/header.html');

if (isset($_POST['submitted'])) { // Handle the form.

	require_once ('includes/mysqli_connect.php');
	
	// Trim all the incoming data:
    $fName=trim($_POST['firstName']);
    $sName=trim($_POST['lastName']);
    $email=trim($_POST['email']);
    $pass1=trim($_POST['password1']);
    $pass2=trim($_POST['password2']);
        
	//could use $trimmed = array_map('trim', $_POST);
	
	// Assume invalid values:
	$fn = $ln = $e = $p = FALSE;
	
	// Check for a first name:
	if (preg_match ('/^[A-Z \'.-]{2,20}$/i', $fName)) {
		$fn = mysqli_real_escape_string ($conn, $fName);
	} else {
		echo '<p class="error">Please enter your first name!</p>';
	}
	
	// Check for a last name:
	if (preg_match ('/^[A-Z \'.-]{2,40}$/i',  $sName)) {
		$ln = mysqli_real_escape_string ($conn,  $sName);
	} else {
		echo '<p class="error">Please enter your last name!</p>';
	}
	
	// Check for an email address:
	if (preg_match ('/^[\w.-]+@[\w.-]+\.[A-Za-z]{2,6}$/',  $email)) {
		$e = mysqli_real_escape_string ($conn,  $email);
	} else {
		echo '<p class="error">Please enter a valid email address!</p>';
	}

	// Check for a password and match against the confirmed password:
	if (preg_match ('/^\w{4,20}$/',  $pass1 )) {
		if ($pass1 ==  $pass2) {
			$p = mysqli_real_escape_string ($conn,  $pass1);
            $p = password_hash ($p, PASSWORD_DEFAULT);
		} else {
			echo '<p class="error">Your password did not match the confirmed password!</p>';
		}
	} else {
		echo '<p class="error">Please enter a valid password!</p>';
	}

	if ($fn && $ln && $e && $p) { // If everything's OK...

		// Make sure the email address (db is set up so that email is unique) is available:

        $q = "SELECT userID FROM usersdemo WHERE email='$e'";
		$r = mysqli_query ($conn, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($conn));
		
		if (mysqli_num_rows($r) == 0) { // Available.
		
	
                    // Add the user to the database:
                    $q = "INSERT INTO usersdemo (email, pass, firstName, lastName, regDate) VALUES ('$e', '$p', '$fn', '$ln', NOW() )";
                    $r = mysqli_query ($conn, $q) or trigger_error("Query: $q\n<br />MySQL Error: " /*. mysqli_error($conn)*/);

                if (mysqli_affected_rows($conn) == 1) { // If it ran OK.

                        // Finish the page:
                        echo '<h3>Thank you for registering!</h3>';
                        include ('includes/footer.html'); // Include the HTML footer.
                        exit(); // Stop the page.

                    } else { // If it did not run OK.
                        echo '<p class="error">You could not be registered due to a system error. We apologize for any inconvenience.</p>';
                    }
			
		} else { // The email address is not available.
			echo '<p class="error">That email address has already been registered. If you have forgotten your password, use the link at right to have your password sent to you.</p>';
		}

	} else { // If one of the data tests failed.
		echo '<p class="error">Please re-enter your passwords and try again.</p>';
	}

	mysqli_close($conn);

} // End of the main Submit conditional.
?>
	
<h1>Register</h1>
<form action="register.php" method="post">
	<fieldset>
	
	<p><b>First Name:</b> <input type="text" name="firstName" size="20" maxlength="20" value="<?php if (isset($fName)) echo $fName; ?>" /></p>
	
	<p><b>Last Name:</b> <input type="text" name="lastName" size="20" maxlength="40" value="<?php if (isset($sName)) echo $sName; ?>" /></p>
	
	<p><b>Email Address:</b> <input type="text" name="email" size="30" maxlength="80" value="<?php if (isset($email)) echo $email; ?>" /> </p>
		
	<p><b>Password:</b> <input type="password" name="password1" size="20" maxlength="20" /> <small>Use only letters, numbers, and the underscore. Must be between 4 and 20 characters long.</small></p>
	
	<p><b>Confirm Password:</b> <input type="password" name="password2" size="20" maxlength="20" /></p>
	</fieldset>
	
	<div align="center"><input type="submit" name="submit" value="Register" /></div>
	<input type="hidden" name="submitted" value="TRUE" />

</form>

<?php // Include the HTML footer.
include ('includes/footer.html');
?>
