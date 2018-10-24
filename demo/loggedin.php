<?php #loggedin.php
// This is the logout page for the site.


$page_title = 'Logged in';
include ('includes/header.html');

// If no first_name session variable exists, redirect the user:
if (!isset($_SESSION['firstName'])) {

	$url = 'index.php'; // Define the URL.
	ob_end_clean(); // Delete the buffer.
	header("Location: $url");
	exit(); // Quit the script.
	
} else { // Log out the user.

	// Print a customized message:
echo '<h3>You are now logged in.</h3>';

}

include ('includes/footer.html');
?>
