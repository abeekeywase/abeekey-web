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

// PHPMailer classes
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// Check for a form submission:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Check for a first name:
    if (preg_match ('/^[A-Z \'.-]{2,20}$/i', $_POST['first_name'])) {
        $fn = mysqli_real_escape_string($dbc, $_POST['first_name']);
    } else {
        $reg_errors['first_name'] = 'Please enter your first name!';
    }

    // Check for a last name:
    if (preg_match ('/^[A-Z \'.-]{2,40}$/i', $_POST['last_name'])) {
        $ln = mysqli_real_escape_string($dbc, $_POST['last_name']);
    } else {
        $reg_errors['last_name'] = 'Please enter your last name!';
    }

    // Check for a username:
    if (preg_match ('/^[A-Z0-9]{2,30}$/i', $_POST['username'])) {
        $u = mysqli_real_escape_string($dbc, $_POST['username']);
    } else {
        $reg_errors['username'] = 'Please enter a desired name!';
    }

    // Check for an email address:
    if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $e = mysqli_real_escape_string($dbc, $_POST['email']);
    } else {
        $reg_errors['email'] = 'Please enter a valid email address!';
    }

    // Check for a password and match against the confirmed password:
		if (preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_])[\w\W]{8,32}$/', $_POST['pass1'])) {
        if ($_POST['pass1'] == $_POST['pass2']) {
            $p = mysqli_real_escape_string($dbc, $_POST['pass1']);
        } else {
            $reg_errors['pass2'] = 'Your password did not match the confirmed password!';
        }
    } else {
        $reg_errors['pass1'] = 'Please enter a valid password!';
    }

    if (empty($reg_errors)) { // If everything's OK...

        // Make sure the email address and username are available:
        $q = "SELECT email, username FROM users WHERE email='$e' OR username='$u'";
        $r = mysqli_query($dbc, $q);

        // Get the number of rows returned:
        $rows = mysqli_num_rows($r);

        if ($rows == 0) { // No problems!

            // Add the user to the database...
            $q = "INSERT INTO users (username, email, pass, first_name, last_name, date_expires) VALUES ('$u', '$e', '"  .  get_password_hash($p) .  "', '$fn', '$ln', SUBDATE(NOW(), INTERVAL 1 DAY) )";
            $r = mysqli_query($dbc, $q);

            if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.

                // Get the user ID:
                $uid = mysqli_insert_id($dbc);

                // Display a thanks message:
                echo "<h3>Thanks!</h3><p>Thank you for registering! To complete the process, please now click the button below so that you may pay for your site access via PayPal. The cost is $10 (US) per year.</p>";

                // PayPal link added in Chapter 6:
                echo '<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
                    <input type="hidden" name="cmd" value="_s-xclick">
                    <input type="hidden" name="custom" value="' . $uid . '">
                    <input type="hidden" name="email" value="' . $e . '">
                    <input type="hidden" name="hosted_button_id" value="8YW8FZDELF296">
                    <input type="image" src="https://www.sandbox.paypal.com/en_US/i/btn/btn_subscribeCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                    <img alt="" border="0" src="https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
                </form>';

								$mail = new PHPMailer\PHPMailer\PHPMailer();

								try {
								    //Server settings
								    $mail->isSMTP();
								    $mail->Host = 'smtp.hostinger.com';
								    $mail->SMTPAuth = true;
								    $mail->Username = 'muazu@abeekey.com';
								    $mail->Password = '5824=M&k';
								    $mail->SMTPSecure = 'tls';
								    $mail->Port = 587;
								    $mail->SMTPDebug = 0;

								    //Recipients
								    $mail->setFrom('muazu@abeekey.com', 'Knowledge Is Power');
								    $mail->addAddress($_POST['email']);

								    //Content
								    $mail->isHTML(true);
								    $mail->Subject = 'Registration Confirmation';
								    $mail->Body    = 'Thank you for registering at our site. You may now log in and access the content.';

								    $mail->send();
								    echo 'A confirmation email has been sent.';
								} catch (Exception $e) {
								    error_log('Message could not be sent. Mailer Error: ' . $mail->ErrorInfo);
								    echo 'Message could not be sent. Please try again later.';
								}

                // Finish the page:
                include ('./includes/footer.html'); // Include the HTML footer.
                exit(); // Stop the page.

            } else { // If it did not run OK.
                trigger_error('You could not be registered due to a system error. We apologize for any inconvenience.');
            }

        } else { // The email address or username is not available.
            // Handle the case where the email or username is already taken.
        }

    } // End of empty($reg_errors) IF.

} // End of the main form submission conditional.

// Need the form functions script, which defines create_form_input():
require ('./includes/form_functions.inc.php');
?>

<h3>Register</h3>
<p>Access to the site's content is available to registered users at a cost of $10.00 (US) per year. Use the form below to begin the registration process. <strong>Note: All fields are required.</strong></p>

<form action="register.php" method="post" accept-charset="utf-8" style="padding-left:100px">
    <p><label for="first_name"><strong>First Name</strong></label><br /><?php create_form_input('first_name', 'text', $reg_errors); ?></p>
    <p><label for="last_name"><strong>Last Name</strong></label><br /><?php create_form_input('last_name', 'text', $reg_errors); ?></p>
    <p><label for="username"><strong>Desired Username</strong></label><br /><?php create_form_input('username', 'text', $reg_errors); ?> <small>Only letters and numbers are allowed.</small></p>
    <p><label for="email"><strong>Email Address</strong></label><br /><?php create_form_input('email', 'text', $reg_errors); ?></p>
    <p><label for="pass1"><strong>Password</strong></label><br /><?php create_form_input('pass1', 'password', $reg_errors); ?> <small>Must be between 8 and 32 characters long, with a mix of uppercase, lowercase, and special characters.</small></p>
    <p><label for="pass2"><strong>Confirm Password</strong></label><br /><?php create_form_input('pass2', 'password', $reg_errors); ?></p>
    <input type="submit" name="submit_button" value="Next &rarr;" id="submit_button" class="formbutton" />
</form>

<?php
// Include the HTML footer:
include ('./includes/footer.html');
?>
