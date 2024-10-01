<?php

// This is the registration page for the site.
// This file both displays and processes the registration form.
// This script is begun in Chapter 4.

// Require the configuration before any PHP code as the configuration controls error reporting:
require ('./includes/config.inc.php');
// The config file also starts the session.

// Include the header file:
$page_title = 'Register';
include ('./includes/header.html');

// Require the database connection:
require (MYSQL);

// For storing registration errors:
$reg_errors = array();

// Check for a form submission:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	// Check for a first name:
	if (preg_match ('/^[A-Z \'.-]{2,20}$/i', $_POST['first_name'])) {
		$fn = mysqli_real_escape_string ($dbc, $_POST['first_name']);
	} else {
		$reg_errors['first_name'] = 'Please enter your first name!';
	}
	
	// Check for a last name:
	if (preg_match ('/^[A-Z \'.-]{2,40}$/i', $_POST['last_name'])) {
		$ln = mysqli_real_escape_string ($dbc, $_POST['last_name']);
	} else {
		$reg_errors['last_name'] = 'Please enter your last name!';
	}
	
	// Check for a username:
	if (preg_match ('/^[A-Z0-9]{2,30}$/i', $_POST['username'])) {
		$u = mysqli_real_escape_string ($dbc, $_POST['username']);
	} else {
		$reg_errors['username'] = 'Please enter a desired name!';
	}
	
	// Check for an email address:
	if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		$e = mysqli_real_escape_string ($dbc, $_POST['email']);
	} else {
		$reg_errors['email'] = 'Please enter a valid email address!';
	}

	// Check for a password and match against the confirmed password:
	if (preg_match ('/^(\w*(?=\w*\d)(?=\w*[a-z])(?=\w*[A-Z])\w*){6,20}$/', $_POST['pass1']) ) {
		if ($_POST['pass1'] == $_POST['pass2']) {
			$p = mysqli_real_escape_string ($dbc, $_POST['pass1']);
		} else {
			$reg_errors['pass2'] = 'Your password did not match the confirmed password!';
		}
	} else {
		$reg_errors['pass1'] = 'Please enter a valid password!';
	}
	
	if (empty($reg_errors)) { // If everything's OK...

		// Make sure the email address and username are available:
		$q = "SELECT email, username FROM users WHERE email='$e' OR username='$u'";
		$r = mysqli_query ($dbc, $q);
		
		// Get the number of rows returned:
		$rows = mysqli_num_rows($r);
		
		if ($rows == 0) { // No problems!
			
			// Add the user to the database...
			
			// Temporary: set expiration to a month!
			// Change after adding PayPal!
			//$q = "INSERT INTO users (username, email, pass, first_name, last_name, date_expires) VALUES ('$u', '$e', '"  .  get_password_hash($p) .  "', '$fn', '$ln', ADDDATE(NOW(), INTERVAL 1 MONTH) )";
			
			// New query, updated in Chapter 6 for PayPal integration:
			// Sets expiration to yesterday:
			$q = "INSERT INTO users (username, email, pass, first_name, last_name, date_expires) VALUES ('$u', '$e', '"  .  get_password_hash($p) .  "', '$fn', '$ln', SUBDATE(NOW(), INTERVAL 1 DAY) )";
			
			$r = mysqli_query ($dbc, $q);

			if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.
							
				// Get the user ID:
				// Store the new user ID in the session:
				// Added in Chapter 6:
				$uid = mysqli_insert_id($dbc);
//				$_SESSION['reg_user_id']  = $uid;		
				
				// Display a thanks message:
				
				// Original message from Chapter 4:
				//echo '<h3>Thanks!</h3><p>Thank you for registering! You may now log in and access the site\'s content.</p>';
				
				// Updated message from Chapter 6:
				echo "<h3>Thanks!</h3><p>Thank you for registering! To complete the process, please now click the button below so that you may pay for your site access via PayPal. The cost is $10 (US) per year.</p>";

				// PayPal link added in Chapter 6:
				echo '<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
				<input type="hidden" name="cmd" value="_s-xclick">
				<input type="hidden" name="custom" value="' . $uid . '">
				<input type="hidden" name="email" value="' . $e . '">
				<input type="hidden" name="hosted_button_id" value="8YW8FZDELF296">
				<input type="image" src="https://www.sandbox.paypal.com/en_US/i/btn/btn_subscribeCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
				<img alt="" border="0" src="https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
				</form>
				';
						
				// Send a separate email?
				$body = "Thank you for registering at <whatever site>. Blah. Blah. Blah.\n\n";
				mail($_POST['email'], 'Registration Confirmation', $body, 'From: admin@example.com');
				
				// Finish the page:
				include ('./includes/footer.html'); // Include the HTML footer.
				exit(); // Stop the page.
				
			} else { // If it did not run OK.
				trigger_error('You could not be registered due to a system error. We apologize for any inconvenience.');
			}
			
		} else { // The email address or username is not available.
			
			if ($rows == 2) { // Both are taken.
				
				$reg_errors['email'] = 'This email address has already been registered. If you have forgotten your password, use the link at right to have your password sent to you.';			
				$reg_errors['username'] = 'This username has already been registered. Please try another.';			

			} else { // One or both may be taken.

				// Get row:
				$row = mysqli_fetch_array($r, MYSQLI_NUM);
									
				if( ($row[0] == $_POST['email']) && ($row[1] == $_POST['username'])) { // Both match.
					$reg_errors['email'] = 'This email address has already been registered. If you have forgotten your password, use the link at right to have your password sent to you.';	
					$reg_errors['username'] = 'This username has already been registered with this email address. If you have forgotten your password, use the link at right to have your password sent to you.';
				} elseif ($row[0] == $_POST['email']) { // Email match.
					$reg_errors['email'] = 'This email address has already been registered. If you have forgotten your password, use the link at right to have your password sent to you.';						
				} elseif ($row[1] == $_POST['username']) { // Username match.
					$reg_errors['username'] = 'This username has already been registered. Please try another.';			
				}
					
			} // End of $rows == 2 ELSE.
			
		} // End of $rows == 0 IF.
		
	} // End of empty($reg_errors) IF.

} // End of the main form submission conditional.

// Need the form functions script, which defines create_form_input():
require ('./includes/form_functions.inc.php');
?><h3>Register</h3>
<p>Access to the site's content is available to registered users at a cost of $10.00 (US) per year. Use the form below to begin the registration process. <strong>Note: All fields are required.</strong> After completing this form, you'll be presented with the opportunity to securely pay for your yearly subscription via <a href="http://www.paypal.com">PayPal</a>.</p>
<form action="register.php" method="post" accept-charset="utf-8" style="padding-left:100px">

		<p><label for="first_name"><strong>First Name</strong></label><br /><?php create_form_input('first_name', 'text', $reg_errors); ?></p>
		
		<p><label for="last_name"><strong>Last Name</strong></label><br /><?php create_form_input('last_name', 'text', $reg_errors); ?></p>
		
		<p><label for="username"><strong>Desired Username</strong></label><br /><?php create_form_input('username', 'text', $reg_errors); ?> <small>Only letters and numbers are allowed.</small></p>
		
		<p><label for="email"><strong>Email Address</strong></label><br /><?php create_form_input('email', 'text', $reg_errors); ?></p>
		
		<p><label for="pass1"><strong>Password</strong></label><br /><?php create_form_input('pass1', 'password', $reg_errors); ?> <small>Must be between 6 and 20 characters long, with at least one lowercase letter, one uppercase letter, and one number.</small></p>
		<p><label for="pass2"><strong>Confirm Password</strong></label><br /><?php create_form_input('pass2', 'password', $reg_errors); ?></p>

		<input type="submit" name="submit_button" value="Next &rarr;" id="submit_button" class="formbutton" />
	
</form>

<?php // Include the HTML footer:
include ('./includes/footer.html');
?>