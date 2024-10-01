<?php

// A more formal comments structure, only used in this one page but could (should) be used everywhere:
/* 	*
	* Title: config.inc.php
	* Created by: Larry E. Ullman of DMC Insights, Inc.
	* Contact: Larry@DMCInsights.com, http://www.dmcinsights.com
	* Last modified: 07-28-2010
	*
	* Configuration file does the following things:
	* - Has site settings in one location.
	* - Stores URLs and URIs as constants.
	* - Starts the session.
	* - Sets how errors will be handled.
	* - Defines a redirection function.
	*
	* This script is begun in Chapter 3.
*/

// ********************************** //
// ************ SETTINGS ************ //

// Are we live?
$live = false;

// Errors are emailed here:
$contact_email = 'you@example.com';

// ************ SETTINGS ************ //
// ********************************** //

// ********************************** //
// ************ CONSTANTS *********** //

// Determine location of files and the URL of the site:
define('BASE_URI', 'C:/xampp/htdocs/abeekey-web/');
define ('BASE_URL', 'www.example.com/');
define ('PDFS_DIR', BASE_URI . 'pdfs/'); // Added in Chapter 5.
define ('MYSQL', BASE_URI . 'includes/mysql.inc.php');

// ************ CONSTANTS *********** //
// ********************************** //

// ********************************* //
// ************ SESSIONS *********** //

// Start the session:
session_start();

// ************ SESSIONS *********** //
// ********************************* //

// ****************************************** //
// ************ ERROR MANAGEMENT ************ //

// Function for handling errors.
// Takes five arguments: error number, error message (string), name of the file where the error occurred (string)
// line number where the error occurred, and the variables that existed at the time (array).
// Returns true.
function my_error_handler($e_number, $e_message, $e_file, $e_line, $e_vars = array()) {

    // Need these two vars:
    global $live, $contact_email;

    // Build the error message:
    $message = "An error occurred in script '$e_file' on line $e_line:\n$e_message\n";

    // Add the backtrace:
    $message .= "<pre>" . print_r(debug_backtrace(), 1) . "</pre>\n";

    // Or just append $e_vars to the message:
    // $message .= "<pre>" . print_r($e_vars, 1) . "</pre>\n";

    if (!$live) { // Show the error in the browser.
        echo '<div class="error">' . nl2br($message) . '</div>';
    } else { // Production (log the error).
        // Send the error in an email:
        error_log($message, 1, $contact_email, 'From:admin@example.com');

        // Only print an error message in the browser if the error isn't a notice:
        if ($e_number != E_NOTICE) {
            echo '<div class="error">A system error occurred. We apologize for the inconvenience.</div>';
        }
    }

    return true; // So that PHP doesn't try to handle the error, too.
}

// Use my error handler:
set_error_handler ('my_error_handler');

// ************ ERROR MANAGEMENT ************ //
// ****************************************** //

// ******************************************* //
// ************ REDIRECT FUNCTION ************ //

// This next block is added in Chapter 4.

// This function redirects invalid users.
// It takes two arguments:
// - The session element to check
// - The destination to where the user will be redirected.
function redirect_invalid_user($check = 'user_id', $destination = 'index.php', $protocol = 'http://') {

	// Check for the session item:
	if (!isset($_SESSION[$check])) {
		$url = $protocol . BASE_URL . $destination; // Define the URL.
		header("Location: $url");
		exit(); // Quit the script.
	}

} // End of redirect_invalid_user() function.

// ************ REDIRECT FUNCTION ************ //
// ******************************************* //

// Omit the closing PHP tag to avoid 'headers already sent' errors!
