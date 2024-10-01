<?php

// This file contains the database access information.
// This file establishes a connection to MySQL and selects the database.
// This file defines a function for making data safe to use in queries.
// This file defines a function for hashing passwords.
// This script is begun in Chapter 3.

// Set the database access information as constants:
DEFINE ('DB_USER', 'u729256872_abeekeyfounder');
DEFINE ('DB_PASSWORD', '5824=M&k');
DEFINE ('DB_HOST', 'srv1614.hstgr.io');
DEFINE ('DB_NAME', 'u729256872_abeekey');

// Make the connection:
$dbc = mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Set the character set:
mysqli_set_charset($dbc, 'utf8');

// Function for escaping and trimming form data.
// Takes one argument: the data to be treated (string).
// Returns the treated data (string).
function escape_data ($data) {

	global $dbc; // Database connection.

	// Strip the slashes if Magic Quotes is on:
	if (get_magic_quotes_gpc()) $data = stripslashes($data);

	// Apply trim() and mysqli_real_escape_string():
	return mysqli_real_escape_string ($dbc, trim ($data));

} // End of the escape_data() function.

// This next block is added in Chapter 4.

// This function returns the hashed version of a password.
// It takes the user's password as its one argument.
// It returns a binary version of the password, already escaped to use in a query.
function get_password_hash($password) {

	// Need the database connection:
	global $dbc;

	// Return the escaped password:
	return mysqli_real_escape_string ($dbc, hash_hmac('sha256', $password, 'c#haRl891', true));

} // End of get_password_hash() function.

// Omit the closing PHP tag to avoid 'headers already sent' errors!
