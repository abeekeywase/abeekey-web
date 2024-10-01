<?php

// This page displays a specific page of HTML content.
// This script is created in Chapter 5.

// Require the configuration before any PHP code as the configuration controls error reporting:
require ('./includes/config.inc.php');
// The config file also starts the session.

// Require the database connection:
require(MYSQL);

// Validate the category ID:
if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT, array('min_range' => 1))) {

	// Get the page info:
	$q = 'SELECT title, description, content FROM pages WHERE id=' . $_GET['id'];
	$r = mysqli_query($dbc, $q);
	if (mysqli_num_rows($r) != 1) { // Problem!
		$page_title = 'Error!';
		include ('./includes/header.html');
		echo '<p class="error">This page has been accessed in error.</p>';
		include ('./includes/footer.html');
		exit();
	}
	
	// Fetch the page info:
	$row = mysqli_fetch_array($r, MYSQLI_ASSOC);
	$page_title = $row['title'];
	include ('includes/header.html');
	echo "<h3>$page_title</h3>";
	
	// Display the content if the user's account is current:
	if (isset($_SESSION['user_not_expired'])) {
		
		// Bonus material! Referenced in Chapter 5.
		// Create add to favorites and remove from favorites links:
		// See if this is favorite:
		$q = 'SELECT user_id FROM favorite_pages WHERE user_id=' . $_SESSION['user_id'] . ' AND page_id=' . $_GET['id'];
		$r = mysqli_query($dbc, $q);
		if (mysqli_num_rows($r) == 1) {
			echo '<p><img src="/images/heart_48.png" border="0" width="48" height="48" align="middle" /> This is a favorite! <a href="remove_from_favorites.php?id=' . $_GET['id'] . '"><img src="/images/cross_48.png" border="0" width="48" height="48" align="middle" /></a></p>';
		} else {
			echo '<p>Make this a favorite! <a href="add_to_favorites.php?id=' . $_GET['id'] . '"><img src="/images/heart_48.png" border="0" width="48" height="48" align="middle" /></a>';
		}


		// Show the page content:
		echo "<div>{$row['content']}</div>";
		
		// Bonus material! Referenced in Chapter 5.
		// Record this visit to the history table:
		$q = "INSERT INTO history (user_id, type, page_id) VALUES ({$_SESSION['user_id']}, 'page', {$_GET['id']})";
		$r = mysqli_query($dbc, $q);
		
	} elseif (isset($_SESSION['user_id'])) { // Logged in but not current.
		echo '<p class="error">Thank you for your interest in this content, but your account is no longer current. Please <a href="renew.php">renew your account</a> in order to view this page in its entirety</p>';
		echo "<div>{$row['description']}</div>";
	} else { // Not logged in.
		echo '<p class="error">Thank you for your interest in this content. You must be a logged in as a registered user to view this page in its entirety.</p>';
		echo "<div>{$row['description']}</div>";
	}

} else { // No valid ID.
	$page_title = 'Error!';
	include ('includes/header.html');
	echo '<p class="error">This page has been accessed in error.</p>';
} // End of primary IF.

// Include the HTML footer:
include ('./includes/footer.html');
?>