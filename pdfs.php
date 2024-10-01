<?php

// This page displays the available PDFs.
// This script is created in Chapter 5.

// Require the configuration before any PHP code as the configuration controls error reporting:
require ('./includes/config.inc.php');
// The config file also starts the session.

// Require the database connection:
require(MYSQL);

// Include the header file:
$page_title = 'PDFs';
include ('./includes/header.html');

// Print a page header:
echo '<h3>PDF Guides</h3>';

// Print a message if they're not an active user:
if (isset($_SESSION['user_id']) && !isset($_SESSION['user_not_expired'])) {
	echo '<p class="error">Thank you for your interest in this content. Unfortunately your account has expired. Please <a href="renew.php">renew your account</a> in order to view any of the PDFs listed below.</p>';
} elseif (!isset($_SESSION['user_id'])) {
	echo '<p class="error">Thank you for your interest in this content. You must be logged in as a registered user to view any of the PDFs listed below.</p>';
}

// Get the PDFs:
$q = 'SELECT tmp_name, title, description, size FROM pdfs ORDER BY date_created DESC';
$r = mysqli_query($dbc, $q);
if (mysqli_num_rows($r) > 0) { // If there are some...
	
	// Fetch every one:
	while ($row = mysqli_fetch_array ($r, MYSQLI_ASSOC)) {

		// Display each record:
		echo "<div><h4><a href=\"view_pdf.php?id={$row['tmp_name']}\">{$row['title']}</a> ({$row['size']}kb)</h4><p>{$row['description']}</p></div>\n";

	} // End of WHILE loop.
	
} else { // No PDFs!
	echo '<p>There are currently no PDFs available to view. Please check back again!</p>';
}

// Include the HTML footer:
include ('./includes/footer.html');
?>