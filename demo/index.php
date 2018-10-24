<?php #index.php
// This is the main page for the site.


// Set the page title and include the HTML header:
$page_title = 'Welcome to this Site!';
include ('includes/header.html');

// Welcome the user (by name if they are logged in):
echo '<h1>Welcome';
if (isset($_SESSION['firstName'])) {
	echo ", {$_SESSION['firstName']}!";
}
echo '</h1>';
?>
<p>Hello, please register or if you have an account already log in.</p>

<?php // Include the HTML footer file:
include ('includes/footer.html');
?>
