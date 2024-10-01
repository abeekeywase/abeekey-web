<?php

// This page is used to change an existing password.
// Users must be logged in to access this page.
// This script is created in Chapter 4.

// Require the configuration before any PHP code as the configuration controls error reporting:
require ('./includes/config.inc.php');
// The config file also starts the session.

// If the user isn't logged in, redirect them:
redirect_invalid_user();

// Include the header file:
$page_title = 'Change Your Password';
include ('./includes/header.html');

// Require the database connection:
require (MYSQL);

// For storing errors:
$pass_errors = array();

// If it's a POST request, handle the form submission:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			
	// Check for the existing password:
	if (!empty($_POST['current'])) {
		$current = mysqli_real_escape_string ($dbc, $_POST['current']);
	} else {
		$pass_errors['current'] = 'Please enter your current password!';
	}
	
	// Check for a password and match against the confirmed password:
	if (preg_match ('/^(\w*(?=\w*\d)(?=\w*[a-z])(?=\w*[A-Z])\w*){6,20}$/', $_POST['pass1']) ) {
		if ($_POST['pass1'] == $_POST['pass2']) {
			$p = mysqli_real_escape_string ($dbc, $_POST['pass1']);
		} else {
			$pass_errors['pass2'] = 'Your password did not match the confirmed password!';
		}
	} else {
		$pass_errors['pass1'] = 'Please enter a valid password!';
	}
	
	if (empty($pass_errors)) { // If everything's OK.
	
		// Check the current password:
		$q = "SELECT id FROM users WHERE pass='"  .  get_password_hash($current) .  "' AND id={$_SESSION['user_id']}";	
		$r = mysqli_query ($dbc, $q);
		if (mysqli_num_rows($r) == 1) { // Correct
			
			// Define the query:
			$q = "UPDATE users SET pass='"  .  get_password_hash($p) .  "' WHERE id={$_SESSION['user_id']} LIMIT 1";	
			if ($r = mysqli_query ($dbc, $q)) { // If it ran OK.

				// Send an email, if desired.

				// Let the user know the password has been changed:
				echo '<h3>Your password has been changed.</h3>';
				include ('./includes/footer.html'); // Include the HTML footer.
				exit();

			} else { // If it did not run OK.

				trigger_error('Your password could not be changed due to a system error. We apologize for any inconvenience.'); 

			}

		} else {
			
			$pass_errors['current'] = 'Your current password is incorrect!';
			
		} // End of current password ELSE.

	} // End of $p IF.
	
} // End of the form submission conditional.

// Need the form functions script, which defines create_form_input():
require ('./includes/form_functions.inc.php');
?><h3>Change Your Password</h3>
<p>Use the form below to change your password.</p>
<form action="change_password.php" method="post" accept-charset="utf-8">
	<p><label for="pass1"><strong>Current Password</strong></label><br /><?php create_form_input('current', 'password', $pass_errors); ?></p>
	<p><label for="pass1"><strong>New Password</strong></label><br /><?php create_form_input('pass1', 'password', $pass_errors); ?> <small>Must be between 6 and 20 characters long, with at least one lowercase letter, one uppercase letter, and one number.</small></p>
	<p><label for="pass2"><strong>Confirm New Password</strong></label><br /><?php create_form_input('pass2', 'password', $pass_errors); ?></p>
	<input type="submit" name="submit_button" value="Change &rarr;" id="submit_button" class="formbutton" />
</form>

<?php // Include the HTML footer:
include ('./includes/footer.html');
?>