<?php

// This page displays the articles listed within a given category.
// This script is created in Chapter 5.

// Require the configuration before any PHP code as the configuration controls error reporting:
require ('./includes/config.inc.php');
// The config file also starts the session.

// Require the database connection:
require(MYSQL);

// Validate the category ID:
if (filter_var($_GET['id'], FILTER_VALIDATE_INT, array('min_range' => 1))) {

	// Get the category title:
	$q = 'SELECT category FROM categories WHERE id=' . $_GET['id'];
	$r = mysqli_query($dbc, $q);
	if (mysqli_num_rows($r) != 1) { // Problem!
		$page_title = 'Error!';
		include ('./includes/header.html');
		echo '<p class="error">This page has been accessed in error.</p>';
		include ('./includes/footer.html');
		exit();
	}
	
	// Fetch the category title and use it as the page title:
	list ($page_title) = mysqli_fetch_array($r, MYSQLI_NUM);
	include ('./includes/header.html');
	echo "<h3>$page_title</h3>";
	
	// Print a message if they're not an active user:
	// Change the message based upon the user's status:
	if (isset($_SESSION['user_id']) && !isset($_SESSION['user_not_expired'])) {
		echo '<p class="error">Thank you for your interest in this content. Unfortunately your account has expired. Please <a href="renew.php">renew your account</a> in order to access site content.</p>';
	} elseif (!isset($_SESSION['user_id'])) {
		echo '<p class="error">Thank you for your interest in this content. You must be logged in as a registered user to view site content.</p>';
	}

	// Get the pages associated with this category:
	$q = 'SELECT id, title, description FROM pages WHERE category_id=' . $_GET['id'] . ' ORDER BY date_created DESC';
	$r = mysqli_query($dbc, $q);
	if (mysqli_num_rows($r) > 0) { // Pages available!
		
		// Fetch each record:
		while ($row = mysqli_fetch_array ($r, MYSQLI_ASSOC)) {

			// Display each record:
			echo "<div><h4><a href=\"page.php?id={$row['id']}\">{$row['title']}</a></h4><p>{$row['description']}</p></div>\n";

		} // End of WHILE loop.
		
	} else { // No pages available.
		echo '<p>There are currently no pages of content associated with this category. Please check back again!</p>';
	}

} else { // No valid ID.
	$page_title = 'Error!';
	include ('./includes/header.html');
	echo '<p class="error">This page has been accessed in error.</p>';
} // End of primary IF.

// Include the HTML footer:
include ('./includes/footer.html');
?>